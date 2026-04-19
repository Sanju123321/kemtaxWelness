@extends('backend.layouts.app')

@section('title', 'Users')

@section('content')
    <h1 class="mt-4">Users</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Users</li>
    </ol>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div><i class="fas fa-users me-1"></i> All Users</div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.users.export') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-file-csv me-1"></i> Export CSV
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatablesSimple" class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->status === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Blocked</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="text-nowrap">
                                    {{-- Toggle Status --}}
                                    <form method="POST" action="{{ route('admin.users.toggle.status', $user->id) }}"
                                        class="d-inline">
                                        @csrf
                                        @if ($user->status === 'active')
                                            <button type="submit" class="btn btn-sm btn-secondary" title="Block User">
                                                <i class="fas fa-ban"></i> Block
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-sm btn-success" title="Unblock User">
                                                <i class="fas fa-check-circle"></i> Unblock
                                            </button>
                                        @endif
                                    </form>
                                    {{-- View Income --}}
                                    <a href="{{ route('admin.users.income', $user->id) }}"
                                        class="btn btn-sm btn-info text-white" title="View Income">
                                        <i class="fas fa-coins"></i> Income
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}"
                                        class="d-inline" onsubmit="return confirm('Delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script>
        if (document.getElementById('datatablesSimple')) {
            new simpleDatatables.DataTable(document.getElementById('datatablesSimple'));
        }
    </script>
@endpush
