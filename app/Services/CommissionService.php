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

        // Pre-load all upline users and their income totals to avoid N+1 queries
        $uplineIds = $uplines->pluck('upline_id')->unique()->all();

        $uplineUsers = User::with('currentPlan')
            ->whereIn('id', $uplineIds)
            ->get()
            ->keyBy('id');

        $totalEarnedMap = Income::where('status', 'credited')
            ->whereIn('user_id', $uplineIds)
            ->groupBy('user_id')
            ->selectRaw('user_id, SUM(amount) as total')
            ->pluck('total', 'user_id');

        $todayEarnedMap = Income::where('status', 'credited')
            ->whereIn('user_id', $uplineIds)
            ->whereDate('created_at', today())
            ->groupBy('user_id')
            ->selectRaw('user_id, SUM(amount) as total')
            ->pluck('total', 'user_id');

        foreach ($uplines as $node) {
            $percent = $this->getPercent($node->level);
            if ($percent == 0) continue;

            $grossIncome = round(($baseValue * $percent) / 100, 2);
            $type        = ((int) $node->level === 1) ? 'direct' : 'level';

            DB::transaction(function () use ($node, $userId, $grossIncome, $type, $uplineUsers, $totalEarnedMap, $todayEarnedMap) {
                // Reload with lock inside transaction for safe increment
                $uplineUser = User::with('currentPlan')->lockForUpdate()->find($node->upline_id);

                if (!$uplineUser) return;

                $dailyCap = $uplineUser->currentPlan?->daily_cap ?? PHP_INT_MAX;
                $totalCap = $uplineUser->currentPlan?->total_cap ?? PHP_INT_MAX;

                $totalEarned = $totalEarnedMap[$uplineUser->id] ?? 0;
                $todayEarned = $todayEarnedMap[$uplineUser->id] ?? 0;

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
        if ($level === 1)                              return 15;
        if ($level === 2)                              return 10;
        if ($level === 3)                              return 5;
        if ($level === 4)                              return 5;
        if ($level >= 5  && $level <= 10)              return 2;
        if ($level >= 11 && $level <= 20)              return 1;
        return 0;
    }
}
