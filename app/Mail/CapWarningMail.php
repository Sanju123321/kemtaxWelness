<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Plan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CapWarningMail extends Mailable
{
    use Queueable, SerializesModels;

    public User  $user;
    public Plan  $plan;
    public float $todayEarned;
    public float $dailyCap;
    public float $totalEarned;
    public float $totalCap;
    public float $percentUsed;
    public ?Plan $nextPlan;

    public function __construct(
        User  $user,
        Plan  $plan,
        float $todayEarned,
        float $totalEarned,
        ?Plan $nextPlan = null
    ) {
        $this->user        = $user;
        $this->plan        = $plan;
        $this->dailyCap    = $plan->daily_cap;
        $this->totalCap    = $plan->total_cap;
        $this->todayEarned = $todayEarned;
        $this->totalEarned = $totalEarned;
        $this->percentUsed = $this->dailyCap > 0
            ? round(($todayEarned / $this->dailyCap) * 100, 1)
            : 0;
        $this->nextPlan    = $nextPlan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⚠️ Daily Income Cap Warning – Upgrade Now to Earn More!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.cap-warning',
        );
    }
}

            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
