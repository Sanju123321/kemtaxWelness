<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_sends_otp_and_verification_flow()
    {
        $this->markTestIncomplete('Implement registration + OTP send/verify test.');
    }

    public function test_login_with_credentials_and_logout()
    {
        $this->markTestIncomplete('Implement login/logout test.');
    }
}
