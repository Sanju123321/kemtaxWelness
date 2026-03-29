@extends('frontend.layouts.master')

@section('title', 'Blog - KemtexWellness')

@section('content')

    <section class="page-title bg-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block text-center">
                        <span class="text-white">Our Blog</span>
                        <h1 class="text-capitalize mb-4 text-lg">Blog with Sidebar</h1>
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

    <section class="section blog-wrap bg-gray">
        <div class="container">
            <div class="row">
                {{-- Main Content --}}
                <div class="col-lg-8">
                    @php
                        $posts = [
                            [
                                'title' => 'How to Build a Successful Network in Wellness',
                                'category' => 'Networking',
                                'date' => '15 Jan 2026',
                                'img' => 'blog/1.jpg',
                                'excerpt' =>
                                    'Build a thriving network by focusing on genuine relationships, value sharing, and consistent follow-up with your team members.',
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
                                    'Discover the top-performing wellness products in our catalog and learn strategies to effectively promote them.',
                            ],
                            [
                                'title' => 'Royalty Income: What It Means & How to Qualify',
                                'category' => 'Finance',
                                'date' => '1 Feb 2026',
                                'img' => 'blog/4.jpg',
                                'excerpt' =>
                                    'Royalty income is the 20% pool distributed to top performers. Learn the exact criteria to qualify and maximize your share.',
                            ],
                        ];
                    @endphp

                    @foreach ($posts as $post)
                        <div class="blog-item mb-5">
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
                                    class="btn btn-small btn-main btn-round-full">Read More</a>
                            </div>
                        </div>
                    @endforeach

                    <div class="row justify-content-center mt-3">
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

                {{-- Sidebar --}}
                <div class="col-lg-4 mt-5 mt-lg-0">
                    <div class="sidebar-wrap">
                        {{-- Search --}}
                        <div class="sidebar-widget search card p-4 mb-3 border-0">
                            <h5 class="mb-3">Search</h5>
                            <input type="text" class="form-control" placeholder="Search articles...">
                            <a href="#" class="btn btn-main btn-small d-block mt-2">Search</a>
                        </div>

                        {{-- Categories --}}
                        <div class="sidebar-widget card border-0 p-4 mb-3">
                            <h5 class="mb-3">Categories</h5>
                            <ul class="list-unstyled">
                                <li class="border-bottom py-2"><a href="#" class="text-dark"><i
                                            class="ti-angle-right mr-2 text-color small"></i>Networking <span
                                            class="float-right text-muted">(8)</span></a></li>
                                <li class="border-bottom py-2"><a href="#" class="text-dark"><i
                                            class="ti-angle-right mr-2 text-color small"></i>Income <span
                                            class="float-right text-muted">(5)</span></a></li>
                                <li class="border-bottom py-2"><a href="#" class="text-dark"><i
                                            class="ti-angle-right mr-2 text-color small"></i>Products <span
                                            class="float-right text-muted">(6)</span></a></li>
                                <li class="border-bottom py-2"><a href="#" class="text-dark"><i
                                            class="ti-angle-right mr-2 text-color small"></i>Training <span
                                            class="float-right text-muted">(4)</span></a></li>
                                <li class="py-2"><a href="#" class="text-dark"><i
                                            class="ti-angle-right mr-2 text-color small"></i>Success Stories <span
                                            class="float-right text-muted">(7)</span></a></li>
                            </ul>
                        </div>

                        {{-- Recent Posts --}}
                        <div class="sidebar-widget latest-post card border-0 p-4 mb-3">
                            <h5>Recent Posts</h5>
                            <div class="media border-bottom py-3">
                                <a href="#"><img loading="lazy" class="mr-4"
                                        src="{{ asset('frontend/images/blog/1.jpg') }}" alt="blog"
                                        style="width:60px;height:50px;object-fit:cover;"></a>
                                <div class="media-body">
                                    <h6 class="my-2"><a href="#" class="text-dark">How to Build a Successful
                                            Network</a></h6>
                                    <span class="text-sm text-muted">15 Jan 2026</span>
                                </div>
                            </div>
                            <div class="media border-bottom py-3">
                                <a href="#"><img loading="lazy" class="mr-4"
                                        src="{{ asset('frontend/images/blog/2.jpg') }}" alt="blog"
                                        style="width:60px;height:50px;object-fit:cover;"></a>
                                <div class="media-body">
                                    <h6 class="my-2"><a href="#" class="text-dark">Understanding the 20-Level
                                            Income</a></h6>
                                    <span class="text-sm text-muted">20 Jan 2026</span>
                                </div>
                            </div>
                            <div class="media py-3">
                                <a href="#"><img loading="lazy" class="mr-4"
                                        src="{{ asset('frontend/images/blog/3.jpg') }}" alt="blog"
                                        style="width:60px;height:50px;object-fit:cover;"></a>
                                <div class="media-body">
                                    <h6 class="my-2"><a href="#" class="text-dark">Top Wellness Products That
                                            Drive Sales</a></h6>
                                    <span class="text-sm text-muted">25 Jan 2026</span>
                                </div>
                            </div>
                        </div>

                        {{-- Tags --}}
                        <div class="sidebar-widget bg-white rounded tags p-4 mb-3">
                            <h5 class="mb-4">Tags</h5>
                            <a href="#">Wellness</a>
                            <a href="#">MLM</a>
                            <a href="#">Network</a>
                            <a href="#">Income</a>
                            <a href="#">Training</a>
                            <a href="#">Royalty</a>
                            <a href="#">Success</a>
                            <a href="#">Products</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
