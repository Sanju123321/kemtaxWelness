@extends('frontend.layouts.master')

@section('title', 'Contact Us')
@section('meta_description',
    'Get in touch with KemtexWellness for product enquiries, support and wellness
    consultations.')

@section('content')

    <section class="py-5 bg-success text-white">
        <div class="container text-center">
            <h1 class="fw-bold">Contact Us</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-75">Home</a></li>
                    <li class="breadcrumb-item active text-white">Contact</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-5">

                {{-- Contact Info --}}
                <div class="col-lg-4">
                    <h4 class="fw-bold mb-4">Get In Touch</h4>
                    <div class="d-flex gap-3 mb-4">
                        <div class="flex-shrink-0 rounded-circle bg-success text-white d-flex align-items-center justify-content-center"
                            style="width:48px;height:48px;">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-1">Address</h6>
                            <p class="text-muted small mb-0">123 Wellness Street, Health City, HC 00100</p>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mb-4">
                        <div class="flex-shrink-0 rounded-circle bg-success text-white d-flex align-items-center justify-content-center"
                            style="width:48px;height:48px;">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-1">Phone</h6>
                            <p class="text-muted small mb-0">+1 800 KEMTEX (Mon–Fri, 9am–6pm)</p>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mb-4">
                        <div class="flex-shrink-0 rounded-circle bg-success text-white d-flex align-items-center justify-content-center"
                            style="width:48px;height:48px;">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-1">Email</h6>
                            <p class="text-muted small mb-0">info@kemtexwellness.com</p>
                        </div>
                    </div>
                </div>

                {{-- Contact Form --}}
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-4">Send Us a Message</h4>
                            <form action="{{ route('contact.send') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Full Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror" placeholder="John Doe"
                                            value="{{ old('name') }}" required />
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Email Address <span
                                                class="text-danger">*</span></label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="john@example.com" value="{{ old('email') }}" required />
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Phone</label>
                                        <input type="tel" name="phone" class="form-control"
                                            placeholder="+1 234 567 8900" value="{{ old('phone') }}" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Subject</label>
                                        <input type="text" name="subject" class="form-control"
                                            placeholder="How can we help?" value="{{ old('subject') }}" />
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Message <span
                                                class="text-danger">*</span></label>
                                        <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="5"
                                            placeholder="Write your message here..." required>{{ old('message') }}</textarea>
                                        @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success px-5">
                                            <i class="bi bi-send me-2"></i>Send Message
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
