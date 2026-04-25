<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommissionDistributionTest extends TestCase
{
    use RefreshDatabase;

    public function test_distribute_income_job_runs_and_creates_incomes()
    {
        $this->markTestIncomplete('Implement DistributeIncomeJob integration test (use Queue::fake).');
    }
}
