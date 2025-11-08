<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/applicant/setting.css') }}">
</head>

<body>
    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="container-fluid" style="max-width: 900px; margin: 0 auto; padding: 0 1.5rem;">
            <a href="{{ route('applicant.info.homepage.display') }}" class="back-btn">
                <i class="bi bi-arrow-left"></i>
                <span>Back to Homepage</span>
            </a>
        </div>
    </nav>

    <!-- Success Message -->
    @if (session('success'))
        <div class="position-fixed top-0 start-50 translate-middle-x mt-5"
            style="z-index: 1055; max-width: 400px; width: 90%;">
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert" id="success-alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>

        <script>
            // Auto-hide after 3 seconds
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                    bsAlert.close();
                }
            }, 3000);
        </script>
    @endif


    <!-- Main Container -->
    <div class="settings-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <div class="icon-badge">
                    <i class="bi bi-gear-fill"></i>
                </div>
                <div class="header-text">
                    <h1>Account Settings</h1>
                    <p>Manage your account preferences and security</p>
                </div>
            </div>
        </div>

        <!-- Settings Card -->
        <div class="settings-card">
            <!-- Security Section -->
            <div class="settings-section">
                <div class="section-title">Security</div>

                <!-- Change Password -->
                <div class="settings-item">
                    <div class="item-info">
                        <div class="item-icon">
                            <i class="bi bi-lock-fill"></i>
                        </div>
                        <div class="item-text">
                            <h3>Change Password</h3>
                            <p>Update your password to keep your account secure</p>
                        </div>
                    </div>
                    <button class="btn-custom btn-primary-custom" data-bs-toggle="modal"
                        data-bs-target="#changePasswordModal">
                        <i class="bi bi-key-fill"></i>
                        Change
                    </button>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="settings-section">
                <div class="section-title">Danger Zone</div>

                <!-- Delete Account -->
                <div class="settings-item">
                    <div class="item-info">
                        <div class="item-icon danger">
                            <i class="bi bi-trash-fill"></i>
                        </div>
                        <div class="item-text">
                            <h3 class="text-danger">Delete Account</h3>
                            <p>Permanently delete your account and all your data</p>
                        </div>
                    </div>
                    <button class="btn-custom btn-danger-custom" data-bs-toggle="modal"
                        data-bs-target="#deleteAccountModal">
                        <i class="bi bi-trash-fill"></i>
                        Delete
                    </button>


                </div>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-key-fill text-success me-2"></i>
                        Change Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="changePasswordForm" method="POST"
                    action="{{ route('applicant.setting.update.password.store') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="current_password"
                                    name="current_password" required>
                                <button type="button" class="btn btn-outline-secondary"
                                    onclick="togglePassword('current_password')">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password" name="new_password"
                                    required minlength="8">
                                <button type="button" class="btn btn-outline-secondary"
                                    onclick="togglePassword('new_password')">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                            </div>
                            <small class="text-muted">
                                Must be at least 8 characters, include one uppercase, one lowercase, one number, and one
                                special character.
                            </small>

                            <!-- Password Rules Checklist -->
                            <ul id="passwordRules" class="list-unstyled mt-2 mb-0">
                                <li id="rule-length" class="text-danger">• At least 8 characters</li>
                                <li id="rule-uppercase" class="text-danger">• At least 1 uppercase letter</li>
                                <li id="rule-lowercase" class="text-danger">• At least 1 lowercase letter</li>
                                <li id="rule-number" class="text-danger">• At least 1 number</li>
                                <li id="rule-special" class="text-danger">• At least 1 special character (@$!%*?&)
                                </li>
                            </ul>
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password_confirmation"
                                    name="new_password_confirmation" required minlength="8">
                                <button type="button" class="btn btn-outline-secondary"
                                    onclick="togglePassword('new_password_confirmation')">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" id="submitPasswordBtn">
                            <i class="bi bi-check-circle-fill"></i>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const passwordInput = document.getElementById('new_password');
        const rules = {
            length: document.getElementById('rule-length'),
            uppercase: document.getElementById('rule-uppercase'),
            lowercase: document.getElementById('rule-lowercase'),
            number: document.getElementById('rule-number'),
            special: document.getElementById('rule-special')
        };

        passwordInput.addEventListener('input', () => {
            const value = passwordInput.value;

            // Check each rule
            rules.length.classList.toggle('text-success', value.length >= 8);
            rules.length.classList.toggle('text-danger', value.length < 8);

            rules.uppercase.classList.toggle('text-success', /[A-Z]/.test(value));
            rules.uppercase.classList.toggle('text-danger', !/[A-Z]/.test(value));

            rules.lowercase.classList.toggle('text-success', /[a-z]/.test(value));
            rules.lowercase.classList.toggle('text-danger', !/[a-z]/.test(value));

            rules.number.classList.toggle('text-success', /\d/.test(value));
            rules.number.classList.toggle('text-danger', !/\d/.test(value));

            rules.special.classList.toggle('text-success', /[@$!%*?&]/.test(value));
            rules.special.classList.toggle('text-danger', !/[@$!%*?&]/.test(value));
        });
    </script>
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === "password" ? "text" : "password";
        }

        const form = document.getElementById('changePasswordForm');
        const passwordInput = document.getElementById('new_password');
        const passwordHelp = document.getElementById('passwordHelp');

        form.addEventListener('submit', function(e) {
            const password = passwordInput.value;
            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            if (!regex.test(password)) {
                e.preventDefault();
                passwordHelp.textContent =
                    "Password must contain at least 8 characters, including one uppercase letter, one lowercase letter, one number, and one special character.";
                passwordInput.focus();
            } else {
                passwordHelp.textContent = "";
            }
        });
    </script>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Confirm Delete Account
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert-custom alert-danger">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <div>
                            <strong>Warning!</strong> This action cannot be undone.
                        </div>
                    </div>
                    <p class="mb-3">Are you sure you want to delete your account?</p>
                    <ul class="text-muted" style="font-size: 0.875rem;">
                        <li>All your personal information will be permanently removed</li>
                        <li>Your job applications will be deleted</li>
                        <li>Your reports and activity history will be erased</li>
                        <li>You won't be able to recover your account</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('applicant.deleteaccount.destroy') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-custom btn-danger-custom">
                            <i class="bi bi-trash-fill"></i>
                            Delete My Account
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle password visibility
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const button = input.nextElementSibling;
            const icon = button.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye-fill');
                icon.classList.add('bi-eye-slash-fill');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash-fill');
                icon.classList.add('bi-eye-fill');
            }
        }

        // Auto-open change password modal if there are errors
        @if ($errors->any())
            const changePasswordModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
            changePasswordModal.show();
        @endif
    </script>
</body>

</html>
