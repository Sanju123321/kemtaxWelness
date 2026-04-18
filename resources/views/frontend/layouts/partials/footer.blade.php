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

                <style>
                    .footer-social-icons {
                        display: flex;
                        flex-direction: row;
                        flex-wrap: nowrap;
                        align-items: center;
                        gap: 12px;
                        justify-content: center;
                        margin-top: 6px;
                    }

                    @media (min-width: 992px) {
                        .footer-social-icons {
                            justify-content: center;
                        }
                    }

                    .social-icon-btn {
                        width: 44px;
                        height: 44px;
                        min-width: 44px;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 1.05rem;
                        color: #fff !important;
                        text-decoration: none !important;
                        transition: transform 0.25s, box-shadow 0.25s;
                        flex-shrink: 0;
                        line-height: 1;
                        box-sizing: border-box;
                        overflow: hidden;
                    }

                    .social-icon-btn:hover {
                        transform: translateY(-4px);
                        box-shadow: 0 6px 18px rgba(0, 0, 0, .35);
                        color: #fff !important;
                    }

                    .social-icon-btn.facebook {
                        background: #1877f2;
                    }

                    .social-icon-btn.instagram {
                        background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
                    }

                    .social-icon-btn.youtube {
                        background: #ff0000;
                    }
                </style>
            </div>
        </div>
    </div>
</footer>
