<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentPurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_order_and_verify_payment_webhook(): void
    {
        $user = User::create([
            'name' => 'Payment User',
            'email' => 'payment@example.com',
            'password' => bcrypt('Password@123'),
            'user_id' => 'PAY1001',
            'phone' => '7777777777',
            'status' => 'active',
        ]);

        $this->withoutMiddleware();

        // Validation should fail before any Razorpay API call.
        $createOrder = $this->actingAs($user)->postJson(route('member.member.create.order'), []);
        $createOrder->assertStatus(422)->assertJsonValidationErrors(['amount']);

        // Webhook endpoint should be reachable and return a success ACK.
        $webhook = $this->actingAs($user)->post('/member/razorpay/webhook', [
            'event' => 'payment.captured',
            'payload' => ['payment' => ['entity' => ['id' => 'pay_test']]],
        ]);

        $webhook->assertOk()->assertJson(['status' => 'ok']);
    }
}
