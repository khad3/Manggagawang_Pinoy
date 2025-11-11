<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/applicant/employer/homepage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/applicant/employer/report.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />

</head>

<body>
    <!-- Mobile Menu Toggle -->
    <button class="btn btn-primary mobile-menu-toggle" id="toggleSidebar">
        <i class="fas fa-bars" id="menuIcon"></i>
    </button>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Brand Section -->
        <div class="brand-section">
            <div class="d-flex align-items-center gap-3">
                @php
                    $retrievelogo = \App\Models\Employer\CompanyAdressModel::where(
                        'employer_id',
                        session('employer_id'),
                    )->first();
                @endphp

                <!-- Company Avatar -->
                <div class="company-avatar">
                    @if ($retrievelogo && $retrievelogo->company_logo)
                        <img src="{{ asset('storage/' . $retrievelogo->company_logo) }}" alt="Company Logo">
               
                    @else
                        <span>  <img src="{{ asset('img/employer default.png') }}" alt="Employer Default" /></span>
                    @endif
                </div>

                <!-- Optional Portal Info -->
                <div class="portal-info">
                    <h5 class="mb-0 fw-bold">Employer Portal</h5>
                    <p class="text-muted small mb-0">{{ $retrievelogo->company_name }}</p>
                </div>
            </div>



        </div>

        <!-- Navigation Links -->
        <nav class="nav-section">
            <div class="nav-item">
                <a href="#" class="nav-link active" data-target="dashboard-section">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link" data-target="applicants-section">
                    <i class="fas fa-users"></i>
                    Applicants
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link" data-target="jobposts-section">
                    <i class="fas fa-briefcase"></i>
                    Job Posts

                    @php
                        $employerId = session('employer_id') ?? null;

                        $applicantApply = 0;

                        if ($employerId) {
                            // Count pending applicant applications for this employer's jobs
    $applicantApply = \App\Models\Applicant\ApplyJobModel::where('status', 'pending')
        ->whereHas('job', function ($query) use ($employerId) {
            $query->where('employer_id', $employerId);
                                })
                                ->count();
                        }
                    @endphp

                    @if ($applicantApply > 0)
                        <span class="badge bg-danger nav-badge" id="notificationUnreadCount">
                            {{ $applicantApply }}
                        </span>
                    @endif
                </a>
            </div>


            <div class="nav-item">
                <a href="#" class="nav-link" data-target="messages-section" style="position: relative;">
                    <i class="fas fa-comments"></i>
                    Messages
                    @php
                        // Count unread messages from applicants (not yet read by employer)
                        $unreadMessagesCount = \App\Models\Employer\SendMessageModel::where(
                            'employer_id',
                            session('employer_id'),
                        )
                            ->where('sender_type', 'applicant')
                            ->where('is_read', false)
                            ->count();
                    @endphp

                    @if ($unreadMessagesCount > 0)
                        <span class="badge bg-danger message-badge" id="messageUnreadCount">
                            {{ $unreadMessagesCount }}
                        </span>
                    @endif
                </a>
            </div>


            <div class="nav-item">
                <a href="#" class="nav-link" data-target="analytics-section">
                    <i class="fas fa-chart-line"></i>
                    Analytics
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link" data-target="settings-section">
                    <i class="fas fa-cog"></i>
                    Settings
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link" data-target="notifications-section" style="position: relative;">
                    <i class="fas fa-bell"></i>
                    Notifications


                    @if ($unreadCount > 0)
                        <span class="badge bg-danger nav-badge" id="notificationUnreadCount">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link" data-target="reports-section">
                    <i class="fas fa-flag"></i>
                    Reports
                </a>
            </div>
            <div class="nav-item mt-4">
                <a href="#" class="nav-link text-danger"
                    onclick="event.preventDefault(); if(confirm('Are you sure you want to logout?')) { document.getElementById('logout-form').submit(); }">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
                <form id="logout-form" action="{{ route('employer.logout.store') }}" method="POST"
                    style="display: none;">
                    @csrf
                </form>
            </div>
        </nav>

        <script>
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = this.dataset.target;
                    if (target) openSection(target);
                });
            });
        </script>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <br>
        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3 shadow-sm rounded-3" role="alert"
                id="success-alert">
                <center>
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </center>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Error Message --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3 shadow-sm rounded-3" role="alert"
                id="error-alert">
                <center>
                    <i class="fas fa-times-circle me-2"></i>{{ session('error') }}
                </center>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-warning alert-dismissible fade show mt-3 shadow-sm rounded-3" role="alert"
                id="warning-alert">
                <center>
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>There were some issues with your input:</strong>
                </center>
                <ul class="mt-2 mb-0 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Auto Fade Script (applies to all alerts) --}}
        <script>
            ['success-alert', 'error-alert', 'warning-alert'].forEach(id => {
                setTimeout(() => {
                    let alert = document.getElementById(id);
                    if (alert) {
                        alert.classList.remove('show');
                        alert.classList.add('fade');
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 2000); // Auto fade after 2 seconds
            });
        </script>
        <!-- Welcome Section -->
        <br>
        <div class="welcome-header d-flex align-items-center justify-content-between">
            <div class="welcome-text">
                <div class="welcome-title">Welcome back, {{ $retrievePersonal->first_name ?? 'Employer' }}
                    {{ $retrievePersonal->last_name ?? '' }}! </div>
                <div class="welcome-subtitle">Here's what's happening with your job postings today</div>
            </div>

            <!-- Right aligned logo -->
            <div class="welcome-logo-wrapper">
                <img src="{{ asset('img/logo.png') }}" alt="MP Logo" id="home2" class="welcome-logo">
            </div>
        </div>

        <!-- Dashboard Section -->
        @include('employer.homepage.section.dashboard_section')
        <!-- Applicants Section -->
        @include('employer.homepage.section.applicant_section')
        <!-- Job Posts Section -->
        @include('employer.homepage.section.job_section')
        <!-- messages section ---->
        @include('employer.homepage.section.message_section')
        <!-- Analytics Section -->
        @include('employer.homepage.section.analytics_section')
        <!-- Employer Notifications Section -->
        @include('employer.homepage.section.notification_section')
        <!-- Settings Section -->
        @include('employer.homepage.section.settings_section')
        <!-- Reports Section -->
        @include('employer.homepage.section.report_section')

    </div>

    <!-- New Job Modal -->
    @include('employer.homepage.modal.job_post_modal')



    <script>
        function openSection(sectionId) {
            document.querySelectorAll('.page-section').forEach(section => {
                section.style.display = 'none';
            });
            document.getElementById(sectionId).style.display = 'block';

            // update active nav link
            document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
            const navLink = document.querySelector(`.nav-link[data-target="${sectionId}"]`);
            if (navLink) navLink.classList.add('active');

            // smooth scroll
            document.getElementById(sectionId).scrollIntoView({
                behavior: 'smooth'
            });
        }
    </script>



    <!-- for the applicant aplied job javascript--->
    <script>
        function exportApplications() {
            // Professional export functionality
            console.log('Exporting applications with balanced theme...');

            const btn = event.target;
            const originalHTML = btn.innerHTML;

            // Show loading state
            btn.innerHTML =
                '<i class="fas fa-spinner fa-spin me-1"></i><span class="d-none d-sm-inline">Exporting...</span><span class="d-sm-none">Loading...</span>';
            btn.disabled = true;
            btn.classList.add('btn-secondary');

            // Simulate export process
            setTimeout(() => {
                btn.innerHTML =
                    '<i class="fas fa-check me-1"></i><span class="d-none d-sm-inline">Exported!</span><span class="d-sm-none">Done!</span>';
                btn.classList.remove('btn-secondary');
                btn.classList.add('btn-success');

                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                    btn.disabled = false;
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-accent-balanced');
                }, 1500);
            }, 2000);
        }

        // Optional: Add filtering functionality
        function filterApplications(status) {
            const applications = document.querySelectorAll('.application-item');

            applications.forEach(app => {
                if (status === 'All Status' || app.dataset.status === status.toLowerCase()) {
                    app.style.display = 'block';
                } else {
                    app.style.display = 'none';
                }
            });
        }

        // Initialize tooltips (if using Bootstrap tooltips)
        document.addEventListener('DOMContentLoaded', function() {
            // Add any initialization code here
            console.log('Balanced theme job applications modal loaded');
        });
    </script>



    {{-- JavaScript Functions --}}
    <script>
        function openApplicationsModal() {
            document.getElementById('applicationsModalOverlay').style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function closeApplicationsModal() {
            document.getElementById('applicationsModalOverlay').style.display = 'none';
            document.body.style.overflow = 'auto'; // Restore scrolling
        }

        function viewDocument(type, applicationId) {
            if (type === 'resume') {
                alert(`Opening resume for application ${applicationId}`);
                // In real implementation: window.open('/storage/resumes/applicant_${applicationId}_resume.pdf', '_blank');
            } else if (type === 'tesda') {
                alert(`Opening TESDA certificate for application ${applicationId}`);
                // In real implementation: window.open('/storage/certificates/applicant_${applicationId}_tesda.pdf', '_blank');
            }
        }

        function approveApplication(applicationId) {
            if (confirm('Are you sure you want to approve this application?')) {
                alert(`Application ${applicationId} approved!`);
                // Update status visually
                updateApplicationStatus(applicationId, 'approved', '#28a745');

                // In real implementation:
                // fetch('/applications/' + applicationId + '/approve', { method: 'POST' })
            }
        }

        function rejectApplication(applicationId) {
            if (confirm('Are you sure you want to reject this application?')) {
                alert(`Application ${applicationId} rejected!`);
                // Update status visually
                updateApplicationStatus(applicationId, 'rejected', '#dc3545');

                // In real implementation:
                // fetch('/applications/' + applicationId + '/reject', { method: 'POST' })
            }
        }

        function scheduleInterview(applicationId) {
            alert(`Schedule interview for application ${applicationId}`);
            // In real implementation: open interview scheduling modal
        }

        function contactApplicant(email) {
            window.location.href = `mailto:${email}`;
        }

        function updateApplicationStatus(applicationId, status, color) {
            // Find the application card and update status badge
            const cards = document.querySelectorAll('.application-card');
            cards.forEach((card, index) => {
                if (index + 1 === applicationId) {
                    const statusBadge = card.querySelector('.status-badge');
                    statusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                    statusBadge.style.background = color;
                    statusBadge.style.color = 'white';
                }
            });
        }

        function exportApplications() {
            alert('Exporting all applications to CSV...');
            // In real implementation: generate and download CSV file
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('applicationsModalOverlay');
            if (event.target === modal) {
                closeApplicationsModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeApplicationsModal();
            }
        });
    </script>

    <!-- Scripts -->

    <script>
        const jobCategorySelect = document.getElementById('jobCategory');
        const jobSubcategorySelect = document.getElementById('otherCategory');

        jobCategorySelect.addEventListener('change', function() {
            if (this.value === 'Other') {
                jobSubcategorySelect.style.display = 'block';
            } else {
                jobSubcategorySelect.style.display = 'none';
            }

        });



        document.addEventListener('DOMContentLoaded', function() {
            const benefitBadges = document.querySelectorAll('.benefit-option');
            const hiddenInput = document.getElementById('benefits');

            benefitBadges.forEach(badge => {
                badge.addEventListener('click', () => {
                    badge.classList.toggle('selected');

                    // Collect all selected benefits
                    const selectedBenefits = Array.from(document.querySelectorAll(
                            '.benefit-option.selected'))
                        .map(el => el.dataset.benefit);

                    // Update the hidden input value (you can split this later on the server)
                    hiddenInput.value = selectedBenefits.join(',');
                });
            });
        });


        function toggleTesdaCerts(checkbox) {
            const tesda = document.getElementById('tesdacertifications');
            const nonTesda = document.getElementById('nonTesdaCertifications');

            if (checkbox.checked) {
                tesda.style.display = 'none';
                nonTesda.style.display = 'block';
            } else {
                tesda.style.display = 'block';
                nonTesda.style.display = 'none';
            }


        }

        function toggleOtherCertInput() {
            const input = document.getElementById('otherCertInput');
            const checkbox = document.getElementById('otherCertCheckbox');
            input.style.display = checkbox.checked ? 'block' : 'none';

        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle functionality
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const menuIcon = document.getElementById('menuIcon');

        function toggleSidebar() {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');

            if (sidebar.classList.contains('show')) {
                menuIcon.classList.remove('fa-bars');
                menuIcon.classList.add('fa-times');
            } else {
                menuIcon.classList.remove('fa-times');
                menuIcon.classList.add('fa-bars');
            }
        }

        toggleBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // Navigation functionality
        const navLinks = document.querySelectorAll('.nav-link[data-target]');
        const sections = document.querySelectorAll('.page-section');

        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();

                // Remove active class from all links
                navLinks.forEach(l => l.classList.remove('active'));
                link.classList.add('active');

                // Hide all sections
                sections.forEach(section => section.classList.remove('active'));

                // Show target section
                const targetId = link.getAttribute('data-target');
                const targetSection = document.getElementById(targetId);
                if (targetSection) {
                    targetSection.classList.add('active');
                }

                // Auto-close sidebar on mobile
                if (window.innerWidth <= 991) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    menuIcon.classList.remove('fa-times');
                    menuIcon.classList.add('fa-bars');
                }
            });
        });

        // Search and filter functionality for applicants
        const searchInput = document.getElementById('searchApplicants');
        const positionFilter = document.getElementById('positionFilter');
        const certificationFilter = document.getElementById('certificationFilter');
        const applicantRows = document.querySelectorAll('#applicantsTable tbody tr');

        function filterApplicants() {
            const searchValue = searchInput ? searchInput.value.toLowerCase().trim() : '';
            const selectedPosition = positionFilter ? positionFilter.value.toLowerCase().trim() : '';
            const certificationValue = certificationFilter ? certificationFilter.value.toLowerCase().trim() : '';

            applicantRows.forEach(row => {
                const nameCell = row.querySelector('.applicant-details h6');
                const positionCell = row.querySelector('td:nth-child(3) strong');
                const locationCell = row.querySelector('td:nth-child(3) small');

                const name = nameCell ? nameCell.textContent.toLowerCase().trim() : '';
                const position = positionCell ? positionCell.textContent.toLowerCase().trim() : '';
                const location = locationCell ? locationCell.textContent.toLowerCase().trim() : '';
                const certificationsText = (row.dataset.certifications || '').toLowerCase().trim();

                const matchesSearch = !searchValue || name.includes(searchValue) || location.includes(searchValue);
                const matchesPosition = !selectedPosition || position.includes(selectedPosition);
                const matchesCertification = !certificationValue || certificationsText.includes(certificationValue);

                row.style.display = (matchesSearch && matchesPosition && matchesCertification) ? '' : 'none';
            });
        }

        if (searchInput) searchInput.addEventListener('input', filterApplicants);
        if (positionFilter) positionFilter.addEventListener('change', filterApplicants);
        if (certificationFilter) certificationFilter.addEventListener('change', filterApplicants);


        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 991) {
                if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target) && sidebar.classList.contains(
                        'show')) {
                    toggleSidebar();
                }
            }
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 991) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                menuIcon.classList.remove('fa-times');
                menuIcon.classList.add('fa-bars');
            }
        });

        function updateBenefits() {
            const selected = document.querySelectorAll('.skill-badge-selected');
            const benefits = Array.from(selected).map(el => el.textContent.trim());
            document.getElementById('benefits').value = selected.join(',');
        }
    </script>

    <!--- Toggle---->
    <script>
        const selectedBenefits = [];

        function toggleSkill(el) {
            const benefit = el.innerText.trim();
            const index = selectedBenefits.indexOf(benefit);

            if (index > -1) {
                selectedBenefits.splice(index, 1);
                el.classList.remove("selected");
            } else {
                selectedBenefits.push(benefit);
                el.classList.add("selected");
            }

            // Update the hidden input
            document.getElementById('benefits').value = selectedBenefits.join(',');
        }
    </script>

    <!---Expiration session--->
    <script>
        const timeout = 10 * 60 * 1000; // 10 minutes
        const warningTime = 9 * 60 * 1000; // 1 minute before logout

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
            window.location.href = "{{ route('employer.login.display') }}";
        }

        document.addEventListener('mousemove', resetTimers);
        document.addEventListener('keydown', resetTimers);
        document.addEventListener('click', resetTimers);
    </script>


</body>

</html>
