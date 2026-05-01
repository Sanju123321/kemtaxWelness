@extends('frontend.layouts.master')

@section('title', 'KemtexWellness – Authentic Ayurvedic Products for Vaat, Pitta & Kapha')

@push('styles')
    <style>
        /* ================================================================
       KEMTEXWELLNESS — PREMIUM AYURVEDIC HOMEPAGE
       Bootstrap 4.5 compatible · Mobile-first · Smooth animations
       ================================================================ */

        /* ---------- PALETTE ---------- */
        :root {
            --kw-green: #2d6a4f;
            --kw-green-d: #1b4332;
            --kw-green-l: #52b788;
            --kw-gold: #c8973a;
            --kw-gold-l: #e4bf7b;
            --kw-cream: #fdf8f0;
            --kw-vaat: #5b6abf;
            --kw-pitta: #e07b39;
            --kw-kapha: #3a9e6b;
            --kw-body: #fafaf7;
            --kw-dark: #1a1a1a;
            --kw-radius: 16px;
            --kw-shadow: 0 8px 30px rgba(0, 0, 0, .08);
            --kw-shadow-lg: 0 16px 50px rgba(0, 0, 0, .12);
        }

        /* ---------- ANIMATION HELPERS ---------- */
        @keyframes kwFadeUp {
            from {
                opacity: 0;
                transform: translateY(30px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes kwPulse {

            0%,
            100% {
                transform: scale(1)
            }

            50% {
                transform: scale(1.05)
            }
        }

        .kw-fade-up {
            animation: kwFadeUp .7s ease both
        }

        .kw-delay-1 {
            animation-delay: .15s
        }

        .kw-delay-2 {
            animation-delay: .3s
        }

        .kw-delay-3 {
            animation-delay: .45s
        }

        .kw-delay-4 {
            animation-delay: .6s
        }

        /* ---------- SECTION COMMON ---------- */
        .kw-section {
            padding: 80px 0;
            position: relative
        }

        .kw-section-sm {
            padding: 56px 0
        }

        .kw-section-label {
            font-size: .72rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--kw-gold);
            display: inline-block;
            margin-bottom: 10px
        }

        .kw-section-title {
            font-size: clamp(1.6rem, 4vw, 2.6rem);
            font-weight: 800;
            color: var(--kw-dark);
            line-height: 1.2
        }

        .kw-section-title.light {
            color: #fff
        }

        .kw-section-sub {
            color: #666;
            font-size: 1rem;
            line-height: 1.8;
            max-width: 600px
        }

        .kw-section-sub.light {
            color: rgba(255, 255, 255, .72)
        }

        .kw-divider {
            width: 60px;
            height: 3px;
            background: var(--kw-gold);
            border-radius: 2px;
            margin: 14px 0 0
        }

        .kw-divider.center {
            margin: 14px auto 0
        }

        .kw-bg-cream {
            background: var(--kw-cream)
        }

        .kw-bg-dark-green {
            background: #4caf50;
            /* background: linear-gradient(145deg, var(--kw-green-d), var(--kw-green)) */
        }

        /* ================================================================
       1. HERO
       ================================================================ */
        .kw-hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: #4caf50;
            position: relative;
            overflow: hidden;
            padding: 100px 0 80px;
        }

        .kw-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><circle cx="40" cy="40" r="1.5" fill="rgba(255,255,255,.04)"/><circle cx="100" cy="80" r="1" fill="rgba(255,255,255,.03)"/><circle cx="160" cy="30" r="2" fill="rgba(255,255,255,.05)"/><circle cx="60" cy="140" r="1.5" fill="rgba(255,255,255,.04)"/><circle cx="150" cy="160" r="1" fill="rgba(255,255,255,.03)"/></svg>');
            background-size: 200px;
        }

        .kw-hero::after {
            content: '';
            position: absolute;
            right: -200px;
            bottom: -200px;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(200, 151, 58, .12) 0%, transparent 70%);
            border-radius: 50%;
        }

        .kw-hero-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(200, 151, 58, .15);
            border: 1px solid rgba(200, 151, 58, .35);
            border-radius: 40px;
            padding: 7px 20px;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--kw-gold-l);
            margin-bottom: 20px;
        }

        .kw-hero h1 {
            font-size: clamp(2rem, 5.5vw, 3.8rem);
            font-weight: 800;
            color: #fff;
            line-height: 1.12;
        }

        .kw-hero h1 em {
            font-style: normal;
            color: var(--kw-gold-l)
        }

        .kw-hero-sub {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, .72);
            max-width: 540px;
            line-height: 1.75;
            margin-top: 16px;
        }

        .kw-hero-btns {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 32px
        }

        .kw-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--kw-gold);
            color: #fff;
            padding: 14px 36px;
            border-radius: 50px;
            font-weight: 700;
            font-size: .95rem;
            text-decoration: none;
            border: none;
            transition: all .3s;
            box-shadow: 0 4px 20px rgba(200, 151, 58, .35);
        }

        .kw-btn-primary:hover {
            background: #a97a28;
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 8px 28px rgba(200, 151, 58, .45)
        }

        .kw-btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            color: #fff;
            border: 2px solid rgba(255, 255, 255, .35);
            padding: 13px 32px;
            border-radius: 50px;
            font-weight: 600;
            font-size: .95rem;
            text-decoration: none;
            transition: all .3s;
        }

        .kw-btn-outline:hover {
            background: rgba(255, 255, 255, .1);
            border-color: rgba(255, 255, 255, .6);
            color: #fff
        }

        .kw-hero-trust {
            display: flex;
            flex-wrap: wrap;
            gap: 22px;
            margin-top: 44px;
            padding-top: 28px;
            border-top: 1px solid rgba(255, 255, 255, .1);
        }

        .kw-hero-trust-item {
            display: flex;
            align-items: center;
            gap: 8px
        }

        .kw-hero-trust-item i {
            color: var(--kw-gold-l);
            font-size: 1rem
        }

        .kw-hero-trust-item span {
            color: rgba(255, 255, 255, .6);
            font-size: .8rem;
            font-weight: 600;
            letter-spacing: .5px
        }

        .kw-hero-visual {
            position: relative;
            text-align: center
        }

        .kw-hero-visual img {
            max-width: 100%;
            border-radius: 24px;
            box-shadow: 0 32px 80px rgba(0, 0, 0, .4);
        }

        .kw-hero-float-card {
            position: absolute;
            background: #fff;
            border-radius: 16px;
            padding: 14px 20px;
            box-shadow: var(--kw-shadow-lg);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .kw-hero-float-card.card-a {
            bottom: 30px;
            left: -10px
        }

        .kw-hero-float-card.card-b {
            top: 30px;
            right: -10px
        }

        .kw-hero-float-card .hfc-icon {
            font-size: 1.8rem
        }

        .kw-hero-float-card .hfc-text {
            font-size: .75rem;
            font-weight: 700;
            line-height: 1.35;
            color: var(--kw-dark)
        }

        .kw-hero-float-card .hfc-sub {
            color: var(--kw-green);
            font-weight: 700;
            font-size: .7rem
        }

        /* ================================================================
       1b. TRUST BAR
       ================================================================ */
        .kw-trust-bar {
            background: var(--kw-cream);
            border-bottom: 1px solid #e8e0d0;
            padding: 16px 0
        }

        .kw-trust-chip {
            display: flex;
            align-items: center;
            gap: 8px;
            justify-content: center
        }

        .kw-trust-chip i {
            color: var(--kw-gold);
            font-size: 1.1rem
        }

        .kw-trust-chip span {
            font-size: .82rem;
            font-weight: 700;
            color: #555
        }

        /* ================================================================
       2. DOSHA SECTION
       ================================================================ */
        .kw-dosha-card {
            border-radius: var(--kw-radius);
            padding: 40px 28px;
            text-align: center;
            height: 100%;
            border: 2px solid transparent;
            transition: all .4s cubic-bezier(.25, .8, .25, 1);
            position: relative;
            overflow: hidden;
        }

        .kw-dosha-card::after {
            content: '';
            position: absolute;
            inset: 0;
            opacity: .04;
            border-radius: inherit;
            transition: opacity .4s;
        }

        .kw-dosha-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--kw-shadow-lg);
        }

        .kw-dosha-card:hover::after {
            opacity: .08
        }

        .kw-dosha-card.vaat {
            background: #f4f5fd;
            border-color: var(--kw-vaat)
        }

        .kw-dosha-card.vaat::after {
            background: var(--kw-vaat)
        }

        .kw-dosha-card.pitta {
            background: #fff7f1;
            border-color: var(--kw-pitta)
        }

        .kw-dosha-card.pitta::after {
            background: var(--kw-pitta)
        }

        .kw-dosha-card.kapha {
            background: #f1fbf5;
            border-color: var(--kw-kapha)
        }

        .kw-dosha-card.kapha::after {
            background: var(--kw-kapha)
        }

        .kw-dosha-icon {
            font-size: 3.2rem;
            margin-bottom: 12px
        }

        .kw-dosha-sans {
            font-size: .72rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            font-weight: 700;
            opacity: .6;
            margin-bottom: 8px
        }

        .kw-dosha-card h4 {
            font-size: 1.35rem;
            font-weight: 800;
            margin-bottom: 6px
        }

        .kw-dosha-elem {
            font-size: .72rem;
            letter-spacing: 1.5px;
            font-weight: 600;
            text-transform: uppercase;
            opacity: .45;
            margin-bottom: 14px
        }

        .kw-dosha-card p {
            font-size: .9rem;
            color: #555;
            line-height: 1.7;
            margin-bottom: 20px
        }

        .kw-dosha-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            justify-content: center;
            margin-bottom: 18px
        }

        .kw-dosha-tag {
            display: inline-block;
            border-radius: 20px;
            padding: 4px 14px;
            font-size: .7rem;
            font-weight: 700;
            color: #fff;
        }

        .kw-tag-vaat {
            background: var(--kw-vaat)
        }

        .kw-tag-pitta {
            background: var(--kw-pitta)
        }

        .kw-tag-kapha {
            background: var(--kw-kapha)
        }

        .kw-dosha-btn {
            display: inline-block;
            padding: 10px 26px;
            border-radius: 30px;
            font-weight: 700;
            font-size: .85rem;
            color: #fff;
            text-decoration: none;
            transition: all .3s;
        }

        .kw-dosha-btn:hover {
            opacity: .88;
            transform: translateY(-2px);
            color: #fff
        }

        /* ================================================================
       3. FEATURED PRODUCTS
       ================================================================ */
        .kw-product-card {
            border-radius: var(--kw-radius);
            overflow: hidden;
            background: #fff;
            border: 1px solid #eee;
            height: 100%;
            transition: all .35s;
        }

        .kw-product-card:hover {
            box-shadow: var(--kw-shadow-lg);
            transform: translateY(-6px);
        }

        .kw-product-img-wrap {
            position: relative;
            overflow: hidden;
            height: 220px;
        }

        .kw-product-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .6s ease;
        }

        .kw-product-card:hover .kw-product-img-wrap img {
            transform: scale(1.08);
        }

        .kw-product-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: var(--kw-gold);
            color: #fff;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 20px;
        }

        .kw-product-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity .35s;
        }

        .kw-product-card:hover .kw-product-overlay {
            opacity: 1
        }

        .kw-overlay-btn {
            background: #fff;
            color: var(--kw-dark);
            padding: 10px 22px;
            border-radius: 30px;
            font-size: .82rem;
            font-weight: 700;
            text-decoration: none;
            transition: all .3s;
        }

        .kw-overlay-btn:hover {
            background: var(--kw-gold);
            color: #fff
        }

        .kw-product-body {
            padding: 20px
        }

        .kw-dosha-label {
            display: inline-block;
            font-size: .66rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 3px 12px;
            border-radius: 20px;
            color: #fff;
            margin-bottom: 8px;
        }

        .kw-dosha-label.kw-dosha-vaat {
            background: var(--kw-vaat)
        }

        .kw-dosha-label.kw-dosha-pitta {
            background: var(--kw-pitta)
        }

        .kw-dosha-label.kw-dosha-kapha {
            background: var(--kw-kapha)
        }

        .kw-dosha-label.kw-dosha-tridosha {
            background: var(--kw-green)
        }

        .kw-product-name {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 4px;
            color: var(--kw-dark)
        }

        .kw-product-desc {
            font-size: .82rem;
            color: #888;
            margin-bottom: 14px;
            line-height: 1.5
        }

        .kw-product-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px
        }

        .kw-product-price {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--kw-green)
        }

        .kw-product-mrp {
            font-size: .85rem;
            color: #bbb;
            text-decoration: line-through;
            margin-left: 6px
        }

        .kw-add-cart-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--kw-green);
            color: #fff;
            padding: 8px 18px;
            border-radius: 30px;
            font-size: .78rem;
            font-weight: 700;
            text-decoration: none;
            transition: all .3s;
            border: none;
        }

        .kw-add-cart-btn:hover {
            background: var(--kw-green-d);
            color: #fff;
            transform: translateY(-2px)
        }

        /* ================================================================
       4. WHY CHOOSE US
       ================================================================ */
        .kw-why-card {
            text-align: center;
            padding: 36px 20px;
            border-radius: var(--kw-radius);
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .12);
            height: 100%;
            transition: all .35s;
        }

        .kw-why-card:hover {
            background: rgba(255, 255, 255, .12);
            transform: translateY(-8px);
        }

        .kw-why-icon {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: rgba(200, 151, 58, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            font-size: 1.8rem;
            transition: transform .3s;
        }

        .kw-why-card:hover .kw-why-icon {
            transform: scale(1.1)
        }

        .kw-why-card h5 {
            color: #fff;
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 1.05rem
        }

        .kw-why-card p {
            color: rgba(255, 255, 255, .65);
            font-size: .88rem;
            line-height: 1.7
        }

        /* ================================================================
       5. TESTIMONIALS
       ================================================================ */
        .kw-testi-card {
            background: #fff;
            border-radius: var(--kw-radius);
            padding: 32px 28px;
            box-shadow: var(--kw-shadow);
            height: 100%;
            transition: all .3s;
            position: relative;
        }

        .kw-testi-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--kw-shadow-lg)
        }

        .kw-testi-stars {
            color: #f4c542;
            font-size: .9rem;
            margin-bottom: 10px;
            letter-spacing: 2px
        }

        .kw-testi-quote {
            font-size: 2.2rem;
            color: var(--kw-gold);
            line-height: 1;
            font-family: Georgia, serif;
            margin-bottom: 8px;
        }

        .kw-testi-card p {
            font-size: .92rem;
            color: #555;
            line-height: 1.8;
            font-style: italic;
            margin-bottom: 20px
        }

        .kw-testi-author {
            display: flex;
            align-items: center;
            gap: 14px
        }

        .kw-testi-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--kw-green), var(--kw-gold));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .kw-testi-info h6 {
            margin: 0;
            font-weight: 700;
            font-size: .92rem
        }

        .kw-testi-info span {
            font-size: .76rem;
            color: var(--kw-green);
            font-weight: 600
        }

        /* ================================================================
       6. ABOUT
       ================================================================ */
        .kw-about-img {
            border-radius: 20px;
            box-shadow: var(--kw-shadow-lg);
            width: 100%;
            object-fit: cover
        }

        .kw-about-feature {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 20px
        }

        .kw-af-icon {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: #e8f5ef;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: transform .3s;
        }

        .kw-about-feature:hover .kw-af-icon {
            transform: scale(1.1)
        }

        .kw-af-icon i {
            color: var(--kw-green);
            font-size: 1.1rem
        }

        .kw-af-text h6 {
            font-weight: 700;
            margin-bottom: 2px;
            font-size: .95rem
        }

        .kw-af-text p {
            font-size: .86rem;
            color: #666;
            margin: 0;
            line-height: 1.6
        }

        /* ================================================================
       7. CTA BANNER
       ================================================================ */
        .kw-cta-box {
            background: linear-gradient(145deg, var(--kw-green-d), var(--kw-green));
            border-radius: 24px;
            padding: 60px 48px;
            position: relative;
            overflow: hidden;
        }

        .kw-cta-box::before {
            content: '🌿';
            font-size: 12rem;
            position: absolute;
            right: -20px;
            top: -30px;
            opacity: .06;
        }

        .kw-cta-box h2 {
            color: #fff;
            font-size: clamp(1.5rem, 3.5vw, 2.4rem);
            font-weight: 800;
            margin-bottom: 14px
        }

        .kw-cta-box p {
            color: rgba(255, 255, 255, .72);
            max-width: 520px;
            margin-bottom: 28px;
            font-size: 1rem;
            line-height: 1.7
        }

        .kw-cta-phone {
            background: rgba(255, 255, 255, .08);
            border-radius: 16px;
            padding: 24px;
            text-align: center;
        }

        .kw-cta-phone-icon {
            font-size: 2.2rem;
            margin-bottom: 8px
        }

        .kw-cta-phone-label {
            color: rgba(255, 255, 255, .6);
            font-size: .75rem;
            letter-spacing: 1.5px;
            text-transform: uppercase
        }

        .kw-cta-phone-num {
            color: var(--kw-gold-l);
            font-size: 1.5rem;
            font-weight: 800;
            margin-top: 4px
        }

        .kw-cta-phone-hours {
            color: rgba(255, 255, 255, .5);
            font-size: .78rem;
            margin-top: 4px
        }

        /* ================================================================
       RESPONSIVE
       ================================================================ */
        @media(max-width:991px) {
            .kw-hero {
                min-height: auto;
                padding: 80px 0 60px
            }

            .kw-hero-visual {
                margin-top: 48px
            }

            .kw-hero-float-card.card-a {
                left: 10px
            }

            .kw-hero-float-card.card-b {
                right: 10px
            }

            .kw-cta-box {
                padding: 40px 28px
            }
        }

        @media(max-width:767px) {
            .kw-section {
                padding: 56px 0
            }

            .kw-hero h1 {
                font-size: 1.9rem
            }

            .kw-hero-trust {
                gap: 14px
            }

            .kw-hero-float-card {
                display: none
            }

            .kw-cta-box {
                padding: 32px 20px
            }

            .kw-cta-box::before {
                display: none
            }

            .kw-product-img-wrap {
                height: 180px
            }
        }
    </style>
@endpush

@section('content')

    {{-- ================================================================
     1. HERO SECTION
     ================================================================ --}}
    <section class="kw-hero">
        <div class="container position-relative" style="z-index:2">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0 kw-fade-up">
                    <span class="kw-hero-label">
                        <i class="fas fa-leaf"></i> 100% Natural &amp; Authentic Ayurveda
                    </span>
                    <h1>Balance Your<br><em>Body Naturally</em></h1>
                    <p class="kw-hero-sub">
                        Premium Ayurvedic solutions crafted to harmonise
                        <strong style="color:var(--kw-vaat)">Vaat</strong>,
                        <strong style="color:var(--kw-pitta)">Pitta</strong> &amp;
                        <strong style="color:var(--kw-kapha)">Kapha</strong>
                        — rooted in 5,000 years of healing wisdom.
                    </p>
                    <div class="kw-hero-btns">
                        <a href="{{ route('products') }}" class="kw-btn-primary">
                            <i class="fas fa-shopping-bag"></i> Shop Now
                        </a>
                        <a href="{{ route('products') }}" class="kw-btn-outline">
                            <i class="fas fa-th-large"></i> Explore Products
                        </a>
                    </div>
                    <div class="kw-hero-trust">
                        <div class="kw-hero-trust-item"><i class="fas fa-certificate"></i><span>FSSAI Certified</span></div>
                        <div class="kw-hero-trust-item"><i class="fas fa-leaf"></i><span>100% Natural</span></div>
                        <div class="kw-hero-trust-item"><i class="fas fa-truck"></i><span>Pan-India Delivery</span></div>
                        <div class="kw-hero-trust-item"><i class="fas fa-undo-alt"></i><span>7-Day Returns</span></div>
                    </div>
                </div>
                <div class="col-lg-6 kw-fade-up kw-delay-2">
                    <div class="kw-hero-visual">
                        <img src="{{ asset('frontend/images/about/bg-1.jpg') }}" alt="KemtexWellness Ayurvedic Products">
                        <div class="kw-hero-float-card card-a kw-fade-up kw-delay-3">
                            <span class="hfc-icon">🌿</span>
                            <div>
                                <div class="hfc-text">No Side Effects</div>
                                <div class="hfc-sub">Clinically Verified</div>
                            </div>
                        </div>
                        <div class="kw-hero-float-card card-b kw-fade-up kw-delay-4">
                            <span class="hfc-icon">⭐</span>
                            <div>
                                <div class="hfc-text">50,000+</div>
                                <div class="hfc-sub">Happy Customers</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- TRUST BAR --}}
    <section class="kw-trust-bar">
        <div class="container">
            <div class="row text-center">
                <div class="col-6 col-md-3 mb-2 mb-md-0">
                    <div class="kw-trust-chip"><i class="fas fa-certificate"></i><span>FSSAI &amp; GMP Certified</span>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-2 mb-md-0">
                    <div class="kw-trust-chip"><i class="fas fa-leaf"></i><span>100% Natural Herbs</span></div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="kw-trust-chip"><i class="fas fa-truck"></i><span>Free Delivery ₹499+</span></div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="kw-trust-chip"><i class="fas fa-shield-alt"></i><span>Secure Payments</span></div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================
     2. DOSHA SECTION
     ================================================================ --}}
    <section class="kw-section kw-bg-cream">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-7">
                    <span class="kw-section-label">The Science of Ayurveda</span>
                    <h2 class="kw-section-title">Three Doshas — One Perfect Balance</h2>
                    <div class="kw-divider center"></div>
                    <p class="kw-section-sub mx-auto mt-3">Every body is unique. Discover your dominant dosha and find
                        products tailored to restore your natural equilibrium.</p>
                </div>
            </div>
            <div class="row">
                {{-- Vaat --}}
                <div class="col-lg-4 col-md-6 mb-4 kw-fade-up">
                    <div class="kw-dosha-card vaat">
                        <div class="kw-dosha-icon">🌬️</div>
                        <div class="kw-dosha-sans" style="color:var(--kw-vaat)">वात · Vaat</div>
                        <h4>Air &amp; Space</h4>
                        <div class="kw-dosha-elem">Elements: Air + Ether</div>
                        <p>Governs movement, breathing, circulation and the nervous system. Imbalanced Vaat causes anxiety,
                            joint pain, dryness and restless sleep.</p>
                        <div class="kw-dosha-tags">
                            <span class="kw-dosha-tag kw-tag-vaat">Joint Support</span>
                            <span class="kw-dosha-tag kw-tag-vaat">Nerve Tonic</span>
                            <span class="kw-dosha-tag kw-tag-vaat">Sleep Aid</span>
                        </div>
                        <a href="{{ route('products') }}" class="kw-dosha-btn" style="background:var(--kw-vaat)">Shop Vaat
                            Range</a>
                    </div>
                </div>
                {{-- Pitta --}}
                <div class="col-lg-4 col-md-6 mb-4 kw-fade-up kw-delay-1">
                    <div class="kw-dosha-card pitta">
                        <div class="kw-dosha-icon">🔥</div>
                        <div class="kw-dosha-sans" style="color:var(--kw-pitta)">पित्त · Pitta</div>
                        <h4>Fire &amp; Water</h4>
                        <div class="kw-dosha-elem">Elements: Fire + Water</div>
                        <p>Governs metabolism, digestion and skin health. Excess Pitta leads to acidity, inflammation, skin
                            rashes and irritability.</p>
                        <div class="kw-dosha-tags">
                            <span class="kw-dosha-tag kw-tag-pitta">Digestive Health</span>
                            <span class="kw-dosha-tag kw-tag-pitta">Skin Glow</span>
                            <span class="kw-dosha-tag kw-tag-pitta">Liver Care</span>
                        </div>
                        <a href="{{ route('products') }}" class="kw-dosha-btn" style="background:var(--kw-pitta)">Shop
                            Pitta Range</a>
                    </div>
                </div>
                {{-- Kapha --}}
                <div class="col-lg-4 col-md-12 mb-4 kw-fade-up kw-delay-2">
                    <div class="kw-dosha-card kapha">
                        <div class="kw-dosha-icon">🌱</div>
                        <div class="kw-dosha-sans" style="color:var(--kw-kapha)">कफ · Kapha</div>
                        <h4>Earth &amp; Water</h4>
                        <div class="kw-dosha-elem">Elements: Earth + Water</div>
                        <p>Governs structure, immunity and lubrication. Kapha imbalance causes weight gain, congestion,
                            sluggishness and water retention.</p>
                        <div class="kw-dosha-tags">
                            <span class="kw-dosha-tag kw-tag-kapha">Weight Mgmt</span>
                            <span class="kw-dosha-tag kw-tag-kapha">Immunity</span>
                            <span class="kw-dosha-tag kw-tag-kapha">Detox</span>
                        </div>
                        <a href="{{ route('products') }}" class="kw-dosha-btn" style="background:var(--kw-kapha)">Shop
                            Kapha Range</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================
     3. FEATURED PRODUCTS
     ================================================================ --}}
    <section class="kw-section">
        <div class="container">
            <div class="row justify-content-between align-items-end mb-5">
                <div class="col-lg-7">
                    <span class="kw-section-label">Our Products</span>
                    <h2 class="kw-section-title">Top-Selling Ayurvedic Formulations</h2>
                    <div class="kw-divider"></div>
                </div>
                <div class="col-lg-4 text-lg-right mt-3 mt-lg-0">
                    <a href="{{ route('products') }}" class="kw-btn-primary" style="font-size:.85rem;padding:11px 28px">
                        View All Products <i class="fas fa-arrow-right ml-2 text-success"></i>
                    </a>
                </div>
            </div>
            <div class="row">
                @foreach (($featuredProducts ?? collect()) as $index => $product)
                    <div class="col-lg-3 col-md-6 mb-4 kw-fade-up kw-delay-{{ $index + 1 }}">
                        @include('components.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ================================================================
     4. WHY CHOOSE US
     ================================================================ --}}
    <section class="kw-section kw-bg-dark-green">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-7">
                    <span class="kw-section-label">Why KemtexWellness</span>
                    <h2 class="kw-section-title light">What Makes Us Different</h2>
                    <div class="kw-divider center"></div>
                    <p class="kw-section-sub light mx-auto mt-3">We combine 5,000-year-old Ayurvedic wisdom with modern
                        quality standards to deliver results you can feel.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4 kw-fade-up">
                    <div class="kw-why-card">
                        <div class="kw-why-icon">🌿</div>
                        <h5>100% Natural</h5>
                        <p>Pure herbs sourced from organic farms — no synthetic fillers, additives or preservatives.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 kw-fade-up kw-delay-1">
                    <div class="kw-why-card">
                        <div class="kw-why-icon">🚫</div>
                        <h5>No Chemicals</h5>
                        <p>Zero harmful chemicals. Every product is free from parabens, sulphates and artificial colours.
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 kw-fade-up kw-delay-2">
                    <div class="kw-why-card">
                        <div class="kw-why-icon">🏆</div>
                        <h5>Ayurvedic Certified</h5>
                        <p>FSSAI, GMP &amp; ISO 9001 certified. Formulated by qualified Ayurvedic Vaidyas.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 kw-fade-up kw-delay-3">
                    <div class="kw-why-card">
                        <div class="kw-why-icon">🚚</div>
                        <h5>Fast Delivery</h5>
                        <p>Quick dispatch across India with free shipping on orders above ₹499. 7-day easy returns.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================
     5. TESTIMONIALS (Slick Carousel)
     ================================================================ --}}
    <section class="kw-section kw-bg-cream">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-7">
                    <span class="kw-section-label">Real Results</span>
                    <h2 class="kw-section-title">What Our Customers Say</h2>
                    <div class="kw-divider center"></div>
                </div>
            </div>
            <div class="kw-testi-slider">
                {{-- Slide 1 --}}
                <div class="px-2">
                    <div class="kw-testi-card">
                        <div class="kw-testi-stars">★★★★★</div>
                        <div class="kw-testi-quote">"</div>
                        <p>After using the Vaat balance range for just 60 days, my chronic knee pain has reduced
                            significantly. I feel more flexible and my sleep has improved tremendously.</p>
                        <div class="kw-testi-author">
                            <div class="kw-testi-avatar">PS</div>
                            <div class="kw-testi-info">
                                <h6>Priya Sharma</h6><span>Bangalore · Vaat Range</span>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Slide 2 --}}
                <div class="px-2">
                    <div class="kw-testi-card">
                        <div class="kw-testi-stars">★★★★★</div>
                        <div class="kw-testi-quote">"</div>
                        <p>The Pitta Cool Syrup solved my decade-long acidity problem in three weeks. My skin also cleared
                            up beautifully. I recommend KemtexWellness to everyone.</p>
                        <div class="kw-testi-author">
                            <div class="kw-testi-avatar">RM</div>
                            <div class="kw-testi-info">
                                <h6>Rajesh Mehra</h6><span>Mumbai · Pitta Range</span>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Slide 3 --}}
                <div class="px-2">
                    <div class="kw-testi-card">
                        <div class="kw-testi-stars">★★★★★</div>
                        <div class="kw-testi-quote">"</div>
                        <p>I lost 8 kg in 4 months with the Kapha Detox Tea combined with a simple lifestyle change. No side
                            effects, fully natural, and I feel energised every morning.</p>
                        <div class="kw-testi-author">
                            <div class="kw-testi-avatar">AV</div>
                            <div class="kw-testi-info">
                                <h6>Anita Verma</h6><span>Delhi · Kapha Range</span>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Slide 4 --}}
                <div class="px-2">
                    <div class="kw-testi-card">
                        <div class="kw-testi-stars">★★★★★</div>
                        <div class="kw-testi-quote">"</div>
                        <p>The free consultation with their Vaidya helped me identify my dosha correctly. Now I know exactly
                            which products to use. Truly personalised healthcare.</p>
                        <div class="kw-testi-author">
                            <div class="kw-testi-avatar">NJ</div>
                            <div class="kw-testi-info">
                                <h6>Neha Joshi</h6><span>Ahmedabad · Tridosha User</span>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Slide 5 --}}
                <div class="px-2">
                    <div class="kw-testi-card">
                        <div class="kw-testi-stars">★★★★★</div>
                        <div class="kw-testi-quote">"</div>
                        <p>The eco-friendly packaging and farm-to-bottle transparency gave me full confidence. I know
                            exactly where my herbs come from — no other brand offers this.</p>
                        <div class="kw-testi-author">
                            <div class="kw-testi-avatar">DT</div>
                            <div class="kw-testi-info">
                                <h6>Deepak Tiwari</h6><span>Lucknow · Ashwagandha User</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================
     6. ABOUT SECTION
     ================================================================ --}}
    <section class="kw-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0 kw-fade-up">
                    <img src="{{ asset('frontend/images/about/about.jpg') }}" alt="About KemtexWellness" class="kw-about-img"
                        loading="lazy">
                </div>
                <div class="col-lg-6 kw-fade-up kw-delay-1">
                    <span class="kw-section-label">Our Story</span>
                    <h2 class="kw-section-title mt-2 mb-4">Rooted in Ancient Wisdom,<br>Trusted by Modern India</h2>
                    <div class="kw-divider mb-4"></div>
                    <p class="kw-section-sub mb-4">KemtexWellness was born from a passion for authentic Ayurvedic healing.
                        We believe that nature holds the most powerful remedies — and that every Indian household deserves
                        access to pure, clinically-verified herbal products.</p>

                    <div class="kw-about-feature">
                        <div class="kw-af-icon"><i class="fas fa-seedling"></i></div>
                        <div class="kw-af-text">
                            <h6>Farm-to-Bottle Integrity</h6>
                            <p>Herbs sourced from certified organic farms across Kerala, Uttarakhand &amp; Himachal Pradesh.
                            </p>
                        </div>
                    </div>
                    <div class="kw-about-feature">
                        <div class="kw-af-icon"><i class="fas fa-flask"></i></div>
                        <div class="kw-af-text">
                            <h6>Science-Backed Formulations</h6>
                            <p>Developed by qualified Ayurvedic Vaidyas and modern pharmacologists for maximum efficacy.</p>
                        </div>
                    </div>
                    <div class="kw-about-feature">
                        <div class="kw-af-icon"><i class="fas fa-award"></i></div>
                        <div class="kw-af-text">
                            <h6>Triple Certified Quality</h6>
                            <p>FSSAI, GMP &amp; ISO 9001 — manufactured in state-of-the-art facilities.</p>
                        </div>
                    </div>

                    <a href="{{ route('about') }}" class="kw-btn-primary mt-3" style="font-size:.9rem;padding:12px 30px">
                        Learn Our Story <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================
     7. CTA BANNER
     ================================================================ --}}
    <section class="kw-section-sm kw-bg-cream">
        <div class="container">
            <div class="kw-cta-box">
                <div class="row align-items-center">
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <span class="kw-section-label">Ready to Heal?</span>
                        <h2>Start Your Natural Healing Journey Today</h2>
                        <p>Take our free 2-minute Dosha Quiz and receive personalised product recommendations from our
                            Ayurvedic experts — completely free.</p>
                        <div class="d-flex flex-wrap" style="gap:14px">
                            <a href="{{ route('products') }}" class="kw-btn-primary">
                                🌿 Take the Dosha Quiz
                            </a>
                            <a href="{{ route('contact') }}" class="kw-btn-outline">
                                Talk to a Vaidya
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="kw-cta-phone">
                            <div class="kw-cta-phone-icon">📞</div>
                            <div class="kw-cta-phone-label">Wellness Helpline</div>
                            <div class="kw-cta-phone-num">+91-456-6588</div>
                            <div class="kw-cta-phone-hours">Mon – Sat · 9 AM – 6 PM</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        $(function() {
            // Testimonial slider (Slick)
            if ($.fn.slick) {
                $('.kw-testi-slider').slick({
                    dots: true,
                    arrows: false,
                    infinite: true,
                    speed: 500,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    responsive: [{
                            breakpoint: 992,
                            settings: {
                                slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 576,
                            settings: {
                                slidesToShow: 1
                            }
                        }
                    ]
                });
            }

            // Counter animation
            if ($.fn.counterUp) {
                $('.counter-stat').counterUp({
                    delay: 10,
                    time: 1200
                });
            }

            // Scroll-triggered fade-up
            var $faders = $('.kw-fade-up');
            if ('IntersectionObserver' in window) {
                var obs = new IntersectionObserver(function(entries) {
                    entries.forEach(function(e) {
                        if (e.isIntersecting) {
                            e.target.style.animationPlayState = 'running';
                            obs.unobserve(e.target);
                        }
                    });
                }, {
                    threshold: 0.15
                });
                $faders.css('animation-play-state', 'paused').each(function() {
                    obs.observe(this)
                });
            }
        });
    </script>
@endsection
