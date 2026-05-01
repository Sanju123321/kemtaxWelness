<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="description" content="KemtexWellness Member Portal">
    <title>@yield('title', 'Member Area') | KemtexWellness</title>

    {{-- Frontend Assets --}}
    <link rel="stylesheet" href="{{ asset('frontend/plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/themify/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="icon" href="{{ asset('frontend/images/favicon.png') }}" type="image/x-icon">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('styles')
</head>

<body>

    {{-- Member Navigation --}}
    <header class="navigation" style="background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">

        <style>

            .plan-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 12px 35px rgba(0,0,0,0.08);
    text-align: center;
    transition: 0.3s;
}

.plan-card:hover {
    transform: translateY(-5px);
}

.plan-badge {
    display: inline-block;
    background: #28a745;
    color: #fff;
    padding: 6px 16px;
    border-radius: 20px;
    font-weight: 600;
    margin-bottom: 10px;
}

.plan-price {
    font-size: 34px;
    font-weight: bold;
    color: #28a745;
}

.plan-sub {
    color: #777;
    margin-bottom: 15px;
}

.plan-divider {
    height: 1px;
    background: #eee;
    margin: 15px 0;
}

.plan-feature {
    display: flex;
    align-items: center;
    text-align: left;
    margin-bottom: 12px;
}

.plan-feature i {
    color: #28a745;
    font-size: 18px;
    margin-right: 10px;
}

.plan-feature small {
    display: block;
    color: #888;
    font-size: 12px;
}

.plan-footer-box {
    background: #f1f8f4;
    padding: 10px;
    border-radius: 10px;
    margin-top: 15px;
    font-size: 14px;
}

.plan-btn {
    margin-top: 15px;
    width: 100%;
    border-radius: 25px;
    background: #28a745;
    color: #fff;
    font-weight: 600;
}
            .member-cart-wrap,
            .member-wish-wrap {
                position: relative;
                display: inline-flex;
                align-items: center;
                margin-right: 4px;
            }

            .member-cart-wrap a,
            .member-wish-wrap a {
                font-size: 19px;
                color: #444;
                padding: 5px 9px;
                text-decoration: none;
                border-radius: 6px;
                transition: background .15s, color .15s;
            }

            .member-cart-wrap a:hover {
                color: #28a745;
                background: #eaf7ef;
            }

            .member-wish-wrap a:hover {
                color: #e53935;
                background: #fdecea;
            }

            .member-cart-wrap a:hover .member-badge {
                background: #1e7e34;
            }

            .member-badge {
                position: absolute;
                top: 2px;
                right: 4px;
                background: #28a745;
                color: #fff;
                font-size: 9px;
                font-weight: 800;
                min-width: 16px;
                height: 16px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0 3px;
                border: 1.5px solid #fff;
                line-height: 1;
            }

            .member-top-links {
                display: none !important;
            }

            body,
            .navigation,
            .container,
            .container-fluid {
                max-width: 100%;
            }

            body {
                overflow-x: hidden;
            }

            .member-navbar-actions {
                display: flex;
                align-items: center;
                flex-wrap: wrap;
                justify-content: flex-end;
                gap: 6px;
                max-width: 100%;
                margin-left: auto !important;
            }

            .member-user-dropdown-btn {
                max-width: 100%;
                min-width: 0;
            }

            .member-user-dropdown-btn .member-user-name {
                display: inline-block;
                max-width: 120px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                vertical-align: bottom;
            }

            @media (max-width: 991.98px) {
                .member-navbar-actions {
                    justify-content: center;
                    padding-top: 8px;
                    width: 100%;
                }

                .member-user-dropdown-btn .member-user-name {
                    max-width: 100px;
                }
            }

            @media (max-width: 575.98px) {
                .member-user-dropdown-btn {
                    padding-left: 10px;
                    padding-right: 10px;
                    font-size: 12px;
                }

                .member-user-dropdown-btn .member-user-name {
                    max-width: 72px;
                }
            }

            .table-responsive {
                -webkit-overflow-scrolling: touch;
            }

            @media (max-width: 768px) {

                .btn,
                .form-control,
                .custom-select {
                    min-height: 42px;
                }

                .navbar-toggler,
                #memberNav {
                    display: none !important;
                }

                .modal .modal-dialog {
                    margin: .5rem;
                }

                .modal .modal-body {
                    max-height: calc(100vh - 130px);
                    overflow-y: auto;
                    -webkit-overflow-scrolling: touch;
                }
            }
        </style>

        <div id="navbar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg px-0 py-3">
                            <a class="navbar-brand" href="{{ route('home') }}">
                                kemtex<span>Wellness.</span>
                            </a>
                            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                                data-target="#memberNav" aria-controls="memberNav" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <span class="fa fa-bars"></span>
                            </button>
                            <div class="collapse navbar-collapse text-center" id="memberNav">
                                <ul class="navbar-nav ml-auto member-top-links">
                                    <li class="nav-item {{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('member.dashboard') }}"><i
                                                class="fas fa-tachometer-alt mr-1"></i>Dashboard</a>
                                    </li>
                                    <li class="nav-item {{ request()->routeIs('member.wallet') ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('member.wallet') }}"><i
                                                class="fas fa-wallet mr-1"></i>Wallet</a>
                                    </li>
                                    <li
                                        class="nav-item {{ request()->routeIs('member.credentials') ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('member.credentials') }}"><i
                                                class="fas fa-award mr-1"></i>My Achievements</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('pricing') }}"><i
                                                class="fas fa-tags mr-1"></i>Pricing &amp; Plans</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('contact') }}"><i
                                                class="fas fa-headset mr-1"></i>Support</a>
                                    </li>
                                </ul>

                                <div class="my-2 my-md-0 ml-lg-3 member-navbar-actions">

                                    {{-- Cart icon --}}
                                    <div class="member-cart-wrap">
                                        <a href="{{ route('member.dashboard') }}#cart" title="My Bag">
                                            <i class="fas fa-shopping-bag"></i>
                                        </a>
                                        <span class="member-badge cart-badge" id="cart-count"
                                            style="{{ ($cartCount ?? 0) > 0 ? '' : 'display:none;' }}">
                                            {{ $cartCount ?? 0 }}
                                        </span>
                                    </div>

                                    {{-- Wishlist icon --}}
                                    <div class="member-wish-wrap">
                                        <a href="{{ route('member.dashboard') }}#wishlist" title="My Wishlist">
                                            <i class="fas fa-heart" style="color:#e53935;"></i>
                                        </a>
                                    </div>

                                    {{-- User dropdown --}}
                                    <div class="dropdown ml-2 flex-shrink-0">
                                        <button type="button"
                                            class="btn btn-main btn-round-full btn-sm dropdown-toggle member-user-dropdown-btn"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                            style="min-width:0;">
                                            <i class="fas fa-user mr-1"></i>
                                            <span class="member-user-name">{{ Str::words(auth()->user()->name ?? 'Member', 1, '') }}</span>
                                            <i class="fas fa-chevron-down ml-1 small"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right"
                                            style="min-width:170px;border-radius:8px;box-shadow:0 4px 20px rgba(0,0,0,.12);border:none;">
                                            <a class="dropdown-item" href="{{ route('member.dashboard') }}"
                                                style="font-size:13px;">
                                                <i class="fas fa-tachometer-alt mr-2 text-color"></i>Dashboard
                                            </a>
                                            <a class="dropdown-item" href="{{ route('member.profile') }}"
                                                style="font-size:13px;">
                                                <i class="fas fa-user-cog mr-2 text-color"></i>Profile
                                            </a>
                                            <a class="dropdown-item" href="{{ route('member.kyc.index') }}"
                                                style="font-size:13px;">
                                                <i class="fas fa-id-card mr-2 text-color"></i>KYC Documents
                                            </a>
                                            <a class="dropdown-item" href="{{ route('products') }}"
                                                style="font-size:13px;">
                                                <i class="fas fa-shopping-bag mr-2 text-color"></i>Shop Products
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                                style="font-size:13px;">
                                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- Page Content --}}
    @yield('content')
   
    {{-- Plan Purchase Modal (hidden by default) --}}
   <div class="modal fade" id="planModal" tabindex="-1" role="dialog"
     aria-labelledby="planModalLabel" aria-hidden="true"
     data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"
             style="border-radius:18px; overflow:hidden; box-shadow:0 8px 32px rgba(0,0,0,0.18);">

            <!-- Header -->
            <div class="modal-header"
                 style="background: linear-gradient(90deg, #1e7e34 0%, #28a745 100%);
                        color:#fff; border-bottom:none;">
                <h4 class="modal-title font-weight-bold w-100 text-center" id="planModalLabel">
                    Welcome! Please Choose a Plan to Continue
                </h4>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background:#f7fafd;">
                <div class="container-fluid">
                    <div class="row justify-content-center">

                        <!-- PLAN CARD START -->
                        <div class="col-lg-7 col-md-10 col-sm-12 mb-4">
                            <div class="plan-card">

                                <!-- Plan Name -->
                                <div class="plan-badge">
                                    <i class="fas fa-star mr-1"></i>
                                    {{ $plan->name ?? 'Essential Care' }}
                                </div>

                                <!-- Price -->
                                <div class="plan-price">
                                    ₹{{ $plan->price ?? '1500' }}
                                </div>

                                <p class="plan-sub">
                                    Start your journey and unlock earning potential
                                </p>

                                <div class="plan-divider"></div>

                                <!-- Features -->
                                <div class="plan-feature">
                                    <i class="fas fa-layer-group"></i>
                                    <div>
                                        <strong>Earn 10X in Total</strong>
                                        <small>On your total income</small>
                                    </div>
                                </div>

                                <div class="plan-feature">
                                    <i class="fas fa-chart-line"></i>
                                    <div>
                                        <strong>Earn 2X Per Day</strong>
                                        <small>On your daily income</small>
                                    </div>
                                </div>

                                <div class="plan-feature">
                                    <i class="fas fa-users"></i>
                                    <div>
                                        <strong>Higher Referral Income</strong>
                                        <small>Grow your network</small>
                                    </div>
                                </div>

                                <div class="plan-feature">
                                    <i class="fas fa-tags"></i>
                                    <div>
                                        <strong>Buy Any Product</strong>
                                        <small>At Direct Price (DP)</small>
                                    </div>
                                </div>

                                <!-- Bottom Box -->
                                <div class="plan-footer-box">
                                    <strong>🛡️ All Plans Same Power</strong>
                                    <div>10X Total | 2X Daily | DP Products</div>
                                </div>

                                <!-- Button -->
                                <a href="{{ route('contact') }}"
                                   class="btn plan-btn purchase-plan">
                                    Join Now <i class="fas fa-arrow-right ml-1"></i>
                                </a>

                            </div>
                        </div>
                        <!-- PLAN CARD END -->

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

    {{-- Scroll to top --}}
    <div id="scroll-to-top" class="scroll-to-top">
        <span class="icon fa fa-angle-up"></span>
    </div>

    {{-- Footer --}}
    <footer class="footer bg-light py-4" style="margin-top: 40px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="mb-0 text-muted small">
                        Copyright &copy; {{ date('Y') }} KemtexWellness. All Rights Reserved. |
                        <a href="{{ route('contact') }}" class="text-color">Support</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="{{ asset('frontend/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/plugins/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/script.js') }}"></script>

    <!-- Razorpay Checkout Script -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    {{-- Plan purchase flow for inactive/no-plan members (manual open only) --}}
    @if (request()->routeIs('member.dashboard') && !auth()->user()->has_plan)
    <script>
        $(document).ready(function() {
            $(document).on('click', '.purchase-plan', function(e) {
                e.preventDefault();

               var planAmount = {{ $plan->price ?? 1500 }};

                $.post('/member/create-order', {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    amount: planAmount
                }, function(orderData) {

                    var options = {
                        "key": "{{ config('services.razorpay.key') }}", // ✅ FIXED
                        "amount": orderData.amount,
                        "currency": "INR",
                        "order_id": orderData.order_id,

                        "handler": function(response) {
                            $.post('/member/verify-payment', {
                                _token: $('meta[name="csrf-token"]').attr(
                                    'content'),
                                razorpay_payment_id: response.razorpay_payment_id,
                                razorpay_order_id: response.razorpay_order_id,
                                razorpay_signature: response.razorpay_signature
                            }, function(res) {
                                if (res.success) {
                                    window.planPurchased = true;
                                    $('#planModal').modal('hide');
                                    window.location.reload();
                                } else {
                                    alert('Payment failed: ' + (res.message ||
                                        'Unknown error. Please contact support.'
                                    ));
                                }
                            });
                        }
                    };

                    var rzp = new Razorpay(options);
                    rzp.open();

                });
            });

        });
    </script>
    @endif

    @stack('scripts')

</body>

</html>