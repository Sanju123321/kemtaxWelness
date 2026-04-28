@extends('frontend.layouts.master')

@section('title', 'About Us - KemtexWellness')

@section('content')

    <section class="page-title bg-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block text-center">
                        <span class="text-white">🚀 Opportunity</span>
                        <h1 class="text-capitalize mb-4 text-lg">Join the Wellness Revolution</h1>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                            <li class="list-inline-item"><span class="text-white">/</span></li>
                            <li class="list-inline-item text-white-50">About Our Opportunity</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section About Start -->
    <section class="section about-2 position-relative">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about-item pr-3 mb-5 mb-lg-0">
                        <span class="h6 text-color">{{ $introHeading ?? 'What we are' }}</span>
                        <p class="mb-5">{{ $introBody ?? '' }}</p>
                        <a href="{{ route('contact') }}" class="btn btn-main btn-round-full">Get started</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-item-img">
                        @php
                            $introImagePath = $introImage ?? '';
                            $introImageUrl = $introImagePath
                                ? (str_starts_with($introImagePath, 'frontend/') ? asset($introImagePath) : asset('storage/' . $introImagePath))
                                : asset('frontend/images/about/home-7.jpg');
                        @endphp
                        <img loading="lazy" src="{{ $introImageUrl }}" alt="about-image"
                            class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section About End -->

    <section class="about-info section pt-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="about-info-item mb-4 mb-lg-0">
                        <h3 class="mb-3"><span class="text-color mr-2 text-md">01.</span>Our Mission</h3>
                        <p>To inspire healthier living and financial freedom by offering high-quality wellness products and
                            a proven business
                            opportunity that rewards dedication, leadership, and teamwork.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="about-info-item mb-4 mb-lg-0">
                        <h3 class="mb-3"><span class="text-color mr-2 text-md">02.</span>Vision</h3>
                        <p>To become a global leader in wellness-driven direct selling, recognized for transforming lives
                            through innovation,
                            empowerment, and sustainable growth.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="about-info-item mb-4 mb-lg-0">
                        <h3 class="mb-3"><span class="text-color mr-2 text-md">03.</span>Our Approach</h3>
                        <p>At KemtexWellness, we unite wellness and entrepreneurship. Our direct selling model empowers
                            individuals to
                            build businesses, earn
                            through teamwork, and promote healthier living with integrity, innovation, and community
                            support.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Counter Start -->
    <section class="section counter bg-counter">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter-item text-center mb-5 mb-lg-0">
                        <i class="ti-user color-one text-md"></i>
                        <h3 class="mt-2 mb-0 text-white"><span class="counter-stat font-weight-bold">50000</span> +</h3>
                        <p class="text-white-50">Active Members</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter-item text-center mb-5 mb-lg-0">
                        <i class="ti-location-pin color-one text-md"></i>
                        <h3 class="mt-2 mb-0 text-white"><span class="counter-stat font-weight-bold">25</span></h3>
                        <p class="text-white-50">Countries Active</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter-item text-center mb-5 mb-lg-0">
                        <i class="ti-money color-one text-md"></i>
                        <h3 class="mt-2 mb-0 text-white"><span class="counter-stat font-weight-bold">₹50</span>Cr+</h3>
                        <p class="text-white-50">Annual Payouts</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter-item text-center">
                        <i class="ti-star color-one text-md"></i>
                        <h3 class="mt-2 mb-0 text-white"><span class="counter-stat font-weight-bold">98</span>%</h3>
                        <p class="text-white-50">Member Satisfaction</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section Counter End -->

    <!-- Section Team Start -->
    <section class="section team">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center">
                    <div class="section-title">
                        <span class="h6 text-color">🌟 Top Earners</span>
                        <h2 class="mt-3 content-title">Meet Our Most Successful Distributors</h2>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                @php
                    $team = !empty($topEarners ?? []) ? $topEarners : [
                        [
                            'name' => 'Rajesh Kumar',
                            'title' => 'Executive Director - Earned ₹25L+',
                            'img' => 'team-1.jpg',
                        ],
                        ['name' => 'Priya Sharma', 'title' => 'Senior Manager - Team of 500+', 'img' => 'team-2.jpg'],
                        [
                            'name' => 'Arun Patel',
                            'title' => 'National Leader - ₹50L+ Annual Income',
                            'img' => 'team-3.jpg',
                        ],
                        [
                            'name' => 'Neha Gupta',
                            'title' => 'Senior Distributor - Luxury Car Qualifier',
                            'img' => 'team-4.jpg',
                        ],
                        [
                            'name' => 'Vikram Singh',
                            'title' => 'Platinum Executive - ₹1Cr+ Income',
                            'img' => 'team-6.jpg',
                        ],
                        ['name' => 'David Spensor', 'title' => 'Project Manager', 'img' => 'team-5.jpg'],
                    ];
                @endphp
                @foreach ($team as $member)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="team-item-wrap mb-5">
                            <div class="team-item position-relative">
                                <img loading="lazy" src="{{ !empty($member['image']) ? asset('storage/' . $member['image']) : asset('frontend/images/team/' . ($member['img'] ?? 'team-1.jpg')) }}"
                                    alt="{{ $member['name'] }}" class="img-fluid w-100">
                                <div class="team-img-hover">
                                    <ul class="team-social list-inline">
                                        <li class="list-inline-item"><a href="#" class="facebook"><i
                                                    class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
                                        <li class="list-inline-item"><a href="#" class="twitter"><i
                                                    class="fab fa-twitter" aria-hidden="true"></i></a></li>
                                        <li class="list-inline-item"><a href="#" class="instagram"><i
                                                    class="fab fa-instagram" aria-hidden="true"></i></a></li>
                                        <li class="list-inline-item"><a href="#" class="linkedin"><i
                                                    class="fab fa-linkedin-in" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="team-item-content">
                                <h4 class="mt-3 mb-0 text-capitalize">{{ $member['name'] }}</h4>
                                <p>{{ $member['title'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Section Team End -->

    <!-- Section Testimonial Start -->
    <section class="section testimonial bg-gray">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center">
                    <div class="section-title">
                        <span class="h6 text-color">💎 Member Success Stories</span>
                        <h2 class="mt-3 content-title">Real People, Real Results</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="testimonial-wrap">
                @php
                    $testimonials = !empty($stories ?? []) ? $stories : [
                        [
                            'name' => 'Anita Verma',
                            'title' => 'Silver Director - Earns ₹2L+/month',
                            'quote' => '"Joining KemtexWellness transformed my life! I started part-time and now earn ₹2L+ monthly."',
                        ],
                        [
                            'name' => 'Rahul Mehta',
                            'title' => 'Gold Manager - ₹50K/month',
                            'quote' => '"From zero to ₹50K monthly in just 6 months! The training and mentorship here is exceptional."',
                        ],
                        [
                            'name' => 'Priya Sharma',
                            'title' => 'Executive Director - ₹25L+/month',
                            'quote' => '"I have built a network of 2000+ people and earned more than my corporate job ever paid."',
                        ],
                    ];
                @endphp
                @foreach ($testimonials as $testimonial)
                    <div class="testimonial-item position-relative">
                        <i class="ti-quote-left text-color"></i>
                        <div class="testimonial-item-content">
                            <p class="testimonial-text">{{ $testimonial['quote'] ?? '' }}</p>
                            <div class="testimonial-author">
                                <h5 class="mb-0 text-capitalize">{{ $testimonial['name'] ?? '' }}</h5>
                                <p>{{ $testimonial['title'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Section Testimonial End -->

    <section class="cta-2">
        <div class="container">
            <div class="cta-block p-5 rounded">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-7 text-center text-lg-left">
                        <span class="text-color">🌟 Ready to Transform Your Life?</span>
                        <h2 class="mt-2 text-white">Your Path to Financial Freedom Starts Here - Join Now</h2>
                    </div>
                    <div class="col-lg-4 text-center text-lg-right mt-4 mt-lg-0">
                        <a href="{{ route('pricing') }}" class="btn btn-main btn-round-full">Get Started Today</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
