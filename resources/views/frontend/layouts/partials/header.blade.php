<header class="navigation">
    <div class="header-top">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-2 col-md-4">
                    <div class="header-top-socials text-center text-lg-left text-md-left">
                        <a href="https://www.facebook.com/" aria-label="facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/" aria-label="twitter"><i class="fab fa-twitter"></i></a>
                        <a href="https://github.com/" aria-label="github"><i class="fab fa-github"></i></a>
                    </div>
                </div>
                <div class="col-lg-10 col-md-8 text-center text-lg-right text-md-right">
                    <div class="header-top-info mb-2 mb-md-0">
                        <a href="tel:+91-456-6588">Call Us : <span>+91-456-6588</span></a>
                        <a href="mailto:kemtexwellness@gmail.com"><i
                                class="fas fa-envelope mr-2"></i><span>kemtexwellness@gmail.com</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .cart-icon-wrap {
            position: relative;
            display: inline-flex;
            align-items: center;
            margin-right: 6px;
        }

        .cart-icon-wrap a {
            color: #333;
            font-size: 20px;
            text-decoration: none;
            padding: 4px 8px;
        }

        .cart-icon-wrap a:hover {
            color: #28a745;
        }

        .cart-badge {
            position: absolute;
            top: -4px;
            right: -2px;
            background: #28a745;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            min-width: 18px;
            height: 18px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
            line-height: 1;
            border: 2px solid #fff;
        }

        .wishlist-icon-wrap {
            position: relative;
            display: inline-flex;
            align-items: center;
            margin-right: 6px;
        }

        .wishlist-icon-wrap a {
            color: #333;
            font-size: 20px;
            text-decoration: none;
            padding: 4px 8px;
        }

        .wishlist-icon-wrap a:hover {
            color: #e53935;
        }

        .user-dropdown .dropdown-toggle::after {
            display: none;
        }

        .user-dropdown .btn-user {
            background: #28a745;
            color: #fff;
            border: none;
            padding: 7px 16px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .user-dropdown .dropdown-menu {
            min-width: 160px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .12);
            border: none;
            right: 0;
            left: auto;
        }

        .user-dropdown .dropdown-item {
            font-size: 13px;
            padding: 8px 16px;
        }

        .user-dropdown .dropdown-item:hover {
            background: #eaf7ef;
            color: #28a745;
        }
    </style>

    <div id="navbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg px-0 py-4">
                        <a class="navbar-brand" href="{{ route('home') }}">
                            Kemtex<span>Wellness.</span>
                        </a>

                        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                            data-target="#navbarsExample09" aria-controls="navbarsExample09" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="fa fa-bars"></span>
                        </button>

                        <div class="collapse navbar-collapse text-center" id="navbarsExample09">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                                </li>
                                <li
                                    class="nav-item dropdown {{ request()->routeIs('about') || request()->routeIs('pricing') ? 'active' : '' }}">
                                    <a class="nav-link dropdown-toggle" href="#" id="dropdown03"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        About <i class="fas fa-chevron-down small"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdown03">
                                        <li><a class="dropdown-item {{ request()->routeIs('about') ? 'active' : '' }}"
                                                href="{{ route('about') }}">Our Company</a></li>
                                        <li><a class="dropdown-item {{ request()->routeIs('pricing') ? 'active' : '' }}"
                                                href="{{ route('pricing') }}">Pricing</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item {{ request()->routeIs('services') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('services') }}">Services</a>
                                </li>
                                <li
                                    class="nav-item {{ request()->routeIs('products') || request()->routeIs('products.show') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('products') }}">Products</a>
                                </li>
                                <li class="nav-item {{ request()->routeIs('contact') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                                </li>
                            </ul>

                            {{-- ── Auth-aware right section ── --}}
                            <div class="my-2 my-md-0 ml-lg-4 d-flex align-items-center justify-content-center"
                                style="gap:4px;">

                                @if (auth()->check())
                                    {{-- Cart icon with live count --}}
                                    <div class="cart-icon-wrap">
                                        <a href="{{ route('member.dashboard') }}#cart" title="My Bag"
                                            id="header-cart-link">
                                            <i class="fas fa-shopping-bag"></i>
                                        </a>
                                        <span class="cart-badge" id="cart-count"
                                            style="{{ ($cartCount ?? 0) > 0 ? '' : 'display:none;' }}">
                                            {{ $cartCount ?? 0 }}
                                        </span>
                                    </div>

                                    {{-- Wishlist icon --}}
                                    <div class="wishlist-icon-wrap">
                                        <a href="{{ route('member.dashboard') }}#wishlist" title="My Wishlist">
                                            <i class="fas fa-heart" style="color: #e53935;"></i>
                                        </a>
                                    </div>

                                    {{-- User dropdown --}}
                                    <div class="dropdown user-dropdown">
                                        <button class="btn-user dropdown-toggle" type="button" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-user mr-1"></i>
                                            {{ Str::words(auth()->user()->name, 1, '') }}
                                            <i class="fas fa-chevron-down ml-1 small"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ route('member.dashboard') }}">
                                                <i class="fas fa-tachometer-alt mr-2 text-color"></i>Dashboard
                                            </a>
                                            <a class="dropdown-item" href="{{ route('products') }}">
                                                <i class="fas fa-shopping-bag mr-2 text-color"></i>Shop
                                            </a>
                                            <a class="dropdown-item" href="{{ route('member.dashboard') }}#wishlist">
                                                <i class="fas fa-heart mr-2" style="color:#e53935;"></i>Wishlist
                                            </a>
                                            <a class="dropdown-item" href="{{ route('member.profile') }}">
                                                <i class="fas fa-user-cog mr-2 text-color"></i>Profile
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    {{-- Guest buttons --}}
                                    <a href="{{ route('register') }}" class="btn btn-main btn-round-full mr-2">Join
                                        Now</a>
                                    <a href="{{ route('contact') }}"
                                        class="btn btn-solid-border btn-round-full">Contact</a>
                                @endif

                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
