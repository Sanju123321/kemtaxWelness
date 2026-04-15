<?php

namespace App\Console\Commands;

use App\Jobs\DistributeIncomeJob;
use App\Models\User;
use Illuminate\Console\Command;

class DistributeIncomeCommand extends Command
{
    protected $signature   = 'income:distribute';
    protected $description = 'Dispatch DistributeIncomeJob for every user who has an active plan.';

    public function handle(): void
    {
        $users = User::whereNotNull('current_plan_id')->pluck('id');

        if ($users->isEmpty()) {
            $this->info('No active plan users found. Nothing dispatched.');
            return;
        }

        foreach ($users as $userId) {
            DistributeIncomeJob::dispatch($userId);
        }

        $this->info("Dispatched DistributeIncomeJob for {$users->count()} user(s).");
    }
}
