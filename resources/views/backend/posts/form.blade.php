@extends('backend.layouts.app')

@section('title', $post ? 'Edit Post' : 'New Post')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush

@section('content')
    <h1 class="mt-4">{{ $post ? 'Edit Post' : 'New Post' }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Posts</a></li>
        <li class="breadcrumb-item active">{{ $post ? 'Edit' : 'New' }}</li>
    </ol>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div><i class="fas fa-exclamation-circle me-1"></i>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ $post ? route('admin.posts.update', $post->id) : route('admin.posts.store') }}"
        enctype="multipart/form-data">
        @csrf
        @if ($post)
            @method('PUT')
        @endif

        <div class="row g-4">
            {{-- Main column --}}
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header"><i class="fas fa-pen me-1"></i> Post Content</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title', $post?->title) }}" placeholder="Post title…" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Excerpt <span class="text-muted small">(short summary,
                                    optional)</span></label>
                            <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" rows="2" maxlength="500"
                                placeholder="Brief description shown on blog listing…">{{ old('excerpt', $post?->excerpt) }}</textarea>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                            <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" rows="12">{{ old('content', $post?->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar column --}}
            <div class="col-lg-4">

                {{-- Publish settings --}}
                <div class="card mb-4">
                    <div class="card-header"><i class="fas fa-cog me-1"></i> Publish Settings</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="draft" @selected(old('status', $post?->status ?? 'draft') === 'draft')>Draft</option>
                                <option value="published" @selected(old('status', $post?->status) === 'published')>Published</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Publish Date</label>
                            <input type="datetime-local" name="published_at" class="form-control"
                                value="{{ old('published_at', $post?->published_at?->format('Y-m-d\TH:i')) }}">
                            <small class="text-muted">Leave blank to use current time when published.</small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> {{ $post ? 'Update Post' : 'Save Post' }}
                            </button>
                            <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </div>
                </div>

                {{-- Category --}}
                <div class="card mb-4">
                    <div class="card-header"><i class="fas fa-tag me-1"></i> Category</div>
                    <div class="card-body">
                        <input type="text" name="category" list="categories"
                            class="form-control @error('category') is-invalid @enderror"
                            value="{{ old('category', $post?->category ?? 'General') }}"
                            placeholder="e.g. Wellness, Products…" required>
                        <datalist id="categories">
                            <option value="Wellness">
                            <option value="Ayurveda">
                            <option value="Products">
                            <option value="Network Building">
                            <option value="Success Stories">
                            <option value="Finance">
                            <option value="Education">
                            <option value="Marketing">
                            <option value="Health">
                            <option value="General">
                        </datalist>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Featured Image --}}
                <div class="card mb-4">
                    <div class="card-header"><i class="fas fa-image me-1"></i> Featured Image</div>
                    <div class="card-body">
                        @if ($post?->featured_image)
                            <img src="{{ Storage::url($post->featured_image) }}" class="img-fluid rounded mb-2"
                                alt="Current image">
                            <small class="text-muted d-block mb-2">Upload a new image to replace.</small>
                        @endif
                        <input type="file" name="featured_image"
                            class="form-control @error('featured_image') is-invalid @enderror"
                            accept="image/jpeg,image/png,image/webp">
                        <small class="text-muted">JPG / PNG / WebP, max 2 MB.</small>
                        @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $('#content').summernote({
            placeholder: 'Write your post content here…',
            tabsize: 2,
            height: 380,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'hr']],
                ['view', ['fullscreen', 'codeview']],
            ],
        });
    </script>
@endpush
