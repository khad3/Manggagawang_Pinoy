<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        :root {
            --primary: #667eea;
            --primary2: #764ba2;
            --success: #10b981;
            --error: #ef4444;
            --muted: #6b7280
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif;
            background: linear-gradient(135deg, var(--primary), var(--primary2));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
            color: #111
        }

        body::before,
        body::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, .12);
            animation: float 20s infinite ease-in-out
        }

        body::before {
            width: 420px;
            height: 420px;
            top: -210px;
            left: -210px
        }

        body::after {
            width: 320px;
            height: 320px;
            bottom: -160px;
            right: -160px;
            animation-delay: 5s
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) scale(1)
            }

            33% {
                transform: translate(30px, -30px) scale(1.07)
            }

            66% {
                transform: translate(-20px, 20px) scale(.95)
            }
        }

        .container {
            width: 100%;
            max-width: 520px;
            position: relative;
            z-index: 1
        }

        .card {
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 24px 60px rgba(0, 0, 0, .28);
            overflow: hidden;
            animation: up .5s ease-out
        }

        @keyframes up {
            from {
                opacity: 0;
                transform: translateY(24px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .card-header {
            padding: 40px 40px 28px;
            text-align: center;
            background: linear-gradient(135deg, var(--primary), var(--primary2));
            color: #fff
        }

        .icon-wrap {
            width: 84px;
            height: 84px;
            margin: 0 auto 18px;
            border-radius: 20px;
            background: rgba(255, 255, 255, .2);
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(8px);
            border: 2px solid rgba(255, 255, 255, .28);
            animation: pulse 2s infinite
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(255, 255, 255, .38)
            }

            50% {
                transform: scale(1.05);
                box-shadow: 0 0 0 12px rgba(255, 255, 255, 0)
            }
        }

        .icon-wrap svg {
            width: 42px;
            height: 42px;
            stroke-width: 2
        }

        h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 6px;
            letter-spacing: .2px
        }

        .sub {
            opacity: .95;
            font-size: 15px
        }

        .card-body {
            padding: 36px 40px
        }

        .steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 34px;
            position: relative
        }

        .steps::before {
            content: "";
            position: absolute;
            left: 22px;
            right: 22px;
            top: 20px;
            height: 2px;
            background: #e5e7eb
        }

        .step {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            position: relative;
            z-index: 1
        }

        .num {
            width: 40px;
            height: 40px;
            border-radius: 999px;
            background: #f3f4f6;
            color: #9ca3af;
            border: 2px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            transition: .3s
        }

        .step.active .num {
            background: linear-gradient(135deg, var(--primary), var(--primary2));
            color: #fff;
            border-color: var(--primary);
            box-shadow: 0 6px 14px rgba(102, 126, 234, .45)
        }

        .step.done .num {
            background: var(--success);
            color: #fff;
            border-color: var(--success)
        }

        .label {
            font-size: 12px;
            color: #9ca3af;
            font-weight: 600
        }

        .step.active .label {
            color: #fff;
            opacity: .9
        }

        .form-section {
            display: none
        }

        .form-section.active {
            display: block;
            animation: fade .35s ease-out
        }

        @keyframes fade {
            from {
                opacity: 0;
                transform: translateX(18px)
            }

            to {
                opacity: 1;
                transform: translateX(0)
            }
        }

        .group {
            margin-bottom: 22px
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #374151;
            margin-bottom: 8px
        }

        .input-wrap {
            position: relative
        }

        .i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            width: 20px;
            height: 20px
        }

        input[type="email"],

        input[type="password"] {
            width: 100%;
            padding: 14px 16px 14px 46px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 15px;
            background: #f9fafb;
            transition: .25s
        }

        */ input:focus {
            outline: none;
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, .12)
        }

        input.error {
            border-color: var(--error);
            background: #fef2f2
        }

        .alert {
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 14px;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            gap: 10px
        }

        .a-info {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #bfdbfe
        }

        .a-success {
            background: #d1fae5;
            color: #064e3b;
            border: 1px solid #a7f3d0
        }

        .a-error {
            background: #fee2e2;
            color: #7f1d1d;
            border: 1px solid #fecaca
        }

        .err {
            color: #ef4444;
            font-size: 13px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 6px
        }

        .btn {
            width: 100%;
            padding: 14px 22px;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: .25s
        }

        .b1 {
            background: linear-gradient(135deg, var(--primary), var(--primary2));
            color: #fff;
            box-shadow: 0 8px 18px rgba(102, 126, 234, .45)
        }

        .b1:hover {
            transform: translateY(-1px)
        }

        .b1:active {
            transform: translateY(0)
        }

        .b1:disabled {
            background: #9ca3af;
            box-shadow: none;
            cursor: not-allowed
        }

        .spinner {
            width: 18px;
            height: 18px;
            border: 3px solid rgba(255, 255, 255, .3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .8s linear infinite;
            display: none
        }

        .btn.loading .spinner {
            display: block
        }

        .btn.loading .t {
            display: none
        }

        @keyframes spin {
            to {
                transform: rotate(360deg)
            }
        }

        .back {
            text-align: center;
            margin-top: 18px
        }

        .back a {
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: .2s
        }

        .back a:hover {
            opacity: .9
        }



        .code-box {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 8px
        }

        .code {
            width: 70px;
            /* bigger input box */
            height: 70px;
            font-size: 42px !important;
            /* large font for visibility */
            line-height: 1.1;
            /* aligns text vertically */
            font-weight: 900 !important;
            /* extra bold numbers */
            text-align: center;
            border: 2px solid #d1d5db;
            border-radius: 12px;
            background: #fff;
            color: #000 !important;
            /* solid black numbers */
            caret-color: #000;
            /* black cursor */
            appearance: none;
            -webkit-appearance: none;
        }


        .code::placeholder {
            color: #c7c7c7
        }

        .code:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.12);
            outline: none;
            color: #000 !important;
        }



        .resend {
            text-align: center;
            margin-top: 18px;
            padding-top: 18px;
            border-top: 1px solid #e5e7eb
        }

        .resend p {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 6px
        }

        .resend button {
            background: none;
            border: 2px solid #e5e7eb;
            color: var(--primary);
            font-weight: 800;
            cursor: pointer;
            font-size: 14px;
            padding: 8px 16px;
            border-radius: 10px;
            transition: .2s
        }

        .resend button:hover {
            background: #f3f4f6
        }

        .resend button:disabled {
            color: #9ca3af;
            cursor: not-allowed;
            border-color: #e5e7eb
        }

        .timer {
            color: #ef4444;
            font-weight: 800;
            margin-left: 6px
        }

        .pwr {
            margin-top: 12px;
            padding: 12px;
            background: #f9fafb;
            border-radius: 10px
        }

        .s-l {
            font-size: 12px;
            font-weight: 800;
            margin-bottom: 8px;
            color: #6b7280
        }

        .s-bar {
            height: 6px;
            background: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 8px
        }

        .s-fill {
            height: 100%;
            width: 0%;
            transition: .3s;
            border-radius: 4px
        }

        .weak {
            width: 33%;
            background: #ef4444
        }

        .medium {
            width: 66%;
            background: #f59e0b
        }

        .strong {
            width: 100%;
            background: #10b981
        }

        .req {
            font-size: 12px;
            color: #9ca3af;
            display: flex;
            align-items: center;
            gap: 6px
        }

        .req.met {
            color: #10b981
        }

        .ok {
            display: inline-block;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 2px solid currentColor
        }

        .ok.met {
            background: currentColor
        }

        .success {
            padding: 40px 0;
            text-align: center
        }

        .circle {
            width: 108px;
            height: 108px;
            border-radius: 999px;
            background: linear-gradient(135deg, #10b981, #059669);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            animation: scale .45s ease-out
        }

        @keyframes scale {
            from {
                transform: scale(0)
            }

            to {
                transform: scale(1)
            }
        }

        .circle svg {
            width: 56px;
            height: 56px;
            stroke: #fff;
            stroke-width: 3;
            fill: none
        }

        @media (max-width:560px) {
            .card-header {
                padding: 30px 22px
            }

            h1 {
                font-size: 24px
            }

            .card-body {
                padding: 26px 22px
            }

            .icon-wrap {
                width: 72px;
                height: 72px
            }

            .icon-wrap svg {
                width: 36px;
                height: 36px
            }

            .code {
                width: 48px;
                height: 50px;
                font-size: 50px
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </div>
                <h1>Forgot Password?</h1>
                <p class="sub">No worries, we'll send you reset instructions</p>
            </div>

            <div class="card-body">
                <div class="steps">
                    @php $step = (int) session('step', 1); @endphp
                    <div class="step {{ $step === 1 ? 'active' : ($step > 1 ? 'done' : '') }}">
                        <div class="num">1</div>
                        <div class="label">Email</div>
                    </div>
                    <div class="step {{ $step === 2 ? 'active' : ($step > 2 ? 'done' : '') }}">
                        <div class="num">2</div>
                        <div class="label">Verify</div>
                    </div>
                    <div class="step {{ $step === 3 ? 'active' : '' }}">
                        <div class="num">3</div>
                        <div class="label">Reset</div>
                    </div>
                </div>

                <form id="emailForm" action="{{ route('employer.forgotpassword.store') }}" method="POST"
                    class="form-section {{ $step === 1 ? 'active' : '' }}">
                    @csrf
                    <div class="group">
                        <label for="email">Email Address</label>
                        <div class="input-wrap">
                            <svg class="i" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z">
                                </path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                placeholder="Enter your email address" required autocomplete="email" />
                        </div>
                        @error('email')
                            <div class="err">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    style="width:16px;height:16px">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <button id="sendCodeBtn" type="submit" class="btn b1"><span class="spinner"></span><span
                            class="t">Send Reset Code</span></button>
                    <div class="back" style="display: flex; justify-content: center; margin-top: 15px;">
                        <a href="{{ route('employer.login.display') }}"
                            style="color: #000; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#000" style="width:16px;height:16px;">
                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                <polyline points="12,19 5,12 12,5"></polyline>
                            </svg>
                            Back to Login
                        </a>
                    </div>


                </form>

                <form id="verificationForm" action="{{ route('employer.verifycode.store') }}" method="POST"
                    class="form-section {{ $step === 2 ? 'active' : '' }}">
                    @csrf
                    <div class="alert a-info">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" style="width:20px;height:20px">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        <span>We sent a verification code to <strong>{{ session('email') }}</strong></span>
                    </div>

                    @if (session('status'))
                        <div class="alert a-success">{{ session('status') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert a-error">{{ session('error') }}</div>
                    @endif

                    <div class="group">
                        <label>Enter Verification Code</label>
                        <div class="code-box">
                            @for ($i = 0; $i < 6; $i++)
                                <input class="code" type="text" inputmode="numeric" pattern="[0-9]*"
                                    maxlength="1" autocomplete="one-time-code"
                                    aria-label="Digit {{ $i + 1 }}" />
                            @endfor
                        </div>
                        <input type="hidden" name="email" value="{{ session('email') }}">

                        <input type="hidden" name="verification_code" id="fullCode" />
                        @error('verification_code')
                            <div id="codeError" class="err">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    style="width:16px;height:16px">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <button id="verifyCodeBtn" type="submit" class="btn b1"><span class="spinner"></span><span
                            class="t">Verify Code</span></button>

                    <div class="resend">
                        <p>Didn't receive the code?</p>
                        <form id="resendForm" action="" method="POST" style="display:inline">
                            @csrf
                            <button id="resendBtn" type="submit" disabled>Resend Code <span id="resendTimer"
                                    class="timer"></span></button>
                        </form>
                    </div>
                </form>

                <form action="{{ route('employer.resetpassword.store') }}" method="POST"
                    class="form-section {{ $step === 3 ? 'active' : '' }}">
                    @csrf
                    <div class="group">
                        <input type="hidden" name="email" value="{{ session(key: 'email') }}">

                        <label for="newPassword">New Password</label>
                        <div class="input-wrap">
                            <svg class="i" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2">
                                </rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <input id="newPassword" type="password" name="password" placeholder="Enter new password"
                                required autocomplete="new-password" />
                        </div>
                        <div class="pwr">
                            <div class="s-l">Password Strength</div>
                            <div class="s-bar">
                                <div id="strengthFill" class="s-fill"></div>
                            </div>
                            <div style="display:flex;flex-direction:column;gap:6px">
                                <div id="rq-len" class="req"><span class="ok"></span> At least 8 characters
                                </div>
                                <div id="rq-up" class="req"><span class="ok"></span> One uppercase letter
                                </div>
                                <div id="rq-low" class="req"><span class="ok"></span> One lowercase letter
                                </div>
                                <div id="rq-num" class="req"><span class="ok"></span> One number</div>
                            </div>
                        </div>
                        @error('password')
                            <div class="err">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    style="width:16px;height:16px">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="group">
                        <label for="confirmPassword">Confirm Password</label>
                        <div class="input-wrap">
                            <svg class="i" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2">
                                </rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <input id="confirmPassword" type="password" name="password_confirmation"
                                placeholder="Confirm new password" required autocomplete="new-password" />
                        </div>
                        <div id="confirmErr" class="err" style="display:none">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                style="width:16px;height:16px">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            <span>Passwords do not match</span>
                        </div>
                    </div>

                    <button type="submit" class="btn b1"><span class="spinner"></span><span class="t">Reset
                            Password</span></button>
                </form>

                <div class="form-section {{ session('password_reset_success') ? 'active' : '' }}">
                    @if (session('password_reset_success'))
                        <div class="success">
                            <div class="circle"><svg viewBox="0 0 24 24">
                                    <polyline points="20,6 9,17 4,12"></polyline>
                                </svg></div>
                            <h2 style="font-family:'Poppins',sans-serif;margin-bottom:6px">Password Reset Successfully!
                            </h2>
                            <p style="color:var(--muted);margin-bottom:16px">You can now login with your new password.
                            </p>
                            <a href="{{ route('employer.login.display') }}" class="btn b1"
                                style="text-decoration:none">Go to Login</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        (function() {
            var emailForm = document.getElementById('emailForm');
            var sendCodeBtn = document.getElementById('sendCodeBtn');
            if (emailForm && sendCodeBtn) {
                emailForm.addEventListener('submit', function() {
                    sendCodeBtn.classList.add('loading');
                    sendCodeBtn.disabled = true;
                });
            }

            var codes = Array.prototype.slice.call(document.querySelectorAll('.code'));
            var full = document.getElementById('fullCode');

            function rebuild() {
                var v = codes.map(function(i) {
                    return i.value.replace(/\D/g, '') || ''
                }).join('');
                full.value = v;
            }

            function focusNext(idx) {
                if (idx < codes.length - 1) {
                    codes[idx + 1].focus();
                    codes[idx + 1].select();
                }
            }

            function focusPrev(idx) {
                if (idx > 0) {
                    codes[idx - 1].focus();
                    codes[idx - 1].select();
                }
            }

            codes.forEach(function(inp, idx) {
                inp.addEventListener('input', function(e) {
                    this.value = this.value.replace(/\D/g, '').slice(0, 1);
                    rebuild();
                    if (this.value.length === 1) {
                        focusNext(idx);
                    }
                });
                inp.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && !this.value) {
                        focusPrev(idx);
                    }
                    if (e.key.length === 1 && !/[0-9]/.test(e.key)) {
                        e.preventDefault();
                    }
                });
                inp.addEventListener('focus', function() {
                    this.select();
                });
                inp.addEventListener('paste', function(e) {
                    e.preventDefault();
                    var t = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '')
                        .slice(0, 6);
                    if (!t) return;
                    for (var i = 0; i < codes.length; i++) {
                        codes[i].value = t[i] || '';
                    }
                    rebuild();
                    if (t.length >= 6) {
                        codes[codes.length - 1].focus();
                    }
                });
            });

            var verificationForm = document.getElementById('verificationForm');
            var verifyBtn = document.getElementById('verifyCodeBtn');
            if (verificationForm && verifyBtn) {
                verificationForm.addEventListener('submit', function(e) {
                    rebuild();
                    if (full.value.length !== 6) {
                        e.preventDefault();
                        var ce = document.getElementById('codeError');
                        if (ce) {
                            ce.style.display = 'flex';
                            ce.querySelector('span').textContent = 'Please enter all 6 digits';
                        }
                        return;
                    }
                    verifyBtn.classList.add('loading');
                    verifyBtn.disabled = true;
                });
            }

            var resendBtn = document.getElementById('resendBtn');
            var resendTimer = document.getElementById('resendTimer');
            var resendForm = document.getElementById('resendForm');

            function startTimer(sec) {
                if (!resendBtn || !resendTimer) return;
                var t = sec;
                resendBtn.disabled = true;
                resendTimer.textContent = '(' + t + 's)';
                var it = setInterval(function() {
                    t--;
                    resendTimer.textContent = '(' + t + 's)';
                    if (t <= 0) {
                        clearInterval(it);
                        resendBtn.disabled = false;
                        resendTimer.textContent = '';
                    }
                }, 1000);
            }
            if (resendBtn) {
                startTimer(60);
            }
            if (resendForm) {
                resendForm.addEventListener('submit', function() {
                    if (resendBtn) {
                        resendBtn.disabled = true;
                    }
                });
            }

            var pw = document.getElementById('newPassword');
            var cf = document.getElementById('confirmPassword');
            var cfErr = document.getElementById('confirmErr');
            var rb = document.getElementById('resetPasswordBtn');
            var fill = document.getElementById('strengthFill');
            var rqLen = document.getElementById('rq-len'),
                rqUp = document.getElementById('rq-up'),
                rqLow = document.getElementById('rq-low'),
                rqNum = document.getElementById('rq-num');

            function req(el, ok) {
                if (!el) return;
                el.classList.toggle('met', ok);
                var dot = el.querySelector('.ok');
                if (dot) {
                    dot.classList.toggle('met', ok);
                }
            }
            if (pw) {
                pw.addEventListener('input', function() {
                    var v = this.value || '',
                        s = 0;
                    var L = v.length >= 8;
                    req(rqLen, L);
                    if (L) s++;
                    var U = /[A-Z]/.test(v);
                    req(rqUp, U);
                    if (U) s++;
                    var W = /[a-z]/.test(v);
                    req(rqLow, W);
                    if (W) s++;
                    var N = /\d/.test(v);
                    req(rqNum, N);
                    if (N) s++;
                    if (fill) {
                        fill.className = 's-fill ' + (s <= 2 ? 'weak' : s === 3 ? 'medium' : 'strong');
                    }
                });
            }
            if (cf && pw) {
                cf.addEventListener('input', function() {
                    if (cfErr && this.value === pw.value) {
                        cfErr.style.display = 'none';
                        cf.classList.remove('error');
                    }
                });
            }
            var resetForm = document.getElementById('resetPasswordForm');
            if (resetForm && rb) {
                resetForm.addEventListener('submit', function(e) {
                    if (pw && cf && pw.value !== cf.value) {
                        e.preventDefault();
                        if (cfErr) {
                            cfErr.style.display = 'flex';
                        }
                        cf.classList.add('error');
                        return;
                    }
                    rb.classList.add('loading');
                    rb.disabled = true;
                });
            }
        })();
    </script>
</body>

</html>
