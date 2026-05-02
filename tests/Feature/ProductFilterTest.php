<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_filters_apply_to_listing(): void
    {
        Product::create([
            'name' => 'Giloy Juice',
            'slug' => 'giloy-juice',
            'category' => 'ayurveda',
            'description' => 'Pure giloy stem juice',
            'price' => 299,
            'original_price' => 399,
            'stock' => 10,
            'status' => 'active',
            'sku' => 'GILOY001',
        ]);

        Product::create([
            'name' => 'Neem Face Wash',
            'slug' => 'neem-face-wash',
            'category' => 'skincare',
            'description' => 'Neem face wash',
            'price' => 899,
            'original_price' => 899,
            'stock' => 10,
            'status' => 'active',
            'sku' => 'NEEM001',
        ]);

        $products = (new ProductRepository())->paginate([
            'category' => 'ayurveda',
            'price' => '0-500',
            'on_sale' => 1,
        ]);

        $names = $products->getCollection()->pluck('name');

        $this->assertTrue($names->contains('Giloy Juice'));
        $this->assertFalse($names->contains('Neem Face Wash'));
    }
}
