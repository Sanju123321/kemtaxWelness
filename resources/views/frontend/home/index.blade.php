@extends('frontend.layouts.master')

@section('title', 'Welcome to KemtexWellness')
@section('meta_description', 'Discover natural health and wellness products at KemtexWellness. Premium supplements,
    herbal teas, vitamins and more.')

@section('content')

    {{-- ==================== HERO SECTION ==================== --}}
    <section class="hero-section bg-gradient"
        style="background: linear-gradient(135deg, #1a472a 0%, #2d7a4f 50%, #40c074 100%); min-height: 85vh;">
        <div class="container h-100">
            <div class="row align-items-center min-vh-85 py-5">
                <div class="col-lg-6 text-white">
                    <span class="badge bg-success bg-opacity-75 mb-3 px-3 py-2 fs-6">
                        <i class="bi bi-leaf me-1"></i> 100% Natural & Organic
                    </span>
                    <h1 class="display-4 fw-bold lh-sm mb-4">
                        Transform Your Health with
                        <span class="text-warning">Nature's Best</span>
                    </h1>
                    <p class="lead text-white-75 mb-4">
                        Discover our premium range of wellness products crafted from nature's finest ingredients.
                        Experience the power of holistic health — from supplements to herbal teas and beyond.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mb-5">
                        <a href="{{ route('products') }}" class="btn btn-warning btn-lg fw-semibold px-4">
                            <i class="bi bi-bag2 me-2"></i>Shop Now
                        </a>
                        <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg px-4">
                            <i class="bi bi-play-circle me-2"></i>Learn More
                        </a>
                    </div>
                    <div class="row g-3 text-center text-lg-start">
                        <div class="col-4">
                            <div class="fw-bold fs-4">5,000+</div>
                            <div class="small text-white-50">Happy Customers</div>
                        </div>
                        <div class="col-4">
                            <div class="fw-bold fs-4">200+</div>
                            <div class="small text-white-50">Products</div>
                        </div>
                        <div class="col-4">
                            <div class="fw-bold fs-4">10+</div>
                            <div class="small text-white-50">Years Experience</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block text-center">
                    <img src="{{ asset('frontend/images/hero.png') }}" alt="Wellness Products" class="img-fluid"
                        style="max-height:480px; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.3));"
                        onerror="this.src='https://placehold.co/500x480/40c074/white?text=KemtexWellness';" />
                </div>
            </div>
        </div>
    </section>

    {{-- ==================== FEATURES STRIP ==================== --}}
    <section class="py-4 bg-success text-white">
        <div class="container">
            <div class="row g-3 text-center">
                <div class="col-6 col-md-3">
                    <i class="bi bi-truck fs-3 mb-1 d-block"></i>
                    <div class="small fw-semibold">Free Shipping Over $50</div>
                </div>
                <div class="col-6 col-md-3">
                    <i class="bi bi-shield-check fs-3 mb-1 d-block"></i>
                    <div class="small fw-semibold">100% Authentic</div>
                </div>
                <div class="col-6 col-md-3">
                    <i class="bi bi-arrow-counterclockwise fs-3 mb-1 d-block"></i>
                    <div class="small fw-semibold">30-Day Returns</div>
                </div>
                <div class="col-6 col-md-3">
                    <i class="bi bi-headset fs-3 mb-1 d-block"></i>
                    <div class="small fw-semibold">24/7 Support</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ==================== CATEGORIES ==================== --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Shop by Category</h2>
                <p class="text-muted">Explore our range of wellness categories</p>
            </div>
            <div class="row g-4">
                @php
                    $categories = [
                        ['icon' => 'capsule', 'name' => 'Supplements', 'count' => 48, 'color' => 'primary'],
                        ['icon' => 'cup-hot', 'name' => 'Herbal Teas', 'count' => 32, 'color' => 'success'],
                        ['icon' => 'droplet', 'name' => 'Vitamins', 'count' => 56, 'color' => 'warning'],
                        ['icon' => 'bag-heart', 'name' => 'Wellness Kits', 'count' => 24, 'color' => 'danger'],
                        ['icon' => 'stars', 'name' => 'Detox Range', 'count' => 18, 'color' => 'info'],
                        ['icon' => 'flower1', 'name' => 'Skincare', 'count' => 40, 'color' => 'secondary'],
                    ];
                @endphp

                @foreach ($categories as $cat)
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('products') }}" class="text-decoration-none">
                            <div class="card border-0 shadow-sm text-center py-4 h-100 card-hover">
                                <div class="card-body">
                                    <div class="icon-box rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center
                                        bg-{{ $cat['color'] }} bg-opacity-10"
                                        style="width:64px;height:64px;">
                                        <i class="bi bi-{{ $cat['icon'] }} fs-3 text-{{ $cat['color'] }}"></i>
                                    </div>
                                    <div class="fw-semibold small">{{ $cat['name'] }}</div>
                                    <div class="text-muted" style="font-size:0.75rem;">{{ $cat['count'] }} items</div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    {{-- ==================== FEATURED PRODUCTS ==================== --}}
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-5">
                <div>
                    <h2 class="fw-bold mb-1">Featured Products</h2>
                    <p class="text-muted mb-0">Hand-picked bestsellers for your wellness journey</p>
                </div>
                <a href="{{ route('products') }}" class="btn btn-outline-success">
                    View All <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="row g-4">

                @php
                    $products = [
                        [
                            'name' => 'Daily Vitality Pack',
                            'price' => 49.99,
                            'old_price' => 65.0,
                            'rating' => 5,
                            'reviews' => 128,
                            'badge' => 'Bestseller',
                            'badge_color' => 'warning',
                        ],
                        [
                            'name' => 'Immune Boost Complex',
                            'price' => 34.99,
                            'old_price' => null,
                            'rating' => 4,
                            'reviews' => 87,
                            'badge' => 'New',
                            'badge_color' => 'success',
                        ],
                        [
                            'name' => 'Herbal Detox Tea',
                            'price' => 22.5,
                            'old_price' => 30.0,
                            'rating' => 5,
                            'reviews' => 214,
                            'badge' => '-25%',
                            'badge_color' => 'danger',
                        ],
                        [
                            'name' => 'Omega-3 Premium',
                            'price' => 38.0,
                            'old_price' => null,
                            'rating' => 4,
                            'reviews' => 63,
                            'badge' => null,
                            'badge_color' => null,
                        ],
                    ];
                @endphp

                @foreach ($products as $product)
                    <div class="col-sm-6 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm product-card">
                            <div class="position-relative overflow-hidden" style="height:220px; background:#f8f9fa;">
                                @if ($product['badge'])
                                    <span
                                        class="badge bg-{{ $product['badge_color'] }} position-absolute top-0 start-0 m-2">
                                        {{ $product['badge'] }}
                                    </span>
                                @endif
                                <img src="{{ asset('frontend/images/product-placeholder.jpg') }}"
                                    class="img-fluid w-100 h-100 object-fit-cover" alt="{{ $product['name'] }}"
                                    onerror="this.src='https://placehold.co/300x220/f8f9fa/198754?text={{ urlencode($product['name']) }}';" />
                                <div class="product-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center gap-2"
                                    style="background:rgba(0,0,0,0.4); opacity:0; transition:0.3s;">
                                    <a href="#" class="btn btn-sm btn-light rounded-circle" title="Quick View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-light rounded-circle" title="Wishlist">
                                        <i class="bi bi-heart"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="fw-semibold mb-1">{{ $product['name'] }}</h6>
                                <div class="text-warning small mb-2">
                                    @for ($i = 0; $i < $product['rating']; $i++)
                                        <i class="bi bi-star-fill"></i>
                                    @endfor
                                    @for ($i = $product['rating']; $i < 5; $i++)
                                        <i class="bi bi-star text-muted"></i>
                                    @endfor
                                    <span class="text-muted ms-1">({{ $product['reviews'] }})</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span
                                        class="fw-bold text-success fs-5">${{ number_format($product['price'], 2) }}</span>
                                    @if ($product['old_price'])
                                        <span class="text-muted text-decoration-line-through small">
                                            ${{ number_format($product['old_price'], 2) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer bg-white border-0 pt-0 pb-3">
                                <button class="btn btn-success w-100 btn-sm">
                                    <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    {{-- ==================== WHY CHOOSE US ==================== --}}
    <section class="py-5 bg-success text-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Why Choose KemtexWellness?</h2>
                <p class="text-white-75">Trusted by thousands for quality and results</p>
            </div>
            <div class="row g-4">
                @php
                    $features = [
                        [
                            'icon' => 'award',
                            'title' => 'Certified Quality',
                            'desc' => 'All products are GMP certified and third-party tested for purity and potency.',
                        ],
                        [
                            'icon' => 'leaf',
                            'title' => 'Natural Ingredients',
                            'desc' =>
                                'We source only the finest natural and organic ingredients from trusted farms worldwide.',
                        ],
                        [
                            'icon' => 'people',
                            'title' => 'Expert Team',
                            'desc' =>
                                'Our R&D team comprises nutrition scientists and wellness experts with decades of experience.',
                        ],
                        [
                            'icon' => 'recycle',
                            'title' => 'Eco-Friendly',
                            'desc' =>
                                'Committed to sustainability with recyclable packaging and carbon-neutral shipping.',
                        ],
                    ];
                @endphp
                @foreach ($features as $f)
                    <div class="col-sm-6 col-lg-3">
                        <div class="text-center">
                            <div class="rounded-circle bg-white bg-opacity-10 mx-auto mb-3 d-flex align-items-center justify-content-center"
                                style="width:72px;height:72px;">
                                <i class="bi bi-{{ $f['icon'] }} fs-2"></i>
                            </div>
                            <h5 class="fw-bold">{{ $f['title'] }}</h5>
                            <p class="text-white-75 small">{{ $f['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ==================== TESTIMONIALS ==================== --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">What Our Customers Say</h2>
                <p class="text-muted">Real stories from real people</p>
            </div>
            <div class="row g-4">
                @php
                    $testimonials = [
                        [
                            'name' => 'Sarah M.',
                            'role' => 'Yoga Instructor',
                            'text' =>
                                'The Daily Vitality Pack has completely transformed my energy levels. I feel more alert and focused throughout the day!',
                            'rating' => 5,
                        ],
                        [
                            'name' => 'James L.',
                            'role' => 'Fitness Coach',
                            'text' =>
                                'Incredible quality and fast shipping. The Omega-3 tubs are now a staple in my clients\' nutrition plans.',
                            'rating' => 5,
                        ],
                        [
                            'name' => 'Priya K.',
                            'role' => 'Nutritionist',
                            'text' =>
                                'I recommend KemtexWellness to all my clients. Pure ingredients, no fillers, and exceptional customer support.',
                            'rating' => 5,
                        ],
                    ];
                @endphp
                @foreach ($testimonials as $t)
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-4">
                                <div class="text-warning mb-3">
                                    @for ($i = 0; $i < $t['rating']; $i++)
                                        <i class="bi bi-star-fill"></i>
                                    @endfor
                                </div>
                                <p class="text-muted fst-italic">"{{ $t['text'] }}"</p>
                                <div class="d-flex align-items-center mt-3">
                                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3"
                                        style="width:44px;height:44px;font-weight:bold;">
                                        {{ strtoupper(substr($t['name'], 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $t['name'] }}</div>
                                        <div class="small text-muted">{{ $t['role'] }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ==================== CTA BANNER ==================== --}}
    <section class="py-5" style="background:linear-gradient(135deg,#0d6efd,#6610f2);">
        <div class="container text-center text-white">
            <h2 class="fw-bold mb-3">Ready to Start Your Wellness Journey?</h2>
            <p class="lead text-white-75 mb-4">
                Join over 5,000 happy customers and experience the KemtexWellness difference.
            </p>
            <a href="{{ route('products') }}" class="btn btn-light btn-lg fw-semibold px-5">
                <i class="bi bi-bag2 me-2"></i>Shop Now
            </a>
        </div>
    </section>

@endsection

@push('styles')
    <style>
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .12) !important;
            transition: .25s;
        }

        .product-card:hover .product-overlay {
            opacity: 1 !important;
        }

        .product-card {
            transition: transform .25s;
        }
    </style>
@endpush
