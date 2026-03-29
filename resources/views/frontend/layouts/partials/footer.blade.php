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
                    <h4 class="text-capitalize mb-4">Join Our Community</h4>
                    <p>Subscribe to get exclusive training, success tips, and income opportunities delivered to your
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
                    <h6><a href="mailto:kemtexwellness@gmail.com">kemtexwellness@gmail.com</a></h6>
                    <a href="tel:+91-456-6588"><span class="text-color h4">+91-456-6588</span></a>
                </div>
            </div>
        </div>

        <div class="footer-btm pt-4">
            <div class="row">
                <div class="col-lg-6">
                    <div class="copyright">
                        Copyright &copy; {{ date('Y') }}, Designed &amp; Developed by <a href="#">Deepak</a>
                    </div>
                </div>
                <div class="col-lg-6 text-left text-lg-right">
                    <ul class="list-inline footer-socials">
                        <li class="list-inline-item"><a href="https://www.facebook.com/"><i
                                    class="fab fa-facebook-f mr-2"></i>Facebook</a></li>
                        <li class="list-inline-item"><a href="https://twitter.com/"><i
                                    class="fab fa-twitter mr-2"></i>Twitter</a></li>
                        <li class="list-inline-item"><a href="https://www.pinterest.com/"><i
                                    class="fab fa-pinterest-p mr-2"></i>Pinterest</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
