<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'KemtexWellness')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="KemtexWellness – Authentic Ayurvedic Products for Vaat, Pitta & Kapha Balance. 100% Natural, FSSAI Certified.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="theme-name" content="megakit" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/plugins/bootstrap/bootstrap.min.css') }}">
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/plugins/themify/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/magnific-popup/magnific-popup.css') }}">
    <!-- Slick Slider CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/plugins/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/slick/slick-theme.css') }}">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('frontend/images/favicon.png') }}" type="image/x-icon">
    @livewireStyles
    @stack('styles')
</head>

<body>

    @include('frontend.layouts.partials.header')
    @include('layouts.partials.toast')

    @yield('content')

    @include('frontend.layouts.partials.footer')

    <!-- Scroll to top -->
    <div id="scroll-to-top" class="scroll-to-top">
        <span class="icon fa fa-angle-up"></span>
    </div>

    <!-- Main jQuery -->
    <script src="{{ asset('frontend/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('frontend/plugins/bootstrap/bootstrap.min.js') }}"></script>
    <!-- Magnific Popup -->
    <script src="{{ asset('frontend/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <!-- Slick Slider -->
    <script src="{{ asset('frontend/plugins/slick/slick.min.js') }}"></script>
    <!-- Counterup -->
    <script src="{{ asset('frontend/plugins/counterup/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('frontend/plugins/counterup/jquery.counterup.min.js') }}"></script>

    @yield('scripts')

    <script src="{{ asset('frontend/js/script.js') }}"></script>
    @livewireScripts
</body>

</html>
