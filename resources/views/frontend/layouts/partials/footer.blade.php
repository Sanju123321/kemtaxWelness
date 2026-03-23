<footer class="bg-dark text-white pt-5 pb-3">
    <div class="container">
        <div class="row g-4 mb-4">

            {{-- Brand & Description --}}
            <div class="col-lg-4 col-md-6">
                <h5 class="fw-bold text-white mb-3">
                    Kemtex<span class="text-success">Wellness</span>
                </h5>
                <p class="text-white-50 small">
                    KemtexWellness is your trusted partner in natural health and wellness.
                    We provide premium quality supplements, herbal products, and wellness solutions
                    to help you live a healthier, happier life.
                </p>
                <div class="d-flex gap-2 mt-3">
                    <a href="#" class="btn btn-sm btn-outline-light rounded-circle" style="width:36px;height:36px;">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-light rounded-circle"
                        style="width:36px;height:36px;">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-light rounded-circle"
                        style="width:36px;height:36px;">
                        <i class="bi bi-twitter-x"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-light rounded-circle"
                        style="width:36px;height:36px;">
                        <i class="bi bi-linkedin"></i>
                    </a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold text-white mb-3 text-uppercase small">Quick Links</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('home') }}"
                            class="text-white-50 text-decoration-none hover-text-white">Home</a></li>
                    <li class="mb-2"><a href="{{ route('about') }}" class="text-white-50 text-decoration-none">About
                            Us</a></li>
                    <li class="mb-2"><a href="{{ route('products') }}"
                            class="text-white-50 text-decoration-none">Products</a></li>
                    <li class="mb-2"><a href="{{ route('services') }}"
                            class="text-white-50 text-decoration-none">Services</a></li>
                    <li class="mb-2"><a href="{{ route('blog') }}" class="text-white-50 text-decoration-none">Blog</a>
                    </li>
                    <li class="mb-2"><a href="{{ route('contact') }}"
                            class="text-white-50 text-decoration-none">Contact</a></li>
                </ul>
            </div>

            {{-- Categories --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold text-white mb-3 text-uppercase small">Categories</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Supplements</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Herbal Teas</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Vitamins</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Wellness Kits</a>
                    </li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Detox Products</a>
                    </li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Skincare</a></li>
                </ul>
            </div>

            {{-- Newsletter & Contact --}}
            <div class="col-lg-4 col-md-6">
                <h6 class="fw-bold text-white mb-3 text-uppercase small">Stay Updated</h6>
                <p class="text-white-50 small mb-3">Subscribe to our newsletter for health tips and exclusive offers.
                </p>
                <form action="#" method="POST" class="mb-3">
                    @csrf
                    <div class="input-group input-group-sm">
                        <input type="email" class="form-control" placeholder="Your email address" required />
                        <button class="btn btn-success" type="submit">Subscribe</button>
                    </div>
                </form>
                <ul class="list-unstyled small text-white-50">
                    <li class="mb-2"><i class="bi bi-geo-alt me-2 text-success"></i>123 Wellness St, Health City, HC
                        00100</li>
                    <li class="mb-2"><i class="bi bi-telephone me-2 text-success"></i>+1 800 KEMTEX</li>
                    <li class="mb-2"><i class="bi bi-envelope me-2 text-success"></i>info@kemtexwellness.com</li>
                </ul>
            </div>

        </div>{{-- /row --}}

        <hr class="border-secondary" />

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="small text-white-50 mb-0">
                    &copy; {{ date('Y') }} <strong class="text-white">KemtexWellness</strong>. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <a href="#" class="text-white-50 text-decoration-none small me-3">Privacy Policy</a>
                <a href="#" class="text-white-50 text-decoration-none small me-3">Terms of Service</a>
                <a href="#" class="text-white-50 text-decoration-none small">Sitemap</a>
            </div>
        </div>

    </div>
</footer>
