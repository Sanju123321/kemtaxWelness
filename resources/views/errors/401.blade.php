<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>401 Unauthorized | KemtexWellness</title>
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
                            <div class="display-1 fw-bold text-warning">401</div>
                            <p class="lead fw-normal">Unauthorized Access</p>
                            <p class="text-muted mb-4">
                                You do not have permission to access this resource.<br>
                                Please log in with an account that has sufficient privileges.
                            </p>
                            <a href="{{ route('login') }}" class="btn btn-warning me-2">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
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
