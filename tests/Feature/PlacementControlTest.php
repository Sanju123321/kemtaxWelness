<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlacementControlTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_place_before_ten_directs(): void
    {
        $member = $this->makeUser('Member');
        $downline = $this->makeUser('Downline', [
            'sponsor_id' => $member->id,
            'parent_id' => $member->id,
            'referred_by' => $member->id,
        ]);
        $target = $this->makeUser('Target', [
            'sponsor_id' => $member->id,
            'parent_id' => null,
            'referred_by' => $member->id,
        ]);

        $this->withoutMiddleware();
        $response = $this->actingAs($member)->post(route('member.placement.place'), [
            'place_user_id' => $target->id,
            'placement_parent_id' => $downline->id,
        ]);

        $response->assertSessionHas('error');
        $this->assertNull($target->fresh()->parent_id);
    }

    public function test_user_cannot_place_under_non_downline_member(): void
    {
        $member = $this->makeUser('Member');
        $this->createDirects($member, 10);

        $target = $this->makeUser('Target', [
            'sponsor_id' => $member->id,
            'parent_id' => null,
            'referred_by' => $member->id,
        ]);

        $outsider = $this->makeUser('Outsider');

        $this->withoutMiddleware();
        $response = $this->actingAs($member)->post(route('member.placement.place'), [
            'place_user_id' => $target->id,
            'placement_parent_id' => $outsider->id,
        ]);

        $response->assertSessionHas('error');
        $this->assertNull($target->fresh()->parent_id);
    }

    public function test_user_can_place_once_and_replacement_is_blocked(): void
    {
        $member = $this->makeUser('Member');
        $directs = $this->createDirects($member, 10);

        $target = $this->makeUser('Target', [
            'sponsor_id' => $member->id,
            'parent_id' => null,
            'referred_by' => $member->id,
        ]);

        $firstParent = $directs[0];
        $secondParent = $directs[1];

        $this->withoutMiddleware();

        $first = $this->actingAs($member)->post(route('member.placement.place'), [
            'place_user_id' => $target->id,
            'placement_parent_id' => $firstParent->id,
        ]);
        $first->assertSessionHas('success');
        $this->assertSame($firstParent->id, $target->fresh()->parent_id);

        $second = $this->actingAs($member)->post(route('member.placement.place'), [
            'place_user_id' => $target->id,
            'placement_parent_id' => $secondParent->id,
        ]);
        $second->assertSessionHas('error');
        $this->assertSame($firstParent->id, $target->fresh()->parent_id);
    }

    private function createDirects(User $sponsor, int $count): array
    {
        $users = [];
        for ($i = 0; $i < $count; $i++) {
            $users[] = $this->makeUser("Direct {$i}", [
                'sponsor_id' => $sponsor->id,
                'parent_id' => $sponsor->id,
                'referred_by' => $sponsor->id,
            ]);
        }

        return $users;
    }

    private function makeUser(string $name, array $overrides = []): User
    {
        static $seq = 2000;
        $seq++;

        return User::create(array_merge([
            'name' => $name,
            'email' => "placement{$seq}@example.com",
            'password' => bcrypt('password123'),
            'user_id' => "PLC{$seq}",
            'status' => 'active',
        ], $overrides));
    }
}
