@extends('frontend.layouts.master')

@section('title', 'Home - KemtexWellness')

@section('content')

    <!-- Slider Start -->
    <section class="slider">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-10">
                    <div class="block">
                        <span class="d-block mb-3 text-white text-capitalize">🚀 Your Path to Financial Freedom Starts
                            Here</span>
                        <h1 class="animated fadeInUp mb-5">Build Your Wellness <br>Empire &amp; Earn <br>Unlimited Income
                        </h1>
                        <a href="{{ route('pricing') }}" class="btn btn-main animated fadeInUp btn-round-full">Join Our
                            Community<i class="btn-icon fa fa-angle-right ml-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Slider End -->

    <!-- Section Intro Start -->
    <section class="section intro">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="section-title">
                        <span class="h6 text-color">🚀 Build Your Network</span>
                        <h2 class="mt-3 content-title">Build Your Network. Grow Your Income.</h2>
                        <p class="mt-3 lead text-muted">Join a Smart &amp; Transparent MLM Platform Designed for Success</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="intro-item mb-5 mb-lg-0">
                        <i class="ti-money color-one"></i>
                        <h4 class="mt-4 mb-3">Multiple Income Opportunities</h4>
                        <p class="mb-3"><strong>Earn through:</strong></p>
                        <ul class="list-unstyled ml-3">
                            <li class="mb-2"><i class="fas fa-check text-color mr-2"></i>Direct Referrals</li>
                            <li class="mb-2"><i class="fas fa-check text-color mr-2"></i>Team Performance Bonuses</li>
                            <li class="mb-2"><i class="fas fa-check text-color mr-2"></i>Rank Advancement Rewards</li>
                            <li class="mb-2"><i class="fas fa-check text-color mr-2"></i>Leadership Incentives</li>
                        </ul>
                        <p class="mt-3 text-muted small">Transparent tracking and real-time earnings visibility.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="intro-item mb-5 mb-lg-0">
                        <i class="ti-rocket color-one"></i>
                        <h4 class="mt-4 mb-3">Fast-Track Your Growth</h4>
                        <p class="mb-3"><strong>Grow your network with:</strong></p>
                        <ul class="list-unstyled ml-3">
                            <li class="mb-2"><i class="fas fa-check text-color mr-2"></i>Structured Level System</li>
                            <li class="mb-2"><i class="fas fa-check text-color mr-2"></i>Automated Rank Upgrades</li>
                            <li class="mb-2"><i class="fas fa-check text-color mr-2"></i>Performance-Based Rewards</li>
                            <li class="mb-2"><i class="fas fa-check text-color mr-2"></i>Incentive Programs</li>
                        </ul>
                        <p class="mt-3 text-muted small">Your growth is tracked, rewarded, and supported.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="intro-item">
                        <i class="ti-lock color-one"></i>
                        <h4 class="mt-4 mb-3">Secure &amp; Professional Platform</h4>
                        <ul class="list-unstyled ml-3">
                            <li class="mb-2"><i class="fas fa-check text-color mr-2"></i>Personal Dashboard Access</li>
                            <li class="mb-2"><i class="fas fa-check text-color mr-2"></i>Secure Wallet &amp; Withdrawals
                            </li>
                            <li class="mb-2"><i class="fas fa-check text-color mr-2"></i>Real-Time Reports</li>
                            <li class="mb-2"><i class="fas fa-check text-color mr-2"></i>Dedicated Support</li>
                        </ul>
                        <p class="mt-3 text-muted small">Built with security, scalability, and transparency in mind.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section Intro End -->

    <!-- Section About Start -->
    <section class="section about position-relative">
        <div class="bg-about"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-6 offset-md-0">
                    <div class="about-item">
                        <span class="h6 text-color">🌟 About Our Opportunity</span>
                        <h2 class="mt-3 mb-4 position-relative content-title">Transform Your Life with Kemtex Wellness</h2>
                        <div class="about-content">
                            <h4 class="mb-3 position-relative">✅ Trusted Network</h4>
                            <p class="mb-5">Join 50,000+ entrepreneurs building their wellness empires. We provide
                                leading-edge wellness products, proven systems, and comprehensive training to help you
                                succeed. Start part-time, grow to full-time income.</p>
                            <a href="{{ route('pricing') }}" class="btn btn-main btn-round-full">Start Your Journey
                                Today</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section About End -->

    <!-- section Counter Start -->
    <section class="section counter">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter-item text-center mb-5 mb-lg-0">
                        <h3 class="mb-0"><span class="counter-stat font-weight-bold">1730</span> +</h3>
                        <p class="text-muted">Project Done</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter-item text-center mb-5 mb-lg-0">
                        <h3 class="mb-0"><span class="counter-stat font-weight-bold">125</span>M</h3>
                        <p class="text-muted">User Worldwide</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter-item text-center mb-5 mb-lg-0">
                        <h3 class="mb-0"><span class="counter-stat font-weight-bold">39</span></h3>
                        <p class="text-muted">Available Countries</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter-item text-center">
                        <h3 class="mb-0"><span class="counter-stat font-weight-bold">14</span></h3>
                        <p class="text-muted">Award Winner</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section Counter End -->

    <!-- Section Services Start -->
    <section class="section service border-top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center">
                    <div class="section-title">
                        <span class="h6 text-color">💼 What You Get</span>
                        <h2 class="mt-3 content-title">Complete Support System for Your Success</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="service-item mb-5">
                        <i class="ti-book"></i>
                        <h4 class="mb-3">Training &amp; Mentoring</h4>
                        <p>Comprehensive programs, weekly webinars, and personal coaching from top earners</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="service-item mb-5">
                        <i class="ti-bag"></i>
                        <h4 class="mb-3">Powerful Products</h4>
                        <p>Premium wellness products that customers love and keep buying month after month</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="service-item mb-5">
                        <i class="ti-bar-chart"></i>
                        <h4 class="mb-3">Business Consulting</h4>
                        <p>Expert guidance to grow your business with proven strategies and mentorship</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="service-item mb-5 mb-lg-0">
                        <i class="ti-vector"></i>
                        <h4 class="mb-3">Branding Support</h4>
                        <p>Professional tools to build your personal brand and attract quality team members</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="service-item mb-5 mb-lg-0">
                        <i class="ti-android"></i>
                        <h4 class="mb-3">Mobile App</h4>
                        <p>Manage your network, track commissions, and stay connected on the go</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="service-item mb-5 mb-lg-0">
                        <i class="ti-pencil-alt"></i>
                        <h4 class="mb-3">Content Creation</h4>
                        <p>Ready-to-use marketing materials, scripts, and templates for every platform</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section Services End -->

    <!-- Section Cta Start -->
    <section class="section cta">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6">
                    <div class="cta-item bg-white p-5 rounded">
                        <span class="h6 text-color">🎯 Ready to Start?</span>
                        <h2 class="mt-2 mb-4">Join the Kemtex Wellness Opportunity Today</h2>
                        <p class="lead mb-4">Limited spots available for serious entrepreneurs. Start building your empire:
                        </p>
                        <h3><i class="ti-mobile mr-3 text-color"></i>+91-456-6588</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section Cta End -->

    <!-- Section Testimonial Start -->
    <section class="section testimonial">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="section-title">
                        <span class="h6 text-color">Success Stories 🌟</span>
                        <h2 class="mt-3 content-title">See How Our Members Are Transforming Their Lives</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row testimonial-wrap">
                <div class="testimonial-item position-relative">
                    <i class="ti-quote-left text-color"></i>
                    <div class="testimonial-item-content">
                        <p class="testimonial-text">Quam maiores perspiciatis temporibus odio reiciendis error alias
                            debitis atque consequuntur natus iusto recusandae numquam corrupti facilis blanditiis.</p>
                        <div class="testimonial-author">
                            <h5 class="mb-0 text-capitalize">Thomas Johnson</h5>
                            <p>Executive Director, KemtexWellness</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item position-relative">
                    <i class="ti-quote-left text-color"></i>
                    <div class="testimonial-item-content">
                        <p class="testimonial-text">Consectetur adipisicing elit. Quam maiores perspiciatis temporibus odio
                            reiciendis error alias debitis atque consequuntur natus iusto recusandae.</p>
                        <div class="testimonial-author">
                            <h5 class="mb-0 text-capitalize">Mickel Hussy</h5>
                            <p>Silver Director, KemtexWellness</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item position-relative">
                    <i class="ti-quote-left text-color"></i>
                    <div class="testimonial-item-content">
                        <p class="testimonial-text">Quam maiores perspiciatis temporibus odio reiciendis error alias
                            debitis atque consequuntur natus iusto recusandae numquam corrupti.</p>
                        <div class="testimonial-author">
                            <h5 class="mb-0 text-capitalize">James Watson</h5>
                            <p>Gold Manager, KemtexWellness</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item position-relative">
                    <i class="ti-quote-left text-color"></i>
                    <div class="testimonial-item-content">
                        <p class="testimonial-text">Consectetur adipisicing elit. Quam maiores perspiciatis temporibus odio
                            reiciendis error alias debitis atque consequuntur natus iusto recusandae.</p>
                        <div class="testimonial-author">
                            <h5 class="mb-0 text-capitalize">Priya Sharma</h5>
                            <p>Senior Manager, KemtexWellness</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section Testimonial End -->

    <!-- Latest Blog -->
    <section class="section latest-blog bg-2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center">
                    <div class="section-title">
                        <span class="h6 text-color">Latest News</span>
                        <h2 class="mt-3 content-title text-white">Latest articles to enrich knowledge</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 mb-5">
                    <div class="card bg-transparent border-0">
                        <img loading="lazy" src="{{ asset('frontend/images/blog/1.jpg') }}" alt="blog"
                            class="img-fluid rounded">
                        <div class="card-body mt-2">
                            <div class="blog-item-meta">
                                <a href="#" class="text-white-50">Wellness<span class="ml-2 mr-2">/</span></a>
                                <a href="#" class="text-white-50 ml-2"><i class="fa fa-user mr-2"></i>admin</a>
                            </div>
                            <h3 class="mt-3 mb-5 lh-36"><a href="#" class="text-white">How to improve your health
                                    with natural supplements?</a></h3>
                            <a href="#" class="btn btn-small btn-solid-border btn-round-full text-white">Learn
                                More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-5">
                    <div class="card border-0 bg-transparent">
                        <img loading="lazy" src="{{ asset('frontend/images/blog/2.jpg') }}" alt="blog"
                            class="img-fluid rounded">
                        <div class="card-body mt-2">
                            <div class="blog-item-meta">
                                <a href="#" class="text-white-50">Business<span class="ml-2 mr-2">/</span></a>
                                <a href="#" class="text-white-50 ml-2"><i class="fa fa-user mr-2"></i>admin</a>
                            </div>
                            <h3 class="mt-3 mb-5 lh-36"><a href="#" class="text-white">Building a successful
                                    network marketing business</a></h3>
                            <a href="#" class="btn btn-small btn-solid-border btn-round-full text-white">Learn
                                More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-5">
                    <div class="card border-0 bg-transparent">
                        <img loading="lazy" src="{{ asset('frontend/images/blog/3.jpg') }}" alt="blog"
                            class="img-fluid rounded">
                        <div class="card-body mt-2">
                            <div class="blog-item-meta">
                                <a href="#" class="text-white-50">Income<span class="ml-2 mr-2">/</span></a>
                                <a href="#" class="text-white-50 ml-2"><i class="fa fa-user mr-2"></i>admin</a>
                            </div>
                            <h3 class="mt-3 mb-5 lh-36"><a href="#" class="text-white">Top strategies to boost your
                                    MLM earnings</a></h3>
                            <a href="#" class="btn btn-small btn-solid-border btn-round-full text-white">Learn
                                More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Blog End -->

    <!-- CTA-2 -->
    <section class="mt-70 position-relative">
        <div class="container">
            <div class="cta-block-2 bg-gray p-5 rounded border-1">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-7">
                        <span class="text-color">For Every type of business</span>
                        <h2 class="mt-2 mb-4 mb-lg-0">Entrust Your Project to Our Best Team of Professionals</h2>
                    </div>
                    <div class="col-lg-4">
                        <a href="{{ route('contact') }}" class="btn btn-main btn-round-full float-lg-right">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
