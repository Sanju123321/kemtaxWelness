@extends('frontend.layouts.master')

@section('title', 'Portfolio - KemtexWellness')

@section('content')

    <section class="page-title bg-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block text-center">
                        <span class="text-white">Our Works</span>
                        <h1 class="text-capitalize mb-4 text-lg">Portfolio</h1>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                            <li class="list-inline-item"><span class="text-white">/</span></li>
                            <li class="list-inline-item text-white-50">Portfolio</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section portfolio pb-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center">
                    <div class="section-title">
                        <span class="h6 text-color">Our Works</span>
                        <h2 class="mt-3 content-title">We have built a powerful wellness network — here are some highlights
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row portfolio-gallery">
                @php
                    $portfolios = [
                        [
                            'img' => 'images/portfolio/1.jpg',
                            'title' => 'Member Growth 2024',
                            'desc' => 'Network Expansion',
                        ],
                        [
                            'img' => 'images/portfolio/2.jpg',
                            'title' => 'Wellness Product Launch',
                            'desc' => 'Product Marketing',
                        ],
                        [
                            'img' => 'images/portfolio/3.jpg',
                            'title' => 'Training Summit 2025',
                            'desc' => 'Team Training',
                        ],
                        [
                            'img' => 'images/portfolio/4.jpg',
                            'title' => 'Leadership Program',
                            'desc' => 'Leadership Development',
                        ],
                        ['img' => 'images/portfolio/5.jpg', 'title' => 'Annual Meet 2025', 'desc' => 'Corporate Event'],
                        [
                            'img' => 'images/portfolio/6.jpg',
                            'title' => 'Digital Marketing',
                            'desc' => 'Digital Strategy',
                        ],
                    ];
                @endphp

                @foreach ($portfolios as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="portflio-item position-relative mb-4">
                            <a href="{{ asset('frontend/' . $item['img']) }}" class="popup-gallery">
                                <img src="{{ asset('frontend/' . $item['img']) }}" alt="{{ $item['title'] }}"
                                    class="img-fluid w-100">
                                <i class="ti-plus overlay-item"></i>
                                <div class="portfolio-item-content">
                                    <h3 class="mb-0 text-white">{{ $item['title'] }}</h3>
                                    <p class="text-white-50">{{ $item['desc'] }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta-2">
        <div class="container">
            <div class="cta-block p-5 rounded">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-8 text-center">
                        <span class="text-color">Join Our Growing Success Stories</span>
                        <h2 class="mt-2 text-white mb-3">Be Part of the KemtexWellness Journey</h2>
                        <p class="text-white mb-4">Thousands of members have already built their success with us. Start your
                            chapter today.</p>
                        <a href="{{ route('register') }}" class="btn btn-main btn-round-full mr-3">Join Now</a>
                        <a href="{{ route('contact') }}" class="btn btn-outline-light btn-round-full">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
