<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Income Cap Warning</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .wrapper {
            max-width: 600px;
            margin: 0 auto;
            padding: 30px 16px;
        }

        .card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .08);
        }

        .header {
            background: linear-gradient(135deg, #e67e22 0%, #d35400 100%);
            padding: 32px 28px;
            text-align: center;
            color: #fff;
        }

        .header h1 {
            margin: 0 0 6px;
            font-size: 22px;
            font-weight: 800;
        }

        .header p {
            margin: 0;
            font-size: 14px;
            opacity: .9;
        }

        .body {
            padding: 28px;
        }

        .hi {
            font-size: 16px;
            color: #333;
            margin-bottom: 18px;
        }

        .progress-wrap {
            background: #f0f0f0;
            border-radius: 20px;
            height: 20px;
            margin: 16px 0 6px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            border-radius: 20px;
            background: linear-gradient(90deg, #f39c12, #e74c3c);
            transition: width .4s;
        }

        .progress-label {
            font-size: 12px;
            color: #888;
            margin-bottom: 18px;
        }

        .stat-row {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }

        .stat-box {
            flex: 1;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 14px;
            text-align: center;
        }

        .stat-box .val {
            font-size: 1.3rem;
            font-weight: 800;
            color: #e74c3c;
        }

        .stat-box .lbl {
            font-size: 11px;
            color: #888;
            font-weight: 600;
            text-transform: uppercase;
            margin-top: 4px;
        }

        .alert-text {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 8px;
            padding: 14px 16px;
            font-size: 14px;
            color: #856404;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        @if ($nextPlan)
            .upgrade-box {
                background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
                border-radius: 10px;
                padding: 20px;
                color: #fff;
                margin-bottom: 20px;
            }

            .upgrade-box h3 {
                margin: 0 0 8px;
                font-size: 16px;
                font-weight: 800;
            }

            .upgrade-box p {
                margin: 0 0 14px;
                font-size: 13px;
                opacity: .9;
            }

            .upgrade-box table {
                width: 100%;
                font-size: 13px;
            }

            .upgrade-box td {
                padding: 4px 0;
            }

            .upgrade-box td:last-child {
                text-align: right;
                font-weight: 700;
            }
        @endif
        .btn {
            display: block;
            text-align: center;
            background: linear-gradient(135deg, #28a745, #1e7e34);
            color: #fff !important;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 700;
            margin: 20px 0;
        }

        .footer {
            background: #f8f9fa;
            padding: 16px 28px;
            text-align: center;
            font-size: 12px;
            color: #aaa;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="card">
            {{-- Header --}}
            <div class="header">
                <h1>⚠️ Daily Cap Warning</h1>
                <p>Your earnings are approaching today's limit — act before midnight!</p>
            </div>

            {{-- Body --}}
            <div class="body">
                <p class="hi">Hi <strong>{{ $user->name }}</strong>,</p>

                <p style="color:#555;font-size:14px;line-height:1.7;">
                    You are on <strong>{{ $plan->name }}</strong> with a <strong>daily earning cap of
                        ₹{{ number_format($dailyCap) }}</strong>.
                    You have earned <strong style="color:#e74c3c;">₹{{ number_format($todayEarned, 2) }}
                        ({{ $percentUsed }}%)</strong> of your daily cap today.
                    Any income above ₹{{ number_format($dailyCap) }} today will be <strong>lost to the company</strong>.
                </p>

                {{-- Progress bar --}}
                <div class="progress-wrap">
                    <div class="progress-bar" style="width:{{ min($percentUsed, 100) }}%;"></div>
                </div>
                <div class="progress-label">
                    ₹{{ number_format($todayEarned, 2) }} earned today &nbsp;/&nbsp; ₹{{ number_format($dailyCap) }}
                    daily cap
                </div>

                {{-- Stats --}}
                <div class="stat-row">
                    <div class="stat-box">
                        <div class="val">₹{{ number_format($todayEarned, 2) }}</div>
                        <div class="lbl">Earned Today</div>
                    </div>
                    <div class="stat-box">
                        <div class="val" style="color:#28a745;">
                            ₹{{ number_format(max(0, $dailyCap - $todayEarned), 2) }}</div>
                        <div class="lbl">Remaining Today</div>
                    </div>
                    <div class="stat-box">
                        <div class="val" style="color:#3498db;">₹{{ number_format($totalEarned, 2) }}</div>
                        <div class="lbl">Total Earned</div>
                    </div>
                </div>

                <div class="alert-text">
                    🕛 <strong>Midnight Deadline:</strong> All unused daily cap resets at 12:00 AM.
                    Income above your cap goes to the company account.
                    <strong>Upgrade your plan before midnight to increase your daily earning limit!</strong>
                </div>

                @if ($nextPlan)
                    {{-- Upgrade box --}}
                    <div class="upgrade-box">
                        <h3>🚀 Upgrade to {{ $nextPlan->name }} — Earn More!</h3>
                        <p>Unlock higher caps and keep more of your hard-earned income.</p>
                        <table>
                            <tr>
                                <td>Current Plan ({{ $plan->name }})</td>
                                <td>Daily Cap: ₹{{ number_format($plan->daily_cap) }} &nbsp;|&nbsp; Total:
                                    ₹{{ number_format($plan->total_cap) }}</td>
                            </tr>
                            <tr>
                                <td>Upgrade to ({{ $nextPlan->name }})</td>
                                <td>Daily Cap: ₹{{ number_format($nextPlan->daily_cap) }} &nbsp;|&nbsp; Total:
                                    ₹{{ number_format($nextPlan->total_cap) }}</td>
                            </tr>
                            <tr>
                                <td>Upgrade Price</td>
                                <td>₹{{ number_format($nextPlan->price) }}</td>
                            </tr>
                        </table>
                    </div>
                @endif

                <a href="{{ url('/member/dashboard') }}" class="btn">
                    Go to Dashboard &amp; Upgrade Now →
                </a>

                <p style="font-size:13px;color:#888;text-align:center;">
                    This notification was sent because your earnings reached {{ $percentUsed }}% of your daily cap.
                </p>
            </div>

            {{-- Footer --}}
            <div class="footer">
                &copy; {{ date('Y') }} KemtexWellness. All rights reserved.<br>
                If you did not expect this email, please contact support.
            </div>
        </div>
    </div>
</body>

</html>
