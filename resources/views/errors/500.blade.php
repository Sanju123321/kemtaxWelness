<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>500 Server Error | KemtexWellness</title>
    <link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous" defer></script>
</head>

<body class="sb-nav-fixed">
    <div id="layoutError">
        <div id="layoutError_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center mt-5">
                            <div class="display-1 fw-bold text-danger">500</div>
                            <p class="lead fw-normal">Internal Server Error</p>
                            <p class="text-muted mb-4">
                                Something went wrong on our end. Please try again later.<br>
                                If the problem persists, please contact support.
                            </p>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left me-1"></i>Go Back
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-danger">
                                <i class="fas fa-home me-1"></i>Go Home
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutError_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; {{ date('Y') }} KemtexWellness</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('backend/js/scripts.js') }}"></script>
</body>

</html>
