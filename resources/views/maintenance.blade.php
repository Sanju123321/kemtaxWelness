<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Maintenance — KemtexWellness</title>
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            overflow: hidden;
        }

        /* Animated background circles */
        .bg-circles {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.08;
            animation: float 8s ease-in-out infinite;
        }

        .circle:nth-child(1) {
            width: 400px;
            height: 400px;
            background: #6366f1;
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }

        .circle:nth-child(2) {
            width: 300px;
            height: 300px;
            background: #8b5cf6;
            bottom: -80px;
            right: -80px;
            animation-delay: 2s;
        }

        .circle:nth-child(3) {
            width: 200px;
            height: 200px;
            background: #ec4899;
            top: 40%;
            left: 60%;
            animation-delay: 4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-30px) scale(1.05);
            }
        }

        /* Gear animation */
        .gear-wrapper {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 2rem;
        }

        .gear {
            font-size: 3rem;
            display: inline-block;
            animation: spin 4s linear infinite;
        }

        .gear.reverse {
            animation-direction: reverse;
            animation-duration: 3s;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Card */
        .card {
            position: relative;
            z-index: 1;
            text-align: center;
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            max-width: 520px;
            width: 90%;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
        }

        .badge {
            display: inline-block;
            background: rgba(99, 102, 241, 0.3);
            border: 1px solid rgba(99, 102, 241, 0.5);
            color: #a5b4fc;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 6px 18px;
            border-radius: 999px;
            margin-bottom: 1.5rem;
        }

        h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(to right, #c7d2fe, #e9d5ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        p {
            color: rgba(255, 255, 255, 0.65);
            font-size: 1rem;
            line-height: 1.7;
            margin-bottom: 2rem;
        }

        /* Progress bar */
        .progress-label {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 6px;
        }

        .progress-bar-outer {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 999px;
            height: 6px;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .progress-bar-inner {
            height: 100%;
            width: 65%;
            background: linear-gradient(to right, #6366f1, #a78bfa);
            border-radius: 999px;
            animation: progress-pulse 2.5s ease-in-out infinite;
        }

        @keyframes progress-pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        /* Contact */
        .contact-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.875rem;
        }

        .contact-row a {
            color: #a5b4fc;
            text-decoration: none;
            font-weight: 500;
        }

        .contact-row a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="bg-circles">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>

    <div class="card">
        <div class="gear-wrapper">
            <span class="gear">⚙️</span>
            <span class="gear reverse">⚙️</span>
        </div>

        <div class="badge">Scheduled Maintenance</div>

        <h1>We'll be back soon!</h1>

        <p>
            KemtexWellness is currently undergoing scheduled maintenance to bring you a
            better experience. We apologize for the inconvenience and appreciate your patience.
        </p>

        <div class="progress-label">
            <span>Maintenance in progress</span>
            <span>Almost done...</span>
        </div>
        <div class="progress-bar-outer">
            <div class="progress-bar-inner"></div>
        </div>

        <div class="contact-row">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                viewBox="0 0 16 16">
                <path
                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383-4.708 2.825L15 11.105V5.383zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741z" />
            </svg>
            Need help? Contact us at
            <a href="mailto:{{ config('mail.from.address', 'support@kemtexwellness.com') }}">
                {{ config('mail.from.address', 'support@kemtexwellness.com') }}
            </a>
        </div>
    </div>

</body>

</html>
