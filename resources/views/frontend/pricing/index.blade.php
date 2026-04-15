@extends('frontend.layouts.master')

@section('title', 'Pricing &amp; Commission Structure - KemtexWellness')

@section('content')

    <section class="page-title bg-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block text-center">
                        <span class="text-white">💎 Income Plans</span>
                        <h1 class="text-capitalize mb-4 text-lg">Pricing Package</h1>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                            <li class="list-inline-item"><span class="text-white">/</span></li>
                            <li class="list-inline-item text-white-50">Our Pricing</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- Section Pricing Packages Start -->
    <section class="section pricing bg-gray position-relative">
        <div class="hero-img bg-overlay h70"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center">
                    <div class="section-title">
                        <span class="h6 text-dark">🎯 Start Now</span>
                        <h2 class="mt-3 content-title text-dark">Choose Your Membership Plan &amp; Start Earning Today</h2>
                    </div>
                </div>
            </div>

            <div id="pricingCarousel" class="carousel slide" data-ride="carousel" data-interval="5000">
                <ol class="carousel-indicators">
                    <li data-target="#pricingCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#pricingCarousel" data-slide-to="1"></li>
                </ol>
                <div class="carousel-inner">
                    <!-- Slide 1 -->
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="card text-center h-100"
                                    style="border-top:4px solid #0066cc;background-color:#dce8fb;">
                                    <div class="card-body py-4 d-flex flex-column">
                                        <div class="pricing-header mb-4">
                                            <h5 class="font-weight-normal mb-2">Essential Care</h5>
                                            <h2 class="mb-1 font-weight-bold">₹1500</h2>
                                            <p class="small">One-Time / Monthly</p>
                                        </div>
                                        <strong class="mb-3">✅ Get Started:</strong>
                                        <ul class="list-unstyled flex-grow-1">
                                            <li class="py-1">- 20% Personal Commission</li>
                                            <li class="py-1">- Starter Resources Kit</li>
                                            <li class="py-1">- Basic Training Access</li>
                                            <li class="py-1">- Community Support</li>
                                        </ul>
                                        <a
                                            class="btn btn-small btn-solid-border mt-4 btn-round-full purchase-plan"  data-amount="1500" data-plan="1">Join Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="card text-center h-100"
                                    style="border-top:4px solid #c8a800;background-color:#fff9d6;">
                                    <div class="card-body py-4 d-flex flex-column">
                                        <div class="pricing-header mb-4">
                                            <h5 class="font-weight-normal mb-2">Signature Care</h5>
                                            <h2 class="mb-1 font-weight-bold">₹3000</h2>
                                            <p class="small">One-Time / Monthly</p>
                                        </div>
                                        <strong class="mb-3">✅ Build Your Team:</strong>
                                        <ul class="list-unstyled flex-grow-1">
                                            <li class="py-1">- 25% Personal Commission</li>
                                            <li class="py-1">- 5% Team Bonus</li>
                                            <li class="py-1">- Advanced Marketing Materials</li>
                                            <li class="py-1">- Bi-Weekly Coaching Calls</li>
                                        </ul>
                                                     <a
                                            class="btn btn-small btn-solid-border mt-4 btn-round-full purchase-plan"  data-amount="3000" data-plan="2">Join Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="card text-center h-100"
                                    style="border-top:4px solid #28a745;background-color:#d4edda;">
                                    <div class="card-body py-4 d-flex flex-column">
                                        <div class="pricing-header mb-4">
                                            <h5 class="font-weight-normal mb-2">Premium Care</h5>
                                            <h2 class="mb-1 font-weight-bold">₹7500</h2>
                                            <p class="small">One-Time / Monthly</p>
                                        </div>
                                        <strong class="mb-3">✅ Scale Your Income:</strong>
                                        <ul class="list-unstyled flex-grow-1">
                                            <li class="py-1">- 30% Personal Commission</li>
                                            <li class="py-1">- 10% Team Bonus</li>
                                            <li class="py-1">- Complete Training Academy</li>
                                            <li class="py-1">- Weekly 1-on-1 Coaching</li>
                                        </ul>
                                                     <a 
                                            class="btn btn-small btn-solid-border mt-4 btn-round-full purchase-plan"  data-amount="7500" data-plan="3">Join Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="carousel-item">
                        <div class="row justify-content-center">
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="card text-center h-100"
                                    style="border-top:4px solid #888;background-color:#e8e8e8;">
                                    <div class="card-body py-4 d-flex flex-column">
                                        <div class="pricing-header mb-4">
                                            <h5 class="font-weight-normal mb-2">Executive Wellness</h5>
                                            <h2 class="mb-1 font-weight-bold">₹15000</h2>
                                            <p class="small">One-Time / Monthly</p>
                                        </div>
                                        <strong class="mb-3">✅ Leadership Tier:</strong>
                                        <ul class="list-unstyled flex-grow-1">
                                            <li class="py-1">- 35% Personal Commission</li>
                                            <li class="py-1">- 15% Team Bonus + Overrides</li>
                                            <li class="py-1">- VIP Mastermind Access</li>
                                            <li class="py-1">- Bonus Trip Qualification</li>
                                        </ul>
                                        <a 
                                            class="btn btn-small btn-solid-border mt-4 btn-round-full purchase-plan"  data-amount="15000" data-plan="4">Join Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="card text-center h-100"
                                    style="border-top:4px solid #FFB300;background-color:#fff3cd;">
                                    <div class="card-body py-4 d-flex flex-column">
                                        <div class="pricing-header mb-4">
                                            <h5 class="font-weight-normal mb-2">Platinum Elite</h5>
                                            <h2 class="mb-1 font-weight-bold">₹30000</h2>
                                            <p class="small">One-Time / Monthly</p>
                                        </div>
                                        <strong class="mb-3">✅ Elite Executive:</strong>
                                        <ul class="list-unstyled flex-grow-1">
                                            <li class="py-1">- 40% Personal Commission</li>
                                            <li class="py-1">- 20% Team Bonus + Generational Income</li>
                                            <li class="py-1">- Luxury Exclusive Rewards</li>
                                            <li class="py-1">- Career Car Qualification</li>
                                        </ul>
                                        <a 
                                            class="btn btn-small btn-solid-border mt-4 btn-round-full purchase-plan"  data-amount="30000" data-plan="5">Join Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#pricingCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#pricingCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

           
        </div>
    </section>
    <!-- Section Pricing End -->
    <!-- Section Intro Start -->
    <section class="section intro">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="section-title pt-5">
                        <span class="h6 text-color">💎 Choose Your Path</span>
                        <h2 class="mt-3">Start with Plan 1 &amp; Upgrade Anytime as You Grow</h2>
                    </div>
                </div>
                <div class="col-lg-6 ml-auto">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="intro-item mb-4 mb-lg-0">
                                <i class="ti-money text-color" style="font-size:48px;"></i>
                                <h4 class="mt-4">High Commission Structure</h4>
                                <p>Up to 50% personal commissions + team bonuses. Multiple income opportunities per tier.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="intro-item mb-4 mb-lg-0">
                                <i class="ti-crown text-color" style="font-size:48px;"></i>
                                <h4 class="mt-4">Exclusive Benefits</h4>
                                <p>Bonus trips, luxury rewards, car allowance, and VIP recognition for top performers.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section Intro End -->

    <!-- Commission Structure Section -->
    <section class="section commission-structure">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="mb-3">💰 Complete Commission &amp; Referral Structure</h2>
                    <p class="lead">Transparent, unlimited earning potential with multiple income streams</p>
                </div>
            </div>

            <!-- Registration & Packages -->
            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="text-color mb-3">📋 Registration &amp; Service Packages</h4>
                            <div class="row">
                                <div class="col-lg-6">
                                    <p><strong>Registration Fee:</strong> <span class="text-color h5">FREE</span></p>
                                    <p class="text-muted">Join our network with zero joining cost</p>
                                </div>
                                <div class="col-lg-6">
                                    <p><strong>Available Service Packages:</strong></p>
                                    <p class="h5 mb-2" style="color:#0066cc;"><strong>₹1000</strong></p>
                                    <p class="h5 mb-2" style="color:#FFD700;"><strong>₹2500</strong></p>
                                    <p class="h5 mb-2" style="color:#28a745;"><strong>₹5000</strong></p>
                                    <p class="h5 mb-2" style="color:#C0C0C0;"><strong>₹10000</strong></p>
                                    <p class="h5 mb-2" style="color:#FFB300;"><strong>₹20000</strong></p>
                                    <p class="text-muted mt-3">Flexible options for all business levels</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Distribution -->
            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm bg-light">
                        <div class="card-body p-4">
                            <h4 class="text-color mb-4">📊 Revenue Distribution Model</h4>
                            <div class="row text-center">
                                <div class="col-lg-4 border-right">
                                    <h2 class="text-color mb-2">55%</h2>
                                    <p><strong>Level Income</strong></p>
                                    <p class="text-muted small">Your MLM Network Earnings</p>
                                </div>
                                <div class="col-lg-4 border-right">
                                    <h2 class="text-color mb-2">20%</h2>
                                    <p><strong>Royalty Income</strong></p>
                                    <p class="text-muted small">Volume Bonus &amp; Recognition</p>
                                </div>
                                <div class="col-lg-4">
                                    <h2 class="text-color mb-2">25%</h2>
                                    <p><strong>Operations &amp; Fund</strong></p>
                                    <p class="text-muted small">Company Growth &amp; Development</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 20-Level Income Structure -->
            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="text-color mb-4">🏆 20-Level Deep Income Structure</h4>
                            <p class="mb-4"><strong>Earn commissions from your entire network tree:</strong></p>
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Level</th>
                                            <th>Commission %</th>
                                            <th>Level</th>
                                            <th>Commission %</th>
                                            <th>Level</th>
                                            <th>Commission %</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>Level 1</strong></td>
                                            <td><span class="badge badge-success">15%</span></td>
                                            <td><strong>Level 8</strong></td>
                                            <td><span class="badge badge-info">2%</span></td>
                                            <td><strong>Level 15</strong></td>
                                            <td><span class="badge badge-secondary">1%</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Level 2</strong></td>
                                            <td><span class="badge badge-success">10%</span></td>
                                            <td><strong>Level 9</strong></td>
                                            <td><span class="badge badge-info">2%</span></td>
                                            <td><strong>Level 16</strong></td>
                                            <td><span class="badge badge-secondary">1%</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Level 3</strong></td>
                                            <td><span class="badge badge-success">5%</span></td>
                                            <td><strong>Level 10</strong></td>
                                            <td><span class="badge badge-info">2%</span></td>
                                            <td><strong>Level 17</strong></td>
                                            <td><span class="badge badge-secondary">1%</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Level 4</strong></td>
                                            <td><span class="badge badge-success">5%</span></td>
                                            <td><strong>Level 11</strong></td>
                                            <td><span class="badge badge-secondary">1%</span></td>
                                            <td><strong>Level 18</strong></td>
                                            <td><span class="badge badge-secondary">1%</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Level 5-7</strong></td>
                                            <td><span class="badge badge-info">2% each</span></td>
                                            <td><strong>Level 12-14</strong></td>
                                            <td><span class="badge badge-secondary">1% each</span></td>
                                            <td><strong>Level 19-20</strong></td>
                                            <td><span class="badge badge-secondary">1% each</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Commission Flow & Package Options -->
            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm"
                        style="background:linear-gradient(135deg,rgba(40,167,69,.05) 0%,rgba(40,167,69,.02) 100%);">
                        <div class="card-body p-4">
                            <h4 class="text-color mb-4">💼 Your Earning Journey - Package Levels &amp; Commissions</h4>
                            <div class="row">
                                <div class="col-lg-6">
                                    <h5 class="mb-4" style="color:#28a745;"><strong>📊 Commission Structure by
                                            Level</strong></h5>
                                    <div
                                        style="background-color:#28a745;color:white;padding:15px;border-radius:8px;margin-bottom:10px;text-align:center;">
                                        <strong>Level 1</strong>
                                        <p class="mb-0" style="font-size:24px;font-weight:bold;">15%</p>
                                    </div>
                                    <div
                                        style="background-color:#48c971;color:white;padding:15px;border-radius:8px;margin-bottom:10px;text-align:center;">
                                        <strong>Level 2</strong>
                                        <p class="mb-0" style="font-size:24px;font-weight:bold;">10%</p>
                                    </div>
                                    <div
                                        style="background-color:#68d985;color:#333;padding:15px;border-radius:8px;margin-bottom:10px;text-align:center;">
                                        <strong>Levels 3-4</strong>
                                        <p class="mb-0" style="font-size:24px;font-weight:bold;">5%</p>
                                    </div>
                                    <div
                                        style="background-color:#a8e6b8;color:#333;padding:15px;border-radius:8px;margin-bottom:10px;text-align:center;">
                                        <strong>Level 5-10</strong>
                                        <p class="mb-0" style="font-size:24px;font-weight:bold;">2%</p>
                                        <p class="mb-0 small">(2% each level)</p>
                                    </div>
                                    <div
                                        style="background-color:#c8f0d8;color:#333;padding:15px;border-radius:8px;text-align:center;">
                                        <strong>Level 11-20</strong>
                                        <p class="mb-0" style="font-size:24px;font-weight:bold;">1%</p>
                                        <p class="mb-0 small">(1% each level)</p>
                                    </div>
                                    <div
                                        style="background-color:#f0f8f5;padding:15px;border-left:4px solid #28a745;margin-top:20px;border-radius:4px;">
                                        <strong style="color:#28a745;">Level Opening Condition:</strong>
                                        <p class="mb-0 mt-2">Direct referral opens network levels. More directs = More
                                            levels accessible.</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <h5 class="mb-4" style="color:#28a745;"><strong>📱 Choose Your Package &amp; Start
                                            Earning</strong></h5>
                                    <div
                                        style="background-color:#fff;border:2px solid #28a745;padding:20px;border-radius:8px;">
                                        <p class="mb-4"><strong>👤 Switch from Package to Package</strong></p>
                                        <div
                                            style="display:flex;align-items:center;padding:12px;margin-bottom:10px;background-color:#f9f9f9;border-radius:6px;border-left:4px solid #0066cc;">
                                            <span
                                                style="font-size:18px;font-weight:bold;color:#0066cc;min-width:80px;">₹1000</span>
                                            <span style="color:#666;flex-grow:1;">Starter Package</span>
                                            <span style="color:#28a745;font-weight:bold;">✓ Active</span>
                                        </div>
                                        <div
                                            style="display:flex;align-items:center;padding:12px;margin-bottom:10px;background-color:#f9f9f9;border-radius:6px;border-left:4px solid #FFD700;">
                                            <span
                                                style="font-size:18px;font-weight:bold;color:#e6c300;min-width:80px;">₹2500</span>
                                            <span style="color:#666;flex-grow:1;">Growth Package</span>
                                            <span style="color:#28a745;font-weight:bold;">✓ Switch</span>
                                        </div>
                                        <div
                                            style="display:flex;align-items:center;padding:12px;margin-bottom:10px;background-color:#f9f9f9;border-radius:6px;border-left:4px solid #28a745;">
                                            <span
                                                style="font-size:18px;font-weight:bold;color:#28a745;min-width:80px;">₹5000</span>
                                            <span style="color:#666;flex-grow:1;">Premium Package</span>
                                            <span style="color:#28a745;font-weight:bold;">✓ Switch</span>
                                        </div>
                                        <div
                                            style="display:flex;align-items:center;padding:12px;margin-bottom:10px;background-color:#f9f9f9;border-radius:6px;border-left:4px solid #999;">
                                            <span
                                                style="font-size:18px;font-weight:bold;color:#999;min-width:80px;">₹10000</span>
                                            <span style="color:#666;flex-grow:1;">Elite Package</span>
                                            <span style="color:#28a745;font-weight:bold;">✓ Switch</span>
                                        </div>
                                        <div
                                            style="display:flex;align-items:center;padding:12px;background-color:#f9f9f9;border-radius:6px;border-left:4px solid #FFB300;">
                                            <span
                                                style="font-size:18px;font-weight:bold;color:#FFB300;min-width:80px;">₹20000</span>
                                            <span style="color:#666;flex-grow:1;">Platinum Package</span>
                                            <span style="color:#28a745;font-weight:bold;">✓ Switch</span>
                                        </div>
                                        <div
                                            style="background-color:#e8f5e9;padding:12px;border-radius:6px;margin-top:15px;text-align:center;border:2px dashed #28a745;">
                                            <p class="mb-0" style="color:#28a745;font-weight:bold;">Upgrade anytime to
                                                earn higher commissions!</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Level Opening Conditions -->
            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="text-color mb-4">🔓 Level Opening Conditions (Build Your Network)</h4>
                            <p class="mb-4"><strong>Unlock deeper levels based on your direct referrals:</strong></p>
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="list-unstyled">
                                        <li class="py-2"><strong>1 Direct →</strong> <span class="badge badge-warning">2
                                                Levels Open</span></li>
                                        <li class="py-2"><strong>2 Directs →</strong> <span
                                                class="badge badge-warning">4 Levels Open</span></li>
                                        <li class="py-2"><strong>3 Directs →</strong> <span
                                                class="badge badge-warning">6 Levels Open</span></li>
                                        <li class="py-2"><strong>4 Directs →</strong> <span
                                                class="badge badge-warning">8 Levels Open</span></li>
                                        <li class="py-2"><strong>5 Directs →</strong> <span
                                                class="badge badge-warning">10 Levels Open</span></li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-unstyled">
                                        <li class="py-2"><strong>6 Directs →</strong> <span
                                                class="badge badge-warning">12 Levels Open</span></li>
                                        <li class="py-2"><strong>7 Directs →</strong> <span
                                                class="badge badge-warning">14 Levels Open</span></li>
                                        <li class="py-2"><strong>8 Directs →</strong> <span
                                                class="badge badge-warning">16 Levels Open</span></li>
                                        <li class="py-2"><strong>9 Directs →</strong> <span
                                                class="badge badge-warning">18 Levels Open</span></li>
                                        <li class="py-2"><strong>10 Directs →</strong> <span
                                                class="badge badge-warning">20 Levels Open</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Royalty Income Qualification -->
            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm bg-light">
                        <div class="card-body p-4">
                            <h4 class="text-color mb-4">👑 Royalty Income Qualification</h4>
                            <p class="mb-4"><strong>Earn additional bonuses based on your direct team size:</strong></p>
                            <div class="row">
                                <div class="col-lg-3 text-center py-3 border-right">
                                    <h3 class="text-color">10%</h3>
                                    <p><strong>15 Direct</strong></p>
                                    <p class="text-muted small">Royalty Income</p>
                                </div>
                                <div class="col-lg-3 text-center py-3 border-right">
                                    <h3 class="text-color">+5%</h3>
                                    <p><strong>20 Direct</strong></p>
                                    <p class="text-muted small">Additional Bonus</p>
                                </div>
                                <div class="col-lg-3 text-center py-3 border-right">
                                    <h3 class="text-color">+3%</h3>
                                    <p><strong>30 Direct</strong></p>
                                    <p class="text-muted small">Additional Bonus</p>
                                </div>
                                <div class="col-lg-3 text-center py-3">
                                    <h3 class="text-color">+2%</h3>
                                    <p><strong>50 Direct</strong></p>
                                    <p class="text-muted small">Additional Bonus</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Income Limits -->
            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="text-color mb-4">⚙️ Income Limits &amp; Earning Policies</h4>
                            <div class="row">
                                <div class="col-lg-6">
                                    <p><strong>💰 Maximum Income Limit:</strong></p>
                                    <p class="h5">10x of Your Active Service Package</p>
                                    <p class="text-muted small">Example: ₹5000 package = Up to ₹50,000 monthly earnings cap
                                    </p>
                                    <p class="mt-3"><strong>📅 Re-top-up Policy:</strong></p>
                                    <p class="text-muted">Mandatory re-investment required after reaching 10x limit to
                                        continue earning</p>
                                </div>
                                <div class="col-lg-6">
                                    <p><strong>📊 Daily Earning Limit:</strong></p>
                                    <p class="h5">2x of Your Service Package Per Day</p>
                                    <p class="text-muted small">Example: ₹5000 package = Maximum ₹10,000 daily earnings</p>
                                    <p class="mt-3"><strong>⏰ Closing Time:</strong></p>
                                    <p class="text-muted">Daily closing at midnight (12:00 AM). Earnings reset daily.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deductions -->
            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="text-color mb-4">📝 Applicable Deductions</h4>
                            <div class="row">
                                <div class="col-lg-6">
                                    <p><strong>10% Maintenance Fee</strong></p>
                                    <p class="text-muted">Platform maintenance and support infrastructure</p>
                                </div>
                                <div class="col-lg-6">
                                    <p><strong>10% Repurchase Deduction</strong></p>
                                    <p class="text-muted">Credited to your wallet for future purchases or upgrades</p>
                                </div>
                            </div>
                            <p class="mb-0 pt-3 border-top"><strong>Net Calculation:</strong> Your earnings minus 20% total
                                deductions = Amount credited to account</p>
                        </div>
                    </div>
                </div>
            </div>
 <div class="container mt-5">
                <div class="cta-block p-5 rounded">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-lg-7 text-center text-lg-left">
                            <span class="text-color">For Every type business</span>
                            <h2 class="mt-2 text-dark">Entrust Your Project to Our Best Team of Professionals</h2>
                        </div>
                        <div class="col-lg-4 text-center text-lg-right mt-4 mt-lg-0">
                            <a href="{{ route('contact') }}" class="btn btn-main btn-round-full">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Commission Structure Section End -->

    

@endsection
@section('scripts')
<script src="{{ asset('frontend/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/plugins/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/script.js') }}"></script>
 <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
$(document).on('click', '.purchase-plan', function(e) {
    e.preventDefault();

    var amount = $(this).data('amount');
    var planId = $(this).data('plan');

    $.post("{{ url('member/create-order') }}", {
        _token: $('meta[name="csrf-token"]').attr('content'),
        amount: amount,
        plan_id: planId
    }, function(order) {

        var options = {
            key: "{{ config('services.razorpay.key') }}",
            amount: order.amount,
            currency: "INR",
            order_id: order.order_id,

            handler: function(response) {

                $.post("{{ url('member/verify-payment') }}", {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    razorpay_payment_id: response.razorpay_payment_id,
                    razorpay_order_id: response.razorpay_order_id,
                    razorpay_signature: response.razorpay_signature,
                    plan_id: planId,
                    amount: amount
                }, function(res) {

                    if (res.success) {
                        alert('✅ Plan Activated Successfully');
                        window.location.reload();
                    } else {
                        alert('❌ Payment Failed');
                    }

                });
            }
        };

        var rzp = new Razorpay(options);
        rzp.open();

    });
});
</script>
@endsection
