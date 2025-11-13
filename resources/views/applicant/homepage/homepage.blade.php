<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Homepage</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- fav icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/applicant/homepage.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />
</head>

<body>

    <!--- Notification Modal ----->
    @include('applicant.homepage.modal.notification')

    <!-- Header Navigation -->
    <header class="header">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <!-- Brand -->
                <div class="nav-logo d-flex align-items-center">

                    <img src="{{ asset('img/logotext.png') }}" alt="MP Logo" id="home" />
                    <img src="{{ asset('img/logo.png') }}" alt="MP Logo" id="home2" />

                </div>

                <!-- Search -->
                <div class="nav-search d-none d-md-block">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" id="navSearch" placeholder="Search companies, industries, descriptions...">
                </div>

                <!-- Navigation Actions -->
                <div class="nav-actions">
                    <a href="{{ route('applicant.forum.display') }}" title="Community Forum">
                        <button class="nav-icon position-relative">
                            <i class="bi bi-people"></i>

                            {{-- Combined Notification Badge --}}
                            @php
                                $totalNotifications =
                                    $friendRequests + $pendingJoinGroupRequests + $unreadMessagesCount;
                            @endphp

                            @if ($totalNotifications > 0)
                                <span class="nav-badge" id="communityBadge">{{ $totalNotifications }}</span>
                            @endif
                        </button>
                    </a>


                    <!-- Messages Dropdown -->

                    @include('applicant.homepage.navigation.messages_navigation')

                    <!-- Notifications Dropdown -->

                    @include('applicant.homepage.navigation.notification_navigation')


                    <!-- Profile Dropdown -->
                    <div class="nav-dropdown">

                        @php
                            $profileImage =
                                !empty($profile->profileimage_path) &&
                                file_exists(storage_path('app/public/' . $profile->profileimage_path))
                                    ? asset('storage/' . $profile->profileimage_path)
                                    : asset('img/workerdefault.png'); // default image
                        @endphp

                        @if (!empty($retrieveDataDecrypted['first_name']) || !empty($retrieveDataDecrypted['last_name']))
                            <button class="profile-pic" onclick="toggleDropdown('profileDropdown')" title="main menu"
                                style="border: none; background: transparent;">
                                <img src="{{ $profileImage }}"
                                    alt="{{ $retrieveDataDecrypted['first_name'] ?? 'User' }} Profile" width="50"
                                    height="50" style="border-radius: 50%; object-fit: cover;">
                            </button>
                        @endif
                        <div class="dropdown-menu profile-menu" id="profileDropdown">
                            @php
                                use Illuminate\Support\Facades\Storage;

                                // Get image path safely
                                $imagePath = $profile->profileimage_path ?? null;

                                // Check if file exists in 'public' disk (e.g., storage/app/public/profile_picture/...)
                                $hasProfileImage = $imagePath && Storage::disk('public')->exists($imagePath);

                                // Default placeholder image
                                $defaultImage = asset('img/workerdefault.png');
                            @endphp

                            <div class="profile-header">
                                <div class="profile-avatar">
                                    @if ($hasProfileImage)
                                        {{-- Show uploaded profile image --}}
                                        <img src="{{ Storage::url($imagePath) }}" alt="Profile Picture" width="50"
                                            height="50" style="border-radius: 50%; object-fit: cover;">
                                    @else
                                        {{-- Show default profile image --}}
                                        <img src="{{ $defaultImage }}" alt="Default Profile Image" width="50"
                                            height="50" style="border-radius: 50%; object-fit: cover;">
                                    @endif
                                </div>

                                <div class="profile-info">
                                    <div class="profile-name">
                                        {{ $retrieveDataDecrypted['first_name'] ?? 'Unknown' }}
                                        {{ $retrieveDataDecrypted['last_name'] ?? '' }}
                                    </div>
                                    <div class="profile-email">
                                        {{ $retrievePersonal->email ?? 'Not Provided' }}
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown-content">
                                <a href="{{ route('applicant.profile.display') }}" class="dropdown-item">
                                    <i class="bi bi-person"></i>
                                    My Profile
                                </a>
                                <a href="{{ route('applicant.callingcard.display') }}" class="dropdown-item">
                                    <i class="bi bi-person-badge"></i>
                                    Ar calling card
                                </a>
                                <a href="{{ route('applicant.resume.display') }}" class="dropdown-item">
                                    <i class="bi bi-file-text"></i>
                                    Resume Builder
                                </a>
                                <a href="{{ route('applicant.application.status.display') }}" class="dropdown-item">
                                    <i class="bi bi-file-text"></i>
                                    My Applications
                                </a>
                                <!-- <a href="#" class="dropdown-item">
                                    <i class="bi bi-bookmark"></i>
                                    Saved Jobs
                                </a> -->
                                <a href="{{ route('applicant.setting.display') }}" class="dropdown-item">
                                    <i class="bi bi-gear"></i>
                                    Settings
                                </a>
                                <a href="{{ route('applicant.report.display') }}" class="dropdown-item">
                                    <i class="bi bi-flag"></i>
                                    Report
                                </a>
                                <hr class="dropdown-divider">
                                <form id="logoutForm" method="POST" action="{{ route('applicant.logout.store') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item" onclick="return confirmLogout(event)">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>




                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Search -->
            <div class="nav-search d-md-none mt-3">
                <i class="bi bi-search search-icon"></i>
                <input type="text" id="mobileNavSearch"
                    placeholder="Search companies, industries, descriptions...">
            </div>
        </div>
    </header>

    @if (session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert"
                id="success-alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>

        <script>
            // Hide the alert after 2 seconds (2000 ms)
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    alert.classList.remove('show'); // fade out
                    alert.classList.add('fade'); // keep bootstrap fade animation
                    setTimeout(() => alert.remove(), 500); // remove from DOM after fade
                }
            }, 2000);
        </script>
    @endif


    <!-- Main Content -->
    <div class="container">
        <div class="main-section">
            <!-- Hero Banner -->
            @include('applicant.homepage.section.banner_section')

            <!-- Filter Section -->
            @include('applicant.homepage.section.filter_section')

            <!-- Results Section -->
            <section class="results-section">
                <div class="results-header">
                    <h2 class="results-count">
                        <span class="count" id="resultsCount">8</span> Companies Found
                    </h2>

                    <select class="sort-dropdown" id="sortDropdown" onchange="sortEmployers()">
                        <option value="name">Sort by Name</option>
                        <option value="rating">Sort by Rating</option>
                        <option value="location">Sort by Location</option>
                        <option value="industry">Sort by Industry</option>
                    </select>
                </div>

                <div class="employer-grid" id="employerGrid">
                    @foreach ($JobPostRetrieved as $jobDetail)
                        @if ($jobDetail->status_post === 'published')
                            @php
                                // Get all ratings for this job
                                $ratingsForJob = $JobPostRating->where('job_post_id', $jobDetail->id);
                                // Calculate average rating
                                $averageRating = $ratingsForJob->count() > 0 ? $ratingsForJob->avg('rating') : 0;
                            @endphp

                            <div class="employer-card"
                                data-company="{{ $jobDetail->employer->addressCompany->company_name ?? 'N/A' }}"
                                data-individual="{{ $jobDetail->employer?->personal_info?->first_name ?? '' }} {{ $jobDetail->employer?->personal_info?->last_name ?? '' }}"
                                data-name="{{ $jobDetail->title ?? 'N/A' }}"
                                data-industry="{{ $jobDetail->department ?? 'N/A' }}"
                                data-location="{{ $jobDetail->location ?? 'N/A' }}" data-hiring="true"
                                data-remote="false" data-featured="false"
                                data-rating="{{ number_format($averageRating, 1) }}">

                                <!-- Card Header -->
                                <div class="card-header">
                                    <div class="company-info">
                                        @php
                                            $company = $retrievedAddressCompany->firstWhere(
                                                'employer_id',
                                                $jobDetail->employer_id,
                                            );
                                            $initials =
                                                $company && !$company->company_logo
                                                    ? strtoupper(Str::limit($company->company_name ?? 'BC', 2, ''))
                                                    : '';
                                        @endphp

                                        <div class="company-avatar-wrapper">
                                            @if ($company && $company->company_logo)
                                                <img src="{{ asset('storage/' . $company->company_logo) }}"
                                                    alt="{{ $company->company_name ?? 'Company Logo' }}"
                                                    class="company-avatar-img">
                                            @elseif ($company)
                                                <div class="company-avatar-initials">{{ $initials }}</div>
                                            @else
                                                <div class="company-avatar-initials">MP</div> <!-- default fallback -->
                                            @endif
                                        </div>
                                        <div class="company-details">
                                            <h3>{{ $jobDetail->title }}</h3>
                                            <div class="company-industry">
                                                {{ $jobDetail->department }} • {{ $jobDetail->job_type }}
                                            </div>
                                            <div class="company-name" style="color:gold;">
                                                @if (!empty($jobDetail->employer->addressCompany->company_name))
                                                    {{ $jobDetail->employer->addressCompany->company_name }}
                                                @else
                                                    Individual
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                    <div class="company-badges">
                                        <span class="status-badge status-active">
                                            <i class="bi bi-lightning"></i> Hiring
                                        </span>
                                        <!-- Report Button -->
                                        @if (in_array($jobDetail->id, $reportedJobIds))
                                            <!--  If already reported -->
                                            <button class="btn btn-link text-muted p-0 ms-2 report-job-btn" disabled
                                                title="You already reported this job">
                                                <i class="bi bi-flag-fill text-danger"></i>
                                            </button>
                                        @else
                                            <!--  If not yet reported -->
                                            <button class="btn btn-link text-muted p-0 ms-2 report-job-btn"
                                                data-employer-id="{{ $jobDetail->employer_id ?? 'Unknown Employer' }}"
                                                data-job-id="{{ $jobDetail->id }}"
                                                data-title="{{ $jobDetail->title }}"
                                                data-company="{{ $jobDetail->employer?->addressCompany?->company_name ?? '' }}"
                                                data-individual="{{ optional($jobDetail->employer?->personal_info)->first_name ?? '' }} {{ optional($jobDetail->employer?->personal_info)->last_name ?? '' }}"
                                                data-bs-toggle="modal" data-bs-target="#reportJobModal"
                                                title="Report this job">
                                                <i class="bi bi-flag"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <!-- Job Description -->
                                <div class="card-body">
                                    <p class="company-description">{{ $jobDetail->job_description }}</p>

                                    @if ($jobDetail->benefits)
                                        <p class="company-description"><strong>Benefits:</strong>
                                            {{ $jobDetail->benefits }} </p>
                                    @endif
                                    <p class="company-description"><strong>Experience Level:</strong>
                                        {{ $jobDetail->experience_level }} </p>
                                    <p class="company-description"><strong>Salary range: ₱</strong>
                                        {{ $jobDetail->job_salary }} Monthly</p>
                                </div>

                                <!-- Card Footer -->
                                <div class="card-footer">
                                    <div class="company-stats">
                                        <div class="stat-item">
                                            <i class="bi bi-geo-alt"></i>
                                            <span>{{ $jobDetail->location }}</span>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="card-actions d-flex gap-2 mt-2">
                                        <!-- Rating Display & Buttons -->
                                        <div class="w-100 mt-2">
                                            @php
                                                $jobRating = $jobRatings[$jobDetail->id] ?? null;
                                                $userRating = $applicantRatings[$jobDetail->id] ?? null;
                                            @endphp

                                            @if ($jobRating)
                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                    <div class="display-rating">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= floor($jobRating->average_rating))
                                                                <i class="bi bi-star-fill"></i>
                                                            @elseif($i - 0.5 <= $jobRating->average_rating)
                                                                <i class="bi bi-star-half"></i>
                                                            @else
                                                                <i class="bi bi-star empty-star"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <span
                                                        class="text-muted">{{ number_format($jobRating->average_rating, 1) }}
                                                        ({{ $jobRating->total_ratings }}
                                                        {{ $jobRating->total_ratings == 1 ? 'review' : 'reviews' }})</span>
                                                </div>
                                            @endif

                                            <div class="d-flex gap-2">
                                                @php
                                                    $applicantId = session('applicant_id');
                                                    // Check if the logged-in applicant already rated this specific job
                                                    $applicantRating = \App\Models\Applicant\SendRatingToJobPostModel::where(
                                                        'applicant_id',
                                                        $applicantId,
                                                    )
                                                        ->where('job_post_id', $jobDetail->id)
                                                        ->first();

                                                    //Show this rate button who accepts the job
                                                    $isJobAccepted = \App\Models\Applicant\ApplyJobModel::where(
                                                        'job_id',
                                                        $jobDetail->id,
                                                    )
                                                        ->where('applicant_id', $applicantId)
                                                        ->where('status', 'approved')
                                                        ->first();
                                                @endphp

                                                @if ($applicantRating)
                                                    <button
                                                        class="btn btn-secondary btn-sm d-flex align-items-center gap-2"
                                                        disabled style="cursor: not-allowed; opacity: 0.8;">
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <span>You already rated this job</span>
                                                    </button>
                                                @elseif($isJobAccepted)
                                                    <button class="btn btn-outline-warning btn-sm rate-job-btn"
                                                        data-job-id="{{ $jobDetail->id }}"
                                                        data-title="{{ $jobDetail->title }}"
                                                        data-company="{{ $company->company_name ?? 'Unknown Company' }}"
                                                        data-bs-toggle="modal" data-bs-target="#rateJobModal">
                                                        <i class="bi bi-star me-1"></i>
                                                        Rate Job
                                                    </button>
                                                @endif


                                                <!-- View Ratings Button -->
                                                <button class="btn btn-outline-secondary btn-sm view-ratings-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewRatingsModal-{{ $jobDetail->id }}">
                                                    <i class="bi bi-chat-left-text me-1"></i>
                                                    View Reviews
                                                </button>
                                            </div>
                                        </div>

                                        <!-- View Details -->
                                        <button class="btn btn-primary btn-sm view-details-btn"
                                            data-title="{{ $jobDetail->title }}"
                                            data-company="{{ $company->company_name ?? ($company->employer->personal_info->first_name . ' ' . $company->employer->personal_info->last_name ?? 'Unknown') }}"
                                            data-has-company="{{ !empty($company->company_name) ? '1' : '0' }}"
                                            data-industry="{{ $jobDetail->department }}"
                                            data-location="{{ $jobDetail->location }}"
                                            data-description="{{ $jobDetail->job_description }}"
                                            data-benefits="{{ $jobDetail->benefits ?? 'None' }}"
                                            data-salary="{{ $jobDetail->job_salary }}"
                                            data-experience="{{ $jobDetail->experience_level ?? 'N/A' }}"
                                            @if (Str::contains($jobDetail->tesda_certification, 'Other')) data-tesda="{{ $jobDetail->other_certifications ?? 'N/A' }}"
                                data-none="N/A"
                            @else
                                data-tesda="{{ $jobDetail->tesda_certification ?? 'N/A' }}"
                                data-none="{{ $jobDetail->none_certifications_qualification ?? 'N/A' }}" @endif
                                            data-bs-toggle="modal" data-bs-target="#viewDetailsModal">
                                            View Details
                                        </button>

                                        <!-- Save/Unsave Job -->
                                        <form action="{{ route('jobs.toggleSave', $jobDetail->id) }}" method="POST"
                                            style="display:inline; width: 100%;">
                                            @csrf
                                            @if (in_array($jobDetail->id, $savedJobIds))
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-bookmark-dash"></i> Unsave Job
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-bookmark-plus"></i> Save Job
                                                </button>
                                            @endif
                                        </form>

                                        @php
                                            // Get applicant's application record for this job
$applicationRecord = \App\Models\Applicant\ApplyJobModel::where(
    'job_id',
    $jobDetail->id ?? null,
)
    ->where('applicant_id', session('applicant_id'))
    ->first();

// Determine if applicant has an active application (any except rejected)
$hasActiveApplication =
    $applicationRecord && $applicationRecord->status !== 'rejected';
                                        @endphp

                                        @if ($hasActiveApplication)
                                            {{-- Handle based on specific application status --}}
                                            @if ($applicationRecord->status === 'pending')
                                                <button type="button" class="btn btn-warning btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#cancelApplicationModal"
                                                    data-job-id="{{ $jobDetail->id }}"
                                                    data-title="{{ $jobDetail->title }}"
                                                    data-company="{{ $retrievedAddressCompany->first()->company_name ?? 'Unknown Company' }}"
                                                    data-location="{{ $jobDetail->location }}">
                                                    <i class="bi bi-hourglass-split me-1"></i> Pending — Cancel
                                                    Application
                                                </button>
                                            @elseif ($applicationRecord->status === 'interview')
                                                <button type="button" class="btn btn-info btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#cancelApplicationModal"
                                                    data-job-id="{{ $jobDetail->id }}"
                                                    data-title="{{ $jobDetail->title }}"
                                                    data-company="{{ $retrievedAddressCompany->first()->company_name ?? 'Unknown Company' }}"
                                                    data-location="{{ $jobDetail->location }}">
                                                    <i class="bi bi-calendar-check me-1"></i> Interview Scheduled —
                                                    Cancel
                                                </button>
                                            @elseif ($applicationRecord->status === 'approved')
                                                <button class="btn btn-success btn-sm" disabled>
                                                    <i class="bi bi-check-circle-fill me-1"></i> Approved
                                                </button>
                                            @elseif ($applicationRecord->status === 'hired')
                                                <button class="btn btn-primary btn-sm" disabled>
                                                    <i class="bi bi-briefcase-fill me-1"></i> Hired
                                                </button>
                                            @elseif ($applicationRecord->status === 'completed')
                                                <button class="btn btn-secondary btn-sm" disabled>
                                                    <i class="bi bi-flag-fill me-1"></i> Completed
                                                </button>
                                            @endif
                                        @else
                                            {{-- Check if suspended --}}
                                            @if ($isSuspended)
                                                <button class="btn btn-secondary btn-sm" disabled>
                                                    <i class="bi bi-slash-circle"></i>
                                                    Suspended ({{ $suspension->suspension_duration }}
                                                    {{ $suspension->suspension_duration == 1 ? 'day' : 'days' }})
                                                </button>
                                                <div class="mt-2">
                                                    <small class="text-muted">
                                                        You cannot apply until
                                                        {{ $suspension->created_at->addDays($suspension->suspension_duration)->format('M d, Y h:i A') }}
                                                    </small>
                                                </div>
                                            @else
                                                {{-- Apply or Reapply --}}
                                                <button class="btn btn-success btn-sm apply-btn"
                                                    data-job-id="{{ $jobDetail->id }}"
                                                    data-title="{{ $jobDetail->title }}"
                                                    data-company="{{ $retrievedAddressCompany->first()->company_name ?? 'Unknown Company' }}"
                                                    data-location="{{ $jobDetail->location }}" data-bs-toggle="modal"
                                                    data-bs-target="#applyJobModal">
                                                    <i class="bi bi-send-check me-1"></i>
                                                    {{ $applicationRecord && $applicationRecord->status === 'rejected' ? 'Re-apply Job' : 'Apply Job' }}
                                                </button>

                                                @if ($applicationRecord && $applicationRecord->status === 'rejected')
                                                    <div class="mt-2">
                                                        <small class="text-danger">
                                                            <i class="bi bi-exclamation-triangle me-1"></i>
                                                            Your previous application was rejected. You can apply again.
                                                        </small>
                                                    </div>
                                                @endif
                                            @endif
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Report Job Modal -->
                @include('applicant.homepage.modal.report_job_modal')

                <!-- Cancel job modal---->
                @include('applicant.homepage.modal.cancel_job')
                <!-- Apply Job Modal -->
                @include('applicant.homepage.modal.apply_job')

                <!-- View Details Modal -->
                @include('applicant.homepage.modal.view_detail_job')

        </div>
        <!-- No Results Message -->
        <div class="no-results hidden" id="noResults">
            <i class="bi bi-search"></i>
            <h3>No employers found</h3>
            <p>Try adjusting your filters or search terms</p>
        </div>
        </section>
    </div>
    </div>



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Message Modal -->
    <div class="modal-overlay" id="messageModal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Message Details</h5>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Message content will be inserted here -->
            </div>
            <div class="modal-footer">
                <button class="btn-reply" onclick="replyToMessage()">Reply</button>
            </div>
        </div>
    </div>

    <section class="offers-section">
        <h2 class="offers-title">Offers</h2>

        <div class="offers-container">
            <!-- Card 1 -->
            <div class="offer-card">
                <h3 class="offer-title">TESDA Online Training Program</h3>
                <ul class="offer-list">
                    <li>Gain practical skills in high-demand industries</li>
                    <li>Receive official TESDA certificates after completion</li>
                    <li>Join thousands of Filipinos leveling up their careers</li>


                </ul>
                <a href="https://e-tesda.gov.ph/course/" target="_blank" class="offer-btn primary">Go to Website</a>
            </div>

            <!-- Card 2 (Highlighted) -->
            <div class="offer-card active">
                <h3 class="offer-title">AR Portfolio</h3>
                <ul class="offer-list">
                    <li>Build a 3D Augmented Reality portfolio</li>
                    <li>Showcase your completed projects interactively</li>
                    <li>Show your portfolio via calling card</li>

                </ul>
                <a href="{{ route('applicant.callingcard.display') }}" class="offer-btn light">Create</a>
            </div>

            <!-- Card 3 -->
            <div class="offer-card">
                <h3 class="offer-title">Resume Builder</h3>
                <ul class="offer-list">
                    <li>Create a professional resume in minutes </li>
                    <li>Export your resume as PDF file</li>
                    <li>Add your experiences and skills easily</li>


                </ul>
                <a href="{{ route('applicant.resume.display') }}" class="offer-btn primary">Create</a>
            </div>
        </div>
    </section>

    <script>
        const applyJobModal = document.getElementById('applyJobModal');
        if (applyJobModal) {
            applyJobModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const jobId = button.getAttribute('data-job-id');
                const jobTitle = button.getAttribute('data-title');
                const companyName = button.getAttribute('data-company');
                const jobLocation = button.getAttribute('data-location');

                // Update modal content
                document.getElementById('apply-job-title').textContent = jobTitle || 'Job Title';
                document.getElementById('apply-company-name').textContent = companyName || 'Company';
                document.getElementById('apply-job-location').textContent = jobLocation || 'Location';
                document.getElementById('apply-job-id-input').value = jobId;

                // Update modal title
                document.getElementById('applyJobModalLabel').innerHTML =
                    `<i class="fas fa-paper-plane me-2"></i>Apply for ${jobTitle || 'Position'}`;
            });
        }

        // Handle Cancel Application Modal
        const cancelModal = document.getElementById("cancelApplicationModal");
        cancelModal.addEventListener("show.bs.modal", function(event) {
            let button = event.relatedTarget;
            let jobId = button.getAttribute("data-job-id");
            document.getElementById("cancelJobId").value = jobId;
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle Report Job Modal
            const reportJobModal = document.getElementById('reportJobModal');
            if (reportJobModal) {
                reportJobModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const employerId = button.getAttribute('data-employer-id');
                    const jobId = button.getAttribute('data-job-id');
                    const jobTitle = button.getAttribute('data-title');
                    const companyName = button.getAttribute('data-company')?.trim();
                    const individualName = button.getAttribute('data-individual')?.trim();

                    // Decide what to show in modal
                    let displayName = '';
                    if (companyName) {
                        displayName = `Company: ${companyName}`;
                    } else if (individualName) {
                        displayName = `Individual: ${individualName}`;
                    } else {
                        displayName = 'Unknown';
                    }

                    // Update modal content
                    document.getElementById('report_employer_id').value = employerId;
                    document.getElementById('report_job_id').value = jobId;
                    document.getElementById('report_job_title').textContent = jobTitle || 'Job Title';
                    document.getElementById('report_company_name').textContent = displayName;
                });

                // Reset form when modal is closed
                reportJobModal.addEventListener('hidden.bs.modal', function() {
                    document.getElementById('reportJobForm').reset();
                });
            }

            // Form validation
            const reportForm = document.getElementById('reportJobForm');
            if (reportForm) {
                reportForm.addEventListener('submit', function(e) {
                    const details = document.getElementById('report_details').value;
                    if (details.length < 20) {
                        e.preventDefault();
                        alert('Please provide at least 20 characters in the details section.');
                        return false;
                    }
                });
            }
        });
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.view-details-btn');

            buttons.forEach(btn => {
                btn.addEventListener('click', function() {
                    document.getElementById('modalJobTitle').textContent = btn.dataset.title;

                    const modalCompanyLabel = document.querySelector('#modalCompanyName')
                        .previousElementSibling;
                    const hasCompany = btn.dataset.hasCompany === '1';

                    modalCompanyLabel.textContent = hasCompany ? 'Company:' : 'Individual:';
                    document.getElementById('modalCompanyName').textContent = btn.dataset.company;

                    document.getElementById('modalIndustry').textContent = btn.dataset.industry;
                    document.getElementById('modalLocation').textContent = btn.dataset.location;
                    document.getElementById('modalDescription').textContent = btn.dataset
                        .description;
                    document.getElementById('modalSalary').textContent = btn.dataset.salary;
                    document.getElementById('modalBenefits').textContent = btn.dataset.benefits;
                    document.getElementById('modalExperienceLevel').textContent = btn.dataset
                        .experience;
                    document.getElementById('modalTESDACertification').textContent = btn.dataset
                        .tesda;
                    document.getElementById('modalNoneCertificationsQualification').textContent =
                        btn.dataset.none;
                });
            });
        });
    </script>


    <!-- Messaging and Notification JavaScript -->
    <script>
        // Dropdown functionality
        function toggleDropdown(dropdownId) {
            // Close all other dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                if (menu.id !== dropdownId) {
                    menu.classList.remove('show');
                }
            });

            // Toggle the clicked dropdown
            const dropdown = document.getElementById(dropdownId);
            dropdown.classList.toggle('show');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.nav-dropdown')) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        });



        // Show message modal
        function showMessageModal(messageId) {
            const message = messagesData[messageId];
            if (!message) return;

            document.getElementById('modalTitle').textContent = message.subject;
            document.getElementById('modalBody').innerHTML = `
                <div style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid #f0f0f0;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <strong style="color: #333;">${message.sender}</strong>
                        <span style="color: #888; font-size: 12px;">${message.time}</span>
                    </div>
                    <div style="color: #667eea; font-size: 14px; margin-bottom: 4px;">${message.company}</div>
                </div>
                <div style="white-space: pre-line; line-height: 1.6; color: #333;">${message.content}</div>
            `;

            document.getElementById('messageModal').classList.add('show');

            // Mark message as read
            const messageItem = document.querySelector(`[data-id="${messageId}"]`);
            if (messageItem && messageItem.classList.contains('unread')) {
                messageItem.classList.remove('unread');
                updateMessageBadge();
            }
        }

        // Close modal
        function closeModal() {
            document.getElementById('messageModal').classList.remove('show');
        }

        // Reply to message
        function replyToMessage() {
            showToast('Reply feature will be available soon!', 'info');
            closeModal();
        }

        // Update message badge count
        function updateMessageBadge() {
            const unreadCount = document.querySelectorAll('#messagesDropdown .message-item.unread').length;
            const badge = document.getElementById('messagesBadge');
            badge.textContent = unreadCount;
            if (unreadCount === 0) {
                badge.style.display = 'none';
            } else {
                badge.style.display = 'flex';
            }
        }

        // Toast notification system
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = 'toast';

            let borderColor = '#667eea';
            if (type === 'success') borderColor = '#22c55e';
            if (type === 'warning') borderColor = '#fbbf24';
            if (type === 'error') borderColor = '#ef4444';

            toast.style.borderLeftColor = borderColor;

            toast.innerHTML = `
                <div class="toast-header">
                    <div class="toast-title">${type.charAt(0).toUpperCase() + type.slice(1)}</div>
                    <button class="toast-close" onclick="this.parentElement.parentElement.remove()">&times;</button>
                </div>
                <div class="toast-body">${message}</div>
            `;

            document.getElementById('toastContainer').appendChild(toast);

            // Show toast
            setTimeout(() => toast.classList.add('show'), 100);

            // Auto remove after 5 seconds
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }



        // Close modal when clicking overlay
        document.getElementById('messageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        });
    </script>

    <!-- Filter JavaScript -->
    <script>
        // Filter state
        let activeFilters = {
            search: '',
            industry: '',
            location: '',
            chips: []
        };

        // Initialize filters
        document.addEventListener('DOMContentLoaded', function() {
            // Search input listeners
            const searchFilter = document.getElementById('searchFilter');
            const navSearch = document.getElementById('navSearch');
            const mobileNavSearch = document.getElementById('mobileNavSearch');

            searchFilter.addEventListener('input', applyFilters);
            navSearch.addEventListener('input', function() {
                searchFilter.value = this.value;
                applyFilters();
            });
            mobileNavSearch.addEventListener('input', function() {
                searchFilter.value = this.value;
                navSearch.value = this.value;
                applyFilters();
            });

            // Dropdown listeners
            document.getElementById('industryFilter').addEventListener('change', applyFilters);
            document.getElementById('locationFilter').addEventListener('change', applyFilters);

            // Initial count
            updateResultsCount();
        });

        // Apply all filters
        function applyFilters() {
            const searchValue = document.getElementById('searchFilter').value.toLowerCase();
            const industryValue = document.getElementById('industryFilter').value;
            const locationValue = document.getElementById('locationFilter').value;

            const cards = document.querySelectorAll('.employer-card');
            let visibleCount = 0;

            cards.forEach(card => {
                let isVisible = true;

                // Assuming searchValue is already in lowercase
                if (searchValue) {
                    const individualName = card.dataset.individual ? card.dataset.individual.toLowerCase() : '';
                    const company = card.dataset.company ? card.dataset.company.toLowerCase() : '';
                    const name = card.dataset.name ? card.dataset.name.toLowerCase() : '';
                    const industry = card.dataset.industry ? card.dataset.industry.toLowerCase() : '';
                    const descriptionEl = card.querySelector('.company-description');
                    const description = descriptionEl ? descriptionEl.textContent.toLowerCase() : '';

                    if (!company.includes(searchValue) &&
                        !name.includes(searchValue) &&
                        !individualName.includes(searchValue) &&
                        !industry.includes(searchValue) &&
                        !description.includes(searchValue)) {
                        isVisible = false;
                    }
                }


                // Industry filter
                if (industryValue && card.dataset.industry !== industryValue) {
                    isVisible = false;
                }

                // Location filter
                if (locationValue && !card.dataset.location.includes(locationValue)) {
                    isVisible = false;
                }

                // Chip filters
                activeFilters.chips.forEach(chip => {
                    if (chip === 'hiring' && card.dataset.hiring !== 'true') {
                        isVisible = false;
                    }
                    if (chip === 'remote' && card.dataset.remote !== 'true') {
                        isVisible = false;
                    }
                    if (chip === 'featured' && card.dataset.featured !== 'true') {
                        isVisible = false;
                    }
                    if (chip === 'startup' && card.dataset.startup !== 'true') {
                        isVisible = false;
                    }
                });

                // Show/hide card
                if (isVisible) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            updateResultsCount(visibleCount);
            toggleNoResults(visibleCount === 0);
        }

        // Toggle filter chip
        function toggleChip(chipElement, filterType) {
            chipElement.classList.toggle('active');

            if (chipElement.classList.contains('active')) {
                if (!activeFilters.chips.includes(filterType)) {
                    activeFilters.chips.push(filterType);
                }
            } else {
                activeFilters.chips = activeFilters.chips.filter(chip => chip !== filterType);
            }

            applyFilters();
        }

        // Clear all filters
        function clearAllFilters() {
            // Clear search inputs
            document.getElementById('searchFilter').value = '';
            document.getElementById('navSearch').value = '';
            document.getElementById('mobileNavSearch').value = '';

            // Clear dropdowns
            document.getElementById('industryFilter').value = '';
            document.getElementById('locationFilter').value = '';

            // Clear chips
            document.querySelectorAll('.filter-chip').forEach(chip => {
                chip.classList.remove('active');
            });

            // Reset filter state
            activeFilters = {
                search: '',
                industry: '',
                location: '',
                chips: []
            };

            // Show all cards
            document.querySelectorAll('.employer-card').forEach(card => {
                card.classList.remove('hidden');
            });

            updateResultsCount();
            toggleNoResults(false);
        }

        // Sort employers
        function sortEmployers() {
            const sortBy = document.getElementById('sortDropdown').value;
            const grid = document.getElementById('employerGrid');
            const cards = Array.from(grid.querySelectorAll('.employer-card'));

            cards.sort((a, b) => {
                let aValue, bValue;

                switch (sortBy) {
                    case 'name':
                        aValue = a.dataset.name.toLowerCase();
                        bValue = b.dataset.name.toLowerCase();
                        return aValue.localeCompare(bValue); // Alphabetical A → Z
                    case 'rating':
                        aValue = parseFloat(a.dataset.rating) || 0;
                        bValue = parseFloat(b.dataset.rating) || 0;
                        return bValue - aValue; // Descending numeric
                    case 'location':
                        aValue = a.dataset.location.toLowerCase();
                        bValue = b.dataset.location.toLowerCase();
                        return aValue.localeCompare(bValue);
                    case 'industry':
                        aValue = a.dataset.industry.toLowerCase();
                        bValue = b.dataset.industry.toLowerCase();
                        return aValue.localeCompare(bValue);
                    default:
                        return 0;
                }
            });

            // Re-append sorted cards
            cards.forEach(card => grid.appendChild(card));
        }



        // Update results count
        function updateResultsCount(count = null) {
            const resultsCount = document.getElementById('resultsCount');
            if (count === null) {
                count = document.querySelectorAll('.employer-card:not(.hidden)').length;
            }
            resultsCount.textContent = count;
        }

        // Toggle no results message
        function toggleNoResults(show) {
            const noResults = document.getElementById('noResults');
            const employerGrid = document.getElementById('employerGrid');

            if (show) {
                noResults.classList.remove('hidden');
                employerGrid.style.display = 'none';
            } else {
                noResults.classList.add('hidden');
                employerGrid.style.display = 'grid';
            }
        }
    </script>

    <script>
        const timeout = 10 * 60 * 1000; // 10 minutes
        const warningTime = 9 * 60 * 1000; // 1 min before logout

        let warningTimer = setTimeout(showWarning, warningTime);
        let logoutTimer = setTimeout(autoLogout, timeout);

        function resetTimers() {
            clearTimeout(warningTimer);
            clearTimeout(logoutTimer);
            warningTimer = setTimeout(showWarning, warningTime);
            logoutTimer = setTimeout(autoLogout, timeout);
        }

        function showWarning() {
            alert(
                "You will be logged out in 1 minute due to inactivity. Move your mouse or press a key to stay logged in."
            );
        }

        function autoLogout() {
            window.location.href = "{{ route('applicant.login.display') }}";
        }

        document.addEventListener('mousemove', resetTimers);
        document.addEventListener('keydown', resetTimers);
        document.addEventListener('click', resetTimers);
    </script>

    <script>
        function confirmLogout(event) {
            event.preventDefault(); // Stop form from submitting immediately

            if (confirm("Are you sure you want to logout?")) {
                document.getElementById('logoutForm').submit();
            }
        }
    </script>

    <!-- Rate Job Modal -->
    <div class="modal fade" id="rateJobModal" tabindex="-1" aria-labelledby="rateJobModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"><!-- Added modal-dialog-scrollable -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rateJobModalLabel">
                        <i class="bi bi-star-fill text-warning me-2"></i>Rate This Job
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="rateJobForm" action="{{ route('applicant.sendrating.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="job_post_id">
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <h6 id="rateJobTitle" class="fw-bold"></h6>
                            <small id="rateJobCompany" class="text-muted"></small>
                        </div>

                        <!-- Star Rating -->
                        <div class="mb-4">
                            <label class="form-label text-center d-block mb-3">How would you rate this job
                                posting?</label>
                            <div class="star-rating justify-content-center">
                                <input type="radio" name="rating" value="5" id="star5" required>
                                <label for="star5"><i class="bi bi-star-fill"></i></label>

                                <input type="radio" name="rating" value="4" id="star4">
                                <label for="star4"><i class="bi bi-star-fill"></i></label>

                                <input type="radio" name="rating" value="3" id="star3">
                                <label for="star3"><i class="bi bi-star-fill"></i></label>

                                <input type="radio" name="rating" value="2" id="star2">
                                <label for="star2"><i class="bi bi-star-fill"></i></label>

                                <input type="radio" name="rating" value="1" id="star1">
                                <label for="star1"><i class="bi bi-star-fill"></i></label>
                            </div>
                            <div class="text-center mt-2">
                                <small class="text-muted" id="ratingText">Select a rating</small>
                            </div>
                        </div>

                        <!-- Feedback -->
                        <div class="mb-3">
                            <label for="feedback" class="form-label">Your Feedback (Optional)</label>
                            <textarea class="form-control" id="feedback" name="feedback" rows="4"
                                placeholder="Share your thoughts about this job posting..."></textarea>
                            <small class="text-muted">Maximum 1000 characters</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-send me-1"></i>Submit Rating
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @foreach ($JobPostRetrieved as $jobDetail)
        <!-- View Ratings Modal -->
        <div class="modal fade" id="viewRatingsModal-{{ $jobDetail->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-star-fill text-warning me-2"></i>Job Ratings & Reviews
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Job Title & Company -->
                        <div class="text-center mb-4">
                            <h6 class="fw-bold">{{ $jobDetail->title }}</h6>
                            <small class="text-muted">
                                @if (!empty($jobDetail->employer?->addressCompany?->company_name))
                                    Company: {{ $jobDetail->employer->addressCompany->company_name }}
                                @elseif (!empty($jobDetail->employer?->personal_info))
                                    Individual: {{ $jobDetail->employer->personal_info->first_name ?? '' }}
                                    {{ $jobDetail->employer->personal_info->last_name ?? '' }}
                                @else
                                    Unknown
                                @endif
                            </small>
                        </div>


                        @php
                            $ratings = $jobDetail->ratings; // make sure relation exists
                            $averageRating = $ratings->avg('rating');
                            $total = $ratings->count();
                        @endphp

                        <!-- Rating Summary -->
                        <div class="rating-summary justify-content-center mb-4 text-center">
                            <div class="rating-number">{{ number_format($averageRating ?? 0, 1) }}</div>
                            <div>
                                <div class="rating-stars-display">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= round($averageRating ?? 0))
                                            <i class="bi bi-star-fill text-warning"></i>
                                        @else
                                            <i class="bi bi-star text-muted"></i>
                                        @endif
                                    @endfor
                                </div>
                                <small class="text-muted">{{ $total }}
                                    {{ Str::plural('rating', $total) }}</small>
                            </div>
                        </div>

                        <hr>

                        <!-- Reviews List -->
                        @if ($ratings->isEmpty())
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1"></i>
                                <p>No reviews yet. Be the first to rate this job!</p>
                            </div>
                        @else
                            @foreach ($ratings as $rating)
                                <div class="review-card mb-3 p-3 border rounded">
                                    <div class="review-header d-flex justify-content-between mb-1">
                                        <span class="reviewer-name">
                                            <i class="bi bi-person-circle me-1"></i>
                                            {{ $rating->applicant->first_name }} {{ $rating->applicant->last_name }}
                                        </span>
                                        <span
                                            class="review-date text-muted">{{ $rating->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="review-rating mb-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $rating->rating)
                                                <i class="bi bi-star-fill text-warning"></i>
                                            @else
                                                <i class="bi bi-star text-muted"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    @if ($rating->review_comments)
                                        <div class="review-feedback">{{ $rating->review_comments }}</div>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    <script>
        // Rate Job Modal
        document.querySelectorAll('.rate-job-btn').forEach(button => {
            button.addEventListener('click', function() {
                const jobId = this.dataset.jobId;
                const title = this.dataset.title;
                const company = this.dataset.company;

                // Fill modal text
                document.getElementById('rateJobTitle').textContent = title;
                document.getElementById('rateJobCompany').textContent = company;

                // Fill hidden input
                document.querySelector('input[name="job_post_id"]').value = jobId;

                // Reset form
                document.getElementById('rateJobForm').reset();
                document.getElementById('ratingText').textContent = 'Select a rating';
            });
        });


        // Star rating text update
        document.querySelectorAll('.star-rating input').forEach(input => {
            input.addEventListener('change', function() {
                const ratingTexts = {
                    '1': '⭐ Poor',
                    '2': '⭐⭐ Fair',
                    '3': '⭐⭐⭐ Good',
                    '4': '⭐⭐⭐⭐ Very Good',
                    '5': '⭐⭐⭐⭐⭐ Excellent'
                };
                document.getElementById('ratingText').textContent = ratingTexts[this.value];
            });
        });

        // View Ratings Modal
        document.querySelectorAll('.view-ratings-btn').forEach(button => {
            button.addEventListener('click', function() {
                const jobId = this.dataset.jobId;
                const title = this.dataset.title;
                const company = this.dataset.company;

                document.getElementById('viewRatingsJobTitle').textContent = title;
                document.getElementById('viewRatingsJobCompany').textContent = company;

                // Fetch ratings
                fetch(`/applicant/jobs/${jobId}/ratings`)
                    .then(response => response.json())
                    .then(data => {
                        // Update summary
                        document.getElementById('averageRating').textContent = data.average || '0.0';
                        document.getElementById('totalRatings').textContent =
                            `${data.total} ${data.total === 1 ? 'rating' : 'ratings'}`;

                        // Display stars
                        const starsHtml = generateStars(data.average || 0);
                        document.getElementById('averageStars').innerHTML = starsHtml;

                        // Display reviews
                        const reviewsList = document.getElementById('reviewsList');
                        if (data.ratings.length === 0) {
                            reviewsList.innerHTML = `
                        <div class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-1"></i>
                            <p>No reviews yet. Be the first to rate this job!</p>
                        </div>
                    `;
                        } else {
                            reviewsList.innerHTML = data.ratings.map(review => `
                        <div class="review-card mb-3 p-3 border rounded">
                            <div class="review-header d-flex justify-content-between mb-1">
                                <span class="reviewer-name">
                                    <i class="bi bi-person-circle me-1"></i>
                                    ${review.applicant.first_name} ${review.applicant.last_name}
                                </span>
                                <span class="review-date text-muted">${new Date(review.created_at).toLocaleDateString()}</span>
                            </div>
                            <div class="review-rating mb-1">
                                ${generateStars(review.rating)}
                            </div>
                            ${review.feedback ? `<div class="review-feedback">${review.feedback}</div>` : ''}
                        </div>
                    `).join('');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching ratings:', error);
                        document.getElementById('reviewsList').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Failed to load reviews. Please try again.
                    </div>
                `;
                    });
            });
        });


        // Generate stars HTML
        function generateStars(rating) {
            const fullStars = Math.floor(rating);
            const hasHalfStar = rating % 1 >= 0.5;
            const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);

            let html = '';
            for (let i = 0; i < fullStars; i++) {
                html += '<i class="bi bi-star-fill"></i>';
            }
            if (hasHalfStar) {
                html += '<i class="bi bi-star-half"></i>';
            }
            for (let i = 0; i < emptyStars; i++) {
                html += '<i class="bi bi-star empty-star"></i>';
            }
            return html;
        }
        // Logo click handlers
        ['home', 'home2'].forEach(id => {
            const logoElement = document.getElementById(id);
            if (logoElement) {
                logoElement.style.cursor = 'pointer'; // Make it look clickable
                logoElement.addEventListener('click', function() {
                    // Scroll to top with smooth animation
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }
        });
    </script>

</body>

</html>
