<?php

namespace App\Notifications;

use App\Mail\CapWarningMail;
use App\Models\Plan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class CapWarningNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Plan  $plan;
    public float $todayEarned;
    public float $totalEarned;
    public ?Plan $nextPlan;

    public function __construct(
        Plan  $plan,
        float $todayEarned,
        float $totalEarned,
        ?Plan $nextPlan = null
    ) {
        $this->plan        = $plan;
        $this->todayEarned = $todayEarned;
        $this->totalEarned = $totalEarned;
        $this->nextPlan    = $nextPlan;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): CapWarningMail
    {
        return new CapWarningMail(
            $notifiable,
            $this->plan,
            $this->todayEarned,
            $this->totalEarned,
            $this->nextPlan,
        );
    }

    public function toArray(object $notifiable): array
    {
        $percentUsed = $this->plan->daily_cap > 0
            ? round(($this->todayEarned / $this->plan->daily_cap) * 100, 1)
            : 0;

        return [
            'type'          => 'cap_warning',
            'plan'          => $this->plan->name,
            'daily_cap'     => $this->plan->daily_cap,
            'today_earned'  => $this->todayEarned,
            'total_earned'  => $this->totalEarned,
            'percent_used'  => $percentUsed,
            'next_plan'     => $this->nextPlan?->name,
            'message'       => "⚠️ You've used {$percentUsed}% of your daily cap (₹{$this->todayEarned} / ₹{$this->plan->daily_cap}). Upgrade to earn more!",
        ];
    }
}

            //
        ];
    }
}
