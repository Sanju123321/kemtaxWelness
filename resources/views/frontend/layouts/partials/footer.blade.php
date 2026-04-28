<footer class="footer section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="widget">
                    <h4 class="text-capitalize mb-4">Company</h4>
                    <ul class="list-unstyled footer-menu lh-35">
                        <li><a href="{{ route('about') }}">Terms &amp; Conditions</a></li>
                        <li><a href="{{ route('about') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('contact') }}">Support</a></li>
                        <li><a href="{{ route('contact') }}">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="widget">
                    <h4 class="text-capitalize mb-4">Quick Links</h4>
                    <ul class="list-unstyled footer-menu lh-35">
                        <li><a href="{{ route('about') }}">About</a></li>
                        <li><a href="{{ route('services') }}">Services</a></li>
                        <li><a href="{{ route('pricing') }}">Pricing</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mx-auto">
                <div class="widget">
                    <h4 class="text-capitalize mb-4">Join Our Wellness Community</h4>
                    <p>Subscribe to get Ayurvedic wellness tips, dosha insights, and exclusive product offers delivered
                        to your
                        inbox</p>
                    <form action="#" class="sub-form">
                        <input type="email" class="form-control mb-3" placeholder="Enter your email...">
                        <a href="#" class="btn btn-main btn-small">Sign Up</a>
                    </form>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="widget">
                    <div class="logo mb-4">
                        <h3>kemtex<span>Wellness.</span></h3>
                    </div>
                    <h6><a href="mailto:support@kemtexwellness.com">support@kemtexwellness.com</a></h6>
                    <a href="tel:+91-456-6588"><span class="text-color h4">+91-456-6588</span></a>
                </div>
            </div>
        </div>

        <div class="footer-btm pt-4">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-left">
                    <div class="copyright">
                        Copyright &copy; {{ date('Y') }}, Designed &amp; Developed by <a href="#">Deepak</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center mt-3 mt-lg-0">
                    <div class="footer-social-icons">
                        <a href="https://www.facebook.com/" target="_blank" rel="noopener" aria-label="Facebook"
                            class="social-icon-btn facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.instagram.com/" target="_blank" rel="noopener" aria-label="Instagram"
                            class="social-icon-btn instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.youtube.com/" target="_blank" rel="noopener" aria-label="YouTube"
                            class="social-icon-btn youtube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer-btm {
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .footer-social-icons {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }

    .social-icon-btn {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff !important;
        font-size: 16px;
        text-decoration: none !important;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.24);
    }

    .social-icon-btn:hover {
        transform: translateY(-3px);
        color: #fff !important;
    }

    .social-icon-btn.facebook {
        background: #1877f2;
    }

    .social-icon-btn.instagram {
        background: linear-gradient(135deg, #f58529 0%, #dd2a7b 45%, #8134af 70%, #515bd4 100%);
    }

    .social-icon-btn.youtube {
        background: #ff0000;
    }
</style>
