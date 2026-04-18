<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Enquiry — {{ config('app.name') }}</title>
</head>

<body style="margin:0;padding:0;background-color:#f0f4ef;font-family:Georgia,'Times New Roman',serif;">

    <!-- Outer wrapper -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f0f4ef;padding:30px 0;">
        <tr>
            <td align="center">
                <table width="620" cellpadding="0" cellspacing="0" border="0"
                    style="max-width:620px;width:100%;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.10);">

                    <!-- HEADER -->
                    <tr>
                        <td style="background:linear-gradient(135deg,#1b5e35 0%,#2e7d4f 50%,#4caf76 100%);padding:0;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td
                                        style="padding:14px 32px 0;font-size:20px;letter-spacing:8px;color:rgba(255,255,255,0.20);text-align:center;">
                                        ❧ ✦ ❧ ✦ ❧ ✦ ❧
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 32px 0;text-align:center;">
                                        <div
                                            style="display:inline-block;width:68px;height:68px;background:rgba(255,255,255,0.15);border-radius:50%;line-height:68px;font-size:34px;border:2px solid rgba(255,255,255,0.35);">
                                            🌿</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 32px 4px;text-align:center;">
                                        <span
                                            style="font-family:Georgia,serif;font-size:28px;font-weight:bold;color:#fff;letter-spacing:1px;display:block;">{{ config('app.name') }}</span>
                                        <span
                                            style="font-family:Arial,sans-serif;font-size:11px;color:rgba(255,255,255,0.75);letter-spacing:3px;text-transform:uppercase;display:block;margin-top:3px;">Wellness
                                            &amp; Ayurveda</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding:10px 32px 16px;font-size:20px;letter-spacing:8px;color:rgba(255,255,255,0.20);text-align:center;">
                                        ❧ ✦ ❧ ✦ ❧ ✦ ❧
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- BANNER STRIP -->
                    <tr>
                        <td
                            style="background:#f7f3ec;border-bottom:2px solid #d4a84b;padding:14px 32px;text-align:center;">
                            <span
                                style="font-family:Arial,sans-serif;font-size:13px;font-weight:700;color:#7a5c1e;letter-spacing:2px;text-transform:uppercase;">
                                ✉&nbsp;&nbsp;New Contact Form Enquiry
                            </span>
                        </td>
                    </tr>

                    <!-- INTRO -->
                    <tr>
                        <td style="padding:28px 36px 8px;">
                            <p style="margin:0;font-family:Georgia,serif;font-size:15px;color:#4a3b2a;line-height:1.8;">
                                Namaste 🙏 — A visitor has reached out through the website contact form. Their details
                                are below.
                            </p>
                        </td>
                    </tr>

                    <!-- DIVIDER -->
                    <tr>
                        <td style="padding:12px 36px;">
                            <hr style="border:none;border-top:1px dashed #c8d5b9;margin:0;">
                        </td>
                    </tr>

                    <!-- DETAILS CARD -->
                    <tr>
                        <td style="padding:0 36px 8px;">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="background:#f9fbf7;border-radius:8px;border:1px solid #d6e8cc;border-collapse:collapse;">

                                <tr>
                                    <td width="110"
                                        style="padding:14px 18px;background:#eef5ea;font-family:Arial,sans-serif;font-size:10px;font-weight:700;color:#5a7a4a;letter-spacing:1.5px;text-transform:uppercase;vertical-align:top;border-bottom:1px solid #e0edd8;">
                                        Name</td>
                                    <td
                                        style="padding:14px 18px;font-family:Georgia,serif;font-size:15px;color:#2c2c2c;vertical-align:top;border-left:1px solid #d6e8cc;border-bottom:1px solid #e0edd8;">
                                        {{ $senderName }}</td>
                                </tr>

                                <tr>
                                    <td width="110"
                                        style="padding:14px 18px;background:#eef5ea;font-family:Arial,sans-serif;font-size:10px;font-weight:700;color:#5a7a4a;letter-spacing:1.5px;text-transform:uppercase;vertical-align:top;border-bottom:1px solid #e0edd8;">
                                        Email</td>
                                    <td
                                        style="padding:14px 18px;font-family:Arial,sans-serif;font-size:14px;vertical-align:top;border-left:1px solid #d6e8cc;border-bottom:1px solid #e0edd8;">
                                        <a href="mailto:{{ $senderEmail }}"
                                            style="color:#1b5e35;text-decoration:none;font-weight:600;">{{ $senderEmail }}</a>
                                    </td>
                                </tr>

                                @if ($phone)
                                    <tr>
                                        <td width="110"
                                            style="padding:14px 18px;background:#eef5ea;font-family:Arial,sans-serif;font-size:10px;font-weight:700;color:#5a7a4a;letter-spacing:1.5px;text-transform:uppercase;vertical-align:top;border-bottom:1px solid #e0edd8;">
                                            Phone</td>
                                        <td
                                            style="padding:14px 18px;font-family:Arial,sans-serif;font-size:14px;color:#2c2c2c;vertical-align:top;border-left:1px solid #d6e8cc;border-bottom:1px solid #e0edd8;">
                                            {{ $phone }}</td>
                                    </tr>
                                @endif

                                @if ($interest)
                                    <tr>
                                        <td width="110"
                                            style="padding:14px 18px;background:#eef5ea;font-family:Arial,sans-serif;font-size:10px;font-weight:700;color:#5a7a4a;letter-spacing:1.5px;text-transform:uppercase;vertical-align:top;border-bottom:1px solid #e0edd8;">
                                            Interest</td>
                                        <td
                                            style="padding:14px 18px;font-family:Arial,sans-serif;font-size:14px;color:#2c2c2c;vertical-align:top;border-left:1px solid #d6e8cc;border-bottom:1px solid #e0edd8;">
                                            {{ $interest }}</td>
                                    </tr>
                                @endif

                                <tr>
                                    <td width="110"
                                        style="padding:14px 18px;background:#eef5ea;font-family:Arial,sans-serif;font-size:10px;font-weight:700;color:#5a7a4a;letter-spacing:1.5px;text-transform:uppercase;vertical-align:top;">
                                        Message</td>
                                    <td style="padding:14px 18px;border-left:1px solid #d6e8cc;vertical-align:top;">
                                        <div
                                            style="font-family:Georgia,serif;font-size:14px;color:#333;line-height:1.9;border-left:3px solid #4caf76;padding-left:14px;white-space:pre-wrap;">
                                            {{ $userMessage }}</div>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                    <!-- CTA BUTTON -->
                    <tr>
                        <td style="padding:26px 36px 10px;text-align:center;">
                            <a href="mailto:{{ $senderEmail }}"
                                style="display:inline-block;background:linear-gradient(135deg,#1b5e35,#2e7d4f);color:#fff;font-family:Arial,sans-serif;font-size:14px;font-weight:700;padding:13px 36px;border-radius:30px;text-decoration:none;letter-spacing:0.8px;">
                                ✉&nbsp; Reply to {{ $senderName }}
                            </a>
                        </td>
                    </tr>

                    <!-- AYURVEDIC QUOTE -->
                    <tr>
                        <td style="padding:16px 36px 24px;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td
                                        style="background:linear-gradient(135deg,#fdfaf3,#fef6e4);border:1px solid #e8d8a0;border-radius:8px;padding:18px 24px;text-align:center;">
                                        <span
                                            style="font-family:Georgia,serif;font-size:14px;font-style:italic;color:#7a5c1e;line-height:1.8;display:block;">
                                            "The natural healing force within each one of us is the greatest force in
                                            getting well."
                                        </span>
                                        <span
                                            style="font-family:Arial,sans-serif;font-size:11px;color:#b8924a;margin-top:8px;display:inline-block;letter-spacing:1px;">—
                                            Ayurvedic Wisdom 🌸</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background:linear-gradient(135deg,#1b5e35,#2e7d4f);padding:22px 32px;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="text-align:center;">
                                        <span style="font-size:18px;letter-spacing:6px;">🌿 🌸 🌾 🌸 🌿</span><br>
                                        <span
                                            style="font-family:Arial,sans-serif;font-size:12px;color:rgba(255,255,255,0.85);line-height:1.9;display:block;margin-top:8px;">
                                            This email was sent from the contact form at <strong
                                                style="color:#fff;">{{ config('app.name') }}</strong>.<br>
                                            Replying will go directly to <strong
                                                style="color:#fff;">{{ $senderName }}</strong>.
                                        </span>
                                        <span
                                            style="font-family:Arial,sans-serif;font-size:10px;color:rgba(255,255,255,0.45);display:block;margin-top:10px;letter-spacing:1px;">
                                            © {{ date('Y') }} {{ config('app.name') }} &nbsp;·&nbsp;
                                            support@kemtexwellness.com
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>
