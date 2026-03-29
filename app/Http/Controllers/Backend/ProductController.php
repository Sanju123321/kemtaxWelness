<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService
    ) {}

    /**
     * Display a listing of all products.
     */
    public function index()
    {
        $products = Product::latest()->paginate(15);
        return view('backend.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('backend.products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'category'       => ['required', 'string'],
            'price'          => ['required', 'numeric', 'min:0'],
            'original_price' => ['nullable', 'numeric', 'min:0'],
            'stock'          => ['required', 'integer', 'min:0'],
            'description'    => ['nullable', 'string'],
            'short_desc'     => ['nullable', 'string', 'max:500'],
            'image'          => ['nullable', 'image', 'max:2048'],
            'status'         => ['required', 'in:active,inactive'],
            'sku'            => ['nullable', 'string', 'unique:products,sku'],
            'sort_order'     => ['nullable', 'integer'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);
        $this->productService->flushCache();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing a product.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('backend.products.edit', compact('product'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'category'       => ['required', 'string'],
            'price'          => ['required', 'numeric', 'min:0'],
            'original_price' => ['nullable', 'numeric', 'min:0'],
            'stock'          => ['required', 'integer', 'min:0'],
            'description'    => ['nullable', 'string'],
            'short_desc'     => ['nullable', 'string', 'max:500'],
            'image'          => ['nullable', 'image', 'max:2048'],
            'status'         => ['required', 'in:active,inactive'],
            'sku'            => ['nullable', 'string', 'unique:products,sku,' . $id],
            'sort_order'     => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);
        $this->productService->flushCache();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product.
     */
    public function destroy(string $id)
    {
        Product::findOrFail($id)->delete();
        $this->productService->flushCache();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
