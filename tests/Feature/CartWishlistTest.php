<?php

namespace Tests\Feature;

use App\Models\Product;
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
