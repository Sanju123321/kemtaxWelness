@extends('frontend.layouts.master')

@section('title', 'Services - KemtexWellness')

@section('content')

    <section class="page-title bg-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block text-center">
                        <span class="text-white">💎 Your Success Toolkit</span>
                        <h1 class="text-capitalize mb-4 text-lg">Complete Support System to Build Your Wealth</h1>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                            <li class="list-inline-item"><span class="text-white">/</span></li>
                            <li class="list-inline-item text-white-50">Support &amp; Services</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Services Start -->
    <section class="section service border-top pb-5">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <div class="section-title">
                        <span class="h6 text-color">💎 MLM Support System</span>
                        <h2 class="mt-3 content-title">Complete Resources to Build Your Wellness Network</h2>
                        <p class="lead mt-4">Everything you need to succeed in your MLM journey</p>
                    </div>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                    <div class="service-card h-100">
                        <div class="service-icon mb-4"><i class="ti-book text-color" style="font-size:2.5rem;"></i></div>
                        <h4 class="mb-3">Training &amp; Certification</h4>
                        <p class="text-muted mb-4">Complete online academy with video courses, certification programs, and
                            ongoing education to master our products and MLM strategies</p>
                        <ul class="service-features list-unstyled">
                            <li><i class="fas fa-check text-color mr-2"></i>Video tutorials &amp; webinars</li>
                            <li><i class="fas fa-check text-color mr-2"></i>Product certification</li>
                            <li><i class="fas fa-check text-color mr-2"></i>Monthly skill upgrades</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                    <div class="service-card h-100">
                        <div class="service-icon mb-4"><i class="ti-files text-color" style="font-size:2.5rem;"></i></div>
                        <h4 class="mb-3">Marketing Materials</h4>
                        <p class="text-muted mb-4">Professional sales presentations, social media templates, email
                            campaigns, and promotional assets ready to use for your network</p>
                        <ul class="service-features list-unstyled">
                            <li><i class="fas fa-check text-color mr-2"></i>Social media templates</li>
                            <li><i class="fas fa-check text-color mr-2"></i>Email campaigns</li>
                            <li><i class="fas fa-check text-color mr-2"></i>Sales presentations</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                    <div class="service-card h-100">
                        <div class="service-icon mb-4"><i class="ti-search text-color" style="font-size:2.5rem;"></i></div>
                        <h4 class="mb-3">Lead Generation</h4>
                        <p class="text-muted mb-4">Advanced tracking system, prospect database management, and tools to
                            identify and connect with potential team members</p>
                        <ul class="service-features list-unstyled">
                            <li><i class="fas fa-check text-color mr-2"></i>Prospect database</li>
                            <li><i class="fas fa-check text-color mr-2"></i>Lead tracking tools</li>
                            <li><i class="fas fa-check text-color mr-2"></i>Follow-up automation</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                    <div class="service-card h-100">
                        <div class="service-icon mb-4"><i class="ti-headphone-alt text-color" style="font-size:2.5rem;"></i>
                        </div>
                        <h4 class="mb-3">24/7 Expert Support</h4>
                        <p class="text-muted mb-4">Dedicated mentorship, weekly coaching calls, live chat support, and
                            direct access to upline leaders for personalized guidance</p>
                        <ul class="service-features list-unstyled">
                            <li><i class="fas fa-check text-color mr-2"></i>Live chat support</li>
                            <li><i class="fas fa-check text-color mr-2"></i>Weekly coaching calls</li>
                            <li><i class="fas fa-check text-color mr-2"></i>Personal mentorship</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                    <div class="service-card h-100">
                        <div class="service-icon mb-4"><i class="ti-mobile text-color" style="font-size:2.5rem;"></i></div>
                        <h4 class="mb-3">Mobile App Platform</h4>
                        <p class="text-muted mb-4">Exclusive MLM app for tracking commissions, team performance, accessing
                            training materials, and managing your network everywhere</p>
                        <ul class="service-features list-unstyled">
                            <li><i class="fas fa-check text-color mr-2"></i>Commission tracking</li>
                            <li><i class="fas fa-check text-color mr-2"></i>Real-time analytics</li>
                            <li><i class="fas fa-check text-color mr-2"></i>Offline access</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                    <div class="service-card h-100">
                        <div class="service-icon mb-4"><i class="ti-gift text-color" style="font-size:2.5rem;"></i></div>
                        <h4 class="mb-3">Exclusive Rewards</h4>
                        <p class="text-muted mb-4">Earn bonus points, trips, cars, and cash bonuses based on team
                            performance and personal sales achievements</p>
                        <ul class="service-features list-unstyled">
                            <li><i class="fas fa-check text-color mr-2"></i>Bonus trips &amp; retreats</li>
                            <li><i class="fas fa-check text-color mr-2"></i>Car allowance program</li>
                            <li><i class="fas fa-check text-color mr-2"></i>Cash rewards</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                    <div class="service-card h-100">
                        <div class="service-icon mb-4"><i class="ti-share text-color" style="font-size:2.5rem;"></i></div>
                        <h4 class="mb-3">Network Growth Tools</h4>
                        <p class="text-muted mb-4">Proven strategies, recruitment funnels, team building frameworks, and
                            success systems to scale your network exponentially</p>
                        <ul class="service-features list-unstyled">
                            <li><i class="fas fa-check text-color mr-2"></i>Proven strategies</li>
                            <li><i class="fas fa-check text-color mr-2"></i>Team building frameworks</li>
                            <li><i class="fas fa-check text-color mr-2"></i>Scaling systems</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                    <div class="service-card h-100">
                        <div class="service-icon mb-4"><i class="ti-bar-chart-alt text-color"
                                style="font-size:2.5rem;"></i></div>
                        <h4 class="mb-3">Performance Dashboard</h4>
                        <p class="text-muted mb-4">Real-time dashboard showing commissions, team stats, growth metrics, and
                            income projections to track your success</p>
                        <ul class="service-features list-unstyled">
                            <li><i class="fas fa-check text-color mr-2"></i>Real-time analytics</li>
                            <li><i class="fas fa-check text-color mr-2"></i>Income projections</li>
                            <li><i class="fas fa-check text-color mr-2"></i>Team performance</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                    <div class="service-card h-100">
                        <div class="service-icon mb-4"><i class="ti-star text-color" style="font-size:2.5rem;"></i></div>
                        <h4 class="mb-3">Elite Mastermind</h4>
                        <p class="text-muted mb-4">Join exclusive networking events, retreats, and VIP masterminds with top
                            earners to build relationships and learn strategies</p>
                        <ul class="service-features list-unstyled">
                            <li><i class="fas fa-check text-color mr-2"></i>VIP networking events</li>
                            <li><i class="fas fa-check text-color mr-2"></i>Mastermind retreats</li>
                            <li><i class="fas fa-check text-color mr-2"></i>Top earner access</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Why Choose Us -->
            <div class="row mt-5 pt-5 border-top">
                <div class="col-lg-8">
                    <div class="section-title mb-5">
                        <span class="h6 text-color">🌟 Why Choose Kemtex Wellness</span>
                        <h3 class="mt-3">Industry-Leading Support &amp; Proven Success</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h5 class="mb-3"><i class="fas fa-check-circle text-color mr-2"></i>Top-Quality Products
                            </h5>
                            <p class="text-muted">Premium wellness products that customers love and reorder monthly</p>
                        </div>
                        <div class="col-md-6 mb-4">
                            <h5 class="mb-3"><i class="fas fa-check-circle text-color mr-2"></i>Unlimited Income
                                Potential</h5>
                            <p class="text-muted">No income caps on commissions or team bonuses</p>
                        </div>
                        <div class="col-md-6 mb-4">
                            <h5 class="mb-3"><i class="fas fa-check-circle text-color mr-2"></i>Fast Payouts</h5>
                            <p class="text-muted">Weekly commission payments directly to your bank account</p>
                        </div>
                        <div class="col-md-6 mb-4">
                            <h5 class="mb-3"><i class="fas fa-check-circle text-color mr-2"></i>Transparent Compensation
                            </h5>
                            <p class="text-muted">Clear 20-level income structure with documented earning potential</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="bg-light p-4 rounded" style="border-left:4px solid #FFD700;">
                        <h5 class="text-color mb-4">📊 Our Track Record</h5>
                        <div class="mb-3">
                            <p class="mb-0"><strong>50,000+</strong></p>
                            <p class="text-muted small">Active distributors worldwide</p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-0"><strong>₹50Cr+</strong></p>
                            <p class="text-muted small">Paid out in commissions annually</p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-0"><strong>25+</strong></p>
                            <p class="text-muted small">Countries with operations</p>
                        </div>
                        <div>
                            <p class="mb-0"><strong>100%</strong></p>
                            <p class="text-muted small">Transparent earnings system</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section Services End -->

    <section class="cta-2">
        <div class="container">
            <div class="cta-block p-5 rounded">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-7 text-center text-lg-left">
                        <span class="text-color">🌟 Ready to Succeed?</span>
                        <h2 class="mt-2 text-white mb-3">Start Building Your Wellness Empire Today</h2>
                        <p class="text-white lead mb-0">Join thousands of successful distributors earning multiple income
                            streams</p>
                    </div>
                    <div class="col-lg-4 text-center text-lg-right mt-4 mt-lg-0">
                        <a href="{{ route('pricing') }}" class="btn btn-main btn-round-full mr-2">Choose Your Plan</a>
                        <a href="{{ route('contact') }}"
                            class="btn btn-solid-border btn-round-full text-white mt-2 mt-lg-0">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
