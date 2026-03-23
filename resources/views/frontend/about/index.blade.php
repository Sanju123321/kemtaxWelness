@extends('frontend.layouts.master')

@section('title', 'About Us')
@section('meta_description', 'Learn about KemtexWellness — our story, mission, and commitment to natural health.')

@section('content')

    {{-- Page Banner --}}
    <section class="py-5 bg-success text-white">
        <div class="container text-center">
            <h1 class="fw-bold">About Us</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-75">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">About Us</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <img src="{{ asset('frontend/images/about.jpg') }}" alt="About KemtexWellness"
                        class="img-fluid rounded-3 shadow"
                        onerror="this.src='https://placehold.co/600x400/198754/white?text=About+Us';" />
                </div>
                <div class="col-lg-6">
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 mb-3">Our Story</span>
                    <h2 class="fw-bold mb-3">Nurturing Wellness Since 2014</h2>
                    <p class="text-muted">
                        KemtexWellness was founded with a simple belief: nature holds the key to optimal health.
                        For over a decade, we have been crafting premium wellness products from the finest natural
                        ingredients, helping thousands of people across the globe live healthier, happier lives.
                    </p>
                    <p class="text-muted">
                        Our team of nutrition scientists, herbalists, and wellness experts work tirelessly to ensure
                        every product meets the highest standards of quality, purity, and efficacy.
                    </p>
                    <ul class="list-unstyled mt-4">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>GMP Certified
                            Manufacturing</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Third-Party Lab Tested
                        </li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>100% Natural Ingredients
                        </li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Eco-Friendly Packaging
                        </li>
                    </ul>
                    <a href="{{ route('contact') }}" class="btn btn-success mt-3">Get In Touch</a>
                </div>
            </div>
        </div>
    </section>

@endsection
