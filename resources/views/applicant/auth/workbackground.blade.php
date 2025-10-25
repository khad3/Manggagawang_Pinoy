<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobHub - Work Background</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/applicant/landingpage/landingpage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/applicant/workbackground.css') }}">
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
    <!-- Loader -->
    <div id="loader-wrapper">
        <div id="loader-content">
            <div
                style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.4)); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; font-weight: 700; color: white;">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" style="max-width: 100px;">
            </div>
            <div id="loader"></div>
            <div id="loader-text">Please wait...</div>
        </div>
    </div>

    <!-- Step Content -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card form-card" style="margin-top:100px;">
                <div class="card-header bg-white border-0 py-4">
                    <div class="container">

                        <!-- Header -->
                        <div class="text-center mb-5">
                            <h1 class="display-4 fw-bold text-dark mb-3">Worker Registration</h1>
                            <p class="lead text-muted">Showcase your TESDA-certified skills and connect with employers
                                who value your expertise.</p>
                        </div>

                        <!-- Progress Stepper -->
                        <div class="row justify-content-center mb-5">
                            <div class="col-lg-10">
                                <div class="d-flex align-items-center justify-content-between">

                                    <!-- Step 1 -->
                                    <div class="text-center">
                                        <div class="step-indicator step-completed" id="step1">1</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-muted">Account</small>
                                            <br><small class="text-muted d-none d-sm-block">Account setup</small>
                                        </div>
                                    </div>
                                    <div class="step-line step-line-completed" id="line2"></div>

                                    <!-- Step 2 -->
                                    <div class="text-center">
                                        <div class="step-indicator step-completed" id="step2">2</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-muted">Verify</small>
                                            <br><small class="text-muted d-none d-sm-block">Verification</small>
                                        </div>
                                    </div>
                                    <div class="step-line step-line-completed" id="line3"></div>

                                    <!-- Step 3 -->
                                    <div class="text-center">
                                        <div class="step-indicator step-completed" id="step3">3</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-muted">Personal</small>
                                            <br><small class="text-muted d-none d-sm-block">Personal info</small>
                                        </div>
                                    </div>
                                    <div class="step-line step-line-completed" id="line4"></div>

                                    <!-- Step 4 -->
                                    <div class="text-center">
                                        <div class="step-indicator step-active" id="step4">4</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-dark">Work</small>
                                            <br><small class="text-muted d-none d-sm-block">Work details</small>
                                        </div>
                                    </div>
                                    <div class="step-line" id="line5"></div>

                                    <!-- Step 5 -->
                                    <div class="text-center">
                                        <div class="step-indicator step-inactive" id="step5">5</div>
                                        <div class="mt-2">
                                            <small class="fw-semibold text-muted">Profile</small>
                                            <br><small class="text-muted d-none d-sm-block">Build profile</small>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div> <!-- End Stepper -->

                    </div>
                </div>
                <!-- Form Content -->
                <div class="card-body p-4">

                    <h2 class="form-title">Work Background</h2>
                    <p class="form-subtitle">Tell us about your professional experience</p>


                    <!-- Work Background Form -->
                    <form action="{{ route('applicant.info.workbackground.store') }}" method="POST"
                        enctype="multipart/form-data" id="workForm">
                        @csrf
                        <input type="hidden" name="id" value="{{ $applicant->id ?? '' }}">

                        <!-- Position -->
                        <div class="form-group fade-in" style="animation-delay: 0.1s;">
                            <label for="position" class="form-label">
                                <i class="bi bi-person-workspace me-2"></i>What position are you applying for?
                            </label>
                            <select class="form-select" id="position" name="position" required
                                onchange="toggleOtherPosition()">
                                <option value="" disabled selected>Select job position</option>
                                <option value="Automotive Servicing">Automotive Servicing</option>
                                <option value="Bartender">Bartender</option>
                                <option value="Barista">Barista</option>
                                <option value="Beauty Care Specialist">Beauty Care Specialist</option>
                                <option value="Carpenter">Carpenter</option>
                                <option value="Cook">Cook</option>
                                <option value="Customer Service Representative">Customer Service Representative
                                </option>
                                <option value="Dressmaker/Tailor">Dressmaker/Tailor</option>
                                <option value="Electrician">Electrician</option>
                                <option value="Food and Beverage Server">Food and Beverage Server</option>
                                <option value="Hairdresser">Hairdresser</option>
                                <option value="Heavy Equipment Operator">Heavy Equipment Operator</option>
                                <option value="Housekeeping">Housekeeping</option>
                                <option value="Mason">Mason</option>
                                <option value="Massage Therapist">Massage Therapist</option>
                                <option value="Mechanic">Mechanic</option>
                                <option value="Plumber">Plumber</option>
                                <option value="Security Guard">Security Guard</option>
                                <option value="SMAW Welder">SMAW Welder</option>
                                <option value="Tile Setter">Tile Setter</option>
                                <option value="Tourism Services Staff">Tourism Services Staff</option>
                                <option value="Waiter/Waitress">Waiter/Waitress</option>
                                <option value="Other">Other (Please specify)</option>
                            </select>

                            <!-- Other Position Input -->
                            <div class="other-position" id="otherPositionContainer">
                                <input type="text" class="form-input" id="other_position" name="other_position"
                                    placeholder="Please specify your position">
                            </div>
                        </div>

                        <!-- Work Experience -->
                        <div class="form-group fade-in" style="animation-delay: 0.2s;">
                            <label class="form-label">
                                <i class="bi bi-clock-history me-2"></i>How long have you been working?
                            </label>
                            <div class="duration-group">
                                <input type="number" class="form-input" id="work_duration" name="work_duration"
                                    min="0" placeholder="Enter duration" required>
                                <select class="form-select" id="work_duration_unit" name="work_duration_unit"
                                    required>
                                    <option value="years" selected>Years</option>
                                    <option value="months">Months</option>
                                </select>
                            </div>
                        </div>

                        <!-- Currently Employed -->
                        <div class="form-group fade-in" style="animation-delay: 0.3s;">
                            <label class="form-label">
                                <i class="bi bi-person-check me-2"></i>Are you currently employed?
                            </label>
                            <div class="employment-toggle">
                                <button type="button" class="toggle-option" data-value="yes"
                                    onclick="setEmploymentStatus('yes')">
                                    <i class="bi bi-check-circle me-1"></i>Yes, I am employed
                                </button>
                                <button type="button" class="toggle-option" data-value="no"
                                    onclick="setEmploymentStatus('no')">
                                    <i class="bi bi-x-circle me-1"></i>No, I'm not employed
                                </button>
                            </div>
                            <input type="hidden" name="employed" id="employed" required>
                        </div>

                        <!-- Profile Picture Upload -->
                        <div class="form-group fade-in" style="animation-delay: 0.4s;">
                            <label class="form-label">
                                <i class="bi bi-camera me-2"></i>Upload Profile Picture
                                <span style="font-weight: 400; color: #6b7280; font-size: 14px;">(Optional)</span>
                            </label>

                            <div class="file-upload-area" onclick="document.getElementById('profile_picture').click()"
                                ondrop="handleDrop(event)" ondragover="handleDragOver(event)"
                                ondragleave="handleDragLeave(event)">
                                <div class="upload-icon">
                                    <i class="bi bi-cloud-upload" style="color: white; font-size: 20px;"></i>
                                </div>
                                <div class="upload-text">Click to upload or drag and drop</div>
                                <div class="upload-subtext">PNG, JPG, GIF up to 5MB</div>

                                <div class="file-selected" id="fileSelected">
                                    <i class="bi bi-check-circle me-1"></i>
                                    <span id="fileName"></span>
                                </div>
                            </div>

                            <input type="file" id="profile_picture" name="profile_picture" accept="image/*"
                                style="display: none;" onchange="handleFileSelect(this)">
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="submit-btn" id="submitBtn" disabled>
                            <i class="bi bi-arrow-right me-2"></i>Continue to Profile Setup
                        </button>
                    </form>
                </div>
            </div>

            <!-- Bootstrap JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

            <script>
                // Hide loader after page load
                window.addEventListener("load", function() {
                    setTimeout(function() {
                        document.getElementById("loader-wrapper").style.display = "none";
                    }, 1500);
                });

                // Toggle other position field
                function toggleOtherPosition() {
                    const positionSelect = document.getElementById("position");
                    const otherContainer = document.getElementById("otherPositionContainer");
                    const otherInput = document.getElementById("other_position");

                    if (positionSelect.value === "Other") {
                        otherContainer.classList.add("show");
                        otherInput.setAttribute("required", "required");
                    } else {
                        otherContainer.classList.remove("show");
                        otherInput.removeAttribute("required");
                        otherInput.value = "";
                    }

                    validateForm();
                }

                // Set employment status
                function setEmploymentStatus(status) {
                    const buttons = document.querySelectorAll('.toggle-option');
                    const hiddenInput = document.getElementById('employed');

                    buttons.forEach(btn => btn.classList.remove('active'));
                    document.querySelector(`[data-value="${status}"]`).classList.add('active');
                    hiddenInput.value = status;

                    validateForm();
                }

                // File upload handlers
                function handleFileSelect(input) {
                    const file = input.files[0];
                    if (file) {
                        document.getElementById('fileName').textContent = file.name;
                        document.getElementById('fileSelected').style.display = 'block';
                    }
                }

                function handleDrop(event) {
                    event.preventDefault();
                    const uploadArea = event.currentTarget;
                    uploadArea.classList.remove('dragover');

                    const files = event.dataTransfer.files;
                    if (files.length > 0) {
                        const fileInput = document.getElementById('profile_picture');
                        fileInput.files = files;
                        handleFileSelect(fileInput);
                    }
                }

                function handleDragOver(event) {
                    event.preventDefault();
                    event.currentTarget.classList.add('dragover');
                }

                function handleDragLeave(event) {
                    event.currentTarget.classList.remove('dragover');
                }

                // Form validation
                function validateForm() {
                    const position = document.getElementById('position').value;
                    const workDuration = document.getElementById('work_duration').value;
                    const workDurationUnit = document.getElementById('work_duration_unit').value;
                    const employed = document.getElementById('employed').value;
                    const otherPosition = document.getElementById('other_position');

                    let isValid = true;

                    // Check required fields
                    if (!position || !workDuration || !workDurationUnit || !employed) {
                        isValid = false;
                    }

                    // Check other position if "Other" is selected
                    if (position === "Other" && (!otherPosition.value || !otherPosition.value.trim())) {
                        isValid = false;
                    }

                    // Enable/disable submit button
                    const submitBtn = document.getElementById('submitBtn');
                    submitBtn.disabled = !isValid;

                    if (isValid) {
                        submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Continue to Profile Setup';
                    } else {
                        submitBtn.innerHTML = '<i class="bi bi-arrow-right me-2"></i>Continue to Profile Setup';
                    }
                }

                // Initialize form
                document.addEventListener('DOMContentLoaded', function() {
                    // Add event listeners for form validation
                    const inputs = document.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        input.addEventListener('input', validateForm);
                        input.addEventListener('change', validateForm);
                    });

                    // Work duration unit change handler
                    document.getElementById('work_duration_unit').addEventListener('change', function() {
                        const durationInput = document.getElementById('work_duration');
                        if (this.value === 'months') {
                            durationInput.placeholder = 'Enter months (max 11)';
                            durationInput.max = 11;
                        } else {
                            durationInput.placeholder = 'Enter years';
                            durationInput.removeAttribute('max');
                        }
                    });

                    // Initial validation
                    validateForm();
                });

                // Form submission handler
                document.getElementById('workForm').addEventListener('submit', function(e) {
                    if (!document.getElementById('employed').value) {
                        e.preventDefault();
                        alert('Please select your current employment status.');
                        return;
                    }

                    const position = document.getElementById('position').value;
                    const otherPosition = document.getElementById('other_position').value;

                    if (position === 'Other' && !otherPosition.trim()) {
                        e.preventDefault();
                        alert('Please specify your position.');
                        return;
                    }
                });
            </script>
</body>

</html>
