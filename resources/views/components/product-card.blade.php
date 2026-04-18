{{-- Product Card Component --}}
{{-- Usage: @include('components.product-card', ['product' => [...] ]) --}}

<div class="kw-product-card">
    <div class="kw-product-img-wrap">
        <img src="{{ $product['image'] ?? asset('frontend/images/blog/1.jpg') }}"
            alt="{{ $product['name'] ?? 'Product' }}" loading="lazy">
        @if (!empty($product['badge']))
            <span class="kw-product-badge">{{ $product['badge'] }}</span>
        @endif
        <div class="kw-product-overlay">
            <a href="{{ $product['url'] ?? route('products') }}" class="kw-overlay-btn">
                <i class="fas fa-eye"></i> Quick View
            </a>
        </div>
    </div>
    <div class="kw-product-body">
        @if (!empty($product['dosha']))
            <span class="kw-dosha-label kw-dosha-{{ strtolower($product['dosha']) }}">{{ $product['dosha'] }}</span>
        @endif
        <h5 class="kw-product-name">{{ $product['name'] ?? 'Product Name' }}</h5>
        <p class="kw-product-desc">{{ $product['desc'] ?? '' }}</p>
        <div class="kw-product-footer">
            <span class="kw-product-price">₹{{ $product['price'] ?? '0' }}</span>
            @if (!empty($product['mrp']) && $product['mrp'] > $product['price'])
                <span class="kw-product-mrp">₹{{ $product['mrp'] }}</span>
            @endif
            <a href="{{ $product['url'] ?? route('products') }}" class="kw-add-cart-btn">
                <i class="fas fa-shopping-bag"></i> Add to Bag
            </a>
        </div>
    </div>
</div>
