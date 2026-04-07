<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\User;
use App\Models\Income;
use App\Models\UserTree;
use App\Services\CommissionService;
class DistributeIncomeJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
   public $userId;

    // ✅ Step 2.1: Pass userId
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    // ✅ Step 2.2: Main Logic Call
    public function handle()
    {
        app(CommissionService::class)
            ->distributeIncome($this->userId);
    }
}
