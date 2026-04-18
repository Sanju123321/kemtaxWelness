@extends('backend.layouts.app')

@section('title', 'Blog Posts')

@section('content')
    <h1 class="mt-4">Blog Posts</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Posts</li>
    </ol>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button"
                class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-primary">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Total Posts</div>
                        <div class="fs-3 fw-bold text-primary">{{ $stats['total'] }}</div>
                    </div>
                    <i class="fas fa-newspaper fa-2x text-primary opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Published</div>
                        <div class="fs-3 fw-bold text-success">{{ $stats['published'] }}</div>
                    </div>
                    <i class="fas fa-check-circle fa-2x text-success opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-secondary">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Drafts</div>
                        <div class="fs-3 fw-bold text-secondary">{{ $stats['draft'] }}</div>
                    </div>
                    <i class="fas fa-pencil-alt fa-2x text-secondary opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div><i class="fas fa-blog me-1"></i> All Posts</div>
            <div class="d-flex gap-2 align-items-center flex-wrap">
                <form method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Search title…"
                        value="{{ request('search') }}">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="published" @selected(request('status') === 'published')>Published</option>
                        <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                    @if (request('search') || request('status'))
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-secondary">Clear</a>
                    @endif
                </form>
                <a href="{{ route('admin.posts.create') }}" class="btn btn-sm btn-success"><i
                        class="fas fa-plus me-1"></i>New Post</a>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Published</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $post->title }}</div>
                                    @if ($post->excerpt)
                                        <small class="text-muted d-inline-block text-truncate"
                                            style="max-width:240px;">{{ $post->excerpt }}</small>
                                    @endif
                                </td>
                                <td><span class="badge bg-info text-dark">{{ $post->category }}</span></td>
                                <td><small>{{ $post->author->name ?? '—' }}</small></td>
                                <td>
                                    @if ($post->status === 'published')
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </td>
                                <td><small>{{ $post->published_at?->format('d M Y') ?? '—' }}</small></td>
                                <td class="text-nowrap">
                                    {{-- View on frontend --}}
                                    @if ($post->status === 'published')
                                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank"
                                            class="btn btn-sm btn-outline-info" title="View"><i
                                                class="fas fa-eye"></i></a>
                                    @endif

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.posts.edit', $post->id) }}"
                                        class="btn btn-sm btn-outline-primary" title="Edit"><i
                                            class="fas fa-edit"></i></a>

                                    {{-- Toggle publish/draft --}}
                                    <form method="POST" action="{{ route('admin.posts.toggle', $post->id) }}"
                                        class="d-inline">
                                        @csrf @method('PATCH')
                                        @if ($post->status === 'published')
                                            <button type="submit" class="btn btn-sm btn-warning text-dark"
                                                title="Set to Draft">
                                                <i class="fas fa-eye-slash"></i>
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-sm btn-success" title="Publish">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                    </form>

                                    {{-- Delete --}}
                                    <form method="POST" action="{{ route('admin.posts.destroy', $post->id) }}"
                                        class="d-inline" onsubmit="return confirm('Delete this post?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No posts found. <a
                                        href="{{ route('admin.posts.create') }}">Create the first one</a>.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($posts->hasPages())
            <div class="card-footer">
                <span class="text-muted small">Showing {{ $posts->firstItem() }}–{{ $posts->lastItem() }} of
                    {{ $posts->total() }}</span>
                {{ $posts->links() }}
            </div>
        @endif
    </div>
@endsection
