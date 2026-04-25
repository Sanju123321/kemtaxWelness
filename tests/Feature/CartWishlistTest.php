<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartWishlistTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_update_remove_cart_items()
    {
        $this->markTestIncomplete('Implement cart add/update/remove tests (JSON endpoints).');
    }

    public function test_wishlist_toggle_and_remove()
    {
        $this->markTestIncomplete('Implement wishlist toggle/remove tests (auth required).');
    }
}
