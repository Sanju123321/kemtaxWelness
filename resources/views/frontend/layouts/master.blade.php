<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="@yield('meta_description', 'KemtexWellness - Natural Health & Wellness Products')" />
    <meta name="keywords" content="@yield('meta_keywords', 'wellness, health, supplements, herbal, natural')" />
    <meta name="author" content="KemtexWellness" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('title', 'KemtexWellness')" />
    <meta property="og:description" content="@yield('meta_description', 'Natural Health & Wellness Products')" />
    <meta property="og:type" content="website" />

    <title>@yield('title', 'Welcome') | KemtexWellness</title>

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap"
        rel="stylesheet" />

    {{-- Frontend Custom CSS --}}
    <link href="{{ asset('frontend/css/styles.css') }}" rel="stylesheet" />

    {{-- Page-specific styles --}}
    @stack('styles')
</head>

<body>

    {{-- Topbar --}}
    <div class="bg-dark text-white py-1 d-none d-md-block">
        <div class="container d-flex justify-content-between align-items-center small">
            <div>
                <i class="bi bi-telephone me-1"></i> +1 800 KEMTEX &nbsp;&nbsp;
                <i class="bi bi-envelope me-1"></i> info@kemtexwellness.com
            </div>
            <div>
                <a href="#" class="text-white me-2"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-white me-2"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-white me-2"><i class="bi bi-twitter-x"></i></a>
                <a href="#" class="text-white"><i class="bi bi-linkedin"></i></a>
            </div>
        </div>
    </div>

    {{-- Main Navigation --}}
    @include('frontend.layouts.partials.header')

    {{-- Page Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('frontend.layouts.partials.footer')

    {{-- Back to Top --}}
    <button id="backToTop" class="btn btn-primary btn-sm rounded-circle shadow"
        style="position:fixed; bottom:2rem; right:2rem; display:none; width:42px; height:42px; z-index:9999;">
        <i class="bi bi-arrow-up"></i>
    </button>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- Frontend Custom Scripts --}}
    <script src="{{ asset('frontend/js/scripts.js') }}" defer></script>

    <script>
        // Back to top button
        const btn = document.getElementById('backToTop');
        window.onscroll = () => {
            btn.style.display = window.scrollY > 300 ? 'block' : 'none';
        };
        btn.addEventListener('click', () => window.scrollTo({
            top: 0,
            behavior: 'smooth'
        }));
    </script>

    {{-- Page-specific scripts --}}
    @stack('scripts')

</body>

</html>
