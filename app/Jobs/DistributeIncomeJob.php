<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\CommissionService;

class DistributeIncomeJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $timeout = 120;

    public function __construct(
        public int $userId,
        public string $commissionSource = 'referral',
    ) {}

    public function handle(): void
    {
        app(CommissionService::class)
            ->distributeIncome($this->userId, $this->commissionSource);
    }
}
