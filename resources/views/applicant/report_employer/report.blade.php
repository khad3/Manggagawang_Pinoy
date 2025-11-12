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
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/applicant/report_job_post.css') }}">
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
                                            @if (!empty($report->employer?->Addresscompany?->company_name))
                                                {{ Str::substr($report->employer->Addresscompany->company_name, 0, 1) }}
                                            @elseif (!empty($report->employer?->personal_info))
                                                {{ Str::substr($report->employer->personal_info->first_name ?? '', 0, 1) }}
                                            @else
                                                U
                                            @endif
                                        </div>
                                        <strong class="company-name">
                                            @if (!empty($report->employer?->Addresscompany?->company_name))
                                                {{ $report->employer->Addresscompany->company_name }}
                                            @elseif (!empty($report->employer?->personal_info))
                                                {{ $report->employer->personal_info->first_name ?? '' }}
                                                {{ $report->employer->personal_info->last_name ?? '' }}
                                            @else
                                                Unknown
                                            @endif
                                        </strong>
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
