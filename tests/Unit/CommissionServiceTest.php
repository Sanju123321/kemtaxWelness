<?php

namespace Tests\Unit;

use App\Models\AdminEarning;
use App\Models\Income;
use App\Models\Plan;
use App\Models\User;
use App\Services\CommissionService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommissionServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_commission_calculation_respects_caps(): void
    {
        $sourcePlan = Plan::create([
            'name' => 'Source Plan',
            'price' => 1500,
            'base_value' => 1000,
            'daily_cap' => 20000,
            'total_cap' => 200000,
            'is_active' => true,
        ]);

        $cappedPlan = Plan::create([
            'name' => 'Capped Plan',
            'price' => 2500,
            'base_value' => 1000,
            'daily_cap' => 100,
            'total_cap' => 100,
            'is_active' => true,
        ]);

        $upline = $this->makeUser('Cap Upline', [
            'current_plan_id' => $cappedPlan->id,
            'has_plan' => true,
        ]);
        $sourceUser = $this->makeUser('Source User', [
            'parent_id' => $upline->id,
            'current_plan_id' => $sourcePlan->id,
            'has_plan' => true,
        ]);

        app(CommissionService::class)->distributeIncome($sourceUser->id, 'referral');

        $this->assertDatabaseHas('incomes', [
            'user_id' => $upline->id,
            'from_user_id' => $sourceUser->id,
            'level' => 1,
            'status' => 'credited',
            'amount' => 100,
        ]);

        $this->assertDatabaseHas('incomes', [
            'user_id' => $upline->id,
            'from_user_id' => $sourceUser->id,
            'level' => 1,
            'status' => 'lost',
            'amount' => 50,
        ]);

        $upline->refresh();
        $this->assertSame(100.0, (float) $upline->total_earned);
        $this->assertSame(85.0, (float) $upline->wallet_balance);
        $this->assertSame(2, Income::count());
        $this->assertGreaterThanOrEqual(2, AdminEarning::count());
    }

    public function test_unslotted_direct_referral_still_pays_upline_commission_via_sponsor_chain(): void
    {
        $plan = Plan::create([
            'name' => 'Starter',
            'price' => 1500,
            'base_value' => 1000,
            'daily_cap' => 20000,
            'total_cap' => 200000,
            'is_active' => true,
        ]);

        $topUpline = $this->makeUser('Top Upline', [
            'current_plan_id' => $plan->id,
            'has_plan' => true,
        ]);

        $sponsor = $this->makeUser('Sponsor', [
            'parent_id' => $topUpline->id,
            'current_plan_id' => $plan->id,
            'has_plan' => true,
        ]);

        // Simulates 11th+ direct: no parent placement yet, but sponsor exists.
        $sourceUser = $this->makeUser('Unslotted Direct', [
            'parent_id' => null,
            'sponsor_id' => $sponsor->id,
            'referred_by' => $sponsor->id,
            'current_plan_id' => $plan->id,
            'has_plan' => true,
        ]);

        app(CommissionService::class)->distributeIncome($sourceUser->id, 'plan');

        $this->assertDatabaseHas('incomes', [
            'user_id' => $sponsor->id,
            'from_user_id' => $sourceUser->id,
            'level' => 1,
            'status' => 'credited',
            'type' => 'direct',
            'commission_source' => 'plan',
            'amount' => 150,
        ]);

        $this->assertDatabaseHas('incomes', [
            'user_id' => $topUpline->id,
            'from_user_id' => $sourceUser->id,
            'level' => 2,
            'status' => 'credited',
            'type' => 'level',
            'commission_source' => 'plan',
            'amount' => 100,
        ]);
    }

    private function makeUser(string $name, array $overrides = []): User
    {
        static $seq = 8000;
        $seq++;

        return User::create(array_merge([
            'name' => $name,
            'email' => "unit{$seq}@example.com",
            'password' => bcrypt('Password@123'),
            'user_id' => "UNT{$seq}",
            'status' => 'active',
            'wallet_balance' => 0,
            'total_earned' => 0,
        ], $overrides));
    }
}
