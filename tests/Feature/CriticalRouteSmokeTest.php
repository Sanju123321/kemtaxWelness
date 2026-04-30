<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use App\Http\Middleware\CheckKycVerified;
use App\Http\Middleware\CheckMaintenanceMode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CriticalRouteSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_routes_are_reachable(): void
    {
        $this->get(route('home'))->assertStatus(200);
        $this->get(route('products'))->assertStatus(200);
        $this->get(route('login'))->assertStatus(200);
        $this->get(route('admin.login'))->assertStatus(200);
    }

    public function test_member_critical_routes_do_not_throw_server_errors_for_authenticated_user(): void
    {
        $this->withoutMiddleware([
            CheckMaintenanceMode::class,
            CheckKycVerified::class,
        ]);
        $user = $this->makeUser();

        $this->actingAs($user)->get(route('member.dashboard'))->assertStatus(200);
        $this->actingAs($user)->get(route('member.wallet'))->assertStatus(200);
        $this->actingAs($user)->get(route('member.profile'))->assertStatus(200);
        $this->actingAs($user)->get(route('member.credentials'))->assertStatus(200);
        $this->actingAs($user)->get(route('member.team'))->assertStatus(200);
        $this->actingAs($user)->get(route('member.commissions.history'))->assertStatus(200);
    }

    public function test_admin_critical_routes_work_with_admin_guard(): void
    {
        $admin = Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('Password@123'),
        ]);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.dashboard'))
            ->assertOk();
    }

    private function makeUser(): User
    {
        static $seq = 9000;
        $seq++;

        return User::create([
            'name' => 'Smoke User',
            'email' => "smoke{$seq}@example.com",
            'password' => bcrypt('Password@123'),
            'user_id' => "SMK{$seq}",
            'phone' => '900000000' . ($seq % 10),
            'status' => 'active',
        ]);
    }
}
