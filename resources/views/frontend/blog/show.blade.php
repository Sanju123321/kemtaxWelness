@extends('frontend.layouts.master')

@section('title', $post->title . ' - KemtexWellness')

@section('content')

    <section class="page-title bg-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block text-center">
                        <span class="text-white">{{ $post->category }}</span>
                        <h1 class="text-capitalize mb-4 text-lg">{{ $post->title }}</h1>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                            <li class="list-inline-item"><span class="text-white">/</span></li>
                            <li class="list-inline-item"><a href="{{ route('blog') }}" class="text-white">Blog</a></li>
                            <li class="list-inline-item"><span class="text-white">/</span></li>
                            <li class="list-inline-item text-white-50">{{ Str::limit($post->title, 40) }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section blog-wrap bg-gray">
        <div class="container">
            <div class="row">

                {{-- Main Article --}}
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-12 mb-5">
                            <div class="single-blog-item">
                                @if ($post->featured_image)
                                    <img loading="lazy" src="{{ Storage::url($post->featured_image) }}"
                                        alt="{{ $post->title }}" class="img-fluid rounded"
                                        style="width:100%;max-height:420px;object-fit:cover;">
                                @endif
                                <div class="blog-item-content bg-white p-5">
                                    <div class="blog-item-meta bg-gray pt-2 pb-1 px-3">
                                        <span class="text-muted text-capitalize mr-3">
                                            <i class="ti-tag mr-2"></i>{{ $post->category }}
                                        </span>
                                        <span class="text-muted text-capitalize mr-3">
                                            <i class="ti-user mr-2"></i>{{ $post->author->name ?? 'Admin' }}
                                        </span>
                                        <span class="text-black text-capitalize mr-3">
                                            <i class="ti-time mr-1"></i> {{ $post->published_at?->format('d M Y') }}
                                        </span>
                                        <span class="text-muted text-capitalize mr-3">
                                            <i class="ti-book mr-1"></i> {{ $post->read_time }}
                                        </span>
                                    </div>

                                    <h2 class="mt-3 mb-4">{{ $post->title }}</h2>

                                    @if ($post->excerpt)
                                        <p class="lead mb-4">{{ $post->excerpt }}</p>
                                    @endif

                                    <div class="post-content">{!! $post->content !!}</div>

                                    <div
                                        class="tag-option mt-5 d-block d-md-flex justify-content-between align-items-center">
                                        <ul class="list-inline">
                                            <li>Category:</li>
                                            <li class="list-inline-item">
                                                <a href="{{ route('blog') }}?category={{ urlencode($post->category) }}"
                                                    rel="tag">{{ $post->category }}</a>
                                            </li>
                                        </ul>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">Share:</li>
                                            <li class="list-inline-item">
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                                    target="_blank" rel="noopener noreferrer">
                                                    <i class="fab fa-facebook-f"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . url()->current()) }}"
                                                    target="_blank" rel="noopener noreferrer">
                                                    <i class="fab fa-whatsapp"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Related Posts --}}
                        @if ($related->count())
                            <div class="col-lg-12 mb-5">
                                <div class="bg-white rounded p-5">
                                    <h4 class="mb-4">Related Posts</h4>
                                    <div class="row">
                                        @foreach ($related as $rel)
                                            <div class="col-md-4 mb-3">
                                                <a href="{{ route('blog.show', $rel->slug) }}" class="text-dark">
                                                    <div
                                                        style="height:120px;border-radius:6px;overflow:hidden;background:#f0f4f8;margin-bottom:8px;">
                                                        @if ($rel->featured_image)
                                                            <img src="{{ Storage::url($rel->featured_image) }}"
                                                                alt="{{ $rel->title }}"
                                                                style="width:100%;height:100%;object-fit:cover;">
                                                        @else
                                                            <div
                                                                style="display:flex;align-items:center;justify-content:center;height:100%;">
                                                                <i class="ti-write text-color"
                                                                    style="font-size:2rem;opacity:.3;"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <h6>{{ Str::limit($rel->title, 50) }}</h6>
                                                    <small
                                                        class="text-muted">{{ $rel->published_at?->format('d M Y') }}</small>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4 mt-5 mt-lg-0">
                    <div class="sidebar-wrap">
                        <div class="sidebar-widget search card p-4 mb-3 border-0">
                            <form method="GET" action="{{ route('blog') }}">
                                <input type="text" name="search" class="form-control" placeholder="Search articles...">
                                <button type="submit" class="btn btn-main btn-small d-block mt-2 w-100">Search</button>
                            </form>
                        </div>

                        @if ($recent->count())
                            <div class="sidebar-widget latest-post card border-0 p-4 mb-3">
                                <h5>Latest Posts</h5>
                                @foreach ($recent as $r)
                                    <div class="media border-bottom py-3">
                                        <a href="{{ route('blog.show', $r->slug) }}">
                                            <div class="mr-4"
                                                style="width:60px;height:50px;border-radius:4px;overflow:hidden;background:#f0f4f8;flex-shrink:0;">
                                                @if ($r->featured_image)
                                                    <img loading="lazy" src="{{ Storage::url($r->featured_image) }}"
                                                        alt="{{ $r->title }}"
                                                        style="width:100%;height:100%;object-fit:cover;">
                                                @else
                                                    <div
                                                        style="display:flex;align-items:center;justify-content:center;height:100%;">
                                                        <i class="ti-write text-color"
                                                            style="font-size:1rem;opacity:.3;"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </a>
                                        <div class="media-body">
                                            <h6 class="my-2">
                                                <a href="{{ route('blog.show', $r->slug) }}"
                                                    class="text-dark">{{ Str::limit($r->title, 45) }}</a>
                                            </h6>
                                            <span
                                                class="text-sm text-muted">{{ $r->published_at?->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="sidebar-widget bg-white rounded tags p-4 mb-3">
                            <h5 class="mb-4">Explore Topics</h5>
                            <a href="{{ route('blog') }}">All</a>
                            <a href="{{ route('blog') }}?category=Wellness">Wellness</a>
                            <a href="{{ route('blog') }}?category=Ayurveda">Ayurveda</a>
                            <a href="{{ route('blog') }}?category=Products">Products</a>
                            <a href="{{ route('blog') }}?category=Network+Building">Network</a>
                            <a href="{{ route('blog') }}?category=Education">Education</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
