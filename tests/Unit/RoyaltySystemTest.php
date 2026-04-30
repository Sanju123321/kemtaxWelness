<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoyaltySystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_royalty_percentage_follows_direct_referral_thresholds(): void
    {
        $sponsor = $this->makeUser('Sponsor');

        $this->assertSame(0.0, $sponsor->getRoyaltyPercentage());

        $this->createDirects($sponsor, 15);
        $this->assertSame(10.0, $sponsor->fresh()->getRoyaltyPercentage());

        $this->createDirects($sponsor, 5);
        $this->assertSame(15.0, $sponsor->fresh()->getRoyaltyPercentage());

        $this->createDirects($sponsor, 10);
        $this->assertSame(18.0, $sponsor->fresh()->getRoyaltyPercentage());

        $this->createDirects($sponsor, 20);
        $this->assertSame(20.0, $sponsor->fresh()->getRoyaltyPercentage());
    }

    public function test_parent_placement_changes_do_not_affect_direct_count_or_royalty(): void
    {
        $sponsor = $this->makeUser('Sponsor');
        $downlineParent = $this->makeUser('Downline Parent', [
            'sponsor_id' => $sponsor->id,
            'parent_id' => $sponsor->id,
            'referred_by' => $sponsor->id,
        ]);

        $this->createDirects($sponsor, 14);
        $target = $this->makeUser('Target Direct', [
            'sponsor_id' => $sponsor->id,
            'parent_id' => null,
            'referred_by' => $sponsor->id,
        ]);

        $this->assertSame(16, $sponsor->fresh()->getDirectReferralCount());
        $this->assertSame(10.0, $sponsor->fresh()->getRoyaltyPercentage());

        $target->update(['parent_id' => $downlineParent->id]);

        $this->assertSame(16, $sponsor->fresh()->getDirectReferralCount());
        $this->assertSame(10.0, $sponsor->fresh()->getRoyaltyPercentage());
    }

    public function test_legacy_referred_by_records_are_counted_when_sponsor_id_is_null(): void
    {
        $sponsor = $this->makeUser('Legacy Sponsor');

        $this->makeUser('Legacy Direct', [
            'sponsor_id' => null,
            'referred_by' => $sponsor->id,
            'parent_id' => null,
        ]);

        $this->assertSame(1, $sponsor->fresh()->getDirectReferralCount());
    }

    private function createDirects(User $sponsor, int $count): void
    {
        for ($i = 0; $i < $count; $i++) {
            $this->makeUser("Direct {$i}", [
                'sponsor_id' => $sponsor->id,
                'parent_id' => $sponsor->id,
                'referred_by' => $sponsor->id,
            ]);
        }
    }

    private function makeUser(string $name, array $overrides = []): User
    {
        static $seq = 1000;
        $seq++;

        return User::create(array_merge([
            'name' => $name,
            'email' => "royalty{$seq}@example.com",
            'password' => bcrypt('password123'),
            'user_id' => "TST{$seq}",
            'status' => 'active',
        ], $overrides));
    }
}
