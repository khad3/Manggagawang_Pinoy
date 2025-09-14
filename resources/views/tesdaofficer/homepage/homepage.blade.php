<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TESDA Officers - Certification Portal</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/applicant/tesdaofficer/homepage.css') }}">
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo-section">
                    <div class="logo">T</div>
                    <div>
                        <div class="header-title">TESDA Officers Portal</div>
                        <div class="header-subtitle">Certification Management System</div>
                    </div>
                </div>
                <div class="user-section">
                    <div class="user-info">
                        <div class="user-name">Admin Officer</div>
                        <div class="user-role">Certification Specialist</div>
                    </div>
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="header-actions">
                        <button class="header-btn" onclick="openModal('settingsModal')" title="Settings">
                            <i class="fas fa-cog"></i>
                        </button>

                        <form action="{{ route('tesda-officer.logout.store') }}" method="POST" style="display:inline;"
                            onsubmit="return confirm('Are you sure you want to logout?');">
                            @csrf
                            <button type="submit" class="header-btn logout-btn" title="Logout">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Certification Dashboard</h1>
                <p class="page-description">Manage and validate technical education certifications</p>
            </div>

            <!-- Statistics -->
            <div class="stats-grid">
                {{-- Pending Review --}}
                <div class="stat-card">
                    <div class="stat-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-number">{{ $todayPending }}</div>
                    <div class="stat-label">Pending Review</div>
                    <div class="stat-change {{ $pendingChange >= 0 ? 'positive' : 'negative' }}">
                        {{ $pendingChange >= 0 ? '+' : '' }}{{ $pendingChange }}
                        ({{ number_format($pendingPercentage, 1) }}%) from yesterday
                    </div>
                </div>

                {{-- Approved Today --}}
                <div class="stat-card">
                    <div class="stat-icon approved">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-number">{{ $approvedToday }}</div>
                    <div class="stat-label">Approved Today</div>
                    <div class="stat-change {{ $approvedChange >= 0 ? 'positive' : 'negative' }}">
                        {{ $approvedSign }}{{ $approvedChange }}% from yesterday
                    </div>
                </div>

                {{-- Total Processed --}}
                <div class="stat-card">
                    <div class="stat-icon total">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div class="stat-number">{{ $totalProcessed }}</div>
                    <div class="stat-label">Total Processed</div>
                    <div class="stat-change neutral">By You</div>
                </div>
            </div>


            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <center>{{ session('success') }}</center>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <!-- Main Card -->
            <div class="main-card">
                <div class="card-header">
                    <div class="card-title">Certification Applications</div>
                    <div class="card-description">Review and validate submitted certification documents</div>
                </div>
                <div class="card-content">
                    <div class="action-section d-flex flex-wrap gap-2 align-items-center mb-3">
                        <!-- Search by applicant name -->
                        <input type="text" id="searchInput" class="form-control form-control-sm w-auto"
                            placeholder="Search applicant">

                        <!-- Status filter -->
                        <select id="statusFilter" class="form-select form-select-sm w-auto">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                            <option value="request_revision">Request Revision</option>
                        </select>

                        <!-- Date range filter -->
                        <input type="date" id="fromDate" class="form-control form-control-sm w-auto">
                        <span>to</span>
                        <input type="date" id="toDate" class="form-control form-control-sm w-auto">

                        <!-- Apply Filter Button -->
                        <button class="btn btn-primary btn-sm" onclick="applyFilters()">
                            <i class="fas fa-filter"></i> Apply
                        </button>

                        <!-- Export Report -->
                        <button class="btn btn-secondary btn-sm ms-auto" onclick="generateReport()">
                            <i class="fas fa-download"></i> Export Report
                        </button>

                        <!-- Delete All Button -->
                        <form action="{{ route('tesda-officer.delete') }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to clear all your reviews? Applicant certificates will remain intact.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i> Clear My Reviews
                            </button>
                        </form>
                    </div>


                    <!-- Applications Table -->
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    @auth('tesda_officer')
                                        <th>Applicant ID</th>
                                    @endauth
                                    <th>Name</th>
                                    <th>Program</th>
                                    <th>Submitted</th>
                                    <th>Status</th>
                                    <th>Suggested Comment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="applicationTable">
                                @foreach ($applicantCertificates as $application)
                                    <tr>
                                        @auth('tesda_officer')
                                            <td><strong>{{ $application->id }}</strong></td>
                                        @endauth

                                        <td>
                                            {{ $application->personal_info?->first_name ?? 'N/A' }}
                                            {{ $application->personal_info?->last_name ?? '' }}
                                        </td>

                                        <td>{{ $application->certification_program ?? 'N/A' }}</td>
                                        <td>{{ $application->created_at ? $application->created_at->format('M d, Y') : 'N/A' }}
                                        </td>

                                        <td>
                                            @php
                                                $status = strtolower($application->status ?? 'pending');
                                                $badgeClass = match ($status) {
                                                    'pending' => 'bg-warning',
                                                    'approved' => 'bg-success',
                                                    'rejected' => 'bg-danger',
                                                    default => 'bg-dark',
                                                };
                                            @endphp
                                            <span class="badge rounded-pill {{ $badgeClass }}">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>

                                        <td>{{ $application->officer_comment ?? '-' }}</td>

                                        <td>
                                            <button class="btn btn-primary btn-sm"
                                                onclick="reviewApplication('{{ $application->id }}')">
                                                Review
                                            </button>

                                            @if ($application->file_path)
                                                <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#certificateModal"
                                                    onclick="viewCertificate('{{ asset('storage/' . $application->file_path) }}')">
                                                    View Certificate
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>


                        <!-- Certificate Modal -->
                        <!-- Modal -->
                        <div class="modal fade" id="certificateModal" tabindex="-1" aria-hidden="true"
                            data-bs-backdrop="false">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Certificate</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-0">
                                        <!-- PDF preview -->
                                        <iframe id="certificateFrame" src="" frameborder="0"
                                            style="width:100%; height:600px;"></iframe>
                                    </div>
                                    {{-- <div class="modal-footer">
                                        <!-- Download link -->
                                        <a id="downloadCertificate" href="#" class="btn btn-primary"
                                            target="_blank">Download</a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>


                        <script>
                            function viewCertificate(url) {
                                document.getElementById('certificateFrame').src = url;
                                document.getElementById('downloadCertificate').href = url;
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Review Application Modal -->
    <div class="modal" id="reviewModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Review Certification Application</h3>
                <button class="close-btn" onclick="closeModal('reviewModal')">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tesda-officer.approved.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Application ID</label>
                        <input type="text" name="application_id" class="form-input" id="appId" readonly>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Review Status</label>
                        <select class="form-select" name="status" required>
                            <option value="">Select review status</option>
                            <option value="approved">Approve Certification</option>
                            <option value="rejected">Reject Application</option>
                            <option value="request_revision">Request Revision</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Officer Comments</label>
                        <textarea class="form-textarea" name="officer_comment" placeholder="Add your review comments and recommendations..."></textarea>
                    </div>

                    <button type="button" class="btn btn-secondary" onclick="closeModal('reviewModal')">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check"></i> Submit Review
                    </button>
                </form>
            </div>
        </div>
    </div>



    <!-- Settings Modal -->
    <div class="modal" id="settingsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">System Settings</h3>
                <button class="close-btn" onclick="closeModal('settingsModal')">&times;</button>
            </div>
            <div class="modal-body">
                <form id="settingsForm">
                    <h4 style="color: #374151; margin-bottom: 16px; font-size: 16px; font-weight: 600;">Account
                        Settings</h4>

                    <div class="form-group">
                        <label class="form-label">Display Name</label>
                        <input type="text" class="form-input" value="Admin Officer" required>
                    </div>

                    <!-- <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-input" value="admin@tesda.gov.ph" required>
                    </div> -->

                    <!-- <div class="form-group">
                        <label class="form-label">Officer Position</label>
                        <select class="form-select" required>
                            <option value="certification-specialist" selected>Certification Specialist</option>
                            <option value="senior-officer">Senior Officer</option>
                            <option value="supervisor">Supervisor</option>
                            <option value="manager">Manager</option>
                        </select>
                    </div> -->

                    <hr style="margin: 24px 0; border: none; border-top: 1px solid #e5e7eb;">

                    <h4 style="color: #374151; margin-bottom: 16px; font-size: 16px; font-weight: 600;">System
                        Preferences</h4>

                    <div class="form-group">
                        <label class="form-label">Default Items Per Page</label>
                        <select class="form-select">
                            <option value="10" selected>10 items</option>
                            <option value="25">25 items</option>
                            <option value="50">50 items</option>
                        </select>
                    </div>

                    <!-- <div class="form-group">
                        <label class="form-label">Email Notifications</label>
                        <select class="form-select">
                            <option value="all" selected>All notifications</option>
                            <option value="important">Important only</option>
                            <option value="none">Disabled</option>
                        </select>
                    </div> -->

                    <div class="form-group">
                        <label class="form-label">Auto-refresh Dashboard</label>
                        <select class="form-select">
                            <option value="30" selected>Every 30 seconds</option>
                            <option value="60">Every 1 minute</option>
                            <option value="300">Every 5 minutes</option>
                            <option value="0">Disabled</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('settingsModal')">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function viewCertificate(url) {
            document.getElementById('certificateFrame').src = url;
        }

        function applyFilters() {
            let search = document.getElementById('searchInput').value.toLowerCase();
            let status = document.getElementById('statusFilter').value.toLowerCase();
            let fromDate = document.getElementById('fromDate').value;
            let toDate = document.getElementById('toDate').value;

            let rows = document.querySelectorAll("#applicationTable tr");

            rows.forEach(row => {
                let name = row.cells[1].innerText.toLowerCase();
                let program = row.cells[2].innerText.toLowerCase();
                let submitted = row.cells[3].innerText; // format: YYYY-MM-DD
                let rowStatus = row.cells[4].innerText.toLowerCase().trim();

                let show = true;

                // Search filter
                if (search && !name.includes(search) && !program.includes(search)) {
                    show = false;
                }

                // Status filter
                if (status && rowStatus !== status) {
                    show = false;
                }

                // Date filter
                if (fromDate && submitted < fromDate) {
                    show = false;
                }
                if (toDate && submitted > toDate) {
                    show = false;
                }

                row.style.display = show ? "" : "none";
            });
        }
    </script>

    <script>
        function generateReport() {
            let table = document.querySelector("#applicationTable");
            if (!table) {
                alert("❌ Table not found! Make sure your table has id='applicationTable'");
                return;
            }

            let rows = table.querySelectorAll("tr");
            let csv = [];

            rows.forEach(row => {
                let cols = Array.from(row.querySelectorAll("td, th"))
                    .map(cell => `"${cell.innerText.trim().replace(/"/g, '""')}"`);
                csv.push(cols.join(","));
            });

            if (csv.length === 0) {
                alert("⚠️ No data found in table!");
                return;
            }

            // Generate CSV
            let csvContent = csv.join("\n");
            console.log("CSV Generated:", csvContent); // 👈 Debug output

            // Create a hidden download link
            let link = document.createElement("a");
            link.href = "data:text/csv;charset=utf-8," + encodeURIComponent(csvContent);
            link.download = "tesda_report.csv";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>

    <script>
        function reviewApplication(appId) {
            document.getElementById('appId').value = appId;
            openModal('reviewModal'); // shows your modal
        }

        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'flex';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
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
            window.location.href = "{{ route('tesda-officer.login.display') }}";
        }

        document.addEventListener('mousemove', resetTimers);
        document.addEventListener('keydown', resetTimers);
        document.addEventListener('click', resetTimers);
    </script>

</body>

</html>
