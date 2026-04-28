<?php

namespace Tests\Feature;

use App\Models\PhoneVerification;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class RegistrationPlacementIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_auto_places_tenth_direct_and_leaves_eleventh_unplaced(): void
    {
        $this->ensureReferralColumnsForTestDatabase();

        $sponsor = User::create([
            'name' => 'Sponsor',
            'email' => 'sponsor@example.com',
            'password' => bcrypt('password123'),
            'user_id' => 'SPN100001',
            'reference_code' => 'REFSPN001',
            'status' => 'active',
        ]);

        // Existing 9 directs under sponsor.
        for ($i = 1; $i <= 9; $i++) {
            User::create([
                'name' => "Existing Direct {$i}",
                'email' => "existing.direct{$i}@example.com",
                'password' => bcrypt('password123'),
                'user_id' => 'ED' . str_pad((string) $i, 6, '0', STR_PAD_LEFT),
                'reference_code' => 'REFED' . str_pad((string) $i, 3, '0', STR_PAD_LEFT),
                'status' => 'active',
                'referred_by' => $sponsor->id,
                'sponsor_id' => $sponsor->id,
                'parent_id' => $sponsor->id,
            ]);
        }

        // 10th direct should be auto-placed under sponsor.
        PhoneVerification::create([
            'phone' => '9000000001',
            'otp' => '123456',
            'is_verified' => true,
            'expires_at' => now()->addMinutes(10),
        ]);

        $responseTenth = $this->withSession(['verified_registration_phone' => '9000000001'])
            ->post(route('register.post'), [
                'name' => 'Tenth Direct',
                'email' => 'tenth.direct@example.com',
                'phone' => '9000000001',
                'reference_code' => $sponsor->reference_code,
                'password' => 'Password@123',
                'password_confirmation' => 'Password@123',
            ]);

        $responseTenth->assertRedirect(route('member.dashboard'));

        $tenth = User::where('email', 'tenth.direct@example.com')->firstOrFail();
        $this->assertSame($sponsor->id, $tenth->sponsor_id);
        $this->assertSame($sponsor->id, $tenth->parent_id);

        Auth::logout();

        // 11th direct should stay unplaced for manual placement.
        PhoneVerification::create([
            'phone' => '9000000002',
            'otp' => '123456',
            'is_verified' => true,
            'expires_at' => now()->addMinutes(10),
        ]);

        $responseEleventh = $this->withSession(['verified_registration_phone' => '9000000002'])
            ->post(route('register.post'), [
                'name' => 'Eleventh Direct',
                'email' => 'eleventh.direct@example.com',
                'phone' => '9000000002',
                'reference_code' => $sponsor->reference_code,
                'password' => 'Password@123',
                'password_confirmation' => 'Password@123',
            ]);

        $responseEleventh->assertRedirect(route('member.dashboard'));

        $eleventh = User::where('email', 'eleventh.direct@example.com')->firstOrFail();
        $this->assertSame($sponsor->id, $eleventh->sponsor_id);
        $this->assertNull($eleventh->parent_id);
    }

    private function ensureReferralColumnsForTestDatabase(): void
    {
        if (!Schema::hasColumn('users', 'phone')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('phone')->nullable();
            });
        }

        if (!Schema::hasColumn('users', 'reference_code')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('reference_code')->nullable();
            });
        }

        if (!Schema::hasColumn('users', 'referred_by')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('referred_by')->nullable();
            });
        }

        if (!Schema::hasColumn('users', 'sponsor_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('sponsor_id')->nullable();
            });
        }

        if (!Schema::hasColumn('users', 'parent_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('parent_id')->nullable();
            });
        }
    }
}
