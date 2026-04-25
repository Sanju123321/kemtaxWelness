<?php

namespace App\Console\Commands;

use App\Models\Income;
use App\Models\Plan;
use App\Models\User;
use App\Notifications\CapWarningNotification;
use App\Services\SmsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckCapWarning extends Command
{
    protected $signature   = 'cap:warn';
    protected $description = 'Notify users approaching their daily income cap. Runs at 9PM, 10PM, 11PM, 11:30PM, 11:45PM.';

    public function handle(SmsService $sms): void
    {
        // Thresholds: warn at 70%, 80%, 90%, 95%, 100%
        $thresholds = [70, 80, 90, 95, 100];
        $now        = now();

        // Pick threshold for the current time
        $hour   = (int) $now->format('G');
        $minute = (int) $now->format('i');

        $threshold = match (true) {
            $hour === 21                       => 70,
            $hour === 22                       => 80,
            $hour === 23 && $minute < 30       => 90,
            $hour === 23 && $minute < 45       => 95,
            $hour === 23 && $minute >= 45      => 100,
            default                            => 70,  // fallback
        };

        $this->info("Running cap warning at threshold {$threshold}%...");

        $plans = Plan::all()->keyBy('id');

        // Find users with a plan who have credited income today
        $todayEarnings = Income::where('status', 'credited')
            ->whereDate('created_at', today())
            ->selectRaw('user_id, SUM(amount) as today_earned')
            ->groupBy('user_id')
            ->pluck('today_earned', 'user_id');

        foreach ($todayEarnings as $userId => $todayEarned) {
            $user = User::with('currentPlan')->find($userId);
            if (!$user || !$user->currentPlan) continue;

            $plan     = $user->currentPlan;
            $dailyCap = $plan->daily_cap;

            if ($dailyCap <= 0) continue;

            $percent = ($todayEarned / $dailyCap) * 100;

            if ($percent < $threshold) continue;

            // Find the next plan (higher price)
            $nextPlan = Plan::where('price', '>', $plan->price)
                ->where('is_active', true)
                ->orderBy('price')
                ->first();

            $totalEarned = Income::where('user_id', $userId)
                ->where('status', 'credited')
                ->sum('amount');

            try {
                // 1) Database + Email notification
                $user->notify(new CapWarningNotification($plan, $todayEarned, $totalEarned, $nextPlan));

                // 2) SMS notification
                if ($user->phone) {
                    $pct     = round($percent, 1);
                    $message = "KemtexWellness Alert: Hi {$user->name}, you've used {$pct}% of your ₹{$dailyCap} daily cap today. Upgrade to earn more before midnight! Login: " . url('/member/dashboard');
                    $sms->send($user->phone, $message);
                }

                $this->line("  ✓ Notified user #{$userId} ({$user->name}) at {$percent}%");
            } catch (\Throwable $e) {
                Log::error("CapWarning notification failed for user {$userId}: " . $e->getMessage());
                $this->error("  ✗ Failed user #{$userId}: " . $e->getMessage());
            }
        }

        $this->info('Done.');
    }
}
