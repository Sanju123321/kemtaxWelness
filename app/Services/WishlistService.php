<?php

namespace App\Services;

use App\Repositories\Contracts\WishlistRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class WishlistService
{
    public function __construct(
        private readonly WishlistRepositoryInterface $wishlistRepo
    ) {}

    public function toggle(int $userId, int $productId): array
    {
        $added = $this->wishlistRepo->toggle($userId, $productId);

        return [
            'success'     => true,
            'favorited'   => $added,
            'message'     => $added ? 'Added to wishlist.' : 'Removed from wishlist.',
            'wish_count'  => count($this->wishlistRepo->favoritedIds($userId)),
        ];
    }

    public function remove(int $userId, int $productId): bool
    {
        return \App\Models\Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete() > 0;
    }

    public function getWishlist(int $userId): Collection
    {
        return $this->wishlistRepo->getForUser($userId);
    }

    public function favoritedIds(int $userId): array
    {
        return $this->wishlistRepo->favoritedIds($userId);
    }
}
