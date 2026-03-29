<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface WishlistRepositoryInterface
{
    public function getForUser(int $userId): Collection;

    public function toggle(int $userId, int $productId): bool; // true = added, false = removed

    public function isFavorited(int $userId, int $productId): bool;

    public function favoritedIds(int $userId): array;
}
