<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Repositories\Contracts\CartRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CartRepository implements CartRepositoryInterface
{
    public function getForUser(int $userId): Collection
    {
        return Cart::with('product')
            ->where('user_id', $userId)
            ->get();
    }

    public function addOrIncrement(int $userId, int $productId, int $qty = 1): Cart
    {
        $cart = Cart::firstOrNew([
            'user_id'    => $userId,
            'product_id' => $productId,
        ]);

        $cart->quantity = $cart->exists ? $cart->quantity + $qty : $qty;
        $cart->save();

        return $cart->load('product');
    }

    public function remove(int $userId, int $productId): bool
    {
        return (bool) Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();
    }

    public function clear(int $userId): bool
    {
        return (bool) Cart::where('user_id', $userId)->delete();
    }

    public function count(int $userId): int
    {
        return Cart::where('user_id', $userId)->sum('quantity');
    }

    public function itemTotal(int $userId): float
    {
        return Cart::with('product')
            ->where('user_id', $userId)
            ->get()
            ->sum(fn($item) => $item->quantity * ($item->product->price ?? 0));
    }

    public function update(int $userId, int $productId, int $qty): Cart
    {
        $cart = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->firstOrFail();

        $cart->quantity = $qty;
        $cart->save();

        return $cart->load('product');
    }
}
