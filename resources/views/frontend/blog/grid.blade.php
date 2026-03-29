@extends('frontend.layouts.master')

@section('title', 'Blog Articles - KemtexWellness')

@section('content')

    {{-- Page Title --}}
    <section class="page-title bg-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block text-center">
                        <span class="text-white">Our Blog</span>
                        <h1 class="text-capitalize mb-4 text-lg">Blog Articles</h1>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                            <li class="list-inline-item"><span class="text-white">/</span></li>
                            <li class="list-inline-item text-white-50">Blog Grid</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Blog Grid --}}
    <section class="section blog-wrap bg-gray">
        <div class="container">
            <div class="row">
                @php
                    $posts = [
                        [
                            'title' => 'How to Build a Successful Network in Wellness',
                            'category' => 'Networking',
                            'date' => '15 Jan 2026',
                            'img' => 'blog/1.jpg',
                            'excerpt' =>
                                'Build a thriving network by focusing on genuine relationships, value sharing, and consistent follow-up with your team.',
                        ],
                        [
                            'title' => 'Understanding the 20-Level Income Structure',
                            'category' => 'Income',
                            'date' => '20 Jan 2026',
                            'img' => 'blog/2.jpg',
                            'excerpt' =>
                                'Our unique 20-level income model allows you to earn from your entire downline, creating truly passive income streams.',
                        ],
                        [
                            'title' => 'Top Wellness Products That Drive Sales',
                            'category' => 'Products',
                            'date' => '25 Jan 2026',
                            'img' => 'blog/3.jpg',
                            'excerpt' =>
                                'Discover the top-performing wellness products in our catalog and learn strategies to effectively promote them to your audience.',
                        ],
                        [
                            'title' => 'Royalty Income: What It Means & How to Qualify',
                            'category' => 'Finance',
                            'date' => '1 Feb 2026',
                            'img' => 'blog/4.jpg',
                            'excerpt' =>
                                'Royalty income is the 20% pool distributed to top performers. Learn the exact criteria to qualify and maximize your share.',
                        ],
                        [
                            'title' => 'Training Resources Every New Member Should Know',
                            'category' => 'Training',
                            'date' => '5 Feb 2026',
                            'img' => 'blog/1.jpg',
                            'excerpt' =>
                                'New to KemtexWellness? This guide covers all the essential training resources to fast-track your success in your first 90 days.',
                        ],
                        [
                            'title' => 'Success Story: From ₹1,000 to ₹1 Lakh Monthly',
                            'category' => 'Success',
                            'date' => '10 Feb 2026',
                            'img' => 'blog/2.jpg',
                            'excerpt' =>
                                'Meet Rajesh Kumar from Pune who transformed his life by starting with our ₹1,000 plan and scaling steadily over 18 months.',
                        ],
                    ];
                @endphp

                @foreach ($posts as $post)
                    <div class="col-lg-6 col-md-6 mb-5">
                        <div class="blog-item">
                            <img loading="lazy" src="{{ asset('frontend/images/' . $post['img']) }}"
                                alt="{{ $post['title'] }}" class="img-fluid rounded">
                            <div class="blog-item-content bg-white p-5">
                                <div class="blog-item-meta bg-gray pt-2 pb-1 px-3">
                                    <span class="text-muted text-capitalize d-inline-block mr-3"><i
                                            class="ti-pencil-alt mr-2"></i>{{ $post['category'] }}</span>
                                    <span class="text-black text-capitalize d-inline-block mr-3"><i
                                            class="ti-time mr-1"></i> {{ $post['date'] }}</span>
                                </div>
                                <h3 class="mt-3 mb-3"><a
                                        href="{{ route('blog.show', Str::slug($post['title'])) }}">{{ $post['title'] }}</a>
                                </h3>
                                <p class="mb-4">{{ $post['excerpt'] }}</p>
                                <a href="{{ route('blog.show', Str::slug($post['title'])) }}"
                                    class="btn btn-small btn-main btn-round-full">Learn More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row justify-content-center mt-5">
                <div class="col-lg-6 text-center">
                    <nav class="navigation pagination d-inline-block">
                        <div class="nav-links">
                            <span aria-current="page" class="page-numbers current">1</span>
                            <a class="page-numbers" href="#">2</a>
                            <a class="next page-numbers" href="#">Next</a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </section>

@endsection
