<div class="page-section active" id="dashboard-section">
    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-value">{{ $totalApprovedApplicant }}</div>
                    <div class="stat-label">Total Applicants Hired</div>
                </div>
                <div class="stat-icon primary">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-value">{{ $JobPostRetrieved->where('status_post', 'published')->count() }}</div>
                    <div class="stat-label">Active Job Posts</div>
                </div>
                <div class="stat-icon success">
                    <i class="fas fa-briefcase"></i>
                </div>
            </div>
        </div>


    </div>

    <!-- Applicants Table -->
    <div class="applicants-section">
        <div class="section-header">
            <h4 class="section-title">Recently Hired Applicants</h4>
            {{-- <div class="section-actions">
                <button class="btn-filter">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <button class="btn-export">
                    <i class="fas fa-download"></i> Export
                </button>
            </div> --}}
        </div>

        <div class="table-container">
            <table class="applicants-table">
                <thead>
                    <tr>
                        <th>Applicant</th>
                        <th>Position & Location</th>
                        <th>Status</th>
                        <th>Applied Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($retrievedApproveApplicants) && count($retrievedApproveApplicants) > 0)
                        @foreach ($retrievedApproveApplicants as $app)
                            @php
                                $personal = $app->applicant->personal_info ?? null;
                                $work = $app->applicant->work_background ?? null;
                                $employedStatus = isset($work->employed)
                                    ? ($work->employed == 'No' || $work->employed == false
                                        ? 'Unemployed'
                                        : 'Employed')
                                    : 'Not Specified';
                                $status = $app->status ?? 'approved';
                                $statusClasses = [
                                    'approved' => 'status-badge approved',
                                    'rejected' => 'status-badge rejected',
                                    'interview' => 'status-badge interview',
                                    'pending' => 'status-badge pending',
                                ];
                                $alreadyReported = in_array($app->applicant->id, $reportedApplicantIds ?? []);
                            @endphp
                            <tr class="table-row" data-id="{{ $app->applicant->id }}">
                                {{-- Applicant Info --}}
                                <td>
                                    <div class="applicant-cell">
                                        <div class="applicant-avatar">
                                            {{ strtoupper(substr($personal->first_name ?? 'N', 0, 1)) }}{{ strtoupper(substr($personal->last_name ?? 'A', 0, 1)) }}
                                        </div>
                                        <div class="applicant-info">
                                            <div class="applicant-name">{{ $personal->first_name ?? 'N/A' }}
                                                {{ $personal->last_name ?? '' }}</div>
                                            <div class="applicant-email">{{ $app->applicant->email ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Position & Location --}}
                                <td>
                                    <div class="position-cell">
                                        <div class="position-title">
                                            {{ $work->position ?? ($work->other_position ?? 'N/A') }}</div>
                                        <div class="position-meta">
                                            <span class="employment-status">{{ $employedStatus }}</span>
                                            <span class="separator">•</span>
                                            <span class="location">{{ $personal->city ?? '' }},
                                                {{ $personal->province ?? '' }}</span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Status Badge --}}
                                <td>
                                    <span class="{{ $statusClasses[$status] ?? 'status-badge pending' }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>

                                {{-- Applied Date --}}
                                <td>
                                    <span
                                        class="date-text">{{ optional($app->created_at)->format('M d, Y') ?? 'N/A' }}</span>
                                </td>

                                {{-- Actions --}}
                                <td>
                                    <div class="action-buttons">
                                        {{-- View Profile --}}
                                        @if ($personal)
                                            <a href="{{ route('employer.applicantsprofile.display', $app->applicant->id) }}"
                                                class="action-btn view-btn" title="View Profile">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('display.notfound') }}" class="action-btn disabled-btn"
                                                title="Profile Not Found">
                                                <i class="fa-solid fa-triangle-exclamation"></i>
                                            </a>
                                        @endif

                                        {{-- Message --}}
                                        <button class="action-btn message-btn" title="Message"
                                            data-applicant-id="{{ $app->applicant->id }}"
                                            data-applicant-name="{{ $personal->first_name ?? '' }} {{ $personal->last_name ?? '' }}"
                                            data-applicant-email="{{ $personal->email ?? '' }}">
                                            <i class="fas fa-envelope"></i>
                                        </button>

                                        {{-- Report --}}
                                        <button class="action-btn report-btn report-applicant-btn"
                                            data-applicant-id="{{ $app->applicant->id }}"
                                            data-applicant-name="{{ $personal->first_name ?? '' }} {{ $personal->last_name ?? '' }}"
                                            data-applicant-email="{{ $personal->email ?? '' }}" data-bs-toggle="modal"
                                            data-bs-target="#reportApplicantModal"
                                            title="{{ $alreadyReported ? 'Already reported' : 'Report this applicant' }}"
                                            @if ($alreadyReported) disabled @endif>
                                            <i class="bi bi-flag-fill"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="empty-state">
                                <div class="empty-content">
                                    <i class="fas fa-users"></i>
                                    <p>No applicants found</p>
                                    <span>Approved applicants will appear here</span>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
