<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hiring Preferences - Employer Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="{{ asset('css/applicant/employer/hiringpreference.css') }}" rel="stylesheet" />
</head>

<body>
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

                        <!-- Step 4 -->
                        <div class="text-center">
                            <div class="step-indicator step-active" id="step3">3</div>
                            <div class="mt-2">
                                <small class="fw-semibold text-dark">Preferences</small>
                                <br /><small class="text-muted d-none d-sm-block">Hiring preferences</small>
                            </div>
                        </div>
                        <div class="step-line" id="line3"></div>

                        <!-- Step 5 -->
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

            <!-- Step Content -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card form-card">
                        <div class="card-header bg-white border-0 py-4">
                            <h3 class="card-title mb-2">Hiring Preferences</h3>
                            <p class="text-muted mb-0">
                                Configure your hiring preferences and communication settings to
                                streamline your recruitment process.
                            </p>
                        </div>
                        <div class="card-body p-4">

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

                            <form id="preferencesForm" action="{{ route('employer.hiringpreference.store') }}"
                                method="POST">
                                @csrf
                                <div class="tesda-priority">
                                    <h5 class="text-warning mb-3">
                                        <i class="fas fa-certificate me-2"></i>TESDA Certification Priority
                                    </h5>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="tesda_certi_priority"
                                            id="tesdaOnly" value="Only consider TESDA-certified workers" required>
                                        <label class="form-check-label fw-bold" for="tesdaOnly"> Only consider
                                            TESDA-certified workers </label>
                                        <div class="text-muted small mt-1"> Strictly filter candidates to only those
                                            with valid TESDA certifications </div>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="tesda_certi_priority"
                                            id="tesdaPreferred" value="Prefer TESDA-certified but consider others">
                                        <label class="form-check-label fw-bold" for="tesdaPreferred"> Prefer
                                            TESDA-certified but consider others </label>
                                        <div class="text-muted small mt-1"> Prioritize TESDA-certified workers but
                                            accept skilled workers with equivalent experience </div>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tesda_certi_priority"
                                            id="skillsBased"
                                            value="Skills-based evaluation (certification not required)">
                                        <label class="form-check-label fw-bold" for="skillsBased"> Skills-based
                                            evaluation (certification not required) </label>
                                        <div class="text-muted small mt-1"> Evaluate candidates based on practical
                                            skills and experience regardless of certification </div>
                                    </div>
                                </div>


                                <!-- Hiring Timeline -->
                                <div class="preference-card">
                                    <h5 class="fw-bold mb-3">
                                        <i class="fas fa-clock text-primary me-2"></i>Hiring Timeline
                                    </h5>
                                    <p class="text-muted mb-3">When do you need workers to start?</p>

                                    <!-- Immediate Option -->
                                    <div class="timeline-option" onclick="selectTimeline(this, 'immediate')">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hiring_timeline"
                                                id="timeline_immediate" value="Immediate (within 1 week)" />
                                            <label class="form-check-label fw-bold" for="timeline_immediate">
                                                Immediate (within 1 week) </label>
                                            <div class="text-muted small"> Urgent requirement - workers needed ASAP
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Soon Option -->
                                    <div class="timeline-option" onclick="selectTimeline(this, 'soon')">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hiring_timeline"
                                                id="timeline_soon" value="Within 2-4 weeks" />
                                            <label class="form-check-label fw-bold" for="timeline_soon"> Within 2-4
                                                weeks </label>
                                            <div class="text-muted small"> Normal timeline for project planning </div>
                                        </div>
                                    </div>

                                    <!-- 1-2 Months Option -->
                                    <div class="timeline-option" onclick="selectTimeline(this, 'month')">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hiring_timeline"
                                                id="timeline_month" value="Within 1-2 months" />
                                            <label class="form-check-label fw-bold" for="timeline_month"> Within 1-2
                                                months </label>
                                            <div class="text-muted small"> Planning ahead for upcoming projects </div>
                                        </div>
                                    </div>

                                    <!-- Flexible Option -->
                                    <div class="timeline-option" onclick="selectTimeline(this, 'flexible')">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hiring_timeline"
                                                id="timeline_flexible" value="Flexible timeline" />
                                            <label class="form-check-label fw-bold" for="timeline_flexible"> Flexible
                                                timeline </label>
                                            <div class="text-muted small"> Building a candidate pool for future needs
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Worker Requirements -->
                                <div class="preference-card">
                                    <h5 class="fw-bold mb-3">
                                        <i class="fas fa-users text-success me-2"></i>Worker
                                        Requirements
                                    </h5>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="workersNeeded" class="form-label">Number of Workers
                                                Needed</label>
                                            <select class="form-select" id="workersNeeded" name="workers_needed">
                                                <option value="">Select number</option>
                                                <option value="1 worker">1 worker</option>
                                                <option value="2-5 workers">2-5 workers</option>
                                                <option value="6-10 workers">6-10 workers</option>
                                                <option value="11-20 workers">11-20 workers</option>
                                                <option value="20+  workers">More than 20 workers</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="projectDuration" class="form-label">Project Duration</label>
                                            <select class="form-select" id="projectDuration" name="project_duration">
                                                <option value="">Select duration</option>
                                                <option value="Daily/Per day">Daily/Per day</option>
                                                <option value="Weekly">Weekly</option>
                                                <option value="Monthly">Monthly</option>
                                                <option value="3-months">3-6 months</option>
                                                <option value="6-months">6-12 months</option>
                                                <option value="Permanent position">Permanent position</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Worker Experience Preference</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="worker_experience[]"
                                                value="Apprentice-level workers (0-1 years experience)"
                                                id="apprenticeOk" />
                                            <label class="form-check-label" for="apprenticeOk">
                                                Accept apprentice-level workers (0-1 years)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" name="worker_experience[]"
                                                value="Skilled workers (2-5 years experience)" type="checkbox"
                                                id="skilledWorkers" />
                                            <label class="form-check-label" for="skilledWorkers">
                                                Skilled workers (2-5 years experience)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" name="worker_experience[]"
                                                value="Experienced craftsmen (6+ years experience)" type="checkbox"
                                                id="experiencedWorkers" />
                                            <label class="form-check-label" for="experiencedWorkers">
                                                Experienced craftsmen (6+ years)
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Interview & Screening Preferences -->
                                <div class="preference-card">
                                    <h5 class="fw-bold mb-3">
                                        <i class="fas fa-clipboard-check text-warning me-2"></i>Interview & Screening
                                        Preferences
                                    </h5>

                                    <div class="mb-3">
                                        <label class="form-label">Preferred Screening Methods</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="preferred_screening_method[]"
                                                        value="Phone/Video interview" id="phoneInterview" />
                                                    <label class="form-check-label" for="phoneInterview">Phone/Video
                                                        interview</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="preferred_screening_method[]"
                                                        value="In-person interview" id="inPersonInterview" />
                                                    <label class="form-check-label" for="inPersonInterview">In-person
                                                        interview</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="preferred_screening_method[]"
                                                        value="Skills demonstration/test" id="skillsDemo" />
                                                    <label class="form-check-label" for="skillsDemo">Skills
                                                        demonstration/test</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="preferred_screening_method[]" value="Reference check"
                                                        id="referenceCheck" />
                                                    <label class="form-check-label" for="referenceCheck">Reference
                                                        check</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="preferred_screening_method[]"
                                                        value="Background verification" id="backgroundCheck" />
                                                    <label class="form-check-label" for="backgroundCheck">Background
                                                        verification</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="preferred_screening_method[]" value="Drug testing"
                                                        id="drugTest" />
                                                    <label class="form-check-label" for="drugTest">Drug
                                                        testing</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="interviewLocation" class="form-label">Preferred Interview
                                            Location</label>
                                        <select class="form-select" id="interviewLocation"
                                            name="preferred_interview_location">
                                            <option value="">Select location</option>
                                            <option value="Our office/headquarters">Our office/headquarters</option>
                                            <option value="Job site/project location">Job site/project location
                                            </option>
                                            <option value="Neutral location (cafe, etc.)">Neutral location (cafe, etc.)
                                            </option>
                                            <option value="Online/Video call only">Online/Video call only</option>
                                            <option value="Flexible - worker's choice">Flexible - worker's choice
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Special Requirements -->
                                <div class="preference-card">
                                    <h5 class="fw-bold mb-3">
                                        <i class="fas fa-exclamation-triangle text-danger me-2"></i>Special
                                        Requirements
                                    </h5>

                                    <div class="switch-container">
                                        <div>
                                            <strong>Safety Training Required</strong>
                                            <div class="text-muted small">
                                                Workers must have safety training certificates
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="special_requirements[]"
                                                value="Workers must have safety training certificates" type="checkbox"
                                                id="safetyTraining" />
                                        </div>
                                    </div>

                                    <div class="switch-container">
                                        <div>
                                            <strong>Own Tools Required</strong>
                                            <div class="text-muted small">
                                                Workers must bring their own basic tools
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="special_requirements[]"
                                                value="Workers must bring their own basic tools" type="checkbox"
                                                id="ownTools" />
                                        </div>
                                    </div>

                                    <div class="switch-container">
                                        <div>
                                            <strong>Transportation Assistance</strong>
                                            <div class="text-muted small">
                                                Provide transportation or allowance
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="special_requirements[]"
                                                value="Provide Transportation or allowance" type="checkbox"
                                                id="transportation" />
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <label for="additionalRequirements" class="form-label">Additional Requirements
                                            or Notes</label>
                                        <textarea class="form-control" name="additional_requirements" id="additionalRequirements" rows="3"
                                            placeholder="Any specific requirements, work conditions, or special instructions..."></textarea>
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
                                            <small class="text-muted">Step 3 of 4</small>
                                            <button type="submit" class="btn btn-primary-custom"> Next <i
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function selectTimeline(element, value) {
            // Remove selected class from all timeline options
            document
                .querySelectorAll(".timeline-option")
                .forEach((option) => option.classList.remove("selected"));

            // Add selected class to clicked option
            element.classList.add("selected");

            // Check the radio button
            document.getElementById(value).checked = true;
        }

        function nextStep() {
            const form = document.getElementById("preferencesForm");
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            window.location.href = "{{ route('employer.reviewregistration.display') }}";
        }

        function previousStep() {
            window.location.href = "{{ route('employer.contact.display') }}";
        }
    </script>
</body>

</html>
