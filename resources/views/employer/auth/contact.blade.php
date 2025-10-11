<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Information - Employer Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="{{ asset('css/applicant/employer/contact.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/applicant/landingpage/landingpage.css') }}" rel="stylesheet" />

</head>

<body>
    <nav>
        <div class="navbar-container">
            <div class="nav-logo d-flex align-items-center">
                <a href="{{ route('display.index') }}" class="d-flex align-items-center gap-2"
                    style="text-decoration:none;">
                    <img src="{{ asset('img/logotext.png') }}" alt="MP Logo" id="home" />
                    <img src="{{ asset('img/logo.png') }}" alt="MP Logo" id="home2" />
                </a>
            </div>
            <ul class="nav-links" id="navLinks">
                <li><a href="#">Services</a></li>
                <li><a href="{{ route('display.topworker') }}">Top Workers</a></li>
                <li><a href="https://www.tesda.gov.ph/">Visit TESDA</a></li>
                <li><a href="{{ route('display.aboutus') }}">About Us</a></li>
                <li><button class="sign-in-b">Sign in</button></li>

                <!-- Sign Up Dropdown -->
                <li class="dropdown">
                    <button class="sign-up-b">Sign up ▾</button>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('applicant.register.display') }}">As Applicant</a></li>
                        <li><a href="{{ route('employer.register.display') }}">As Employer</a></li>
                    </ul>
                </li>
            </ul>


            <div class="hamburger" id="hamburger">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </nav>
    <!-- Step Content -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card form-card">
                <div class="registration-container">
                    <div class="container">
                        <!-- Header -->
                        <div class="text-center mb-5">
                            <h1 class="display-4 fw-bold text-dark mb-3">
                                Employer Registration
                            </h1>
                            <p class="lead text-muted">
                                Find TESDA-certified skilled workers and blue collar professionals
                                for your projects
                            </p>
                        </div>

                        <!-- Progress Stepper -->
                        <div class="row justify-content-center mb-5">
                            <div class="col-lg-10">
                                <div class="d-flex align-items-center justify-content-between">


                                    <!-- Step 1 -->
                                    <div class="text-center">
                                        <div class="step-indicator step-completed" id="step1">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-dark">Job Details</small>
                                            <br /><small class="text-muted d-none d-sm-block">Position
                                                requirements</small>
                                        </div>
                                    </div>
                                    <div class="step-line step-line-completed" id="line1"></div>

                                    <!-- Step 2 -->
                                    <div class="text-center">
                                        <div class="step-indicator step-active" id="step2">2</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-dark">Contact</small>
                                            <br /><small class="text-muted d-none d-sm-block">Your contact info</small>
                                        </div>
                                    </div>
                                    <div class="step-line" id="line2"></div>

                                    <!-- Step 3 -->
                                    <div class="text-center">
                                        <div class="step-indicator step-inactive" id="step3">3</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-muted">Preferences</small>
                                            <br /><small class="text-muted d-none d-sm-block">Hiring preferences</small>
                                        </div>
                                    </div>
                                    <div class="step-line" id="line3"></div>

                                    <!-- Step 4 -->
                                    <div class="text-center">
                                        <div class="step-indicator step-inactive" id="step4">4</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-muted">Review</small>
                                            <br /><small class="text-muted d-none d-sm-block">Review & submit</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-header bg-white border-0">
                            <h3 class="card-title mb-2">Contact Information</h3>
                            <p class="text-muted mb-0">
                                We'll use this information to contact you about worker
                                applications and project updates.
                            </p>
                        </div>
                        <div class="card-body p-0">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            {{-- Optional: Show form validation errors --}}
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-times-circle me-2"></i>
                                    <strong>There were some problems with your input.</strong>
                                    <ul class="mb-0 mt-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <form id="contactForm" action="{{ route('employer.contact.store') }}" method="POST">
                                @csrf

                                <!-- Employer Account Section -->
                                <div class="section-divider">
                                    <h5 class="fw-bold mb-3">
                                        <i class="fas fa-user-lock text-primary me-2"></i>Account Information
                                    </h5>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="accountEmail" class="form-label">Email Address *</label>
                                            <input type="email" class="form-control" id="accountEmail"
                                                name="account_email" placeholder="e.g. employer@company.com"
                                                required />
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="password" class="form-label">Password *</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="password"
                                                    name="password" placeholder="Create a password" minlength="8"
                                                    required
                                                    oninput="checkPasswordStrength(this.value); checkPasswordMatch();" />
                                                <button class="btn btn-outline-secondary" type="button"
                                                    onclick="togglePassword('password')">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <div class="progress mt-2" style="height: 5px;">
                                                <div id="passwordStrengthBar" class="progress-bar"
                                                    role="progressbar"></div>
                                            </div>
                                            <small id="passwordFeedback" class="form-text text-muted mt-1"></small>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="password_confirmation" class="form-label">Confirm Password
                                                *</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control"
                                                    id="password_confirmation" name="password_confirmation"
                                                    placeholder="Re-enter password" required
                                                    oninput="checkPasswordMatch();" />
                                                <button class="btn btn-outline-secondary" type="button"
                                                    onclick="togglePassword('password_confirmation')">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <small id="matchFeedback" class="form-text text-muted mt-1"></small>
                                        </div>
                                    </div>
                                </div>



                                <!-- Personal Information -->
                                <h5 class="fw-bold mb-3">
                                    <i class="fas fa-user text-primary me-2"></i>Personal
                                    Information
                                </h5>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="firstName" class="form-label">First Name *</label>
                                        <input type="text" class="form-control" id="firstName" name="first_name"
                                            placeholder="Enter your first name" required />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="lastName" class="form-label">Last Name *</label>
                                        <input type="text" class="form-control" name="last_name" id="lastName"
                                            placeholder="Enter your last name" required />
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email Address *</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="your.email@company.com" required />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone Number *</label>
                                        <input type="tel" class="form-control" name="phone_number"
                                            id="phone" placeholder="e.g. 09XX XXX XXXX" required />
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="jobTitle" class="form-label">Your Job Title *</label>
                                        <input type="text" class="form-control" name="employer_job_title"
                                            id="jobTitle" placeholder="e.g. HR Manager, Project Manager, Owner"
                                            required />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="department" class="form-label">Department</label>
                                        <select class="form-select" id="department" name="employer_department">
                                            <option value="">Select department</option>
                                            <option value="Management">Management</option>
                                            <option value="Human-resource">Human Resources</option>
                                            <option value="Operations">Operations</option>
                                            <option value="Project-management">
                                                Project Management
                                            </option>
                                            <option value="Safety-compliance">Safety & Compliance</option>
                                            <option value="Administration">Administration</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Company Address Section - Cavite Only -->
                                <div class="section-divider">
                                    <h5 class="fw-bold mb-3">
                                        <i class="fas fa-building text-warning me-2"></i>Company Address
                                    </h5>
                                    <div class="mb-4">
                                        <label for="address" class="form-label">Company Name *</label>
                                        <input type="text" class="form-control" id="companyname"
                                            name="company_name" placeholder="e.g. ABC Construction Company"
                                            required />
                                    </div>

                                    <div class="mb-4">
                                        <label for="address" class="form-label">Street Address *</label>
                                        <input type="text" class="form-control" id="address"
                                            name="complete_address" placeholder="Complete street address" required />
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="city" class="form-label">City / Municipality in Cavite
                                                *</label>
                                            <select class="form-select" id="city" name="municipality" required>
                                                <option value="">Select city or municipality</option>
                                                <option value="Alfonso">Alfonso</option>
                                                <option value="Amadeo">Amadeo</option>
                                                <option value="Bacoor">Bacoor</option>
                                                <option value="Carmona">Carmona</option>
                                                <option value="Cavite City">Cavite City</option>
                                                <option value="Dasmariñas">Dasmariñas</option>
                                                <option value="General Emilio Aguinaldo">General Emilio Aguinaldo
                                                </option>
                                                <option value="General Mariano Alvarez">General Mariano Alvarez (GMA)
                                                </option>
                                                <option value="General Trias">General Trias</option>
                                                <option value="Imus">Imus</option>
                                                <option value="Indang">Indang</option>
                                                <option value="Kawit">Kawit</option>
                                                <option value="Magallanes">Magallanes</option>
                                                <option value="Maragondon">Maragondon</option>
                                                <option value="Mendez">Mendez (Mendez-Nuñez)</option>
                                                <option value="Naic">Naic</option>
                                                <option value="Noveleta">Noveleta</option>
                                                <option value="Rosario">Rosario</option>
                                                <option value="Silang">Silang</option>
                                                <option value="Tagaytay">Tagaytay</option>
                                                <option value="Tanza">Tanza</option>
                                                <option value="Ternate">Ternate</option>
                                                <option value="Trece Martires">Trece Martires</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="zipCode" class="form-label">ZIP/Postal Code</label>
                                            <input type="text" class="form-control" id="zipCode"
                                                name="zip_code" placeholder="e.g. 4114" />
                                        </div>

                                        <div class="col-md-3">
                                            <label for="province" class="form-label">Province *</label>
                                            <input type="text" class="form-control" id="province"
                                                name="province" value="Cavite" readonly />
                                        </div>
                                    </div>


                                </div>


                                <!-- Emergency Contact -->
                                {{-- <div class="section-divider">
                                    <h5 class="fw-bold mb-3">
                                        <i class="fas fa-phone text-danger me-2"></i>Emergency
                                        Contact (Optional)
                                    </h5>
                                    <div class="info-highlight">
                                        <p class="small mb-0">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Provide an emergency contact person for urgent worker-related
                                            matters or site emergencies.
                                        </p>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="emergencyName" class="form-label">Emergency Contact
                                                Name</label>
                                            <input type="text" class="form-control" id="emergencyName"
                                                name="emergency_contact_name" placeholder="Full name" />
                                        </div>
                                        <div class="col-md-6">
                                            <label for="emergencyPhone" class="form-label">Emergency Contact
                                                Phone</label>
                                            <input type="tel" class="form-control"
                                                name="emergency_contact_number" id="emergencyPhone"
                                                placeholder="e.g. 09XX XXX XXXX" />
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="emergencyRelation" class="form-label">Relationship to
                                            Company</label>
                                        <select class="form-select" id="emergencyRelation"
                                            name="emergency_contact_relationship">
                                            <option value="">Select relationship</option>
                                            <option value="Company_Owner">Company Owner</option>
                                            <option value="Manager/Supervisor">Manager/Supervisor</option>
                                            <option value="Safety-officer">Safety Officer</option>
                                            <option value="HR-representative">HR Representative</option>
                                            <option value="Business-partner">Business Partner</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div> --}}

                                <!-- Communication Preferences -->
                                <div class="section-divider">
                                    <h5 class="fw-bold mb-3">
                                        <i class="fas fa-comments text-success me-2"></i>Communication
                                        Preferences
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Preferred Contact Method *</label>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="contact_method"
                                                    id="contactEmail" value="email" required />
                                                <label class="form-check-label" for="contactEmail">
                                                    <i class="fas fa-envelope me-2"></i>Email
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="contact_method"
                                                    id="contactPhone" value="phone" />
                                                <label class="form-check-label" for="contactPhone">
                                                    <i class="fas fa-phone me-2"></i>Phone Call
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="contact_method"
                                                    id="contactSMS" value="sms" />
                                                <label class="form-check-label" for="contactSMS">
                                                    <i class="fas fa-sms me-2"></i>SMS/Text Message
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Best Time to Contact</label>
                                            <select class="form-select" id="contactTime" name="contact_time">
                                                <option value="">Select best time</option>
                                                <option value="morning">Morning (8AM - 12PM)</option>
                                                <option value="afternoon">Afternoon (12PM - 5PM)</option>
                                                <option value="evening">Evening (5PM - 8PM)</option>
                                                <option value="anytime">Anytime during business hours</option>
                                            </select>

                                            <label class="form-label mt-3">Language Preference</label>
                                            <select class="form-select" id="language" name="language_preference">
                                                <option value="english">English</option>
                                                <option value="filipino">Filipino/Tagalog</option>
                                                <option value="cebuano">Cebuano</option>
                                                <option value="ilocano">Ilocano</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="section-divider">
                                    <h5 class="fw-bold mb-3">
                                        <i class="fas fa-clipboard text-info me-2"></i>Additional
                                        Information
                                    </h5>

                                    <div class="mb-4">
                                        <label for="workHours" class="form-label">Typical Work Hours</label>
                                        <input type="text" class="form-control" name="typical_working_hours"
                                            id="workHours" placeholder="e.g. 7:00 AM - 5:00 PM, Monday to Saturday" />
                                    </div>

                                    <div class="mb-4">
                                        <label for="notes" class="form-label">Special Instructions or Notes</label>
                                        <textarea class="form-control" name="special_instructions" id="notes" rows="3"
                                            placeholder="Any additional information about your project, location, or requirements..."></textarea>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="agreeTerms" required />
                                        <label class="form-check-label" for="agreeTerms">
                                            I agree to receive communications regarding worker
                                            applications and project updates *
                                        </label>
                                    </div>
                                </div>

                                <!-- Navigation Buttons -->
                                <div class="row justify-content-center mt-4">
                                    <div class="col-lg-8">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="previousStep()">
                                                <i class="fas fa-arrow-left me-2"></i>Previous
                                            </button>
                                            <small class="text-muted">Step 2 of 4</small>
                                            <button type="submit" class="btn btn-primary-custom">Next <i
                                                    class="fas fa-arrow-right ms-2"></i></button>

                                        </div>
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
    </div>
    <script>
        function checkPasswordStrength(password) {
            const strengthBar = document.getElementById('passwordStrengthBar');
            const feedback = document.getElementById('passwordFeedback');

            let strength = 0;
            if (password.length >= 8) strength += 1;
            if (/[a-z]/.test(password)) strength += 1;
            if (/[A-Z]/.test(password)) strength += 1;
            if (/\d/.test(password)) strength += 1;
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;

            let width = strength * 20;
            strengthBar.style.width = width + '%';

            if (strength <= 2) {
                strengthBar.className = 'progress-bar bg-danger';
                feedback.textContent = 'Weak password. Try adding numbers, symbols, or uppercase letters.';
                feedback.className = 'form-text text-danger';
            } else if (strength === 3 || strength === 4) {
                strengthBar.className = 'progress-bar bg-warning';
                feedback.textContent = 'Moderate password. Consider making it stronger.';
                feedback.className = 'form-text text-warning';
            } else if (strength === 5) {
                strengthBar.className = 'progress-bar bg-success';
                feedback.textContent = 'Strong password.';
                feedback.className = 'form-text text-success';
            }
        }

        function checkPasswordMatch() {
            const pass = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;
            const matchFeedback = document.getElementById('matchFeedback');

            if (!confirm) {
                matchFeedback.textContent = '';
                return;
            }

            if (pass === confirm) {
                matchFeedback.textContent = 'Passwords match.';
                matchFeedback.className = 'form-text text-success';
            } else {
                matchFeedback.textContent = 'Passwords do not match.';
                matchFeedback.className = 'form-text text-danger';
            }
        }

        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = input.nextElementSibling.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previousStep() {
            window.location.href = "{{ route('employer.register.display') }}";
        }
    </script>
</body>

</html>
