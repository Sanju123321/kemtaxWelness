@extends('frontend.layouts.master')

@section('title', $product->name . ' - KemtexWellness')

@push('styles')
    <style>
        .product-hero-bg {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            padding: 40px 0
        }

        .product-img-main {
            width: 100%;
            max-height: 420px;
            object-fit: contain;
            border-radius: 12px;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .08)
        }

        .product-emoji-main {
            font-size: 140px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 360px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .08)
        }

        .product-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: #222;
            margin-bottom: 8px
        }

        .product-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
            flex-wrap: wrap
        }

        .product-cat-badge {
            background: #eaf7ef;
            color: #28a745;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700
        }

        .product-stock.in-stock {
            color: #28a745;
            font-size: 13px;
            font-weight: 600
        }

        .product-stock.out-stock {
            color: #dc3545;
            font-size: 13px;
            font-weight: 600
        }

        .price-block {
            margin-bottom: 20px
        }

        .price-block .price-main {
            font-size: 2rem;
            font-weight: 900;
            color: #28a745
        }

        .price-block .price-orig {
            color: #bbb;
            text-decoration: line-through;
            font-size: 1rem;
            margin-left: 8px
        }

        .price-block .price-save {
            background: #dc3545;
            color: #fff;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 700;
            margin-left: 8px
        }

        .qty-control {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px
        }

        .qty-control button {
            width: 36px;
            height: 36px;
            border: 1.5px solid #dee2e6;
            background: #fff;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            font-weight: 700;
            color: #555
        }

        .qty-control button:hover {
            border-color: #28a745;
            color: #28a745
        }

        .qty-control input {
            width: 56px;
            text-align: center;
            border: 1.5px solid #dee2e6;
            border-radius: 8px;
            padding: 6px;
            font-size: 16px;
            font-weight: 700
        }

        .btn-cart-main {
            background: #28a745;
            color: #fff;
            border: none;
            padding: 12px 32px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: background .15s;
            margin-right: 10px
        }

        .btn-cart-main:hover {
            background: #1e7e34
        }

        .btn-wishlist-main {
            background: #fff;
            color: #e53935;
            border: 2px solid #e53935;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all .15s
        }

        .btn-wishlist-main.active,
        .btn-wishlist-main:hover {
            background: #e53935;
            color: #fff
        }

        .benefits-list {
            list-style: none;
            padding: 0;
            margin: 0
        }

        .benefits-list li {
            padding: 6px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #555
        }

        .benefits-list li:last-child {
            border: none
        }

        .benefits-list li::before {
            content: "✓ ";
            color: #28a745;
            font-weight: 700
        }

        .section-heading {
            font-size: 1.1rem;
            font-weight: 700;
            color: #222;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid #28a745;
            display: inline-block
        }

        .related-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .07);
            overflow: hidden;
            transition: all .25s
        }

        .related-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, .12)
        }

        .related-img {
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            font-size: 50px
        }

        .related-body {
            padding: 12px
        }

        #toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 8px
        }

        .toast-msg {
            background: #222;
            color: #fff;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            box-shadow: 0 4px 16px rgba(0, 0, 0, .2);
            animation: slideIn .25s ease;
            max-width: 280px
        }

        .toast-msg.success {
            border-left: 4px solid #28a745
        }

        .toast-msg.error {
            border-left: 4px solid #dc3545
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(40px)
            }

            to {
                opacity: 1;
                transform: translateX(0)
            }
        }
    </style>
@endpush

@section('content')

    <div id="toast-container"></div>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="product-hero-bg">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb" style="background:none;padding:0;font-size:13px;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products') }}">Products</a></li>
                    <li class="breadcrumb-item active">{{ $product->name }}</li>
                </ol>
            </nav>

            <div class="row align-items-center">
                {{-- Image --}}
                <div class="col-lg-5 col-md-6 mb-4 mb-md-0">
                    @if ($product->image)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-img-main">
                    @else
                        <div class="product-emoji-main">🌿</div>
                    @endif
                </div>

                {{-- Details --}}
                <div class="col-lg-7 col-md-6">
                    <div class="product-meta">
                        <span class="product-cat-badge">{{ ucfirst($product->category) }}</span>
                        @if ($product->in_stock)
                            <span class="product-stock in-stock"><i class="fas fa-check-circle mr-1"></i>In Stock</span>
                        @else
                            <span class="product-stock out-stock"><i class="fas fa-times-circle mr-1"></i>Out of
                                Stock</span>
                        @endif
                    </div>

                    <h1 class="product-title">{{ $product->name }}</h1>

                    {{-- Rating --}}
                    <div class="d-flex align-items-center mb-3">
                        @for ($s = 1; $s <= 5; $s++)
                            <i class="{{ $s <= round($product->rating) ? 'fas' : 'far' }} fa-star"
                                style="color:#ffc107;font-size:14px;"></i>
                        @endfor
                        <span class="ml-2" style="font-size:13px;color:#888;">{{ $product->rating }}
                            ({{ $product->review_count }} reviews)</span>
                    </div>

                    {{-- Price --}}
                    <div class="price-block">
                        <span class="price-main">₹{{ number_format($product->price, 0) }}</span>
                        @if ($product->original_price)
                            <span class="price-orig">₹{{ number_format($product->original_price, 0) }}</span>
                            @if ($product->discount_percent > 0)
                                <span class="price-save">{{ $product->discount_percent }}% OFF</span>
                            @endif
                        @endif
                    </div>

                    {{-- Short description --}}
                    @if ($product->short_desc)
                        <p class="mb-3" style="color:#555;font-size:14px;line-height:1.7;">{{ $product->short_desc }}</p>
                    @endif

                    {{-- Benefits --}}
                    @if ($product->benefits)
                        <ul class="benefits-list mb-4">
                            @foreach ($product->benefits as $b)
                                <li>{{ $b }}</li>
                            @endforeach
                        </ul>
                    @endif

                    {{-- Quantity + Actions --}}
                    @auth
                        <div class="qty-control">
                            <button type="button" onclick="changeQty(-1)">−</button>
                            <input type="number" id="qtyInput" value="1" min="1" max="99">
                            <button type="button" onclick="changeQty(1)">+</button>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn-cart-main" id="cartBtn" data-product-id="{{ $product->id }}"
                                data-product-name="{{ $product->name }}" onclick="addToCartDetail()">
                                <i class="fas fa-shopping-bag mr-2"></i>Add to Bag
                            </button>
                            <button type="button"
                                class="btn-wishlist-main {{ in_array($product->id, $favorited) ? 'active' : '' }}"
                                id="wishBtn" data-product-id="{{ $product->id }}" onclick="toggleWishlist(this)">
                                <i class="{{ in_array($product->id, $favorited) ? 'fas' : 'far' }} fa-heart mr-1"></i>
                                {{ in_array($product->id, $favorited) ? 'Wishlisted' : 'Wishlist' }}
                            </button>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn-cart-main"
                            style="display:inline-block;text-decoration:none;">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login to Add to Bag
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    {{-- Description --}}
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <span class="section-heading">Product Description</span>
                    <div style="color:#555;font-size:14px;line-height:1.8;margin-top:12px;">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="p-4" style="background:#f8f9fa;border-radius:10px;">
                        <span class="section-heading">Quick Info</span>
                        <table class="table table-sm mt-3" style="font-size:13px;">
                            <tr>
                                <td style="color:#888">SKU</td>
                                <td><strong>{{ $product->sku ?? 'N/A' }}</strong></td>
                            </tr>
                            <tr>
                                <td style="color:#888">Category</td>
                                <td><strong>{{ ucfirst($product->category) }}</strong></td>
                            </tr>
                            <tr>
                                <td style="color:#888">Rating</td>
                                <td><strong>{{ $product->rating }}/5</strong></td>
                            </tr>
                            <tr>
                                <td style="color:#888">Stock</td>
                                <td><strong>{{ $product->stock }} units</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Recently Viewed --}}
    @if ($recently->count())
        <section class="py-4" style="background:#fafafa;">
            <div class="container">
                <span class="section-heading">Recently Viewed</span>
                <div class="row mt-3">
                    @foreach ($recently as $rv)
                        <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-3">
                            <a href="{{ route('products.show', $rv->slug) }}" style="text-decoration:none;">
                                <div class="related-card">
                                    <div class="related-img">🌿</div>
                                    <div class="related-body">
                                        <div style="font-size:12px;font-weight:700;color:#222;">
                                            {{ Str::limit($rv->name, 28) }}</div>
                                        <div style="font-size:13px;color:#28a745;font-weight:700;">
                                            ₹{{ number_format($rv->price, 0) }}</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection

@push('scripts')
    <script>
        const IS_AUTH = {{ auth()->check() ? 'true' : 'false' }};
        const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function toast(msg, type) {
            type = type || 'success';
            var el = document.createElement('div');
            el.className = 'toast-msg ' + type;
            el.textContent = msg;
            document.getElementById('toast-container').appendChild(el);
            setTimeout(function() {
                el.remove();
            }, 3500);
        }

        function changeQty(delta) {
            var input = document.getElementById('qtyInput');
            var val = parseInt(input.value) + delta;
            if (val < 1) val = 1;
            if (val > 99) val = 99;
            input.value = val;
        }

        function addToCartDetail() {
            var btn = document.getElementById('cartBtn');
            var productId = btn.dataset.productId;
            var qty = parseInt(document.getElementById('qtyInput').value) || 1;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Adding...';
            fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: parseInt(productId),
                        quantity: qty
                    })
                })
                .then(function(r) {
                    return r.json();
                })
                .then(function(data) {
                    if (data.success) {
                        toast(data.message || 'Added to bag!', 'success');
                        btn.innerHTML = '<i class="fas fa-check mr-2"></i>Added to Bag';
                        setTimeout(function() {
                            btn.innerHTML = '<i class="fas fa-shopping-bag mr-2"></i>Add to Bag';
                            btn.disabled = false;
                        }, 2500);
                    } else {
                        toast(data.message || 'Could not add.', 'error');
                        btn.innerHTML = '<i class="fas fa-shopping-bag mr-2"></i>Add to Bag';
                        btn.disabled = false;
                    }
                })
                .catch(function() {
                    toast('Network error.', 'error');
                    btn.innerHTML = '<i class="fas fa-shopping-bag mr-2"></i>Add to Bag';
                    btn.disabled = false;
                });
        }

        function toggleWishlist(btn) {
            if (!IS_AUTH) {
                window.location.href = '{{ route('login') }}';
                return;
            }
            var productId = btn.dataset.productId;
            fetch('{{ route('wishlist.toggle') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: parseInt(productId)
                    })
                })
                .then(function(r) {
                    return r.json();
                })
                .then(function(data) {
                    if (data.success) {
                        var icon = btn.querySelector('i');
                        if (data.favorited) {
                            btn.classList.add('active');
                            icon.className = 'fas fa-heart mr-1';
                            btn.childNodes[btn.childNodes.length - 1].textContent = ' Wishlisted';
                            toast('Added to wishlist', 'success');
                        } else {
                            btn.classList.remove('active');
                            icon.className = 'far fa-heart mr-1';
                            btn.childNodes[btn.childNodes.length - 1].textContent = ' Wishlist';
                            toast('Removed from wishlist', 'success');
                        }
                    }
                })
                .catch(function() {
                    toast('Network error.', 'error');
                });
        }
    </script>
@endpush
