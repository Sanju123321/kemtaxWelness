<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <div class="sb-sidenav-menu-heading">Core</div>

                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="bi bi-speedometer2"></i></div>
                    Dashboard
                </a>

                <div class="sb-sidenav-menu-heading">Management</div>

                {{-- Users --}}
                <a class="nav-link collapsed {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                    href="#collapseUsers" data-bs-toggle="collapse" data-bs-target="#collapseUsers"
                    aria-expanded="{{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}"
                    aria-controls="collapseUsers">
                    <div class="sb-nav-link-icon"><i class="bi bi-people"></i></div>
                    Users
                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-down"></i></div>
                </a>
                <div class="collapse {{ request()->routeIs('admin.users.*') ? 'show' : '' }}" id="collapseUsers"
                    aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}"
                            href="{{ route('admin.users.index') }}">
                            <i class="bi bi-dot me-1"></i>All Users
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.users.create') ? 'active' : '' }}"
                            href="{{ route('admin.users.create') }}">
                            <i class="bi bi-dot me-1"></i>Add User
                        </a>
                    </nav>
                </div>

                {{-- Products --}}
                <a class="nav-link collapsed {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                    href="#collapseProducts" data-bs-toggle="collapse" data-bs-target="#collapseProducts"
                    aria-expanded="{{ request()->routeIs('admin.products.*') ? 'true' : 'false' }}"
                    aria-controls="collapseProducts">
                    <div class="sb-nav-link-icon"><i class="bi bi-box-seam"></i></div>
                    Products
                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-down"></i></div>
                </a>
                <div class="collapse {{ request()->routeIs('admin.products.*') ? 'show' : '' }}" id="collapseProducts"
                    aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->routeIs('admin.products.index') ? 'active' : '' }}"
                            href="{{ route('admin.products.index') }}">
                            <i class="bi bi-dot me-1"></i>All Products
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.products.create') ? 'active' : '' }}"
                            href="{{ route('admin.products.create') }}">
                            <i class="bi bi-dot me-1"></i>Add Product
                        </a>
                    </nav>
                </div>

                {{-- Orders --}}
                <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="#">
                    <div class="sb-nav-link-icon"><i class="bi bi-cart3"></i></div>
                    Orders
                </a>

                <div class="sb-sidenav-menu-heading">System</div>

                {{-- Reports --}}
                <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="#">
                    <div class="sb-nav-link-icon"><i class="bi bi-bar-chart-line"></i></div>
                    Reports
                </a>

                {{-- Settings --}}
                <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="#">
                    <div class="sb-nav-link-icon"><i class="bi bi-gear"></i></div>
                    Settings
                </a>

            </div>
        </div>

        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ Auth::check() ? Auth::user()->name : 'Admin' }}
        </div>
    </nav>
</div>
