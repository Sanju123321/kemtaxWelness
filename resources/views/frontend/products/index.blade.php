@extends('frontend.layouts.master')

@section('title', 'Our Products')
@section('meta_description', 'Browse KemtexWellness natural health and wellness products.')

@section('content')

    {{-- Page Banner --}}
    <section class="py-5 bg-success text-white">
        <div class="container text-center">
            <h1 class="fw-bold">Our Products</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-75">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Products</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3">
                    {{-- Filter Sidebar --}}
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Filter by Category</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="#"
                                        class="text-success text-decoration-none fw-semibold">All Products</a></li>
                                <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Supplements</a>
                                </li>
                                <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Herbal Teas</a>
                                </li>
                                <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Vitamins</a>
                                </li>
                                <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Wellness
                                        Kits</a></li>
                            </ul>
                            <hr />
                            <h6 class="fw-bold mb-3">Price Range</h6>
                            <input type="range" class="form-range" min="0" max="200" step="5"
                                value="100" />
                            <div class="d-flex justify-content-between small text-muted">
                                <span>$0</span><span>$200</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row g-4">
                        @php
                            $products = [
                                ['name' => 'Daily Vitality Pack', 'price' => 49.99],
                                ['name' => 'Immune Boost Complex', 'price' => 34.99],
                                ['name' => 'Herbal Detox Tea', 'price' => 22.5],
                                ['name' => 'Omega-3 Premium', 'price' => 38.0],
                                ['name' => 'Vitamin D3+K2', 'price' => 28.0],
                                ['name' => 'Probiotic Blend', 'price' => 42.0],
                            ];
                        @endphp
                        @foreach ($products as $p)
                            <div class="col-sm-6 col-md-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <img src="{{ asset('frontend/images/product-placeholder.jpg') }}" class="card-img-top"
                                        style="height:180px;object-fit:cover;" alt="{{ $p['name'] }}"
                                        onerror="this.src='https://placehold.co/300x180/f8f9fa/198754?text={{ urlencode($p['name']) }}';" />
                                    <div class="card-body">
                                        <h6 class="fw-semibold">{{ $p['name'] }}</h6>
                                        <span class="fw-bold text-success">${{ number_format($p['price'], 2) }}</span>
                                    </div>
                                    <div class="card-footer bg-white border-0 pt-0 pb-3">
                                        <button class="btn btn-success btn-sm w-100">Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
