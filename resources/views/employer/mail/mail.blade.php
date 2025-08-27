<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Verify Your Email - MangagawangPinoyCompany</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body style="margin: 0; font-family: 'Inter', sans-serif; background: #f3f4f6; color: #1f2937;">

    <div
        style="max-width: 620px; margin: 40px auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.07);">
        <!-- Header -->
        <div
            style="background: linear-gradient(90deg, #3b82f6, #8b5cf6); color: white; padding: 40px 30px; text-align: center;">
            <img src="{{ $message->embed($logo) }}" alt="Mangagawang Pinoy Logo"
                style="height: 95px; margin-bottom: 20px;">
            <h1 style="margin: 0; font-size: 26px;">MangagawangPinoyCompany</h1>
            <p style="margin: 5px 0 0; font-weight: 300;">Your trusted partner in local workforce hiring</p>
        </div>

        <!-- Body -->
        <div style="padding: 30px;">
            <h2 style="margin-top: 0; font-size: 22px;">Hey there, 👋</h2>
            <p style="font-size: 16px; line-height: 1.6; margin-bottom: 30px;">
                Thanks for signing up at <strong>MangagawangPinoyCompany</strong>! To activate your account and complete
                the registration, please verify your email by clicking the button below.
            </p>

            <div style="text-align: center;">
                <a href="{{ $verifyUrl }}"
                    style="display: inline-block; background: linear-gradient(90deg, #3b82f6, #8b5cf6); color: white; padding: 14px 32px; font-size: 16px; font-weight: 600; border-radius: 50px; text-decoration: none; transition: all 0.3s;">
                    <i class="fas fa-check-circle" style="margin-right: 8px;"></i> Verify My Email
                </a>
            </div>

            <div
                style="margin-top: 40px; padding: 20px; background: #fef3c7; border: 1px solid #fde68a; border-radius: 10px; font-size: 14px; display: flex; align-items: center;">
                <i class="fas fa-shield-alt" style="margin-right: 12px; color: #d97706;"></i>
                <span>
                    If you did not sign up for <strong>MangagawangPinoyCompany</strong>, please disregard this email.
                </span>
            </div>
        </div>

        <!-- Footer -->
        <div style="background: #f9fafb; text-align: center; padding: 25px;">
            <p style="margin: 0; font-size: 14px; color: #6b7280;">
                &copy; {{ date('Y') }} <strong>MangagawangPinoyCompany</strong>. All rights reserved.
            </p>
            <p style="margin: 5px 0 0; font-size: 13px; color: #9ca3af;">Connecting Filipino talent with real
                opportunities.</p>
        </div>
    </div>
</body>

</html>
