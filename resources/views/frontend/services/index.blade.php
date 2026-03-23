@extends('frontend.layouts.master')

@section('title', 'Our Services')
@section('meta_description', 'Explore the wellness services offered by KemtexWellness.')

@section('content')

    {{-- Page Banner --}}
    <section class="py-5 bg-success text-white">
        <div class="container text-center">
            <h1 class="fw-bold">Our Services</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-75">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Services</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                @php
                    $services = [
                        [
                            'icon' => 'person-heart',
                            'title' => 'Wellness Consulting',
                            'desc' =>
                                'One-on-one sessions with certified wellness consultants tailored to your health goals.',
                            'color' => 'success',
                        ],
                        [
                            'icon' => 'journal-medical',
                            'title' => 'Nutrition Planning',
                            'desc' => 'Personalised meal and supplement plans designed by registered dietitians.',
                            'color' => 'primary',
                        ],
                        [
                            'icon' => 'activity',
                            'title' => 'Health Assessments',
                            'desc' => 'Comprehensive wellness assessments to understand your current health status.',
                            'color' => 'warning',
                        ],
                        [
                            'icon' => 'camera-video',
                            'title' => 'Virtual Workshops',
                            'desc' => 'Live online workshops covering fitness, nutrition, mental well-being, and more.',
                            'color' => 'info',
                        ],
                        [
                            'icon' => 'truck',
                            'title' => 'Subscription Boxes',
                            'desc' => 'Curated monthly wellness boxes delivered straight to your door.',
                            'color' => 'danger',
                        ],
                        [
                            'icon' => 'headset',
                            'title' => '24/7 Support',
                            'desc' => 'Round-the-clock support from our team of wellness experts.',
                            'color' => 'secondary',
                        ],
                    ];
                @endphp
                @foreach ($services as $s)
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100 text-center p-4">
                            <div class="rounded-circle bg-{{ $s['color'] }} bg-opacity-10 mx-auto mb-4 d-flex align-items-center justify-content-center"
                                style="width:72px;height:72px;">
                                <i class="bi bi-{{ $s['icon'] }} fs-2 text-{{ $s['color'] }}"></i>
                            </div>
                            <h5 class="fw-bold">{{ $s['title'] }}</h5>
                            <p class="text-muted small">{{ $s['desc'] }}</p>
                            <a href="{{ route('contact') }}"
                                class="btn btn-sm btn-outline-{{ $s['color'] }} mt-auto">Learn More</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
