<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reported Job Posts</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #10b981;
            --primary-green-dark: #059669;
            --danger-red: #ef4444;
            --warning-yellow: #f59e0b;
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --border-light: #e5e7eb;
            --hover-bg: #f9fafb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #ffffff;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: var(--text-primary);
            min-height: 100vh;
        }

        /* Top Navigation */
        .top-nav {
            background: #ffffff;
            border-bottom: 1px solid var(--border-light);
            padding: 1.25rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95);
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.938rem;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
        }

        .back-btn:hover {
            color: var(--primary-green);
            background-color: #f0fdf4;
        }

        .back-btn i {
            font-size: 1.125rem;
        }

        /* Main Container */
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem;
        }

        /* Header Section */
        .page-header {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid var(--border-light);
        }

        .page-title-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .title-content {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .icon-badge {
            width: 3.5rem;
            height: 3.5rem;
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: #dc2626;
        }

        .title-text h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            letter-spacing: -0.025em;
        }

        .title-text p {
            font-size: 0.938rem;
            color: var(--text-secondary);
            margin: 0.25rem 0 0 0;
        }

        .stats-badge {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: var(--primary-green-dark);
            padding: 0.625rem 1.25rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 600;
            white-space: nowrap;
        }

        /* Card Styling */
        .reports-card {
            background: #ffffff;
            border: 1px solid var(--border-light);
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        /* Table Styling - Desktop */
        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .reports-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 0;
        }

        .reports-table thead th {
            background: #f9fafb;
            padding: 1rem 1.5rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.813rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid var(--border-light);
            white-space: nowrap;
        }

        .reports-table tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid #f3f4f6;
        }

        .reports-table tbody tr:hover {
            background-color: var(--hover-bg);
        }

        .reports-table tbody tr:last-child {
            border-bottom: none;
        }

        .reports-table tbody td {
            padding: 1.5rem 1.5rem;
            vertical-align: middle;
        }

        .company-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .company-name {
            font-weight: 600;
            font-size: 0.938rem;
            color: var(--text-primary);
        }

        .company-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-dark) 100%);
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .job-title {
            font-size: 0.875rem;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .other-reason {
            font-size: 0.875rem;
            color: var(--text-secondary);
            line-height: 1.5;
            max-width: 250px;
        }

        /* Badge Styling */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.813rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-badge.fraudulent {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-badge.misleading {
            background: #fef3c7;
            color: #92400e;
        }

        .status-badge i {
            font-size: 0.75rem;
        }

        /* Button Styling */
        .btn-custom {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .btn-view {
            background: #ffffff;
            color: var(--primary-green);
            border: 1.5px solid var(--primary-green);
        }

        .btn-view:hover {
            background: var(--primary-green);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
        }

        .btn-remove {
            background: #ffffff;
            color: var(--danger-red);
            border: 1.5px solid var(--danger-red);
        }

        .btn-remove:hover {
            background: var(--danger-red);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
        }

        /* Modal Styling */
        .modal-content {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background: #ffffff;
            border-bottom: 1px solid var(--border-light);
            padding: 1.5rem;
            border-radius: 1rem 1rem 0 0;
        }

        .modal-title {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 1.125rem;
        }

        .modal-body {
            padding: 2rem 1.5rem;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .modal-footer {
            border-top: 1px solid var(--border-light);
            padding: 1rem 1.5rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--text-secondary);
            opacity: 0.3;
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .main-container {
                padding: 2rem 1.25rem;
            }

            .reports-table thead th,
            .reports-table tbody td {
                padding: 1rem 1.25rem;
            }
        }

        /* Mobile Responsive - Card Layout */
        @media (max-width: 768px) {
            .top-nav {
                padding: 1rem 0;
            }

            .main-container {
                padding: 1.5rem 1rem;
            }

            .page-header {
                margin-bottom: 1.5rem;
                padding-bottom: 1rem;
            }

            .page-title-wrapper {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .title-content {
                gap: 0.75rem;
            }

            .icon-badge {
                width: 3rem;
                height: 3rem;
                font-size: 1.5rem;
            }

            .title-text h1 {
                font-size: 1.5rem;
            }

            .title-text p {
                font-size: 0.875rem;
            }

            .stats-badge {
                width: 100%;
                text-align: center;
            }

            /* Hide table headers on mobile */
            .reports-table thead {
                display: none;
            }

            /* Make table rows display as cards */
            .reports-table tbody tr {
                display: block;
                background: #ffffff;
                border: 1px solid var(--border-light);
                border-radius: 0.75rem;
                margin-bottom: 1rem;
                padding: 1.25rem;
            }

            .reports-table tbody tr:last-child {
                margin-bottom: 0;
            }

            .reports-table tbody td {
                display: block;
                padding: 0.5rem 0;
                border: none;
                text-align: left;
            }

            /* Add labels before each cell */
            .reports-table tbody td::before {
                content: attr(data-label);
                display: block;
                font-size: 0.75rem;
                font-weight: 600;
                color: var(--text-secondary);
                text-transform: uppercase;
                letter-spacing: 0.05em;
                margin-bottom: 0.375rem;
            }

            /* Company info styling for mobile */
            .reports-table tbody td:first-child {
                padding-bottom: 1rem;
                margin-bottom: 0.5rem;
                border-bottom: 1px solid var(--border-light);
            }

            .reports-table tbody td:first-child::before {
                display: none;
            }

            .company-info {
                flex-direction: row;
                align-items: center;
                gap: 0.75rem;
            }

            .company-icon {
                margin-bottom: 0;
            }

            /* Adjust other fields */
            .other-reason {
                max-width: 100%;
            }

            /* Action buttons full width */
            .reports-table tbody td:last-child form {
                width: 100%;
            }

            .btn-custom {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .back-btn {
                font-size: 0.875rem;
                padding: 0.5rem 0.75rem;
            }

            .main-container {
                padding: 1.25rem 0.75rem;
            }

            .title-text h1 {
                font-size: 1.25rem;
            }

            .icon-badge {
                width: 2.5rem;
                height: 2.5rem;
                font-size: 1.25rem;
            }

            .reports-card {
                border-radius: 0.75rem;
            }

            .reports-table tbody tr {
                padding: 1rem;
            }

            .company-icon {
                width: 2rem;
                height: 2rem;
                font-size: 0.75rem;
            }

            .btn-custom {
                padding: 0.5rem 0.875rem;
                font-size: 0.813rem;
            }
        }
    </style>
</head>

<body>
    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="container-fluid" style="max-width: 1400px; margin: 0 auto; padding: 0 1.5rem;">
            <a href="{{ route('applicant.info.homepage.display') }}" class="back-btn">
                <i class="bi bi-arrow-left"></i>
                <span>Back to Homepage</span>
            </a>
        </div>
    </nav>

    @if (session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert" id="success-alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>

        <script>
            // Hide the alert after 2 seconds (2000 ms)
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 500);
                }
            }, 2000);
        </script>
    @endif

    <!-- Main Content -->
    <div class="main-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-title-wrapper">
                <div class="title-content">
                    <div class="icon-badge">
                        <i class="bi bi-flag-fill"></i>
                    </div>
                    <div class="title-text">
                        <h1>Reported Job Posts</h1>
                        <p>Review and manage flagged job listings</p>
                    </div>
                </div>
                @if ($jobPostReported->count() > 1)
                    <div class="stats-badge">
                        Showing {{ $jobPostReported->count() }} reports
                    </div>
                @else
                    <div class="stats-badge">
                        Showing {{ $jobPostReported->count() }} report
                    </div>
                @endif
            </div>
        </div>

        <!-- Reports Card -->
        <div class="reports-card">
            <div class="table-wrapper">
                <table class="reports-table">
                    <thead>
                        <tr>
                            <th>Company Name</th>
                            <th>Job Title</th>
                            <th>Evidence</th>
                            <th>Reason</th>
                            <th>Additional Information</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jobPostReported as $report)
                            <tr>
                                <td data-label="Company Name">
                                    <div class="company-info">
                                        <div class="company-icon">
                                            {{ Str::substr($report->employer->Addresscompany->company_name ?? 'Unknown', 0, 1) }}
                                        </div>
                                        <strong
                                            class="company-name">{{ $report->employer->Addresscompany->company_name ?? 'Unknown Company' }}</strong>
                                    </div>
                                </td>
                                <td data-label="Job Title">
                                    <div class="job-title">{{ $report->job->title ?? 'N/A' }}</div>
                                </td>
                                <td data-label="Evidence">
                                    @if ($report->attachment)
                                        <button class="btn-custom btn-view" data-bs-toggle="modal"
                                            data-bs-target="#evidenceModal{{ $loop->index }}">
                                            <i class="bi bi-eye"></i>
                                            <span>View</span>
                                        </button>

                                        <!-- Evidence Modal -->
                                        <div class="modal fade" id="evidenceModal{{ $loop->index }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Evidence</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img src="{{ asset('storage/' . $report->attachment) }}"
                                                            class="img-fluid" alt="Evidence" />
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">No evidence</span>
                                    @endif
                                </td>
                                <td data-label="Reason">
                                    @if ($report->reason == 'other')
                                        <span class="status-badge {{ strtolower($report->other_reason) }}">
                                            <i class="bi bi-exclamation-circle-fill"></i>
                                            {{ ucfirst($report->other_reason ?? 'N/A') }}
                                        </span>
                                    @else
                                        <span class="status-badge {{ strtolower($report->reason) }}">
                                            <i class="bi bi-exclamation-circle-fill"></i>
                                            {{ ucfirst($report->reason ?? 'N/A') }}
                                        </span>
                                    @endif
                                </td>
                                <td data-label="Additional Information">
                                    <div class="other-reason">{{ $report->additional_info ?? '-' }}</div>
                                </td>
                                <td data-label="Action">
                                    <form method="POST" action="{{ route('applicant.report.delete', $report->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-custom btn-remove">
                                            <i class="bi bi-trash"></i>
                                            <span>Remove Report</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <p>No reported job posts found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
