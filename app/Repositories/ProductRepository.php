<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function paginate(array $filters, int $perPage = 12): LengthAwarePaginator
    {
        $query = Product::active()
            ->byCategory($filters['category'] ?? null)
            ->byPriceRange($filters['price'] ?? null)
            ->search($filters['search'] ?? null);

        if (!empty($filters['on_sale'])) {
            $query->whereColumn('price', '<', 'original_price');
        }

        $sort = $filters['sort'] ?? 'default';

        match ($sort) {
            'price-asc'  => $query->orderBy('price'),
            'price-desc' => $query->orderByDesc('price'),
            'rating'     => $query->orderByDesc('rating'),
            'discount'   => $query->orderByRaw('(original_price - price) DESC'),
            default      => $query->orderBy('sort_order')->orderByDesc('created_at'),
        };

        return $query->paginate($perPage)->withQueryString();
    }

    public function findBySlug(string $slug): ?Product
    {
        return Product::active()->where('slug', $slug)->first();
    }

    public function findById(int $id): ?Product
    {
        return Product::find($id);
    }

    public function all(): Collection
    {
        return Product::active()->orderBy('sort_order')->get();
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(int $id, array $data): bool
    {
        return (bool) Product::where('id', $id)->update($data);
    }

    public function delete(int $id): bool
    {
        return (bool) Product::destroy($id);
    }

    public function categories(): array
    {
        return Product::active()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->toArray();
    }
}
