@php
    $toastMessages = collect([
        ['type' => 'success', 'message' => session('success')],
        ['type' => 'error', 'message' => session('error')],
        ['type' => 'warning', 'message' => session('warning')],
        ['type' => 'info', 'message' => session('status')],
    ])->filter(fn ($toast) => filled($toast['message']))->values();
@endphp

<style>
    .kw-toast-wrap {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10850;
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: min(360px, calc(100vw - 32px));
        pointer-events: none;
    }

    .kw-toast {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 14px 42px 14px 14px;
        border-radius: 8px;
        color: #1f2937;
        background: #fff;
        border-left: 5px solid #64748b;
        box-shadow: 0 12px 30px rgba(15, 23, 42, .18);
        font-size: 14px;
        line-height: 1.45;
        position: relative;
        overflow: hidden;
        pointer-events: auto;
        animation: kwToastIn .25s ease-out;
    }

    .kw-toast-success {
        border-left-color: #16a34a;
    }

    .kw-toast-error {
        border-left-color: #dc2626;
    }

    .kw-toast-warning {
        border-left-color: #f59e0b;
    }

    .kw-toast-info {
        border-left-color: #2563eb;
    }

    .kw-toast-icon {
        flex: 0 0 auto;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        margin-top: 1px;
    }

    .kw-toast-success .kw-toast-icon {
        background: #16a34a;
    }

    .kw-toast-error .kw-toast-icon {
        background: #dc2626;
    }

    .kw-toast-warning .kw-toast-icon {
        background: #f59e0b;
    }

    .kw-toast-info .kw-toast-icon {
        background: #2563eb;
    }

    .kw-toast-close {
        position: absolute;
        top: 8px;
        right: 10px;
        border: 0;
        background: transparent;
        color: #64748b;
        font-size: 20px;
        line-height: 1;
        cursor: pointer;
        padding: 2px 4px;
    }

    .kw-toast-message {
        margin: 0;
        padding-right: 4px;
        word-break: break-word;
    }

    .kw-toast.hide {
        animation: kwToastOut .2s ease-in forwards;
    }

    @keyframes kwToastIn {
        from {
            opacity: 0;
            transform: translateX(28px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes kwToastOut {
        to {
            opacity: 0;
            transform: translateX(28px);
        }
    }

    @media (max-width: 575.98px) {
        .kw-toast-wrap {
            top: 12px;
            right: 12px;
            left: 12px;
            width: auto;
        }
    }
</style>

<div class="kw-toast-wrap" id="kw-toast-wrap" aria-live="polite" aria-atomic="true"></div>

<script>
    (function() {
        const iconMap = {
            success: '+',
            error: '!',
            warning: '!',
            info: 'i'
        };

        function removeToast(toast) {
            if (!toast || toast.classList.contains('hide')) {
                return;
            }

            toast.classList.add('hide');
            setTimeout(function() {
                toast.remove();
            }, 220);
        }

        window.showToast = function(message, type) {
            const wrap = document.getElementById('kw-toast-wrap');
            const toastType = ['success', 'error', 'warning', 'info'].includes(type) ? type : 'info';

            if (!wrap || !message) {
                return;
            }

            const toast = document.createElement('div');
            toast.className = 'kw-toast kw-toast-' + toastType;
            toast.setAttribute('role', toastType === 'error' ? 'alert' : 'status');
            toast.innerHTML =
                '<span class="kw-toast-icon">' + iconMap[toastType] + '</span>' +
                '<p class="kw-toast-message"></p>' +
                '<button type="button" class="kw-toast-close" aria-label="Close notification">&times;</button>';

            toast.querySelector('.kw-toast-message').textContent = message;
            toast.querySelector('.kw-toast-close').addEventListener('click', function() {
                removeToast(toast);
            });

            wrap.appendChild(toast);
            setTimeout(function() {
                removeToast(toast);
            }, 5000);
        };

        document.addEventListener('DOMContentLoaded', function() {
            const serverToasts = @json($toastMessages);

            serverToasts.forEach(function(toast) {
                window.showToast(toast.message, toast.type);

                document.querySelectorAll('.alert').forEach(function(alertEl) {
                    if (alertEl.textContent.replace(/\s+/g, ' ').trim().includes(toast.message)) {
                        alertEl.remove();
                    }
                });
            });
        });
    })();
</script>
