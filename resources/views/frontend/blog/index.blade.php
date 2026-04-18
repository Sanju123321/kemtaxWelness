@extends('frontend.layouts.master')

@section('title', 'Blog - KemtexWellness')

@section('content')

    <section class="page-title bg-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block text-center">
                        <span class="text-white">📝 Latest Updates</span>
                        <h1 class="text-capitalize mb-4 text-lg">News &amp; Insights</h1>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                            <li class="list-inline-item"><span class="text-white">/</span></li>
                            <li class="list-inline-item text-white-50">Blog</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section latest-blog">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <div class="section-title">
                        <span class="h6 text-color">📣 Stay Informed</span>
                        <h2 class="mt-3 content-title">Tips, Success Stories &amp; Wellness Insights</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                @forelse ($posts as $post)
                    <div class="col-lg-4 col-md-6 mb-5">
                        <div class="post-item">
                            <div class="post-thumb mb-3" style="height:200px;border-radius:8px;overflow:hidden;">
                                @if ($post->featured_image)
                                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}"
                                        style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    <div
                                        style="width:100%;height:100%;background:#f0f4f8;display:flex;align-items:center;justify-content:center;">
                                        <i class="ti-write text-color" style="font-size:4rem;opacity:.3;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="post-content">
                                <div class="post-meta mb-2">
                                    <span class="badge badge-light text-color mr-2">{{ $post->category }}</span>
                                    <span class="text-muted small">{{ $post->published_at?->format('d M Y') }}</span>
                                </div>
                                <h5 class="mb-3">
                                    <a href="{{ route('blog.show', $post->slug) }}"
                                        class="text-dark">{{ $post->title }}</a>
                                </h5>
                                @if ($post->excerpt)
                                    <p class="text-muted">{{ $post->excerpt }}</p>
                                @endif
                                <a href="{{ route('blog.show', $post->slug) }}"
                                    class="btn btn-small btn-solid-border btn-round-full mt-2">Read More</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="ti-write text-color" style="font-size:4rem;opacity:.3;"></i>
                        <p class="text-muted mt-3">No posts published yet. Check back soon!</p>
                    </div>
                @endforelse
            </div>

            @if ($posts->hasPages())
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        {{ $posts->links() }}
                    </div>
                </div>
            @else
                <div class="text-center mt-4">
                    <p class="text-muted">Ready to start your own success story?</p>
                    <a href="{{ route('pricing') }}" class="btn btn-main btn-round-full">Join Now</a>
                </div>
            @endif
        </div>
    </section>

@endsection
