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
                                <ul class="navbar-nav ml-auto">
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
                                                class="fas fa-award mr-1"></i>Credentials</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('pricing') }}"><i
                                                class="fas fa-tags mr-1"></i>Pricing</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('contact') }}"><i
                                                class="fas fa-headset mr-1"></i>Support</a>
                                    </li>
                                </ul>

                                <div class="my-2 my-md-0 ml-lg-3 d-flex align-items-center justify-content-center"
                                    style="gap:2px;">

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
                                    <div class="dropdown ml-2">
                                        <button type="button"
                                            class="btn btn-main btn-round-full btn-sm dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                            style="min-width:130px;">
                                            <i class="fas fa-user mr-1"></i>
                                            {{ Str::words(auth()->user()->name ?? 'Member', 1, '') }}
                                            <i class="fas fa-chevron-down ml-1 small"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right"
                                            style="min-width:170px;border-radius:8px;box-shadow:0 4px 20px rgba(0,0,0,.12);border:none;">
                                            <a class="dropdown-item" href="{{ route('member.profile') }}"
                                                style="font-size:13px;">
                                                <i class="fas fa-user-cog mr-2 text-color"></i>Profile
                                            </a>
                                            <a class="dropdown-item" href="{{ route('products') }}"
                                                style="font-size:13px;">
                                                <i class="fas fa-shopping-bag mr-2 text-color"></i>Shop Products
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger"
                                                    style="font-size:13px;">
                                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                                </button>
                                            </form>
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

    @stack('scripts')

</body>

</html>
