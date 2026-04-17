<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="KemtexWellness Admin" />
    <title>@yield('title', 'Auth') - KemtexWellness</title>
    <link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    @stack('styles')
    <style>
        /* ── Auth page base ── */
        body.admin-auth {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
            background-attachment: fixed;
        }

        /* animated floating circles */
        body.admin-auth::before,
        body.admin-auth::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            opacity: .07;
            pointer-events: none;
        }

        body.admin-auth::before {
            width: 600px;
            height: 600px;
            background: #3b82f6;
            top: -150px;
            left: -150px;
            animation: floatBlob 12s ease-in-out infinite alternate;
        }

        body.admin-auth::after {
            width: 400px;
            height: 400px;
            background: #8b5cf6;
            bottom: -100px;
            right: -80px;
            animation: floatBlob 9s ease-in-out infinite alternate-reverse;
        }

        @keyframes floatBlob {
            from {
                transform: translate(0, 0) scale(1);
            }

            to {
                transform: translate(40px, 30px) scale(1.15);
            }
        }

        /* ── Wrapper ── */
        .auth-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        /* ── Card ── */
        .auth-card {
            width: 100%;
            max-width: 460px;
            background: rgba(255, 255, 255, .04);
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0, 0, 0, .5);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            animation: slideUp .45s cubic-bezier(.22, 1, .36, 1) both;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(28px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ── Card header ── */
        .auth-header {
            background: linear-gradient(135deg, #1e40af 0%, #4f46e5 100%);
            padding: 2.4rem 2rem 2rem;
            text-align: center;
            position: relative;
        }

        .auth-header .brand-icon {
            width: 64px;
            height: 64px;
            background: rgba(255, 255, 255, .15);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: .9rem;
            border: 2px solid rgba(255, 255, 255, .25);
        }

        .auth-header h4 {
            color: #fff;
            font-size: 1.35rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: -.3px;
        }

        .auth-header small {
            color: rgba(255, 255, 255, .65);
            font-size: .82rem;
        }

        /* ── Card body ── */
        .auth-body {
            padding: 2rem 2rem 1.5rem;
            background: #fff;
        }

        /* ── Input group overrides ── */
        .auth-body .input-group-text {
            background: #f8fafc;
            border-right: none;
            color: #64748b;
        }

        .auth-body .form-control {
            border-left: none;
            background: #f8fafc;
            padding: .72rem 1rem;
            font-size: .95rem;
            transition: box-shadow .2s, border-color .2s;
        }

        .auth-body .form-control:focus {
            box-shadow: 0 0 0 3px rgba(79, 70, 229, .18);
            border-color: #4f46e5;
            background: #fff;
        }

        .auth-body .form-control.is-invalid {
            border-left: none;
        }

        .auth-body .input-group:focus-within .input-group-text {
            border-color: #4f46e5;
            background: #fff;
        }

        /* show/hide password toggle */
        .btn-eye {
            background: #f8fafc;
            border-left: none;
            border-color: #dee2e6;
            color: #94a3b8;
        }

        .btn-eye:hover {
            background: #e2e8f0;
            color: #4f46e5;
            border-color: #dee2e6;
        }

        /* ── Inputs label ── */
        .input-label {
            font-size: .82rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: .35rem;
            display: block;
        }

        /* ── Divider ── */
        .auth-divider {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 1.25rem 0;
        }

        /* ── Remember me ── */
        .form-check-input:checked {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }

        /* ── Buttons ── */
        .btn-auth-primary {
            background: linear-gradient(135deg, #1e40af, #4f46e5);
            border: none;
            color: #fff;
            padding: .65rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            letter-spacing: .3px;
            transition: transform .15s, box-shadow .15s;
        }

        .btn-auth-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, .4);
            color: #fff;
        }

        .btn-auth-warning {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            border: none;
            color: #fff;
            padding: .65rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            letter-spacing: .3px;
            transition: transform .15s, box-shadow .15s;
        }

        .btn-auth-warning:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(245, 158, 11, .4);
            color: #fff;
        }

        .btn-auth-success {
            background: linear-gradient(135deg, #059669, #10b981);
            border: none;
            color: #fff;
            padding: .65rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            transition: transform .15s, box-shadow .15s;
        }

        .btn-auth-success:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, .4);
            color: #fff;
        }

        /* ── Card footer ── */
        .auth-footer-card {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: .9rem 2rem;
            text-align: center;
        }

        /* ── Page footer ── */
        footer.auth-page-footer {
            padding: 1.1rem 2rem;
            background: rgba(0, 0, 0, .25);
            backdrop-filter: blur(8px);
        }

        footer.auth-page-footer a,
        footer.auth-page-footer span {
            color: rgba(255, 255, 255, .5) !important;
            font-size: .8rem;
            text-decoration: none;
        }

        footer.auth-page-footer a:hover {
            color: rgba(255, 255, 255, .85) !important;
        }

        /* ── Back link ── */
        .back-link {
            font-size: .85rem;
            color: #64748b;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            transition: color .15s;
        }

        .back-link:hover {
            color: #4f46e5;
        }

        /* ── Alert tweaks ── */
        .auth-body .alert {
            border-radius: 10px;
            font-size: .875rem;
            padding: .75rem 1rem;
        }

        /* ── Responsive ── */
        @media (max-width: 479px) {
            .auth-card {
                border-radius: 14px;
            }

            .auth-header {
                padding: 1.8rem 1.25rem 1.5rem;
            }

            .auth-body {
                padding: 1.5rem 1.25rem 1.25rem;
            }

            .auth-footer-card {
                padding: .75rem 1.25rem;
            }
        }
    </style>
</head>

<body class="admin-auth">
    <div class="auth-wrapper">
        @yield('content')
    </div>
    <footer class="auth-page-footer">
        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between gap-1">
            <span>&copy; {{ date('Y') }} <strong style="color:rgba(255,255,255,.7)">KemtexWellness</strong>. All
                rights reserved.</span>
            <span>
                <a href="{{ route('about') }}">Privacy Policy</a>
                <span class="mx-2">&middot;</span>
                <a href="{{ route('about') }}">Terms &amp; Conditions</a>
            </span>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('backend/js/scripts.js') }}"></script>
    @stack('scripts')
</body>

</html>
