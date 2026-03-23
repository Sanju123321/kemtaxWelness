<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">

    {{-- Brand Logo --}}
    <a class="navbar-brand ps-3" href="{{ route('admin.dashboard') }}">
        <img src="{{ asset('backend/images/logo.png') }}" alt="KemtexWellness" height="30"
            onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';" />
        <span style="display:none;">KemtexWellness</span>
    </a>

    {{-- Sidebar Toggle Button --}}
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#">
        <i class="bi bi-list fs-4 text-white"></i>
    </button>

    {{-- Search Form --}}
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search..." aria-label="Search"
                aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </form>

    {{-- Navbar Right --}}
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">

        {{-- Notifications --}}
        <li class="nav-item dropdown me-2">
            <a class="nav-link position-relative" id="navbarDropdownNotif" href="#" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-bell fs-5 text-white"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                    style="font-size:0.55rem;">3</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdownNotif"
                style="min-width:280px;">
                <li>
                    <h6 class="dropdown-header">Notifications</h6>
                </li>
                <li><a class="dropdown-item small" href="#">New order received</a></li>
                <li><a class="dropdown-item small" href="#">User registration pending</a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item text-center small text-primary" href="#">View all</a></li>
            </ul>
        </li>

        {{-- User Dropdown --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" id="navbarDropdownUserImage"
                href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('backend/images/avatar.png') }}" alt="Avatar" width="32" height="32"
                    class="rounded-circle"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';" />
                <i class="bi bi-person-circle fs-5 text-white" style="display:none;"></i>
                <span class="d-none d-lg-inline text-white">
                    {{ Auth::check() ? Auth::user()->name : 'Admin' }}
                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdownUserImage">
                <li>
                    <h6 class="dropdown-header">
                        {{ Auth::check() ? Auth::user()->email : 'admin@kemtex.com' }}
                    </h6>
                </li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li>
                    <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>

    </ul>
</nav>
