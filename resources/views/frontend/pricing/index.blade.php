@extends('frontend.layouts.master')

@section('title', 'Pricing &amp; Commission Structure - KemtexWellness')

@push('styles')
<style>
    .plans-carousel-wrap {
        position: relative;
        padding: 0 30px 6px;
    }

    .plans-mobile-grid {
        display: none;
    }

    .plans-slide-row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -9px;
    }

    .plans-slide-col {
        width: 33.3333%;
        padding: 0 9px;
        margin-bottom: 10px;
    }

    .showcase-plan {
        border-radius: 18px;
        border: 1px solid rgba(15, 23, 42, 0.08);
        background: #fff;
        box-shadow: 0 10px 26px rgba(16, 24, 40, 0.08);
        overflow: hidden;
        padding: 18px 16px 14px;
        display: flex;
        flex-direction: column;
    }

    .showcase-plan-head {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #fff;
        font-weight: 800;
        font-size: 12px;
        letter-spacing: .04em;
        text-transform: uppercase;
        border-radius: 999px;
        padding: 7px 14px;
        width: fit-content;
        margin: 0 auto 14px;
    }

    .showcase-price {
        font-size: clamp(2rem, 2.4vw, 2.7rem);
        line-height: 1;
        font-weight: 900;
        color: #0f172a;
        text-align: center;
    }

    .showcase-sub {
        text-align: center;
        color: #0f172a;
        font-size: 14px;
        margin: 10px 0 12px;
    }

    .showcase-rule {
        height: 1px;
        background: #dce7dd;
        margin-bottom: 14px;
    }

    .showcase-feature {
        display: flex;
        gap: 10px;
        margin-bottom: 12px;
        align-items: flex-start;
    }

    .showcase-feature i {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #eef7ee;
        color: #2a7f38;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        margin-top: 1px;
        flex-shrink: 0;
    }

    .showcase-feature-title {
        font-size: 13px;
        font-weight: 800;
        color: #101828;
        line-height: 1.2;
    }

    .showcase-feature-sub {
        font-size: 12px;
        color: #475467;
        line-height: 1.3;
        margin-top: 3px;
    }

    .showcase-power {
        border-radius: 10px;
        padding: 10px 11px;
        margin-top: 4px;
        margin-bottom: 14px;
        font-size: 12px;
        text-align: center;
        border: 1px solid rgba(16, 24, 40, .06);
    }

    .showcase-power strong {
        display: block;
        font-size: 13px;
        margin-bottom: 4px;
    }

    .showcase-cta {
        margin-top: auto;
        border: none;
        border-radius: 10px;
        height: 44px;
        font-size: 22px;
        font-weight: 800;
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .showcase-cta.disabled {
        background: #8b98a8 !important;
        cursor: not-allowed;
        opacity: .95;
        font-size: 22px;
    }

    .showcase-cta.active-plan {
        background: #28a745 !important;
        color: #fff !important;
    }

    .showcase-cta.upgrade-plan {
        background: #ff8a00 !important;
        color: #fff !important;
    }

    .plan-theme-bronze { background: linear-gradient(135deg, #f5c58d, #f2dcc2); }
    .plan-theme-bronze .showcase-plan-head, .plan-theme-bronze .showcase-cta { background: #1f2937; }
    .plan-theme-silver { background: linear-gradient(135deg, #e8e8e8, #f9f9f9); }
    .plan-theme-silver .showcase-plan-head, .plan-theme-silver .showcase-cta { background: #1f2937; }
    .plan-theme-gold { background: linear-gradient(135deg, #ffe86e, #fff8cf); }
    .plan-theme-gold .showcase-plan-head, .plan-theme-gold .showcase-cta { background: #1f2937; }
    .plan-theme-platinum { background: linear-gradient(135deg, #64d983, #d7f7e0); }
    .plan-theme-platinum .showcase-plan-head, .plan-theme-platinum .showcase-cta { background: #1f2937; }
    .plan-theme-diamond { background: linear-gradient(135deg, #54a7ff, #d6ebff); }
    .plan-theme-diamond .showcase-plan-head, .plan-theme-diamond .showcase-cta { background: #1f2937; }

    .plans-carousel-caption {
        margin-top: 6px;
        text-align: center;
        font-size: 13px;
        color: #475467;
        font-weight: 600;
    }

    .plans-carousel-wrap .carousel-indicators {
        bottom: -22px;
    }

    .plans-carousel-wrap .carousel-indicators li {
        background-color: #9ca3af;
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    .plans-carousel-wrap .carousel-indicators .active {
        background-color: #28a745;
    }

    .plans-carousel-wrap .carousel-control-prev,
    .plans-carousel-wrap .carousel-control-next {
        width: 30px;
        opacity: .95;
    }

    .plans-carousel-wrap .carousel-control-prev-icon,
    .plans-carousel-wrap .carousel-control-next-icon {
        background-color: #1f2937;
        border-radius: 999px;
        background-size: 52% 52%;
        width: 28px;
        height: 28px;
    }

    @media (max-width: 1399px) { .plans-slide-col { width: 33.3333%; } }
    @media (max-width: 991px) { .plans-slide-col { width: 50%; } }
    @media (max-width: 575px) {
        .plans-carousel-wrap {
            padding: 0 6px 6px;
        }

        .plans-slide-col {
            width: 100%;
        }

        .showcase-plan { padding: 16px 14px 12px; border-radius: 16px; }
    }

    @media (max-width: 767.98px) {
        .plans-carousel-wrap {
            display: none;
        }

        .plans-mobile-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
        }
    }
</style>
@endpush

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
<section class="section pricing bg-gray position-relative py-5">
    <div class="container">

        <div class="row justify-content-center mb-5">
            <div class="col-lg-7 text-center">
                <h2 class="mt-3 font-weight-bold">
                    Choose Your Membership Plan & Start Earning
                </h2>
            </div>
        </div>
        @php
        $planNames = [
        'Bronze Core',
        'Silver Edge',
        'Gold Rise',
        'Platinum Force',
        'Diamond Elite'
        ];

        $planColors = [
        'linear-gradient(135deg, #cd7f32, #fbe8d3)',
        'linear-gradient(135deg, #c0c0c0, #f1f1f1)',
        'linear-gradient(135deg, #ffd700, #fff8dc)',
        'linear-gradient(135deg, #28a745, #d4edda)',
        'linear-gradient(135deg, #007bff, #d6eaff)',
        ];

        $currentPlanId = auth()->user()->current_plan_id ?? 0;

        // get current plan index
        $currentIndex = collect($packages)->search(function ($p) use ($currentPlanId) {
        return $p->id == $currentPlanId;
        });
        @endphp

        @php
            $themes = ['bronze', 'silver', 'gold', 'platinum', 'diamond'];
            $labels = ['Bronze Core', 'Silver Edge', 'Gold Rise', 'Platinum Force', 'Diamond Elite'];
            $icons = ['fa-star', 'fa-medal', 'fa-gem', 'fa-crown', 'fa-trophy'];
        @endphp

        @php
            $slides = collect($packages)->values()->chunk(3);
        @endphp
        <div class="plans-carousel-wrap">
            <div id="plansCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                <ol class="carousel-indicators">
                    @foreach($slides as $slideIndex => $slide)
                        <li data-target="#plansCarousel" data-slide-to="{{ $slideIndex }}" class="{{ $slideIndex === 0 ? 'active' : '' }}"></li>
                    @endforeach
                </ol>

                <div class="carousel-inner">
                    @foreach($slides as $slideIndex => $slide)
                        <div class="carousel-item {{ $slideIndex === 0 ? 'active' : '' }}">
                            <div class="plans-slide-row justify-content-center">
                                @foreach($slide as $package)
                                    @php
                                        $index = $packages->search(fn($p) => $p->id === $package->id);
                                        $isCurrent = $package->id == $currentPlanId;
                                        $isNext = $index == $currentIndex + 1;
                                        $isLocked = $index < $currentIndex;
                                        $theme = $themes[$index] ?? 'bronze';
                                        $label = $labels[$index] ?? ($package->name ?? 'Premium Plan');
                                    @endphp

                                    <div class="plans-slide-col">
                                        <div class="showcase-plan plan-theme-{{ $theme }}">
                                            <span class="showcase-plan-head">
                                                <i class="fas {{ $icons[$index] ?? 'fa-star' }}"></i>{{ $label }}
                                            </span>

                                            <div class="showcase-price">₹{{ number_format((float) $package->price, 0) }}</div>
                                            <div class="showcase-sub">Start your journey and unlock earning potential </div>
                                            <div class="showcase-rule"></div>

                                            <div class="showcase-feature">
                                                <i class="fas fa-layer-group"></i>
                                                <div>
                                                    <div class="showcase-feature-title">Earn 10X in Total</div>
                                                    <div class="showcase-feature-sub">On your total income</div>
                                                </div>
                                            </div>
                                            <div class="showcase-feature">
                                                <i class="fas fa-chart-line"></i>
                                                <div>
                                                    <div class="showcase-feature-title">Earn 2X Per Day</div>
                                                    <div class="showcase-feature-sub">On your daily income</div>
                                                </div>
                                            </div>
                                            <div class="showcase-feature">
                                                <i class="fas fa-users"></i>
                                                <div>
                                                    <div class="showcase-feature-title">Higher Referral Income</div>
                                                    <div class="showcase-feature-sub">Grow your network and earn more</div>
                                                </div>
                                            </div>
                                            <div class="showcase-feature">
                                                <i class="fas fa-tags"></i>
                                                <div>
                                                    <div class="showcase-feature-title">Buy Any Product</div>
                                                    <div class="showcase-feature-sub">At Direct Price (DP)</div>
                                                </div>
                                            </div>

                                            <div class="showcase-power">
                                                <strong><i class="fas fa-shield-alt mr-1"></i>All Plans, Same Power.</strong>
                                                <div>10X in Total &nbsp;|&nbsp; 2X Per Day</div>
                                                <div>Buy Any Product in DP</div>
                                            </div>

                                            @if($isCurrent)
                                                <button class="showcase-cta active-plan" disabled><i class="fas fa-check-circle"></i> Active Plan</button>
                                            @elseif($isNext)
                                                <button class="showcase-cta upgrade-plan purchase-plan" data-amount="{{ $package->price }}" data-plan="{{ $package->id }}">
                                                    Upgrade Now <i class="fas fa-arrow-right"></i>
                                                </button>
                                            @elseif($isLocked)
                                                <button class="showcase-cta disabled" disabled>Locked</button>
                                            @else
                                                <button class="showcase-cta disabled" disabled>Not Available</button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="plans-carousel-caption">
                                {{ $slide->pluck('name')->join(' • ') }}
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($slides->count() > 1)
                    <a class="carousel-control-prev" href="#plansCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#plansCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                @endif
            </div>
        </div>

        <div class="plans-mobile-grid">
            @foreach($packages as $index => $package)
                @php
                    $isCurrent = $package->id == $currentPlanId;
                    $isNext = $index == $currentIndex + 1;
                    $isLocked = $index < $currentIndex;
                    $theme = $themes[$index] ?? 'bronze';
                    $label = $labels[$index] ?? ($package->name ?? 'Premium Plan');
                @endphp
                <div class="showcase-plan plan-theme-{{ $theme }}">
                    <span class="showcase-plan-head">
                        <i class="fas {{ $icons[$index] ?? 'fa-star' }}"></i>{{ $label }}
                    </span>
                    <div class="showcase-price">₹{{ number_format((float) $package->price, 0) }}</div>
                    <div class="showcase-sub">Start your journey and unlock earning potential 🚀</div>
                    <div class="showcase-rule"></div>
                    <div class="showcase-feature"><i class="fas fa-layer-group"></i><div><div class="showcase-feature-title">Earn 10X in Total</div><div class="showcase-feature-sub">On your total income</div></div></div>
                    <div class="showcase-feature"><i class="fas fa-chart-line"></i><div><div class="showcase-feature-title">Earn 2X Per Day</div><div class="showcase-feature-sub">On your daily income</div></div></div>
                    <div class="showcase-feature"><i class="fas fa-users"></i><div><div class="showcase-feature-title">Higher Referral Income</div><div class="showcase-feature-sub">Grow your network and earn more</div></div></div>
                    <div class="showcase-feature"><i class="fas fa-tags"></i><div><div class="showcase-feature-title">Buy Any Product</div><div class="showcase-feature-sub">At Direct Price (DP)</div></div></div>
                    <div class="showcase-power">
                        <strong><i class="fas fa-shield-alt mr-1"></i>All Plans, Same Power.</strong>
                        <div>10X in Total &nbsp;|&nbsp; 2X Per Day</div>
                        <div>Buy Any Product in DP</div>
                    </div>
                    @if($isCurrent)
                        <button class="showcase-cta active-plan" disabled><i class="fas fa-check-circle"></i> Active Plan</button>
                    @elseif($isNext)
                        <button class="showcase-cta upgrade-plan purchase-plan" data-amount="{{ $package->price }}" data-plan="{{ $package->id }}">
                            Upgrade Now <i class="fas fa-arrow-right"></i>
                        </button>
                    @elseif($isLocked)
                        <button class="showcase-cta disabled" disabled>Locked</button>
                    @else
                        <button class="showcase-cta disabled" disabled>Not Available</button>
                    @endif
                </div>
            @endforeach
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
                            @php
                            $currentPlanId = auth()->user()->current_plan_id ?? 0;

                            $currentIndex = collect($packages)->search(function ($p) use ($currentPlanId) {
                            return $p->id == $currentPlanId;
                            });
                            @endphp

                            <div class="col-lg-6">
                                <h5 class="mb-4" style="color:#28a745;">
                                    <strong>📱 Choose Your Package & Start Earning</strong>
                                </h5>

                                <div style="background-color:#fff;border:2px solid #28a745;padding:20px;border-radius:8px;">

                                    <p class="mb-4"><strong>👤 Switch from Package to Package</strong></p>

                                    @foreach($packages as $index => $package)

                                    @php
                                    $isCurrent = $package->id == $currentPlanId;
                                    $isNext = $index == $currentIndex + 1;
                                    $isLocked = $index < $currentIndex;

                                        // Color based on index (optional)
                                        $colors=['#0066cc','#FFD700','#28a745','#999','#FFB300'];
                                        $color=$colors[$index] ?? '#0066cc' ;
                                        @endphp

                                        <div style="
                display:flex;
                align-items:center;
                padding:12px;
                margin-bottom:10px;
                background-color:#f9f9f9;
                border-radius:6px;
                border-left:4px solid {{ $color }};
            ">

                                        <span style="font-size:18px;font-weight:bold;color:{{ $color }};min-width:80px;">
                                            ₹{{ $package->price }}
                                        </span>

                                        <span style="color:#666;flex-grow:1;">
                                            {{ $package->name ?? 'Package ' . ($index + 1) }}
                                        </span>

                                        {{-- STATUS --}}
                                        @if($isCurrent)
                                        <span style="color:#28a745;font-weight:bold;">✓ Active</span>

                                        @elseif($isNext)
                                        <a href="javascript:void(0)"
                                            class="purchase-plan"
                                            data-plan="{{ $package->id }}"
                                            data-amount="{{ $package->price }}"
                                            style="color:#28a745;font-weight:bold;">
                                            ⬆ Upgrade
                                        </a>

                                        @elseif($isLocked)
                                        <span style="color:#999;font-weight:bold;">🔒 Locked</span>

                                        @else
                                        <span style="color:#999;">Not Available</span>
                                        @endif

                                </div>

                                @endforeach

                                <div style="
            background-color:#e8f5e9;
            padding:12px;
            border-radius:6px;
            margin-top:15px;
            text-align:center;
            border:2px dashed #28a745;
        ">
                                    <p class="mb-0" style="color:#28a745;font-weight:bold;">
                                        Upgrade anytime to earn higher commissions!
                                    </p>
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
                            <p><strong>5% Repurchase Deduction</strong></p>
                            <p class="text-muted">Credited to your wallet for future purchases or upgrades</p>
                        </div>
                    </div>
                    <p class="mb-0 pt-3 border-top"><strong>Net Calculation:</strong> Your earnings minus 15% total
                        deductions = Amount credited to account</p>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="container mt-5">
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
    </div> -->

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