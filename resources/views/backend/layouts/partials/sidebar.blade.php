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

                {{-- Users --}}
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUsers"
                    aria-expanded="{{ request()->routeIs('admin.users*') ? 'true' : 'false' }}"
                    aria-controls="collapseUsers">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Users
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->routeIs('admin.users*') ? 'show' : '' }}" id="collapseUsers"
                    aria-labelledby="headingUsers" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}"
                            href="{{ route('admin.users.index') }}">All Users</a>
                    </nav>
                </div>

                {{-- Products --}}
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#collapseProducts"
                    aria-expanded="{{ request()->routeIs('admin.products*') ? 'true' : 'false' }}"
                    aria-controls="collapseProducts">
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

                {{-- Plans --}}
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePlans"
                    aria-expanded="{{ request()->routeIs('admin.plans*') ? 'true' : 'false' }}"
                    aria-controls="collapsePlans">
                    <div class="sb-nav-link-icon"><i class="fas fa-layer-group"></i></div>
                    MLM Plans
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->routeIs('admin.plans*') ? 'show' : '' }}" id="collapsePlans"
                    aria-labelledby="headingPlans" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->routeIs('admin.plans.index') ? 'active' : '' }}"
                            href="{{ route('admin.plans.index') }}">All Plans</a>
                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading">Finance</div>

                {{-- Payments --}}
                <a class="nav-link {{ request()->routeIs('admin.payments*') ? 'active' : '' }}"
                    href="{{ route('admin.payments.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-receipt"></i></div>
                    Payments
                </a>

                {{-- Royalty --}}
                <a class="nav-link {{ request()->routeIs('admin.royalty*') ? 'active' : '' }}"
                    href="{{ route('admin.royalty.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-percent"></i></div>
                    Royalty
                </a>

                {{-- Commissions --}}
                <a class="nav-link {{ request()->routeIs('admin.incomes*') ? 'active' : '' }}"
                    href="{{ route('admin.incomes.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-coins"></i></div>
                    Commissions
                </a>

                {{-- Admin Earnings --}}
                <a class="nav-link {{ request()->routeIs('admin.admin.earnings*') ? 'active' : '' }}"
                    href="{{ route('admin.admin.earnings.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-crown"></i></div>
                    Admin Earnings
                </a>

                {{-- Withdrawals --}}
                <a class="nav-link {{ request()->routeIs('admin.withdrawals*') ? 'active' : '' }}"
                    href="{{ route('admin.withdrawals.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-wallet"></i></div>
                    Withdrawals
                    @php $pendingWithdrawals = \App\Models\WithdrawalRequest::where('status','pending')->count(); @endphp
                    @if ($pendingWithdrawals > 0)
                        <span class="badge bg-warning text-dark ms-auto">{{ $pendingWithdrawals }}</span>
                    @endif
                </a>

                <div class="sb-sidenav-menu-heading">Content</div>

                {{-- Blog Posts --}}
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePosts"
                    aria-expanded="{{ request()->routeIs('admin.posts*') ? 'true' : 'false' }}"
                    aria-controls="collapsePosts">
                    <div class="sb-nav-link-icon"><i class="fas fa-blog"></i></div>
                    Blog Posts
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->routeIs('admin.posts*') ? 'show' : '' }}" id="collapsePosts"
                    aria-labelledby="headingPosts" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->routeIs('admin.posts.index') ? 'active' : '' }}"
                            href="{{ route('admin.posts.index') }}">All Posts</a>
                        <a class="nav-link {{ request()->routeIs('admin.posts.create') ? 'active' : '' }}"
                            href="{{ route('admin.posts.create') }}">New Post</a>
                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading">Compliance</div>

                {{-- KYC --}}
                <a class="nav-link {{ request()->routeIs('admin.kyc*') ? 'active' : '' }}"
                    href="{{ route('admin.kyc.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-id-card"></i></div>
                    KYC Verification
                    @php $pendingKyc = \App\Models\KycDocument::where('status','pending')->count(); @endphp
                    @if ($pendingKyc > 0)
                        <span class="badge bg-danger ms-auto">{{ $pendingKyc }}</span>
                    @endif
                </a>

                <div class="sb-sidenav-menu-heading">Support</div>

                {{-- Contact Messages --}}
                <a class="nav-link {{ request()->routeIs('admin.contact*') ? 'active' : '' }}"
                    href="{{ route('admin.contact.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-envelope"></i></div>
                    Contact Messages
                    @php $unreadMsgs = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
                    @if ($unreadMsgs > 0)
                        <span class="badge bg-danger ms-auto">{{ $unreadMsgs }}</span>
                    @endif
                </a>

                {{-- Announcements --}}
                <a class="nav-link {{ request()->routeIs('admin.announcements*') ? 'active' : '' }}"
                    href="{{ route('admin.announcements.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-bullhorn"></i></div>
                    Announcements
                </a>

                <a class="nav-link {{ request()->routeIs('admin.about*') ? 'active' : '' }}"
                    href="{{ route('admin.about.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-address-card"></i></div>
                    About Us Content
                </a>

                <div class="sb-sidenav-menu-heading">Reports</div>

                <a class="nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}"
                    href="{{ route('admin.reports.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-pie"></i></div>
                    Advanced Reports
                </a>

                <a class="nav-link {{ request()->routeIs('admin.charts') ? 'active' : '' }}"
                    href="{{ route('admin.charts') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Charts
                </a>

                <div class="sb-sidenav-menu-heading">System</div>

                <a class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}"
                    href="{{ route('admin.settings.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-cog"></i></div>
                    Settings
                </a>

                <a class="nav-link {{ request()->routeIs('admin.activity-log*') ? 'active' : '' }}"
                    href="{{ route('admin.activity-log.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                    Activity Log
                </a>

                <div class="sb-sidenav-menu-heading">Website</div>
                <a class="nav-link" href="{{ route('home') }}" target="_blank">
                    <div class="sb-nav-link-icon"><i class="fas fa-globe"></i></div>
                    View Website
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            @auth('admin')
                {{ auth('admin')->user()->name }}
            @endauth
        </div>
    </nav>
</div>
