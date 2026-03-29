<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Product;

interface ProductRepositoryInterface
{
    public function paginate(array $filters, int $perPage = 12): LengthAwarePaginator;

    public function findBySlug(string $slug): ?Product;

    public function findById(int $id): ?Product;

    public function all(): Collection;

    public function create(array $data): Product;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    public function categories(): array;
}
