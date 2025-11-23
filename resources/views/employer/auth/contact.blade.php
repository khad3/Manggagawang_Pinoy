<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="{{ asset('css/applicant/employer/contact.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/applicant/landingpage/landingpage.css') }}" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />
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
                <li><a href="{{ route('display.topworker') }}">Top Workers</a></li>
                <li><a href="https://www.tesda.gov.ph/">Visit TESDA</a></li>
                <li><a href="{{ route('display.aboutus') }}">About Us</a></li>
                <li class="dropdown">
                    <button class="sign-in-b">Sign in</button>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('applicant.login.display') }}">As Applicant</a></li>
                        <li><a href="{{ route('employer.login.display') }}">As Employer</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <button class="sign-up-b">Sign up</button>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('applicant.register.display') }}">As Applicant</a></li>
                        <li><a href="{{ route('employer.register.display') }}">As Employer</a></li>
                    </ul>
                </li>
            </ul>

            <!-- Mobile Hamburger -->
            <button id="m-hamburger" class="m-hamburger" aria-label="Open menu" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <!-- Mobile navbar -->
            <div class="mobile-overlay" id="mobileOverlay" aria-hidden="true"></div>

            <div class="mobile-navbar" id="mobileNavbar" role="dialog" aria-modal="true" aria-hidden="true">
                <div class="nav-top nav-logo">
                    <img src="{{ asset('img/logotext.png') }}" alt="MP Logo" id="home" />
                    <img src="{{ asset('img/logo.png') }}" alt="MP Logo" id="home2" />

                    <button id="closeMenu" class="close-btn" aria-label="Close menu"></button>
                </div>

                <ul class="mobile-menu" role="menu" aria-label="Mobile main menu">
                    <li role="none"><a role="menuitem" href="{{ route('display.topworker') }}">Top Workers</a></li>
                    <li role="none"><a role="menuitem" href="https://www.tesda.gov.ph/">Visit TESDA</a></li>
                    <li role="none"><a role="menuitem" href="{{ route('display.aboutus') }}">About Us</a></li>

                    <li class="dropdown" role="none">
                        <button class="dropdown-btn" aria-expanded="false">Sign in</button>
                        <ul class="dropdown-content" role="menu" aria-hidden="true">
                            <li role="none"><a role="menuitem" href="{{ route('applicant.login.display') }}">As
                                    Applicant</a>
                            </li>
                            <li role="none"><a role="menuitem" href="{{ route('employer.login.display') }}">As
                                    Employer</a>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown" role="none">
                        <button class="dropdown-btn" aria-expanded="false">Sign up</button>
                        <ul class="dropdown-content" role="menu" aria-hidden="true">
                            <li role="none"><a role="menuitem" href="{{ route('applicant.register.display') }}">As
                                    Applicant</a>
                            </li>
                            <li role="none"><a role="menuitem" href="{{ route('employer.register.display') }}">As
                                    Employer</a>
                            </li>
                        </ul>
                    </li>
                </ul>
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
                                            1
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
                                            <br /><small class="text-muted d-none d-sm-block">Hiring
                                                preferences</small>
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

                                <!-- Employer Type Selection -->
                                <div class="section-divider" style="border-top: none; padding-top: 0;">
                                    <h5 class="fw-bold mb-4">
                                        <i class="fas fa-users text-primary me-2"></i>Employer Type
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="employer-type-card" id="individualCard">
                                                <input type="radio" name="employer_type" value="individual"
                                                    required onchange="toggleEmployerType()">
                                                <div class="employer-type-icon text-primary">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <h6 class="fw-bold">Individual</h6>
                                                <p class="text-muted small mb-0">I'm hiring as an individual person</p>
                                            </label>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="employer-type-card" id="companyCard">
                                                <input type="radio" name="employer_type" value="company" required
                                                    onchange="toggleEmployerType()">
                                                <div class="employer-type-icon text-warning">
                                                    <i class="fas fa-building"></i>
                                                </div>
                                                <h6 class="fw-bold">Company</h6>
                                                <p class="text-muted small mb-0">I'm hiring on behalf of a company</p>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Employer Account Section -->
                                <div class="section-divider">
                                    <h5 class="fw-bold mb-3">
                                        <i class="fas fa-user-lock text-primary me-2"></i>Account Information
                                    </h5>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="accountEmail" class="form-label">Email Address <span
                                                    style="color: red;">*</span></label>
                                            <input type="email" class="form-control" id="accountEmail"
                                                name="account_email" placeholder="e.g. employer@company.com"
                                                required />
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="password" class="form-label">Password <span
                                                    style="color: red;">*</span></label>
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
                                                <span style="color: red;">*</span></label>
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
                                    <i class="fas fa-user text-primary me-2"></i>Personal Information
                                </h5>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="firstName" class="form-label">First Name <span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="firstName" name="first_name"
                                            placeholder="Enter your first name" required />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="lastName" class="form-label">Last Name <span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="last_name" id="lastName"
                                            placeholder="Enter your last name" required />
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email Address <span
                                                style="color: red;">*</span></label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="your.email@company.com" required />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone Number <span
                                                style="color: red;">*</span></label>
                                        <input type="tel" class="form-control" name="phone_number"
                                            id="phone" placeholder="e.g. 09XX XXX XXXX" required />
                                    </div>
                                </div>

                                <!-- Company-specific fields -->
                                <div id="companyFields" style="display: none;">
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="jobTitle" class="form-label">Your Job Title <span
                                                    class="required-star" style="color: red;">*</span></label>
                                            <input type="text" class="form-control" name="employer_job_title"
                                                id="jobTitle"
                                                placeholder="e.g. HR Manager, Project Manager, Owner" />
                                        </div>
                                        <div class="col-md-6">
                                            <label for="department" class="form-label">Department <span
                                                    class="required-star" style="color: red;">*</span></label>
                                            <select class="form-select" id="department" name="employer_department">
                                                <option value="">Select department</option>
                                                <option value="Administration">Administration</option>
                                                <option value="Human-resource">Human Resources</option>
                                                <option value="Management">Management</option>
                                                <option value="Operations">Operations</option>
                                                <option value="Project-management">Project Management</option>
                                                <option value="Safety-compliance">Safety & Compliance</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Company Address Section -->
                                <div class="section-divider">
                                    <h5 class="fw-bold mb-3">
                                        <i class="fas fa-building text-warning me-2"></i><span
                                            id="addressTitle">Company Address</span>
                                    </h5>

                                    <div class="mb-4" id="companyNameField">
                                        <label for="companyname" class="form-label">Company Name <span
                                                class="required-star" style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="companyname"
                                            name="company_name" placeholder="e.g. ABC Construction Company" />
                                    </div>

                                    <div class="mb-4">
                                        <label for="address" class="form-label">Street Address <span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="address"
                                            name="complete_address" placeholder="Complete street address" required />
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="city" class="form-label">City / Municipality in Cavite
                                                <span style="color: red;">*</span></label>
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
                                            <label for="zipCode" class="form-label">ZIP/Postal Code<span
                                                    style="color: red;">*</span></label>
                                            <input type="text" class="form-control" id="zipCode"
                                                name="zip_code" placeholder="e.g. 4114" />
                                        </div>

                                        <div class="col-md-3">
                                            <label for="province" class="form-label">Province </label>
                                            <input type="text" class="form-control" id="province"
                                                name="province" value="Cavite" readonly />
                                        </div>
                                    </div>
                                </div>

                                <!-- Communication Preferences -->
                                <div class="section-divider">
                                    <h5 class="fw-bold mb-3">
                                        <i class="fas fa-comments text-success me-2"></i>Communication Preferences
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Preferred Contact Method <span
                                                    style="color: red;">*</span></label>
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
                                        <i class="fas fa-clipboard text-info me-2"></i>Additional Information
                                    </h5>

                                    <div class="mb-4">
                                        <label for="workHours" class="form-label">Typical Work Hours<span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="typical_working_hours"
                                            id="workHours" placeholder="e.g. 7:00 AM - 5:00 PM, Monday to Saturday" />
                                    </div>

                                    <div class="mb-4">
                                        <label for="notes" class="form-label">Special Instructions or Notes<span
                                                style="color: red;">*</span></label>
                                        <textarea class="form-control" name="special_instructions" id="notes" rows="3"
                                            placeholder="Any additional information about your project, location, or requirements..."></textarea>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="agreeTerms" required />
                                        <label class="form-check-label" for="agreeTerms">
                                            I agree to receive communications regarding worker applications and project
                                            updates *
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <script>
        function toggleEmployerType() {
            const individualRadio = document.querySelector('input[name="employer_type"][value="individual"]');
            const companyRadio = document.querySelector('input[name="employer_type"][value="company"]');
            const companyFields = document.getElementById('companyFields');
            const companyNameField = document.getElementById('companyNameField');
            const addressTitle = document.getElementById('addressTitle');
            const jobTitle = document.getElementById('jobTitle');
            const department = document.getElementById('department');
            const companyName = document.getElementById('companyname');

            // Update card selection styling
            document.getElementById('individualCard').classList.remove('selected');
            document.getElementById('companyCard').classList.remove('selected');

            if (individualRadio.checked) {
                document.getElementById('individualCard').classList.add('selected');
                companyFields.style.display = 'none';
                companyNameField.style.display = 'none';
                addressTitle.textContent = 'Your Address';

                // Remove required attribute for company fields
                jobTitle.removeAttribute('required');
                department.removeAttribute('required');
                companyName.removeAttribute('required');

                // Clear values of company fields when individual is selected
                jobTitle.value = '';
                department.value = '';
                companyName.value = '';
            } else if (companyRadio.checked) {
                document.getElementById('companyCard').classList.add('selected');
                companyFields.style.display = 'block';
                companyNameField.style.display = 'block';
                addressTitle.textContent = 'Company Address';

                // Add required attribute for company fields
                jobTitle.setAttribute('required', 'required');
                department.setAttribute('required', 'required');
                companyName.setAttribute('required', 'required');
            }
        }

        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling.querySelector('i');

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function checkPasswordStrength(password) {
            const strengthBar = document.getElementById('passwordStrengthBar');
            const feedback = document.getElementById('passwordFeedback');

            let strength = 0;
            if (password.length >= 8) strength++;
            if (password.length >= 12) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/\d/.test(password)) strength++;
            if (/[^a-zA-Z\d]/.test(password)) strength++;

            const percentage = (strength / 5) * 100;
            strengthBar.style.width = percentage + '%';

            if (strength <= 2) {
                strengthBar.className = 'progress-bar bg-danger';
                feedback.textContent = 'Weak password';
                feedback.className = 'form-text text-danger mt-1';
            } else if (strength === 3) {
                strengthBar.className = 'progress-bar bg-warning';
                feedback.textContent = 'Medium password';
                feedback.className = 'form-text text-warning mt-1';
            } else {
                strengthBar.className = 'progress-bar bg-success';
                feedback.textContent = 'Strong password';
                feedback.className = 'form-text text-success mt-1';
            }
        }

        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmation = document.getElementById('password_confirmation').value;
            const feedback = document.getElementById('matchFeedback');

            if (confirmation.length === 0) {
                feedback.textContent = '';
                return;
            }

            if (password === confirmation) {
                feedback.textContent = 'Passwords match';
                feedback.className = 'form-text text-success mt-1';
            } else {
                feedback.textContent = 'Passwords do not match';
                feedback.className = 'form-text text-danger mt-1';
            }
        }

        function previousStep() {
            // Add your previous step logic here
            console.log('Going to previous step');
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const hamburger = document.getElementById("hamburger");
            const navLinks = document.getElementById("navLinks");

            if (!hamburger || !navLinks) return;

            // Toggle menu visibility
            hamburger.addEventListener("click", function(e) {
                e.stopPropagation();
                hamburger.classList.toggle("active");
                navLinks.classList.toggle("active");
            });

            // Close menu when clicking outside
            document.addEventListener("click", function(e) {
                if (!navLinks.contains(e.target) && !hamburger.contains(e.target)) {
                    hamburger.classList.remove("active");
                    navLinks.classList.remove("active");
                }
            });

            // Handle dropdown buttons (Sign in / Sign up)
            document.querySelectorAll(".dropdown button").forEach(btn => {
                btn.addEventListener("click", e => {
                    e.stopPropagation();
                    const dropdown = btn.closest(".dropdown");
                    dropdown.classList.toggle("active");
                });
            });

            // Close dropdown when a link is clicked
            document.querySelectorAll(".dropdown-menu a").forEach(link => {
                link.addEventListener("click", () => {
                    document.querySelectorAll(".dropdown.active").forEach(d => d.classList.remove(
                        "active"));
                    hamburger.classList.remove("active");
                    navLinks.classList.remove("active");
                });
            });
        });

        (function() {
            function log(...args) {
                if (window.console) console.log('[nav]', ...args);
            }

            document.addEventListener('DOMContentLoaded', () => {
                try {
                    // ====== wire new mobile-navbar ======
                    const hamburger = document.getElementById('m-hamburger');
                    const mobileNavbar = document.getElementById('mobileNavbar');
                    const closeMenu = document.getElementById('closeMenu');
                    const overlay = document.getElementById('mobileOverlay');

                    function openMenu() {
                        mobileNavbar.classList.add('open');
                        overlay.classList.add('show');
                        hamburger.classList.add('active');
                        hamburger.setAttribute('aria-expanded', 'true');
                        mobileNavbar.setAttribute('aria-hidden', 'false');
                        document.body.style.overflow = 'hidden';
                    }

                    function closeMenuFn() {
                        mobileNavbar.classList.remove('open');
                        overlay.classList.remove('show');
                        hamburger.classList.remove('active');
                        hamburger.setAttribute('aria-expanded', 'false');
                        mobileNavbar.setAttribute('aria-hidden', 'true');
                        document.body.style.overflow = 'auto';
                    }

                    if (hamburger && mobileNavbar) {
                        hamburger.addEventListener('click', (e) => {
                            e.stopPropagation();
                            if (window.innerWidth <= 768) {
                                if (mobileNavbar.classList.contains('open')) closeMenuFn();
                                else openMenu();
                            }
                        });

                        closeMenu.addEventListener('click', (e) => {
                            e.stopPropagation();
                            closeMenuFn();
                        });

                        overlay.addEventListener('click', closeMenuFn);

                        // dropdown toggles
                        mobileNavbar.querySelectorAll('.dropdown').forEach(drop => {
                            const btn = drop.querySelector('.dropdown-btn');
                            const menu = drop.querySelector('.dropdown-content');
                            btn.addEventListener('click', (ev) => {
                                ev.stopPropagation();
                                const isOpen = drop.classList.toggle('open');
                                btn.setAttribute('aria-expanded', String(isOpen));
                                if (menu) menu.setAttribute('aria-hidden', String(!isOpen));
                            });
                        });

                        // close when selecting a link
                        mobileNavbar.querySelectorAll('a').forEach(a => {
                            a.addEventListener('click', () => closeMenuFn());
                        });

                        // close on ESC
                        document.addEventListener('keydown', (e) => {
                            if (e.key === 'Escape') closeMenuFn();
                        });

                        // click outside closes menu
                        document.addEventListener('click', (e) => {
                            if (!mobileNavbar.contains(e.target) && !hamburger.contains(e.target)) {
                                closeMenuFn();
                            }
                        });

                        log('Mobile navbar initialized');
                    }
                } catch (err) {
                    log('Error:', err.message);
                }
            });
        })();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previousStep() {
            window.location.href = "{{ route('employer.register.display') }}";
        }
    </script>
</body>

</html>
