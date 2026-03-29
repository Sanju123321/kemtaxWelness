<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'short_desc',
        'price',
        'original_price',
        'image',
        'benefits',
        'tags',
        'stock',
        'rating',
        'review_count',
        'status',
        'sku',
        'sort_order',
    ];

    protected $casts = [
        'benefits'       => 'array',
        'tags'           => 'array',
        'price'          => 'decimal:2',
        'original_price' => 'decimal:2',
        'rating'         => 'decimal:2',
    ];

    // ── Relationships ──────────────────────────────────────────────

    public function cartItems(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    // ── Accessors ──────────────────────────────────────────────────

    /**
     * Discount percentage computed on the fly.
     */
    public function getDiscountPercentAttribute(): int
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return (int) round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return 0;
    }

    /**
     * Public image URL (falls back to a placeholder).
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('frontend/images/product-placeholder.png');
    }

    /**
     * Whether the product is in stock.
     */
    public function getInStockAttribute(): bool
    {
        return $this->stock > 0;
    }

    // ── Mutators ───────────────────────────────────────────────────

    /**
     * Auto-generate slug from name if not supplied.
     */
    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    // ── Scopes ─────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByCategory($query, ?string $category)
    {
        return $category && $category !== 'all'
            ? $query->where('category', $category)
            : $query;
    }

    public function scopeByPriceRange($query, ?string $range)
    {
        return match ($range) {
            '0-500'     => $query->whereBetween('price', [0, 500]),
            '500-1000'  => $query->whereBetween('price', [500, 1000]),
            '1000-2000' => $query->whereBetween('price', [1000, 2000]),
            '2000+'     => $query->where('price', '>=', 2000),
            default     => $query,
        };
    }

    public function scopeSearch($query, ?string $term)
    {
        return $term
            ? $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%")
                  ->orWhere('short_desc', 'like', "%{$term}%")
                  ->orWhere('category', 'like', "%{$term}%");
            })
            : $query;
    }
}
