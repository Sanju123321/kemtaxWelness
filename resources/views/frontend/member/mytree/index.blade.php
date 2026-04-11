@extends('frontend.layouts.member')

@section('title', 'My Team - Genealogy Tree')

@push('styles')
    <style>
        /* ── Sidebar layout ─────────────────────────────── */
        .dash-layout {
            display: flex;
            align-items: flex-start;
            background: #f4f6f9;
            min-height: calc(100vh - 80px);
        }

        .dash-sidebar {
            width: 230px;
            flex-shrink: 0;
            background: white;
            min-height: calc(100vh - 80px);
            box-shadow: 2px 0 12px rgba(0, 0, 0, .06);
            position: sticky;
            top: 0;
            display: flex;
            flex-direction: column;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px 18px 16px;
            border-bottom: 1px solid #f0f0f0;
        }

        .sidebar-user .u-name {
            font-size: 13px;
            font-weight: 700;
            color: #333;
            line-height: 1.3;
        }

        .sidebar-user .u-role {
            font-size: 11px;
            font-weight: 600;
        }

        .sidebar-nav {
            padding: 10px 0;
            flex: 1;
        }

        .sidebar-nav .nav-label {
            padding: 10px 18px 4px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #aaa;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 18px;
            font-size: 14px;
            font-weight: 500;
            color: #555;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all .15s;
        }

        .sidebar-nav a:hover {
            background: #f4f9f6;
            color: #28a745;
            border-left-color: #28a745;
            text-decoration: none;
        }

        .sidebar-nav a.active {
            background: #eaf7ef;
            color: #28a745;
            font-weight: 700;
            border-left-color: #28a745;
        }

        .sidebar-nav a.disabled,
        .sidebar-nav a.disabled:hover {
            pointer-events: none;
            color: #bbb !important;
            background: #f8f9fa !important;
            border-left-color: #eee !important;
            opacity: .7;
        }

        .sidebar-nav a i.nav-icon {
            width: 18px;
            text-align: center;
            font-size: 14px;
        }

        .sidebar-footer {
            padding: 14px 18px;
            border-top: 1px solid #f0f0f0;
        }

        .dash-main {
            flex: 1;
            min-width: 0;
            padding: 24px 20px 60px;
        }

        @media (max-width:768px) {
            .dash-sidebar {
                display: none;
            }

            .dash-main {
                padding: 14px 12px 40px;
            }
        }

        /* Controls bar */
        .tree-controls .btn {
            font-size: 13px;
        }

        /* ── Vertical tree ────────────────────────────────── */
        .v-tree {
            font-size: 14px;
        }

        .v-node {
            position: relative;
        }

        .v-node-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 5px 8px 5px 0;
            border-radius: 8px;
            transition: background .15s;
        }

        .v-node-row:hover {
            background: #f4f9f6;
        }

        .v-children {
            margin-left: 20px;
            border-left: 2px solid #dee2e6;
            padding-left: 14px;
        }

        /* toggle button */
        .v-toggle {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #28a745;
            color: #fff;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            cursor: pointer;
            transition: background .2s;
            user-select: none;
        }

        .v-toggle.leaf {
            background: #dee2e6;
            color: #aaa;
            cursor: default;
            font-size: 5px;
        }

        .v-toggle:not(.leaf):hover {
            background: #155724;
        }

        /* avatars */
        .v-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #fff;
            flex-shrink: 0;
            border: 2px solid transparent;
            transition: transform .2s;
        }

        .v-node-row:hover .v-avatar {
            transform: scale(1.08);
        }

        .depth-0 .v-avatar {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            border-color: #28a745;
            width: 48px;
            height: 48px;
            font-size: 20px;
        }

        .depth-1 .v-avatar {
            background: linear-gradient(135deg, #3498db, #2980b9);
            border-color: #3498db;
        }

        .depth-2 .v-avatar {
            background: linear-gradient(135deg, #9b59b6, #8e44ad);
            border-color: #9b59b6;
        }

        .depth-3 .v-avatar {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            border-color: #e74c3c;
        }

        .depth-4 .v-avatar {
            background: linear-gradient(135deg, #1abc9c, #16a085);
            border-color: #1abc9c;
        }

        .depth-deep .v-avatar {
            background: linear-gradient(135deg, #7f8c8d, #95a5a6);
            border-color: #7f8c8d;
        }

        /* info */
        .v-info {
            flex: 1;
            min-width: 0;
        }

        .v-name {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .v-uid {
            font-size: 11px;
            color: #888;
        }

        .v-count {
            margin-left: auto;
            background: #eaf7ef;
            color: #28a745;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .v-status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        #tree-loading,
        #tree-error {
            display: none;
        }

        #tree-loading {
            text-align: center;
            padding: 60px 0;
            color: #28a745;
        }

        #tree-error {
            text-align: center;
            padding: 40px 0;
            color: #dc3545;
        }
    </style>
@endpush

@section('content')
    @php $isInactive = auth()->check() && auth()->user()->status == 'inactive'; @endphp
    <div class="dash-layout">

        {{-- Sidebar --}}
        <aside class="dash-sidebar">
            <div class="sidebar-user">
                <div
                    style="background:{{ $isInactive ? '#f8d7da' : '#e9f7ef' }};border:2px solid {{ $isInactive ? '#dc3545' : '#28a745' }};border-radius:50%;width:40px;height:40px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas fa-user {{ $isInactive ? 'text-danger' : 'text-success' }}" style="font-size:18px;"></i>
                </div>
                <div>
                    <div class="u-name">@auth{{ Auth::user()->name }}
                    @else
                    Member @endauth
                </div>
                <div class="u-role" style="color:{{ $isInactive ? '#dc3545' : '#28a745' }};">
                    <i class="fas fa-circle" style="font-size:7px;margin-right:3px;"></i>
                    @auth{{ ucfirst(Auth::user()->status) }}
                @else
                Inactive @endauth
            </div>
        </div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Main Menu</div>
        <a href="{{ route('member.dashboard') }}"><i class="fas fa-tachometer-alt nav-icon"></i> Dashboard</a>
        <a href="{{ route('member.wallet') }}" class="{{ $isInactive ? 'disabled' : '' }}"><i
                class="fas fa-wallet nav-icon"></i> Wallet</a>
        <a href="{{ route('member.credentials') }}" class="{{ $isInactive ? 'disabled' : '' }}"><i
                class="fas fa-award nav-icon"></i> Credentials</a>
        <div class="nav-label">More</div>
        <a href="{{ route('pricing') }}"><i class="fas fa-tags nav-icon"></i> Pricing</a>
        <a href="{{ route('contact') }}"><i class="fas fa-headset nav-icon"></i> Support</a>
        <div class="nav-label">My Team</div>
        <a href="{{ route('member.team') }}" class="active {{ $isInactive ? 'disabled' : '' }}"><i
                class="fas fa-sitemap nav-icon"></i> Genealogy Tree</a>
    </nav>
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                style="background:none;border:none;padding:0;width:100%;text-align:left;display:flex;align-items:center;gap:10px;font-size:14px;color:#dc3545;font-weight:600;cursor:pointer;">
                <i class="fas fa-sign-out-alt" style="width:18px;text-align:center;"></i> Logout
            </button>
        </form>
    </div>
</aside>

{{-- Main Content --}}
<div class="dash-main">

    {{-- Page header --}}
    <div
        style="background:linear-gradient(135deg,#28a745 0%,#1e7e34 100%);padding:20px 24px;color:white;margin-bottom:24px;border-radius:10px;display:flex;align-items:center;justify-content:space-between;">
        <div>
            <h5 class="mb-0 font-weight-bold"><i class="fas fa-sitemap mr-2"></i>My Genealogy Tree</h5>
            <small class="opacity-75">Your full downline network</small>
        </div>
        <a href="{{ route('member.dashboard') }}" class="btn btn-light btn-sm">
            <i class="fas fa-arrow-left mr-1"></i>Dashboard
        </a>
    </div>

    <div>

        {{-- Stats row --}}
        <div class="row mb-4" id="tree-stats" style="display:none!important;">
            <div class="col-6 col-md-3 mb-3">
                <div class="card border-0 shadow-sm text-center py-3">
                    <div class="h4 text-success mb-0 font-weight-bold" id="stat-direct">0</div>
                    <small class="text-muted">Direct Members</small>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card border-0 shadow-sm text-center py-3">
                    <div class="h4 text-primary mb-0 font-weight-bold" id="stat-total">0</div>
                    <small class="text-muted">Total Team</small>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card border-0 shadow-sm text-center py-3">
                    <div class="h4 text-warning mb-0 font-weight-bold" id="stat-levels">0</div>
                    <small class="text-muted">Levels Deep</small>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card border-0 shadow-sm text-center py-3">
                    <div class="h4 text-info mb-0 font-weight-bold" id="stat-active">0</div>
                    <small class="text-muted">Active Members</small>
                </div>
            </div>
        </div>

        {{-- Tree Card --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                <h6 class="mb-0 font-weight-bold text-dark"><i
                        class="fas fa-network-wired text-success mr-2"></i>Network Tree</h6>
                <div class="tree-controls d-flex gap-2">
                    <button class="btn btn-outline-success btn-sm mr-1" id="btn-expand-all">
                        <i class="fas fa-expand-arrows-alt mr-1"></i>Expand All
                    </button>
                    <button class="btn btn-outline-secondary btn-sm mr-1" id="btn-collapse-all">
                        <i class="fas fa-compress-arrows-alt mr-1"></i>Collapse All
                    </button>
                    <button class="btn btn-outline-primary btn-sm" id="btn-reload">
                        <i class="fas fa-sync-alt mr-1"></i>Refresh
                    </button>
                </div>
            </div>
            <div class="card-body p-3" style="min-height:320px;">

                {{-- Loading --}}
                <div id="tree-loading">
                    <div class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading your team network…</p>
                </div>

                {{-- Error --}}
                <div id="tree-error">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                    <p id="tree-error-msg">Failed to load tree. Please try again.</p>
                    <button class="btn btn-sm btn-outline-danger" id="btn-retry">Retry</button>
                </div>

                {{-- Tree container --}}
                <div id="tree-container" style="overflow-y:auto;">
                    <div class="v-tree" id="tree-root"></div>
                </div>
            </div>
        </div>

        {{-- Legend --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body py-2 px-4 d-flex flex-wrap" style="gap:12px;">
                <strong class="text-muted" style="font-size:13px;line-height:2;">LEGEND:</strong>
                <span style="font-size:12px;"><span
                        style="display:inline-block;width:14px;height:14px;border-radius:50%;background:linear-gradient(135deg,#f39c12,#e67e22);border:2px solid #28a745;vertical-align:middle;margin-right:4px;"></span>You</span>
                <span style="font-size:12px;"><span
                        style="display:inline-block;width:14px;height:14px;border-radius:50%;background:linear-gradient(135deg,#3498db,#2980b9);border:2px solid #3498db;vertical-align:middle;margin-right:4px;"></span>Level
                    1</span>
                <span style="font-size:12px;"><span
                        style="display:inline-block;width:14px;height:14px;border-radius:50%;background:linear-gradient(135deg,#9b59b6,#8e44ad);border:2px solid #9b59b6;vertical-align:middle;margin-right:4px;"></span>Level
                    2</span>
                <span style="font-size:12px;"><span
                        style="display:inline-block;width:14px;height:14px;border-radius:50%;background:linear-gradient(135deg,#e74c3c,#c0392b);border:2px solid #e74c3c;vertical-align:middle;margin-right:4px;"></span>Level
                    3</span>
                <span style="font-size:12px;"><span
                        style="display:inline-block;width:14px;height:14px;border-radius:50%;background:linear-gradient(135deg,#1abc9c,#16a085);border:2px solid #1abc9c;vertical-align:middle;margin-right:4px;"></span>Level
                    4</span>
                <span style="font-size:12px;"><span
                        style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#28a745;vertical-align:middle;margin-right:4px;"></span>Active</span>
                <span style="font-size:12px;"><span
                        style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#dc3545;vertical-align:middle;margin-right:4px;"></span>Inactive</span>
            </div>
        </div>

    </div>{{-- /.inner-wrapper --}}
</div>{{-- /.dash-main --}}
</div>{{-- /.dash-layout --}}
@endsection

@push('scripts')
<script>
    (function() {
        'use strict';

        const TREE_URL = "{{ route('member.team.tree') }}";
        let treeData = null;
        let totalCount = 0,
            directCount = 0,
            maxDepth = 0,
            activeCount = 0;

        /* ---- Fetch tree ---- */
        function loadTree() {
            showLoading();
            fetch(TREE_URL, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(r => {
                    if (!r.ok) throw new Error('Server error ' + r.status);
                    return r.json();
                })
                .then(data => {
                    treeData = data;
                    hideLoading();
                    resetCounters();
                    const root = document.getElementById('tree-root');
                    root.innerHTML = '';
                    root.appendChild(buildNode(data, 0));
                    updateStats();
                })
                .catch(err => showError(err.message));
        }

        function resetCounters() {
            totalCount = 0;
            directCount = 0;
            maxDepth = 0;
            activeCount = 0;
        }

        /* ---- Build vertical DOM node ---- */
        function buildNode(node, depth) {
            totalCount++;
            if (depth > maxDepth) maxDepth = depth;
            if (depth === 1) directCount++;
            if (node.status === 'active') activeCount++;

            const depthClass = depth <= 4 ? 'depth-' + depth : 'depth-deep';
            const hasChildren = node.children && node.children.length > 0;

            const wrapper = document.createElement('div');
            wrapper.className = 'v-node ' + depthClass;
            wrapper.dataset.id = node.id;

            // Row
            const row = document.createElement('div');
            row.className = 'v-node-row';

            // Toggle
            const toggle = document.createElement('div');
            toggle.className = 'v-toggle' + (hasChildren ? '' : ' leaf');
            toggle.innerHTML = hasChildren ? '<i class="fas fa-minus"></i>' : '<i class="fas fa-circle"></i>';

            // Avatar
            const avatar = document.createElement('div');
            avatar.className = 'v-avatar';
            avatar.innerHTML = '<i class="fas fa-user"></i>';

            // Info
            const info = document.createElement('div');
            info.className = 'v-info';
            const nameEl = document.createElement('div');
            nameEl.className = 'v-name';
            nameEl.title = node.name || 'Unknown';
            nameEl.textContent = node.name || 'Unknown';
            const uidEl = document.createElement('div');
            uidEl.className = 'v-uid';
            uidEl.textContent = node.user_id || ('#' + node.id);
            info.appendChild(nameEl);
            info.appendChild(uidEl);

            // Status dot
            const dot = document.createElement('span');
            dot.className = 'v-status-dot';
            dot.style.background = node.status === 'active' ? '#28a745' : '#dc3545';
            dot.title = node.status || 'unknown';

            row.appendChild(toggle);
            row.appendChild(avatar);
            row.appendChild(info);
            row.appendChild(dot);

            if (hasChildren) {
                const countBadge = document.createElement('span');
                countBadge.className = 'v-count';
                countBadge.textContent = node.children.length + (node.children.length === 1 ? ' member' :
                    ' members');
                row.appendChild(countBadge);
            }

            wrapper.appendChild(row);

            // Children
            if (hasChildren) {
                const childrenWrap = document.createElement('div');
                childrenWrap.className = 'v-children';
                node.children.forEach(function(child) {
                    childrenWrap.appendChild(buildNode(child, depth + 1));
                });
                wrapper.appendChild(childrenWrap);

                toggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const show = childrenWrap.style.display === 'none';
                    childrenWrap.style.display = show ? '' : 'none';
                    toggle.innerHTML = show ? '<i class="fas fa-minus"></i>' :
                    '<i class="fas fa-plus"></i>';
                });
            }

            return wrapper;
        }

        /* ---- Expand / Collapse All ---- */
        function setAllChildren(show) {
            document.querySelectorAll('#tree-root .v-children').forEach(function(c) {
                c.style.display = show ? '' : 'none';
            });
            document.querySelectorAll('#tree-root .v-toggle:not(.leaf)').forEach(function(b) {
                b.innerHTML = show ? '<i class="fas fa-minus"></i>' : '<i class="fas fa-plus"></i>';
            });
        }

        /* ---- Stats ---- */
        function updateStats() {
            document.getElementById('stat-direct').textContent = directCount;
            document.getElementById('stat-total').textContent = totalCount - 1;
            document.getElementById('stat-levels').textContent = maxDepth;
            document.getElementById('stat-active').textContent = activeCount;
            document.getElementById('tree-stats').style.setProperty('display', 'flex', 'important');
        }

        /* ---- UI helpers ---- */
        function showLoading() {
            document.getElementById('tree-loading').style.display = 'block';
            document.getElementById('tree-error').style.display = 'none';
            document.getElementById('tree-container').style.display = 'none';
        }

        function hideLoading() {
            document.getElementById('tree-loading').style.display = 'none';
            document.getElementById('tree-container').style.display = 'block';
        }

        function showError(msg) {
            document.getElementById('tree-loading').style.display = 'none';
            document.getElementById('tree-container').style.display = 'none';
            document.getElementById('tree-error').style.display = 'block';
            document.getElementById('tree-error-msg').textContent = msg || 'Could not load tree.';
        }

        /* ---- Event bindings ---- */
        document.getElementById('btn-expand-all').addEventListener('click', function() {
            setAllChildren(true);
        });
        document.getElementById('btn-collapse-all').addEventListener('click', function() {
            setAllChildren(false);
        });
        document.getElementById('btn-reload').addEventListener('click', loadTree);
        document.getElementById('btn-retry').addEventListener('click', loadTree);

        /* ---- Boot ---- */
        loadTree();
    })();
</script>
@endpush
