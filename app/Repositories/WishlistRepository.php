<?php

namespace App\Repositories;

use App\Models\Wishlist;
use App\Repositories\Contracts\WishlistRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class WishlistRepository implements WishlistRepositoryInterface
{
    public function getForUser(int $userId): Collection
    {
        return Wishlist::with('product')
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    /**
     * @return bool  true = item added, false = item removed
     */
    public function toggle(int $userId, int $productId): bool
    {
        $existing = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
            return false;
        }

        Wishlist::create([
            'user_id'    => $userId,
            'product_id' => $productId,
        ]);

        return true;
    }

    public function isFavorited(int $userId, int $productId): bool
    {
        return Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();
    }

    public function favoritedIds(int $userId): array
    {
        return Wishlist::where('user_id', $userId)
            ->pluck('product_id')
            ->toArray();
    }
}
