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
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/applicant/employer/forgotpassword.css') }}" />
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
