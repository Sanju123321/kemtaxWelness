<?php

namespace App\Services;

use App\Models\RecentlyViewed;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class ProductService
{
    private const CACHE_TTL    = 600;
    private const CACHE_PREFIX = 'products_';

    public function __construct(
        private readonly ProductRepositoryInterface $productRepo
    ) {}

    public function listing(array $filters): LengthAwarePaginator
    {
        $isCacheable = empty($filters['search'])
            && (empty($filters['category']) || $filters['category'] === 'all')
            && (empty($filters['price'])    || $filters['price']    === 'all')
            && (empty($filters['sort'])     || $filters['sort']     === 'default')
            && empty($filters['on_sale']);

        if ($isCacheable) {
            $page = request()->get('page', 1);
            $key  = self::CACHE_PREFIX . "listing_page_{$page}";
            return Cache::remember($key, self::CACHE_TTL, fn () =>
                $this->productRepo->paginate($filters)
            );
        }

        return $this->productRepo->paginate($filters);
    }

    public function detail(string $slug)
    {
        $key = self::CACHE_PREFIX . "detail_{$slug}";
        return Cache::remember($key, self::CACHE_TTL, fn () =>
            $this->productRepo->findBySlug($slug)
        );
    }

    public function categories(): array
    {
        return Cache::remember(self::CACHE_PREFIX . 'categories', self::CACHE_TTL, fn () =>
            $this->productRepo->categories()
        );
    }

    public function trackView(int $userId, int $productId): void
    {
        RecentlyViewed::updateOrCreate(
            ['user_id' => $userId, 'product_id' => $productId],
            ['viewed_at' => now()]
        );
    }

    public function recentlyViewed(int $userId, int $limit = 6): \Illuminate\Database\Eloquent\Collection
    {
        return RecentlyViewed::with('product')
            ->where('user_id', $userId)
            ->orderByDesc('viewed_at')
            ->limit($limit)
            ->get()
            ->pluck('product')
            ->filter();
    }

    public function flushCache(): void
    {
        Cache::forget(self::CACHE_PREFIX . 'categories');
        for ($page = 1; $page <= 20; $page++) {
            Cache::forget(self::CACHE_PREFIX . "listing_page_{$page}");
        }
        $this->productRepo->all()->each(function ($product) {
            Cache::forget(self::CACHE_PREFIX . "detail_{$product->slug}");
        });
    }
}

