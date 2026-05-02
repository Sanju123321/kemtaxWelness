<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="KemtexWellness Admin Panel" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Admin') - KemtexWellness</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    @stack('styles')
</head>

<body class="sb-nav-fixed">

    @include('backend.layouts.partials.topnav')
    @include('layouts.partials.toast')

    <div id="layoutSidenav">
        @include('backend.layouts.partials.sidebar')

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 py-3">
                    @yield('content')
                </div>
            </main>
            @include('backend.layouts.partials.footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('backend/js/scripts.js') }}"></script>
    @stack('scripts')
</body>

</html>
