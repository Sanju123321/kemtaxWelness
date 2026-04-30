<?php

namespace App\Services;

use App\Models\AdminEarning;
use App\Models\Income;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CommissionService
{
    /**
     * Distribute income to all uplines of the given user.
     * Applies each upline's daily cap and total cap.
     * Excess income is marked 'lost' and goes to company.
     */
    public function distributeIncome(int $userId, string $commissionSource = 'referral'): void
    {
        $user = User::with('currentPlan')->find($userId);

        if (!$user || !$user->currentPlan) {
            return;
        }

        $baseValue = $user->currentPlan->base_value;
        $uplines = $this->placementUplines($userId);
        if ($uplines->isEmpty()) {
            return;
        }

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

            DB::transaction(function () use ($node, $userId, $grossIncome, $type, $uplineUsers, $totalEarnedMap, $todayEarnedMap, $commissionSource) {
                // Reload with lock inside transaction for safe increment
                $uplineUser = User::with('currentPlan')->lockForUpdate()->find($node->upline_id);

                if (!$uplineUser) return;

                $dailyCap = $uplineUser->currentPlan?->daily_cap ?? PHP_INT_MAX;
                $totalCap = $uplineUser->currentPlan?->total_cap ?? PHP_INT_MAX;

                $totalEarned = $totalEarnedMap[$uplineUser->id] ?? 0;
                $todayEarned = $todayEarnedMap[$uplineUser->id] ?? 0;

                // ── Already hit total cap — full amount goes to admin ──────────
                if ($totalEarned >= $totalCap) {
                    Income::create([
                        'user_id'            => $uplineUser->id,
                        'from_user_id'       => $userId,
                        'level'              => $node->level,
                        'type'               => $type,
                        'commission_source'  => $commissionSource,
                        'amount'             => $grossIncome,
                        'status'             => 'lost',
                        'remark'             => 'total_cap_exceeded',
                    ]);

                    // Lost income → admin
                    AdminEarning::create([
                        'from_user_id'       => $userId,
                        'beneficiary_user_id' => $uplineUser->id,
                        'type'               => 'lost_capture',
                        'amount'             => $grossIncome,
                        'remark'             => "total_cap_exceeded for user {$uplineUser->id}",
                    ]);
                    return;
                }

                $remainingDaily = max(0, $dailyCap - $todayEarned);
                $remainingTotal = max(0, $totalCap - $totalEarned);
                $creditable     = min($grossIncome, $remainingDaily, $remainingTotal);

                // ── Nothing creditable today — full amount goes to admin ───────
                if ($creditable <= 0) {
                    Income::create([
                        'user_id'            => $uplineUser->id,
                        'from_user_id'       => $userId,
                        'level'              => $node->level,
                        'type'               => $type,
                        'commission_source'  => $commissionSource,
                        'amount'             => $grossIncome,
                        'status'             => 'lost',
                        'remark'             => 'daily_cap_exceeded',
                    ]);

                    // Lost income → admin
                    AdminEarning::create([
                        'from_user_id'       => $userId,
                        'beneficiary_user_id' => $uplineUser->id,
                        'type'               => 'lost_capture',
                        'amount'             => $grossIncome,
                        'remark'             => "daily_cap_exceeded for user {$uplineUser->id}",
                    ]);
                    return;
                }

                // ── Partial credit (split into credited + lost) ────────────────
                if ($creditable < $grossIncome) {
                    $lost            = round($grossIncome - $creditable, 2);
                    $feeRate         = $this->getMaintenanceFeePercent() / 100;
                    $maintenanceFee  = round($creditable * $feeRate, 2);
                    $repurchaseRate  = 0.05;
                    $repurchaseAmt   = round($creditable * $repurchaseRate, 2);
                    $userNet         = round($creditable - $maintenanceFee - $repurchaseAmt, 2);

                    Income::create([
                        'user_id'            => $uplineUser->id,
                        'from_user_id'       => $userId,
                        'level'              => $node->level,
                        'type'               => $type,
                        'commission_source'  => $commissionSource,
                        'amount'             => $creditable,
                        'status'             => 'credited',
                        'remark'             => null,
                    ]);

                    Income::create([
                        'user_id'            => $uplineUser->id,
                        'from_user_id'       => $userId,
                        'level'              => $node->level,
                        'type'               => $type,
                        'commission_source'  => $commissionSource,
                        'amount'             => $lost,
                        'status'             => 'lost',
                        'remark'             => 'daily_cap_exceeded',
                    ]);

                    // Lost portion → admin
                    AdminEarning::create([
                        'from_user_id'       => $userId,
                        'beneficiary_user_id' => $uplineUser->id,
                        'type'               => 'lost_capture',
                        'amount'             => $lost,
                        'remark'             => "partial cap exceeded for user {$uplineUser->id}",
                    ]);

                    // 10% maintenance fee on credited portion → admin
                    AdminEarning::create([
                        'from_user_id'       => $userId,
                        'beneficiary_user_id' => $uplineUser->id,
                        'type'               => 'maintenance_fee',
                        'amount'             => $maintenanceFee,
                        'remark'             => "10% fee on ₹{$creditable} credited to user {$uplineUser->id}",
                    ]);

                    // 5% to repurchase wallet
                    \App\Models\RepurchaseWalletTopup::create([
                        'user_id' => $uplineUser->id,
                        'amount'  => $repurchaseAmt,
                        'status'  => 'approved',
                    ]);

                    $uplineUser->increment('wallet_balance', $userNet);
                    $uplineUser->increment('total_earned', $creditable);
                    return;
                }

                // ── Full credit ────────────────────────────────────────────────
                $feeRate        = $this->getMaintenanceFeePercent() / 100;
                $maintenanceFee = round($grossIncome * $feeRate, 2);
                $repurchaseRate = 0.05;
                $repurchaseAmt = round($grossIncome * $repurchaseRate, 2);
                $userNet       = round($grossIncome - $maintenanceFee - $repurchaseAmt, 2);

                Income::create([
                    'user_id'            => $uplineUser->id,
                    'from_user_id'       => $userId,
                    'level'              => $node->level,
                    'type'               => $type,
                    'commission_source'  => $commissionSource,
                    'amount'             => $grossIncome,
                    'status'             => 'credited',
                    'remark'             => null,
                ]);

                // 10% maintenance fee on full credited amount → admin
                AdminEarning::create([
                    'from_user_id'       => $userId,
                    'beneficiary_user_id' => $uplineUser->id,
                    'type'               => 'maintenance_fee',
                    'amount'             => $maintenanceFee,
                    'remark'             => "10% fee on ₹{$grossIncome} credited to user {$uplineUser->id}",
                ]);

                // 5% to repurchase wallet
                \App\Models\RepurchaseWalletTopup::create([
                    'user_id' => $uplineUser->id,
                    'amount'  => $repurchaseAmt,
                    'status'  => 'approved',
                ]);

                $uplineUser->increment('wallet_balance', $userNet);
                $uplineUser->increment('total_earned', $grossIncome);
            });
        }
    }

    private function getPercent(int $level): float
    {
        static $rates = null;

        if ($rates === null) {
            $rates = \App\Models\Setting::whereIn('key', [
                'commission_l1', 'commission_l2', 'commission_l3', 'commission_l4',
                'commission_l5_l10', 'commission_l11_l20',
            ])->pluck('value', 'key')->toArray();
        }

        if ($level === 1) return (float)($rates['commission_l1']     ?? 15);
        if ($level === 2) return (float)($rates['commission_l2']     ?? 10);
        if ($level === 3) return (float)($rates['commission_l3']     ?? 5);
        if ($level === 4) return (float)($rates['commission_l4']     ?? 5);
        if ($level >= 5  && $level <= 10) return (float)($rates['commission_l5_l10']  ?? 2);
        if ($level >= 11 && $level <= 20) return (float)($rates['commission_l11_l20'] ?? 1);
        return 0;
    }

    private function getMaintenanceFeePercent(): float
    {
        return (float)(\App\Models\Setting::getValue('maintenance_fee_percent', 10));
    }

    private function placementUplines(int $userId, int $maxLevels = 20)
    {
        $nodes = collect();
        $current = User::query()->select('id', 'parent_id')->find($userId);
        $level = 1;

        while ($current && $current->parent_id && $level <= $maxLevels) {
            $nodes->push((object) [
                'upline_id' => (int) $current->parent_id,
                'level' => $level,
            ]);

            $current = User::query()
                ->select('id', 'parent_id')
                ->find((int) $current->parent_id);
            $level++;
        }

        return $nodes;
    }
}
