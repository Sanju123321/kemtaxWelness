<footer class="mt-auto" style="background:#1e1e2d;color:#9ca3af;">
    <div class="container-fluid px-4">
        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between gap-2 py-3"
            style="border-top:1px solid rgba(255,255,255,.07);">
            <div class="d-flex align-items-center gap-2 text-center text-sm-start">
                <span class="fw-bold" style="color:#a5b4fc;font-size:.875rem;"><i
                        class="fas fa-leaf me-1"></i>KemtexWellness</span>
                <span style="color:#374151;">|</span>
                <span class="small">&copy; {{ date('Y') }} All rights reserved.</span>
            </div>
            <div class="d-flex align-items-center gap-3 text-center text-sm-end small">
                <a href="{{ route('about') }}" style="color:#9ca3af;text-decoration:none;"
                    onmouseover="this.style.color='#a5b4fc'" onmouseout="this.style.color='#9ca3af'">Privacy Policy</a>
                <a href="{{ route('about') }}" style="color:#9ca3af;text-decoration:none;"
                    onmouseover="this.style.color='#a5b4fc'" onmouseout="this.style.color='#9ca3af'">Terms &amp;
                    Conditions</a>
                <span class="badge"
                    style="background:rgba(165,180,252,.15);color:#a5b4fc;font-size:.7rem;font-weight:500;">Admin
                    Panel</span>
            </div>
        </div>
    </div>
</footer>
