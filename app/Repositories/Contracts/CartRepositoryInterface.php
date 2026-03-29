<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Cart;

interface CartRepositoryInterface
{
    public function getForUser(int $userId): Collection;

    public function addOrIncrement(int $userId, int $productId, int $qty = 1): Cart;

    public function remove(int $userId, int $productId): bool;

    public function clear(int $userId): bool;

    public function count(int $userId): int;

    public function itemTotal(int $userId): float;

    public function update(int $userId, int $productId, int $qty): Cart;
}
