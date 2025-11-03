<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Verification</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div
        style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">

        <div style="text-align: center;">
            <img src="{{ $message->embed($logo) }}" alt="Mangagawang Pinoy Logo"
                style="width: 110px; margin-bottom: 20px;">
        </div>

        <h2 style="color: #333333; text-align: center;">Reset Your Password</h2>

        <p style="color: #555555; font-size: 16px; line-height: 1.5;">
            Hi there,<br><br>
            We received a request to reset the password associated with your <strong>Mangagawang Pinoy</strong> account.
            To proceed, please use the verification code below:
        </p>

        <div style="text-align: center; margin: 30px 0;">
            <span
                style="font-size: 32px; color: #1a73e8; font-weight: bold; letter-spacing: 4px;">{{ $code }}</span>
        </div>

        <p style="color: #555555; font-size: 14px; line-height: 1.6;">
            This verification code will expire in <strong>10 minutes</strong>. If you didn’t request a password reset,
            you can safely ignore this email — your password will remain unchanged.
        </p>

        <p style="color: #999999; font-size: 12px; text-align: center; margin-top: 40px;">
            &copy; {{ now()->year }} Mangagawang Pinoy. All rights reserved.
        </p>
    </div>
</body>

</html>
