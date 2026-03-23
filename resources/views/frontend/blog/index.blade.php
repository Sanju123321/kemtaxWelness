@extends('frontend.layouts.master')

@section('title', 'Blog')
@section('meta_description', 'Health tips, wellness articles and news from KemtexWellness.')

@section('content')

    <section class="py-5 bg-success text-white">
        <div class="container text-center">
            <h1 class="fw-bold">Wellness Blog</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-75">Home</a></li>
                    <li class="breadcrumb-item active text-white">Blog</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                @php
                    $posts = [
                        [
                            'title' => 'Top 10 Natural Supplements for Energy',
                            'excerpt' =>
                                'Discover the best nature-derived supplements that can sustainably boost your daily energy levels without the crash.',
                            'date' => 'Feb 20, 2026',
                            'cat' => 'Supplements',
                            'img' => 'post1',
                        ],
                        [
                            'title' => 'The Benefits of Herbal Detox Teas',
                            'excerpt' =>
                                'Herbal teas have been used for centuries to cleanse the body. Learn which blends work best for detoxification.',
                            'date' => 'Feb 14, 2026',
                            'cat' => 'Herbal',
                            'img' => 'post2',
                        ],
                        [
                            'title' => 'Understanding Omega-3 Fatty Acids',
                            'excerpt' =>
                                'A deep dive into why Omega-3s are essential and how to choose the right supplement for your needs.',
                            'date' => 'Feb 08, 2026',
                            'cat' => 'Nutrition',
                            'img' => 'post3',
                        ],
                        [
                            'title' => '5 Morning Wellness Rituals',
                            'excerpt' =>
                                'Start your day right with these science-backed morning habits that promote lasting health and mental clarity.',
                            'date' => 'Jan 30, 2026',
                            'cat' => 'Lifestyle',
                            'img' => 'post4',
                        ],
                        [
                            'title' => 'Vitamins vs Supplements: What\'s the Difference?',
                            'excerpt' =>
                                'Confused about whether to take vitamins or supplements? We break down the key differences for you.',
                            'date' => 'Jan 22, 2026',
                            'cat' => 'Education',
                            'img' => 'post5',
                        ],
                        [
                            'title' => 'Gut Health: The Foundation of Wellness',
                            'excerpt' =>
                                'Your gut houses 70% of your immune system. Learn how probiotics and diet can transform your overall health.',
                            'date' => 'Jan 15, 2026',
                            'cat' => 'Health',
                            'img' => 'post6',
                        ],
                    ];
                @endphp
                @foreach ($posts as $p)
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100">
                            <img src="{{ asset('frontend/images/' . $p['img'] . '.jpg') }}" class="card-img-top"
                                style="height:200px;object-fit:cover;" alt="{{ $p['title'] }}"
                                onerror="this.src='https://placehold.co/400x200/198754/white?text={{ urlencode($p['cat']) }}';" />
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-success">{{ $p['cat'] }}</span>
                                    <small class="text-muted">{{ $p['date'] }}</small>
                                </div>
                                <h6 class="fw-semibold">{{ $p['title'] }}</h6>
                                <p class="text-muted small">{{ $p['excerpt'] }}</p>
                            </div>
                            <div class="card-footer bg-white border-0 pt-0 pb-3">
                                <a href="#" class="btn btn-outline-success btn-sm">Read More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
