<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <div class="sb-sidenav-menu-heading">Management</div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUsers"
                    aria-expanded="false" aria-controls="collapseUsers">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Users
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->routeIs('admin.users*') ? 'show' : '' }}" id="collapseUsers"
                    aria-labelledby="headingUsers" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}"
                            href="{{ route('admin.users.index') }}">All Users</a>
                        <a class="nav-link {{ request()->routeIs('admin.users.create') ? 'active' : '' }}"
                            href="{{ route('admin.users.create') }}">Add User</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#collapseProducts" aria-expanded="false" aria-controls="collapseProducts">
                    <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                    Products
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->routeIs('admin.products*') ? 'show' : '' }}" id="collapseProducts"
                    aria-labelledby="headingProducts" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->routeIs('admin.products.index') ? 'active' : '' }}"
                            href="{{ route('admin.products.index') }}">All Products</a>
                        <a class="nav-link {{ request()->routeIs('admin.products.create') ? 'active' : '' }}"
                            href="{{ route('admin.products.create') }}">Add Product</a>
                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading">Reports</div>
                <a class="nav-link {{ request()->routeIs('admin.charts') ? 'active' : '' }}"
                    href="{{ route('admin.charts') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Charts
                </a>
                <a class="nav-link {{ request()->routeIs('admin.tables') ? 'active' : '' }}"
                    href="{{ route('admin.tables') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Tables
                </a>

                <div class="sb-sidenav-menu-heading">Frontend</div>
                <a class="nav-link" href="{{ route('home') }}" target="_blank">
                    <div class="sb-nav-link-icon"><i class="fas fa-globe"></i></div>
                    View Website
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            @auth {{ Auth::user()->name }} @endauth
        </div>
    </nav>
</div>
