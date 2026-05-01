<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        $featuredProducts = Product::query()
            ->active()
            ->orderByDesc('id')
            ->take(4)
            ->get()
            ->map(function (Product $product) {
                return [
                    'name' => $product->name,
                    'desc' => Str::limit((string) ($product->short_desc ?: $product->description), 75),
                    'price' => (float) $product->price,
                    'mrp' => (float) ($product->original_price ?? 0),
                    'dosha' => Str::upper((string) $product->category),
                    'badge' => $product->discount_percent > 0 ? 'Sale' : '',
                    'image' => $product->image_url,
                    'url' => route('products.show', $product->slug),
                ];
            });

        return view('frontend.home.index', compact('featuredProducts'));
    }
}
