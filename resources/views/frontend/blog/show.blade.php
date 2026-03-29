@extends('frontend.layouts.master')

@section('title', 'Blog Post - KemtexWellness')

@section('content')

    <section class="page-title bg-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block text-center">
                        <span class="text-white">News Details</span>
                        <h1 class="text-capitalize mb-4 text-lg">Blog Single</h1>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                            <li class="list-inline-item"><span class="text-white">/</span></li>
                            <li class="list-inline-item"><a href="{{ route('blog') }}" class="text-white">Blog</a></li>
                            <li class="list-inline-item"><span class="text-white">/</span></li>
                            <li class="list-inline-item text-white-50">Post</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section blog-wrap bg-gray">
        <div class="container">
            <div class="row">

                {{-- Main Article --}}
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-12 mb-5">
                            <div class="single-blog-item">
                                <img loading="lazy" src="{{ asset('frontend/images/blog/2.jpg') }}" alt="Blog Post"
                                    class="img-fluid rounded">
                                <div class="blog-item-content bg-white p-5">
                                    <div class="blog-item-meta bg-gray pt-2 pb-1 px-3">
                                        <span class="text-muted text-capitalize mr-3"><i
                                                class="ti-pencil-alt mr-2"></i>Wellness</span>
                                        <span class="text-muted text-capitalize mr-3"><i class="ti-comment mr-2"></i>5
                                            Comments</span>
                                        <span class="text-black text-capitalize mr-3"><i class="ti-time mr-1"></i> 20 Jan
                                            2026</span>
                                    </div>

                                    <h2 class="mt-3 mb-4">Understanding the 20-Level Income Structure at KemtexWellness</h2>

                                    <p class="lead mb-4">Our unique 20-level income model is designed to reward both active
                                        networking and passive growth, creating sustainable long-term income for every
                                        member.</p>

                                    <p>The 20-level income structure at KemtexWellness allows you to earn commissions not
                                        just from your direct referrals, but from every member your team recruits, up to 20
                                        levels deep. This exponential growth model is what separates our compensation plan
                                        from traditional MLM structures.</p>

                                    <h3 class="quote">"Your network is your net worth — and with 20 levels of income, every
                                        person in your team contributes to your financial future."</h3>

                                    <p>At level 1, you earn the highest percentage of the plan value. As commissions extend
                                        to deeper levels, the percentages decrease but the volume multiplies exponentially.
                                        A member at level 20 earning even 0.05% still benefits from potentially thousands of
                                        transactions per month.</p>

                                    <p>To unlock deeper levels, your direct team must also grow and qualify. This ensures
                                        that the structure remains merit-based — rewarding those who actively build and
                                        mentor their teams rather than simply waiting for passive income.</p>

                                    <div
                                        class="tag-option mt-5 d-block d-md-flex justify-content-between align-items-center">
                                        <ul class="list-inline">
                                            <li>Tags:</li>
                                            <li class="list-inline-item"><a href="#" rel="tag">Income</a></li>
                                            <li class="list-inline-item"><a href="#" rel="tag">MLM</a></li>
                                            <li class="list-inline-item"><a href="#" rel="tag">Wellness</a></li>
                                        </ul>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">Share:</li>
                                            <li class="list-inline-item"><a href="#"><i
                                                        class="fab fa-facebook-f"></i></a></li>
                                            <li class="list-inline-item"><a href="#"><i
                                                        class="fab fa-twitter"></i></a></li>
                                            <li class="list-inline-item"><a href="#"><i
                                                        class="fab fa-whatsapp"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Post Navigation --}}
                        <div class="col-lg-12 mb-5">
                            <div class="posts-nav bg-white p-5 d-lg-flex d-md-flex justify-content-between">
                                <a class="post-prev align-items-center" href="#">
                                    <div class="posts-prev-item mb-4 mb-lg-0">
                                        <span class="nav-posts-desc text-color">- Previous Post</span>
                                        <h6 class="nav-posts-title mt-1">How to Build a Successful Network</h6>
                                    </div>
                                </a>
                                <div class="border"></div>
                                <a class="posts-next" href="#">
                                    <div class="posts-next-item pt-4 pt-lg-0">
                                        <span class="nav-posts-desc text-lg-right text-md-right text-color d-block">- Next
                                            Post</span>
                                        <h6 class="nav-posts-title mt-1">Top Wellness Products That Drive Sales</h6>
                                    </div>
                                </a>
                            </div>
                        </div>

                        {{-- Comments --}}
                        <div class="col-lg-12 mb-5">
                            <div class="comment-area card border-0 p-5">
                                <h4 class="mb-4">2 Comments</h4>
                                <ul class="comment-tree list-unstyled">
                                    <li class="mb-5">
                                        <div class="comment-area-box">
                                            <h5 class="mb-1">Priya Sharma</h5>
                                            <span>Mumbai, India</span>
                                            <div class="comment-meta mt-4 mt-lg-0 mt-md-0 float-lg-right float-md-right">
                                                <span class="date-comm">Posted January 22, 2026</span>
                                            </div>
                                            <div class="comment-content mt-3">
                                                <p>This is a great explanation! I finally understand how the 20-level
                                                    structure works. Looking forward to building my team.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="comment-area-box">
                                            <h5 class="mb-1">Rajesh Kumar</h5>
                                            <span>Delhi, India</span>
                                            <div class="comment-meta mt-4 mt-lg-0 mt-md-0 float-lg-right float-md-right">
                                                <span class="date-comm">Posted January 25, 2026</span>
                                            </div>
                                            <div class="comment-content mt-3">
                                                <p>I've been with KemtexWellness for 6 months and the 20-level structure is
                                                    real. Already earning from level 3 downline members!</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- Comment Form --}}
                        <div class="col-lg-12">
                            <form class="contact-form bg-white rounded p-5">
                                <h4 class="mb-4">Write a Comment</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Your Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" type="email" placeholder="Your Email">
                                        </div>
                                    </div>
                                </div>
                                <textarea class="form-control mb-3" rows="5" placeholder="Your Comment"></textarea>
                                <button type="submit" class="btn btn-main btn-round-full">Submit Comment</button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4 mt-5 mt-lg-0">
                    <div class="sidebar-wrap">
                        <div class="sidebar-widget search card p-4 mb-3 border-0">
                            <input type="text" class="form-control" placeholder="Search articles...">
                            <a href="#" class="btn btn-main btn-small d-block mt-2">Search</a>
                        </div>

                        <div class="sidebar-widget latest-post card border-0 p-4 mb-3">
                            <h5>Latest Posts</h5>
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
                                        src="{{ asset('frontend/images/blog/3.jpg') }}" alt="blog"
                                        style="width:60px;height:50px;object-fit:cover;"></a>
                                <div class="media-body">
                                    <h6 class="my-2"><a href="#" class="text-dark">Top Wellness Products That
                                            Drive Sales</a></h6>
                                    <span class="text-sm text-muted">25 Jan 2026</span>
                                </div>
                            </div>
                            <div class="media py-3">
                                <a href="#"><img loading="lazy" class="mr-4"
                                        src="{{ asset('frontend/images/blog/4.jpg') }}" alt="blog"
                                        style="width:60px;height:50px;object-fit:cover;"></a>
                                <div class="media-body">
                                    <h6 class="my-2"><a href="#" class="text-dark">Royalty Income: How to
                                            Qualify</a></h6>
                                    <span class="text-sm text-muted">1 Feb 2026</span>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-widget bg-white rounded tags p-4 mb-3">
                            <h5 class="mb-4">Tags</h5>
                            <a href="#">Wellness</a>
                            <a href="#">MLM</a>
                            <a href="#">Network</a>
                            <a href="#">Income</a>
                            <a href="#">Training</a>
                            <a href="#">Royalty</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
