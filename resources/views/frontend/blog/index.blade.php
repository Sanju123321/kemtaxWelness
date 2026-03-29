@extends('frontend.layouts.master')

@section('title', 'Blog - KemtexWellness')

@section('content')

    <section class="page-title bg-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block text-center">
                        <span class="text-white">📝 Latest Updates</span>
                        <h1 class="text-capitalize mb-4 text-lg">News &amp; Insights</h1>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                            <li class="list-inline-item"><span class="text-white">/</span></li>
                            <li class="list-inline-item text-white-50">Blog</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section latest-blog">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <div class="section-title">
                        <span class="h6 text-color">📣 Stay Informed</span>
                        <h2 class="mt-3 content-title">Tips, Success Stories &amp; Wellness Insights</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                @php
                    $posts = [
                        [
                            'title' => 'How to Build a 1000-Person Network in 90 Days',
                            'date' => 'January 15, 2026',
                            'cat' => 'Network Building',
                            'excerpt' =>
                                'Discover the proven strategies our top distributors use to rapidly expand their networks while maintaining quality relationships.',
                            'img' => 'blog-1.jpg',
                        ],
                        [
                            'title' => 'Top 5 Wellness Products That Sell Themselves',
                            'date' => 'January 10, 2026',
                            'cat' => 'Products',
                            'excerpt' =>
                                'Learn which products generate the most repeat orders and why customers love them. Your commission income depends on product retention.',
                            'img' => 'blog-2.jpg',
                        ],
                        [
                            'title' => 'From ₹0 to ₹1L Monthly: A Distributor\'s Journey',
                            'date' => 'January 5, 2026',
                            'cat' => 'Success Stories',
                            'excerpt' =>
                                'Read how Anita went from a homemaker to earning ₹1 lakh per month using our step-by-step system and dedicated mentorship.',
                            'img' => 'blog-3.jpg',
                        ],
                        [
                            'title' => 'Understanding the 20-Level Income Structure',
                            'date' => 'December 28, 2025',
                            'cat' => 'Education',
                            'excerpt' =>
                                'A detailed breakdown of how commissions flow through 20 levels in our compensation plan and strategies to maximize every level.',
                            'img' => 'blog-4.jpg',
                        ],
                        [
                            'title' => 'Social Media Strategies for MLM Success in 2026',
                            'date' => 'December 20, 2025',
                            'cat' => 'Marketing',
                            'excerpt' =>
                                'Master Instagram, WhatsApp, and YouTube to attract quality leads and build your network faster than ever before.',
                            'img' => 'blog-5.jpg',
                        ],
                        [
                            'title' => 'The Science Behind Our Immunity Booster Kit',
                            'date' => 'December 15, 2025',
                            'cat' => 'Health',
                            'excerpt' =>
                                'Explore the research and ingredients behind our best-selling immunity product and why customers reorder month after month.',
                            'img' => 'blog-6.jpg',
                        ],
                    ];
                @endphp
                @foreach ($posts as $post)
                    <div class="col-lg-4 col-md-6 mb-5">
                        <div class="post-item">
                            <div class="post-thumb mb-3"
                                style="height:200px;background:#f0f4f8;border-radius:8px;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                                <i class="ti-write text-color" style="font-size:4rem;opacity:.3;"></i>
                            </div>
                            <div class="post-content">
                                <div class="post-meta mb-2">
                                    <span class="badge badge-light text-color mr-2">{{ $post['cat'] }}</span>
                                    <span class="text-muted small">{{ $post['date'] }}</span>
                                </div>
                                <h5 class="mb-3"><a href="{{ route('blog') }}" class="text-dark">{{ $post['title'] }}</a>
                                </h5>
                                <p class="text-muted">{{ $post['excerpt'] }}</p>
                                <a href="{{ route('blog') }}"
                                    class="btn btn-small btn-solid-border btn-round-full mt-2">Read More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-4">
                <p class="text-muted">Ready to start your own success story?</p>
                <a href="{{ route('pricing') }}" class="btn btn-main btn-round-full">Join Now</a>
            </div>
        </div>
    </section>

@endsection
