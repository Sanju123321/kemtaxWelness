<?php

namespace App\Services;

use App\Models\User;
use App\Models\Income;
use App\Models\UserTree;
use Illuminate\Support\Facades\DB;

class CommissionService
{
    /**
     * Distribute income to all uplines of the given user.
     * Applies each upline's daily cap and total cap.
     * Excess income is marked 'lost' and goes to company.
     */
    public function distributeIncome(int $userId): void
    {
        $user = User::with('currentPlan')->find($userId);

        if (!$user || !$user->currentPlan) {
            return;
        }

        $baseValue = $user->currentPlan->base_value;
        $uplines   = UserTree::where('user_id', $userId)->get();

        foreach ($uplines as $node) {
            $percent = $this->getPercent($node->level);
            if ($percent == 0) continue;

            $grossIncome = round(($baseValue * $percent) / 100, 2);
            $type        = ((int) $node->level === 1) ? 'direct' : 'level';

            DB::transaction(function () use ($node, $userId, $grossIncome, $type) {
                $uplineUser = User::with('currentPlan')->lockForUpdate()->find($node->upline_id);

                if (!$uplineUser) return;

                // Default unlimited caps if no plan (safety)
                $dailyCap = $uplineUser->currentPlan?->daily_cap ?? PHP_INT_MAX;
                $totalCap = $uplineUser->currentPlan?->total_cap ?? PHP_INT_MAX;

                // Lifetime credited earnings
                $totalEarned = Income::where('user_id', $uplineUser->id)
                    ->where('status', 'credited')
                    ->sum('amount');

                // Already hit total cap
                if ($totalEarned >= $totalCap) {
                    Income::create([
                        'user_id'      => $uplineUser->id,
                        'from_user_id' => $userId,
                        'level'        => $node->level,
                        'type'         => $type,
                        'amount'       => $grossIncome,
                        'status'       => 'lost',
                        'remark'       => 'total_cap_exceeded',
                    ]);
                    return;
                }

                // Earnings today
                $todayEarned = Income::where('user_id', $uplineUser->id)
                    ->where('status', 'credited')
                    ->whereDate('created_at', today())
                    ->sum('amount');

                $remainingDaily = max(0, $dailyCap - $todayEarned);
                $remainingTotal = max(0, $totalCap - $totalEarned);
                $creditable     = min($grossIncome, $remainingDaily, $remainingTotal);

                // Nothing creditable today
                if ($creditable <= 0) {
                    Income::create([
                        'user_id'      => $uplineUser->id,
                        'from_user_id' => $userId,
                        'level'        => $node->level,
                        'type'         => $type,
                        'amount'       => $grossIncome,
                        'status'       => 'lost',
                        'remark'       => 'daily_cap_exceeded',
                    ]);
                    return;
                }

                // Partial credit (split into credited + lost)
                if ($creditable < $grossIncome) {
                    $lost = round($grossIncome - $creditable, 2);

                    Income::create([
                        'user_id'      => $uplineUser->id,
                        'from_user_id' => $userId,
                        'level'        => $node->level,
                        'type'         => $type,
                        'amount'       => $creditable,
                        'status'       => 'credited',
                        'remark'       => null,
                    ]);

                    Income::create([
                        'user_id'      => $uplineUser->id,
                        'from_user_id' => $userId,
                        'level'        => $node->level,
                        'type'         => $type,
                        'amount'       => $lost,
                        'status'       => 'lost',
                        'remark'       => 'daily_cap_exceeded',
                    ]);

                    $uplineUser->increment('wallet_balance', $creditable);
                    $uplineUser->increment('total_earned', $creditable);
                    return;
                }

                // Full credit
                Income::create([
                    'user_id'      => $uplineUser->id,
                    'from_user_id' => $userId,
                    'level'        => $node->level,
                    'type'         => $type,
                    'amount'       => $grossIncome,
                    'status'       => 'credited',
                    'remark'       => null,
                ]);

                $uplineUser->increment('wallet_balance', $grossIncome);
                $uplineUser->increment('total_earned', $grossIncome);
            });
        }
    }

    private function getPercent(int $level): float
    {
        if ($level == 1)                               return 15;
        if ($level == 2)                               return 10;
        if ($level == 3)                               return 5;
        if ($level == 4)                               return 5;
        if ($level >= 5  && $level <= 10)              return 2;
        if ($level >= 11 && $level <= 20)              return 1;
        return 0;
    }
}
