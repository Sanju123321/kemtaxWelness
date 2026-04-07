<?php

namespace App\Services;
use App\Models\User;
use App\Models\Income;
use App\Models\UserTree;

class CommissionService
{
    public function distributeIncome($userId)
    {
        $user = User::find($userId);

        $amount = $user->currentPlan->base_value;

        $uplines = UserTree::where('user_id', $userId)->get();

        $rows = [];

        foreach ($uplines as $node) {

            $percent = $this->getPercent($node->level);

            if ($percent == 0) continue;

            $income = ($amount * $percent) / 100;
            $rows[] = [
                'user_id' => $node->upline_id,
                'from_user_id' => $userId,
                'level' => $node->level,
               'type' => ((int)$node->level === 1) ? 'direct' : 'level',
                'amount' => $income,
                'status' => 'pending',
                'created_at' => now()
            ];
        }

        Income::insert($rows);
    }

    private function getPercent($level)
    {
        if ($level == 1) return 15;
        if ($level == 2) return 10;
        if ($level == 3) return 5;
        if ($level == 4) return 5;
        if ($level >= 5 && $level <= 10) return 2;
        if ($level >= 11 && $level <= 20) return 1;

        return 0;
    }
}