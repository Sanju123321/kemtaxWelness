<?php

namespace Tests\Feature;

use App\Models\PhoneVerification;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_sends_otp_and_verification_flow(): void
    {
        PhoneVerification::create([
            'phone' => '9999999999',
            'otp' => '123456',
            'is_verified' => true,
            'expires_at' => now()->addMinutes(10),
        ]);

        $response = $this
            ->withSession(['verified_registration_phone' => '9999999999'])
            ->post(route('register.post'), [
                'name' => 'Test Member',
                'email' => 'member@example.com',
                'phone' => '9999999999',
                'password' => 'Password@123',
                'password_confirmation' => 'Password@123',
            ]);

        $response->assertRedirect(route('member.dashboard'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'phone' => '9999999999',
            'email' => 'member@example.com',
        ]);
    }

    public function test_login_with_credentials_and_logout(): void
    {
        $user = User::create([
            'name' => 'Login User',
            'email' => 'login@example.com',
            'password' => bcrypt('Password@123'),
            'user_id' => 'TST1001',
            'phone' => '8888888888',
            'status' => 'active',
        ]);

        $login = $this->post(route('login.post'), [
            'user_id' => $user->user_id,
            'password' => 'Password@123',
        ]);

        $login->assertRedirect(route('member.dashboard'));
        $this->assertAuthenticatedAs($user);

        $logout = $this->post(route('logout'));
        $logout->assertRedirect(route('home'));
        $this->assertGuest();
    }
}
