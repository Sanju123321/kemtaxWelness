<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\RepurchaseWalletTopup;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartWishlistTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_update_remove_cart_items(): void
    {
        [$user, $product] = $this->seedUserAndProduct();

        $this->actingAs($user)->postJson(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 2,
        ])->assertOk()->assertJson(['success' => true]);

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $this->actingAs($user)->postJson(route('cart.update'), [
            'product_id' => $product->id,
            'quantity' => 3,
        ])->assertOk()->assertJson(['success' => true]);

        $this->actingAs($user)->postJson(route('cart.remove'), [
            'product_id' => $product->id,
        ])->assertOk()->assertJson(['success' => true]);

        $this->assertDatabaseMissing('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_wishlist_toggle_and_remove(): void
    {
        [$user, $product] = $this->seedUserAndProduct('wishlist');

        $this->actingAs($user)->postJson(route('wishlist.toggle'), [
            'product_id' => $product->id,
        ])->assertOk()->assertJson([
            'success' => true,
            'favorited' => true,
        ]);

        $this->assertDatabaseHas('wishlists', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $this->actingAs($user)->postJson(route('wishlist.remove'), [
            'product_id' => $product->id,
        ])->assertOk()->assertJson(['success' => true]);

        $this->assertDatabaseMissing('wishlists', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_cart_quantity_cannot_exceed_stock(): void
    {
        [$user, $product] = $this->seedUserAndProduct('stock');
        $product->update(['stock' => 3]);

        $this->actingAs($user)->postJson(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 2,
        ])->assertOk()->assertJson(['success' => true]);

        $this->actingAs($user)->postJson(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 2,
        ])->assertStatus(422)->assertJson(['success' => false]);

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    public function test_user_can_checkout_cart_with_repurchase_wallet(): void
    {
        [$user, $product] = $this->seedUserAndProduct('buy');
        $product->update(['stock' => 5, 'price' => 100]);

        RepurchaseWalletTopup::create([
            'user_id' => $user->id,
            'amount' => 500,
            'bank_reference' => 'test_credit',
            'status' => 'approved',
        ]);

        $this->actingAs($user)->postJson(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 2,
        ])->assertOk();

        $this->actingAs($user)->postJson(route('cart.checkout'))
            ->assertOk()
            ->assertJson(['success' => true, 'cart_count' => 0]);

        $this->assertDatabaseMissing('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $this->assertDatabaseHas('product_orders', [
            'user_id' => $user->id,
            'total' => 200,
            'payment_method' => 'repurchase_wallet',
            'payment_status' => 'paid',
        ]);

        $order = ProductOrder::where('user_id', $user->id)->first();

        $this->assertDatabaseHas('product_order_items', [
            'product_order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'line_total' => 200,
        ]);

        $this->assertSame(3, $product->fresh()->stock);
        $this->assertSame(300.0, (float) RepurchaseWalletTopup::where('user_id', $user->id)->sum('amount'));
    }

    public function test_checkout_requires_repurchase_wallet_balance(): void
    {
        [$user, $product] = $this->seedUserAndProduct('poor');
        $product->update(['stock' => 5, 'price' => 100]);

        RepurchaseWalletTopup::create([
            'user_id' => $user->id,
            'amount' => 50,
            'bank_reference' => 'test_credit',
            'status' => 'approved',
        ]);

        $this->actingAs($user)->postJson(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 1,
        ])->assertOk();

        $this->actingAs($user)->postJson(route('cart.checkout'))
            ->assertStatus(422)
            ->assertJson(['success' => false]);

        $this->assertDatabaseCount('product_orders', 0);
        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }

    private function seedUserAndProduct(string $prefix = 'cart'): array
    {
        static $seq = 5000;
        $seq++;

        $user = User::create([
            'name' => "{$prefix} user",
            'email' => "{$prefix}{$seq}@example.com",
            'password' => bcrypt('Password@123'),
            'user_id' => strtoupper($prefix) . $seq,
            'status' => 'active',
            'phone' => '700000000' . ($seq % 10),
        ]);

        $product = Product::create([
            'name' => "{$prefix} product {$seq}",
            'slug' => "{$prefix}-product-{$seq}",
            'category' => 'general',
            'description' => 'Test product',
            'price' => 100,
            'original_price' => 120,
            'stock' => 20,
            'status' => 'active',
            'sku' => strtoupper($prefix) . "SKU{$seq}",
        ]);

        return [$user, $product];
    }
}
