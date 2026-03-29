<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Services\WishlistService;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService  $productService,
        private readonly WishlistService $wishlistService,
        private readonly CartService     $cartService,
    ) {}

    /**
     * Display all products with optional filtering.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['category', 'price', 'search', 'sort', 'on_sale']);

        $products   = $this->productService->listing($filters);
        $categories = $this->productService->categories();

        $favoritedIds = Auth::check()
            ? $this->wishlistService->favoritedIds(Auth::id())
            : [];

        $cartCount = Auth::check()
            ? $this->cartService->cartCount(Auth::id())
            : 0;

        return view('frontend.products.index', compact(
            'products',
            'categories',
            'favoritedIds',
            'cartCount',
            'filters',
        ));
    }

    /**
     * Display a single product.
     */
    public function show(string $slug)
    {
        $product = $this->productService->detail($slug);

        abort_unless($product, 404);

        // Track recently viewed
        if (Auth::check()) {
            $this->productService->trackView(Auth::id(), $product->id);
        }

        $favorited = Auth::check()
            ? $this->wishlistService->favoritedIds(Auth::id())
            : [];

        $recently = Auth::check()
            ? $this->productService->recentlyViewed(Auth::id())
            : collect();

        return view('frontend.products.show', compact('product', 'favorited', 'recently'));
    }
}
