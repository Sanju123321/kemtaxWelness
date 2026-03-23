<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">

            {{-- Brand --}}
            <a class="navbar-brand fw-bold fs-4 text-success" href="{{ route('home') }}">
                <img src="{{ asset('frontend/images/logo.png') }}" alt="KemtexWellness" height="40"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';" />
                <span style="display:none;">Kemtex<span class="text-primary">Wellness</span></span>
            </a>

            {{-- Mobile Toggle --}}
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Nav Links --}}
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1">

                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('home') ? 'active text-primary' : '' }}"
                            href="{{ route('home') }}">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('about') ? 'active text-primary' : '' }}"
                            href="{{ route('about') }}">About Us</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold {{ request()->routeIs('products*') ? 'active text-primary' : '' }}"
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Products
                        </a>
                        <ul class="dropdown-menu shadow border-0">
                            <li><a class="dropdown-item" href="{{ route('products') }}">All Products</a></li>
                            <li><a class="dropdown-item" href="#">Supplements</a></li>
                            <li><a class="dropdown-item" href="#">Herbal Teas</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li><a class="dropdown-item text-primary" href="#">New Arrivals</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('services') ? 'active text-primary' : '' }}"
                            href="{{ route('services') }}">Services</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('blog*') ? 'active text-primary' : '' }}"
                            href="{{ route('blog') }}">Blog</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('contact') ? 'active text-primary' : '' }}"
                            href="{{ route('contact') }}">Contact</a>
                    </li>

                </ul>

                {{-- Right Side Buttons --}}
                <div class="d-flex align-items-center gap-2">
                    <a href="#" class="btn btn-sm btn-outline-secondary position-relative">
                        <i class="bi bi-bag"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            style="font-size:0.55rem;">2</span>
                    </a>
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-sm btn-success">
                            <i class="bi bi-person-plus me-1"></i>Register
                        </a>
                    @endauth
                </div>
            </div>

        </div>
    </nav>
</header>
