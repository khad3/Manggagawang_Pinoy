<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Review Registration - Employer Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="{{ asset('css/applicant/employer/reviewregistration.css') }}" rel="stylesheet" />
     <link href="{{ asset('css/applicant/landingpage/landingpage.css') }}" rel="stylesheet" />

</head>

<body>
   <nav>
        <div class="navbar-container">
            <div class="nav-logo d-flex align-items-center">
                <a href="{{ route('display.index') }}" class="d-flex align-items-center gap-2" style="text-decoration:none;">
                    <img src="{{ asset('img/logotext.png') }}" alt="MP Logo" id="home"/>
                    <img src="{{ asset('img/logo.png') }}" alt="MP Logo" id="home2"/>
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

   
            <!-- Review Content -->
          <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card form-card">
                         <div class="registration-container">
        <div class="container">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-dark mb-3">
                    Review Your Registration
                </h1>
                <p class="lead text-muted">
                    Please review all information before submitting your employer
                    registration
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
                                <br /><small class="text-muted d-none d-sm-block">Position requirements</small>
                            </div>
                        </div>
                        <div class="step-line step-line-completed" id="line1"></div>

                        <!-- Step 2 -->
                        <div class="text-center">
                            <div class="step-indicator step-completed" id="step2">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="mt-2">
                                <small class="fw-semibold text-dark">Contact</small>
                                <br /><small class="text-muted d-none d-sm-block">Your contact info</small>
                            </div>
                        </div>
                        <div class="step-line step-line-completed" id="line2"></div>

                        <!-- Step 3 -->
                        <div class="text-center">
                            <div class="step-indicator step-completed" id="step3">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="mt-2">
                                <small class="fw-semibold text-dark">Preferences</small>
                                <br /><small class="text-muted d-none d-sm-block">Hiring preferences</small>
                            </div>
                        </div>
                        <div class="step-line step-line-completed" id="line3"></div>

                        <!-- Step 4 -->
                        <div class="text-center">
                            <div class="step-indicator step-active" id="step4">4</div>
                            <div class="mt-2">
                                <small class="fw-semibold text-dark">Review</small>
                                <br /><small class="text-muted d-none d-sm-block">Review & submit</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-building text-primary me-2"></i>Company
                                    Information
                                </h5>
                                <a href="employer-registration.html" class="edit-link">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="summary-item">
                                <strong>{{ $retrievedCompanyAddress->company_name }}</strong>
                                <div class="text-muted">{{ $retrievedJobDetail->department }}</div>
                                <div class="small text-muted">{{ $retrievedCompanyAddress->company_complete_address }}
                                </div>
                            </div>
                            <div class="mt-3">
                                <p class="small">
                                    {{ $retrievedJobDetail->job_description }}
                                </p>
                            </div>
                            <div class="tesda-highlight">
                                <small class="fw-bold">
                                    <i class="fas fa-certificate me-1"></i>TESDA Partnership
                                    Status:
                                </small>
                                <br /><small>✓ {{ $retrievedCertPriority->tesda_priority }}</small>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Contact Information -->
                <div class="mb-4">
                    <div class="review-card">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-user text-success me-2"></i>Contact
                                    Information
                                </h5>
                                <a href="contact-info.html" class="edit-link">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="summary-item">
                                <strong>{{ $retrievedPersonalInfo->first_name }}
                                    {{ $retrievedPersonalInfo->last_name }}</strong>
                                <div class="text-muted">{{ $retrievedPersonalInfo->employer_job_title }}</div>
                            </div>
                            <div class="mt-3">
                                <p class="mb-1">
                                    <i class="fas fa-envelope text-muted me-2"></i>
                                    {{ $retrievedPersonalInfo->email }}
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-phone text-muted me-2"></i>
                                    {{ $retrievedPersonalInfo->phone_number }}
                                </p>
                                <p class="mb-3">
                                    <i class="fas fa-map-marker-alt text-muted me-2"></i>
                                    {{ $retrievedCompanyAddress->company_complete_address }}
                                    {{ $retrievedCompanyAddress->company_municipality }},
                                    {{ $retrievedCompanyAddress->company_province }}
                                </p>
                                <div class="small">
                                    <strong>Preferred Contact:</strong>
                                    {{ $retrievedCommunication->contact_method }}<br />
                                    <strong>Best Time:</strong> {{ $retrievedCommunication->contact_time }}<br />
                                    <strong>Language:</strong> {{ $retrievedCommunication->language_preference }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Job Details -->
                <div class="col-12 mb-4">
                    <div class="review-card">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-briefcase text-warning me-2"></i>Job Details
                                </h5>
                                <a href="job-details.html" class="edit-link">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="summary-item">
                                        <strong>{{ $retrievedJobDetail->title }}</strong>
                                        <div class="text-muted">
                                            {{ $retrievedCompanyAddress->department }} •
                                            {{ $retrievedJobDetail->location }}• {{ $retrievedJobDetail->work_type }}
                                        </div>
                                        <div class="text-muted">
                                            {{ $retrievedJobDetail->experience_level }} •
                                            ₱{{ $retrievedJobDetail->job_salary }}/month
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <p class="small">
                                            <strong>Job Description:</strong>
                                            {{ $retrievedJobDetail->job_description }}

                                            <br />
                                            <strong>Job Requirements:</strong>
                                            {{ $retrievedJobDetail->additional_requirements ?? 'No additional requirements' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="tesda-highlight">
                                        <strong class="">Required TESDA Certifications:</strong>
                                        <div class="mt-2">
                                            @php
                                                $certs = [];

                                                if (!empty($retrievedJobDetail->tesda_certification)) {
                                                    $certsRaw = $retrievedJobDetail->tesda_certification;
                                                } elseif (!empty($retrievedJobDetail->other_certifications)) {
                                                    $certsRaw = $retrievedJobDetail->other_certifications;
                                                } elseif (
                                                    !empty($retrievedJobDetail->none_certifications_qualification)
                                                ) {
                                                    $certsRaw = $retrievedJobDetail->none_certifications_qualification;
                                                } else {
                                                    $certsRaw = null;
                                                }

                                                if ($certsRaw) {
                                                    $decoded = json_decode($certsRaw, true);

                                                    if (is_array($decoded)) {
                                                        // Stored as JSON
                                                        $certs = $decoded;
                                                    } else {
                                                        // Stored as comma-separated string
                                                        $certs = array_map('trim', explode(',', $certsRaw));
                                                    }
                                                }
                                            @endphp

                                            @if (!empty($certs))
                                                @foreach ($certs as $certification)
                                                    <span class="skill-badge">{{ $certification }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">No certifications provided.</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <strong>Benefits Offered:</strong>
                                    <div class="mt-2">

                                        @php
                                            $benefits = [];

                                            if (!empty($retrievedJobDetail->benefits)) {
                                                $decoded = json_decode($retrievedJobDetail->benefits, true);

                                                if (is_array($decoded)) {
                                                    // Benefits stored as JSON array
                                                    $benefits = $decoded;
                                                } else {
                                                    // Fallback: plain comma-separated string
                                                    $benefits = array_map(
                                                        'trim',
                                                        explode(',', $retrievedJobDetail->benefits),
                                                    );
                                                }
                                            }
                                        @endphp

                                        @if (!empty($benefits))
                                            @foreach ($benefits as $benefit)
                                                <span class="skill-badge">{{ $benefit }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">No benefits selected.</span>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hiring Preferences -->
                <div class="col-12 mb-4">
                    <div class="review-card">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-cog text-info me-2"></i>Hiring Preferences
                                </h5>
                                <a href="preferences.html" class="edit-link">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="summary-item">
                                        <strong>Timeline</strong>
                                        <div class="text-muted">
                                            {{ $retrievedHiringTimeline->hiring_timeline ?? 'No hiring timeline' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="summary-item">
                                        <strong>Workers Needed</strong>
                                        <div class="text-muted">{{ $retrievedWorkerRequirement->number_of_workers }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="summary-item">
                                        <strong>Project Duration</strong>
                                        <div class="text-muted">{{ $retrievedWorkerRequirement->project_duration }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <strong>TESDA Priority:</strong>
                                    <div class="mt-1">

                                        <i
                                            class="fas fa-check text-success me-2"></i>{{ $retrievedCertPriority->tesda_priority }}

                                    </div>
                                </div>
                                <!-- <div class="col-md-6">
                    <strong>Communication:</strong>
                    <div class="mt-1">
                   
                      <i class="fas fa-check text-success me-2"></i>Email notifications<br />
                      <i class="fas fa-check text-success me-2"></i>SMS notifications
                    </div>
                  </div> -->
                            </div>

                            <div class="mt-3">
                                <strong>Screening Methods:</strong>
                                @foreach (json_decode($retrievedInterviewScreening->preferred_screening_method ?? '[]') as $interview)
                                    <span class="skill-badge">{{ $interview }}</span>
                                @endforeach

                                <span
                                    class="skill-badge">{{ $retrievedInterviewScreening->preferred_interview_location }}</span>

                            </div>

                            <div class="mt-3">
                                <strong>location of interview:</strong>
                                <span
                                    class="skill-badge">{{ $retrievedInterviewScreening->preferred_interview_location }}</span>

                            </div>

                            <div class="mt-3">
                                <strong>Special Requirements:</strong>
                                <div class="mt-1">
                                    @foreach (json_decode($retrievedSpecialRequirement->special_requirements ?? '[]') as $requirements)
                                        <i class="fas fa-check text-success me-2"></i>{{ $requirements }}<br />
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Final Checklist -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="final-checklist">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-clipboard-check text-success me-2"></i>Final
                            Checklist
                        </h5>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="reviewComplete" required />
                            <label class="form-check-label" for="reviewComplete">
                                I have reviewed all information and confirm it is accurate
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="agreeTerms" required />
                            <label class="form-check-label" for="agreeTerms">
                                I agree to Mangagawang Pinoy's
                                <a href="{{ route('display.termsandconditions') }}"
                                    class="text-decoration-underline">Terms of Service</a>
                                and
                                <a href="#" class="text-decoration-underline">Privacy Policy</a>
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="communicationConsent" required />
                            <label class="form-check-label" for="communicationConsent">
                                I consent to receiving communications about worker applications
                                and platform updates
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="dataProcessing" required />
                            <label class="form-check-label" for="dataProcessing">
                                I consent to the processing of my company and personal data for
                                hiring purposes in accordance with the Data Privacy Act
                            </label>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>What happens next?</strong><br />
                            After submission, our team will review your registration within
                            24 hours. You'll receive an email confirmation and can start
                            receiving worker applications immediately upon approval.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="row justify-content-center mt-4">
                <div class="col-lg-8">
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-outline-secondary" onclick="previousStep()">
                            <i class="fas fa-arrow-left me-2"></i>Previous
                        </button>
                        <small class="text-muted">Step 4 of 4</small>
                        <form action="{{ route('employer.sendVerificationEmail') }}" method="POST">
                            @csrf
                            <input type="hidden" name="account_email" value="{{ $retriedAccountInfo->email }}">
                            <button type="submit" class="btn btn-success-custom"><i
                                    class="fas fa-check-circle me-2"></i>Submit Registration </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function submitRegistration() {
            // Check all required checkboxes
            const requiredCheckboxes = [
                "reviewComplete",
                "agreeTerms",
                "communicationConsent",
                "dataProcessing",
            ];

            let allChecked = true;
            requiredCheckboxes.forEach((id) => {
                if (!document.getElementById(id).checked) {
                    allChecked = false;
                }
            });

            if (!allChecked) {
                alert(
                    "Please complete all required checkboxes before submitting.",
                );
                return;
            }

            // Show loading state
            const submitBtn = document.getElementById("submitBtn");
            submitBtn.innerHTML =
                '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
            submitBtn.disabled = true;

            // Simulate submission delay
            setTimeout(() => {
                window.location.href = "{{ route('employer.successregistration.display') }}";
            }, 2000);
        }

        function previousStep() {
            window.location.href = "{{ route('employer.reviewregistration.display') }}";
        }
    </script>
</body>

</html>
