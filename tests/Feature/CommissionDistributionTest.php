<?php

namespace Tests\Feature;

use App\Models\Income;
use App\Models\Plan;
use App\Models\User;
use App\Services\CommissionService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommissionDistributionTest extends TestCase
{
    use RefreshDatabase;

    public function test_distribute_income_job_runs_and_creates_incomes(): void
    {
        $plan = Plan::create([
            'name' => 'Starter',
            'price' => 1500,
            'base_value' => 1000,
            'daily_cap' => 10000,
            'total_cap' => 500000,
            'is_active' => true,
        ]);

        $grandParent = $this->makeUser('Grand Parent');
        $parent = $this->makeUser('Parent', ['parent_id' => $grandParent->id]);
        $buyer = $this->makeUser('Buyer', [
            'parent_id' => $parent->id,
            'current_plan_id' => $plan->id,
        ]);

        app(CommissionService::class)->distributeIncome($buyer->id, 'referral');

        $this->assertDatabaseHas('incomes', [
            'user_id' => $parent->id,
            'from_user_id' => $buyer->id,
            'level' => 1,
            'type' => 'direct',
            'status' => 'credited',
        ]);

        $this->assertDatabaseHas('incomes', [
            'user_id' => $grandParent->id,
            'from_user_id' => $buyer->id,
            'level' => 2,
            'type' => 'level',
            'status' => 'credited',
        ]);

        $this->assertSame(2, Income::count());
    }

    private function makeUser(string $name, array $overrides = []): User
    {
        static $seq = 4000;
        $seq++;

        return User::create(array_merge([
            'name' => $name,
            'email' => "commission{$seq}@example.com",
            'password' => bcrypt('Password@123'),
            'user_id' => "COM{$seq}",
            'status' => 'active',
            'wallet_balance' => 0,
            'total_earned' => 0,
        ], $overrides));
    }
}
