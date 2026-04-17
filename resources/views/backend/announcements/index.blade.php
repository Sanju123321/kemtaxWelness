@extends('backend.layouts.app')

@section('title', 'Announcements')

@section('content')
    <h1 class="mt-4">
        Announcements</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Announcements</li>
    </ol>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button"
                class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="row g-4">
        {{-- Create Form --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white"><i class="fas fa-bullhorn me-1"></i> New Announcement</div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger py-2">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('admin.announcements.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message <span class="text-danger">*</span></label>
                            <textarea name="body" class="form-control" rows="4" required>{{ old('body') }}</textarea>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label">Type</label>
                                <select name="type" class="form-select form-select-sm">
                                    @foreach (['info', 'success', 'warning', 'danger'] as $t)
                                        <option value="{{ $t }}" @selected(old('type', 'info') == $t)>{{ ucfirst($t) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Target</label>
                                <select name="target" class="form-select form-select-sm">
                                    @foreach (['all' => 'All Members', 'active' => 'Active', 'inactive' => 'Inactive', 'with_plan' => 'With Plan', 'without_plan' => 'No Plan'] as $v => $l)
                                        <option value="{{ $v }}" @selected(old('target', 'all') == $v)>{{ $l }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Expires At</label>
                            <input type="datetime-local" name="expires_at" class="form-control form-control-sm"
                                value="{{ old('expires_at') }}">
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive"
                                @checked(old('is_active', true))>
                            <label class="form-check-label" for="isActive">Active immediately</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i
                                class="fas fa-paper-plane me-1"></i>Publish</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- List --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header"><i class="fas fa-list me-1"></i> All Announcements ({{ $announcements->total() }})
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Target</th>
                                    <th>Status</th>
                                    <th>Expires</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($announcements as $ann)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $ann->title }}</div>
                                            <small class="text-muted">{{ Str::limit($ann->body, 60) }}</small>
                                        </td>
                                        <td>
                                            @php $typeColors = ['info'=>'info','success'=>'success','warning'=>'warning','danger'=>'danger']; @endphp
                                            <span
                                                class="badge bg-{{ $typeColors[$ann->type] ?? 'secondary' }} text-dark">{{ ucfirst($ann->type) }}</span>
                                        </td>
                                        <td><span
                                                class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $ann->target)) }}</span>
                                        </td>
                                        <td>
                                            <form method="POST"
                                                action="{{ route('admin.announcements.toggle', $ann->id) }}">
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-xs {{ $ann->is_active ? 'btn-success' : 'btn-outline-secondary' }}">
                                                    {{ $ann->is_active ? 'Active' : 'Inactive' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td><small>{{ $ann->expires_at ? $ann->expires_at->format('d M Y') : '—' }}</small>
                                        </td>
                                        <td>
                                            <button class="btn btn-xs btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editAnn{{ $ann->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form method="POST"
                                                action="{{ route('admin.announcements.destroy', $ann->id) }}"
                                                class="d-inline" onsubmit="return confirm('Delete this announcement?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-xs btn-danger"><i
                                                        class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- Edit Modal --}}
                                    <div class="modal fade" id="editAnn{{ $ann->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <form method="POST"
                                                    action="{{ route('admin.announcements.update', $ann->id) }}">
                                                    @csrf @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Announcement</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Title</label>
                                                            <input type="text" name="title" class="form-control"
                                                                value="{{ $ann->title }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Message</label>
                                                            <textarea name="body" class="form-control" rows="3" required>{{ $ann->body }}</textarea>
                                                        </div>
                                                        <div class="row g-2">
                                                            <div class="col-md-4">
                                                                <label class="form-label">Type</label>
                                                                <select name="type" class="form-select form-select-sm">
                                                                    @foreach (['info', 'success', 'warning', 'danger'] as $t)
                                                                        <option value="{{ $t }}"
                                                                            @selected($ann->type == $t)>
                                                                            {{ ucfirst($t) }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label">Target</label>
                                                                <select name="target" class="form-select form-select-sm">
                                                                    @foreach (['all' => 'All Members', 'active' => 'Active', 'inactive' => 'Inactive', 'with_plan' => 'With Plan', 'without_plan' => 'No Plan'] as $v => $l)
                                                                        <option value="{{ $v }}"
                                                                            @selected($ann->target == $v)>
                                                                            {{ $l }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label">Expires At</label>
                                                                <input type="datetime-local" name="expires_at"
                                                                    class="form-control form-control-sm"
                                                                    value="{{ $ann->expires_at ? $ann->expires_at->format('Y-m-d\TH:i') : '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-check form-switch mt-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="is_active" value="1"
                                                                @checked($ann->is_active)>
                                                            <label class="form-check-label">Active</label>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Save
                                                            Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">No announcements yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($announcements->hasPages())
                    <div class="card-footer">
                        <div class="pagination-wrapper">
                            <span
                                class="text-muted small">{{ $announcements->firstItem() }}–{{ $announcements->lastItem() }}
                                of {{ $announcements->total() }}</span>
                            {{ $announcements->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
