<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class RoyaltyTestSeeder extends Seeder
{
    /**
     * Seed focused MLM royalty test data.
     */
    public function run(): void
    {
        $sponsor = $this->createUser('Royalty Sponsor', 'royalty.sponsor@example.com', 'ROY100001');

        // 50 directs under sponsor. First 10 auto-placed under sponsor, remaining unplaced.
        for ($i = 1; $i <= 50; $i++) {
            $index = str_pad((string) $i, 3, '0', STR_PAD_LEFT);
            User::create([
                'name' => "Royalty Direct {$i}",
                'email' => "royalty.direct{$index}@example.com",
                'password' => bcrypt('password123'),
                'user_id' => "ROYD{$index}",
                'status' => 'active',
                'referred_by' => $sponsor->id,
                'sponsor_id' => $sponsor->id,
                'parent_id' => $i <= 10 ? $sponsor->id : null,
            ]);
        }

        // A non-downline user for placement negative-case testing.
        $this->createUser('Outside Member', 'outside.member@example.com', 'ROY999001');
    }

    private function createUser(string $name, string $email, string $userId): User
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt('password123'),
            'user_id' => $userId,
            'status' => 'active',
        ]);
    }
}
