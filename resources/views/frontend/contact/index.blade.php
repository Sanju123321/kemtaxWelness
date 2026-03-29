@extends('frontend.layouts.master')

@section('title', 'Contact Us - KemtexWellness')

@section('content')

    <section class="page-title bg-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block text-center">
                        <span class="text-white">💼 Opportunity</span>
                        <h1 class="text-capitalize mb-4 text-lg">Let's Build Your Success Story</h1>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                            <li class="list-inline-item"><span class="text-white">/</span></li>
                            <li class="list-inline-item text-white-50">Join Us</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Start -->
    <section class="contact-form-wrap section">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <form id="contact-form" class="contact__form" method="POST" action="{{ route('contact.send') }}">
                        @csrf
                        <h3 class="text-md mb-4">🚀 Start Your Journey</h3>
                        <p class="mb-4 text-muted">Tell us about yourself and we'll guide you to the right opportunity</p>

                        <div class="form-group">
                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Your Full Name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="Email Address" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input name="phone" type="text" class="form-control" placeholder="Phone Number"
                                value="{{ old('phone') }}">
                        </div>
                        <div class="form-group">
                            <select name="interest" class="form-control">
                                <option value="">Select Your Interest Level</option>
                                <option value="curious" {{ old('interest') == 'curious' ? 'selected' : '' }}>Just Curious
                                </option>
                                <option value="serious" {{ old('interest') == 'serious' ? 'selected' : '' }}>Serious About
                                    Income</option>
                                <option value="fulltime" {{ old('interest') == 'fulltime' ? 'selected' : '' }}>Looking for
                                    Full-Time Opportunity</option>
                                <option value="already" {{ old('interest') == 'already' ? 'selected' : '' }}>Already in MLM
                                </option>
                            </select>
                        </div>
                        <div class="form-group-2 mb-4">
                            <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="3"
                                placeholder="Tell us your goals or questions...">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="btn btn-main" name="submit" type="submit">Get Started Now</button>
                    </form>
                </div>

                <div class="col-lg-5 col-sm-12">
                    <div class="contact-content pl-lg-5 mt-5 mt-lg-0">
                        <span class="text-muted">💎 Ready to Transform Your Life?</span>
                        <h2 class="mb-5 mt-2">Fast-Track Your Success with Our Support Team</h2>

                        <ul class="address-block list-unstyled">
                            <li><i class="ti-location-pin mr-3 text-color"></i><strong>Headquarter:</strong> Mumbai, India
                            </li>
                            <li><i class="ti-email mr-3 text-color"></i><strong>Email:</strong> <a
                                    href="mailto:kemtexwellness@gmail.com">kemtexwellness@gmail.com</a></li>
                            <li><i class="ti-mobile mr-3 text-color"></i><strong>Enrollment Line:</strong> <a
                                    href="tel:+919999999999">+91-9999-999-999</a></li>
                            <li><i class="ti-time mr-3 text-color"></i><strong>Hours:</strong> Mon-Fri 10AM-8PM, Sat
                                11AM-6PM</li>
                        </ul>

                        <div class="mt-4 p-3 rounded" style="background-color:#fff3cd;">
                            <p class="mb-0"><strong>💡 Tip:</strong> Our team typically responds within 2 hours. Have your
                                questions ready!</p>
                        </div>

                        <ul class="social-icons list-inline mt-5">
                            <li class="list-inline-item"><a href="http://www.facebook.com" title="Facebook"><i
                                        class="fab fa-facebook-f"></i></a></li>
                            <li class="list-inline-item"><a href="http://www.whatsapp.com" title="WhatsApp"><i
                                        class="fab fa-whatsapp"></i></a></li>
                            <li class="list-inline-item"><a href="http://www.instagram.com" title="Instagram"><i
                                        class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="google-map">
        <div id="map" data-latitude="19.076090" data-longitude="72.877426"
            data-marker="{{ asset('frontend/images/marker.png') }}" data-marker-name="KemtexWellness"></div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('frontend/plugins/google-map/map.js') }}" defer></script>
@endpush
