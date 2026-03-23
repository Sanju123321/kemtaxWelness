<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="@yield('meta_description', 'KemtexWellness Admin Panel')" />
    <meta name="author" content="KemtexWellness" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title', 'Dashboard') | KemtexWellness Admin</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />

    {{-- DataTables CSS --}}
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

    {{-- Backend Custom CSS --}}
    <link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />

    {{-- Page-specific styles --}}
    @stack('styles')
</head>

<body class="sb-nav-fixed">

    {{-- Top Navigation --}}
    @include('backend.layouts.partials.header')

    <div id="layoutSidenav">

        {{-- Sidebar --}}
        @include('backend.layouts.partials.sidebar')

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">

                    {{-- Page Heading --}}
                    <h1 class="mt-4">@yield('page_title', 'Dashboard')</h1>

                    {{-- Breadcrumb --}}
                    @hasSection('breadcrumb')
                        <ol class="breadcrumb mb-4">
                            @yield('breadcrumb')
                        </ol>
                    @endif

                    {{-- Flash Messages --}}
                    @include('backend.layouts.partials.alerts')

                    {{-- Main Content --}}
                    @yield('content')

                </div>
            </main>

            {{-- Footer --}}
            @include('backend.layouts.partials.footer')
        </div>
    </div>

    {{-- Bootstrap Bundle JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- DataTables JS --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    {{-- Backend Custom Scripts --}}
    <script src="{{ asset('backend/js/scripts.js') }}"></script>

    {{-- Page-specific scripts --}}
    @stack('scripts')

</body>

</html>
