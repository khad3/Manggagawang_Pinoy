<div class="page-section" id="reports-section">
    <div class="content-section">
        <div class="reports-header">
            <div class="header-content">
                <h3 class="fw-bold mb-0">
                    <i class="fas fa-flag me-2 text-danger"></i>Reported Applicants
                </h3>
                @if (count($retrievedApplicantReported) === 1)
                    <span class="badge bg-danger reports-badge">{{ count($retrievedApplicantReported) }} Report</span>
                @elseif (count($retrievedApplicantReported) > 1)
                    <span class="badge bg-danger reports-badge">{{ count($retrievedApplicantReported) }} Reports</span>
                @else
                    <span class="badge bg-secondary reports-badge">No Reports</span>
                @endif
            </div>
        </div>

        @if ($retrievedApplicantReported->isNotEmpty())
            <!-- Reports Table -->
            <div class="table-container">
                <table class="reports-table">
                    <thead>
                        <tr>
                            <th class="number-col">#</th>
                            <th class="name-col">Name</th>
                            <th class="reason-col">Reason</th>
                            <th class="evidence-col">Photo Evidence</th>
                            <th class="action-col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($retrievedApplicantReported as $index => $userReported)
                            @php
                                $applicant = $userReported->appplicantReported ?? null;
                                $personal = $applicant->personal_info ?? null;
                                $work = $applicant->work_background ?? null;
                            @endphp

                            <tr class="report-row">
                                <td class="number-col" data-label="#">{{ $index + 1 }}</td>
                                <td class="name-col" data-label="Name">
                                    <div class="applicant-info">
                                        @if ($applicant?->profile_photo)
                                            <!-- Show uploaded profile photo -->
                                            <img src="{{ asset('storage/' . $applicant->profileimage_path) }}"
                                                class="applicant-photo" alt="Applicant">
                                        @else
                                            <!-- Show initials when no profile photo -->
                                            @php
                                                $firstInitial = strtoupper(substr($personal?->first_name ?? 'U', 0, 1));
                                                $lastInitial = strtoupper(substr($personal?->last_name ?? 'N', 0, 1));
                                                $initials = $firstInitial . $lastInitial;
                                            @endphp

                                            <div class="applicant-avatar">
                                                {{ $initials }}
                                            </div>
                                        @endif

                                        <div class="applicant-details">
                                            <div class="applicant-name">{{ $personal?->first_name ?? 'Unknown' }}
                                                {{ $personal?->last_name ?? '' }}</div>
                                            <div class="applicant-position">{{ $work?->position ?? 'Unknown Position' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="reason-col" data-label="Reason">
                                    @php
                                        $mainReason = $userReported->reason ?? null;
                                        $additional = $userReported->additional_info ?? null;
                                        $other = $userReported->other_reason ?? null;

                                        if ($mainReason === 'other' && $other) {
                                            $displayReason = ucfirst($other);
                                        } else {
                                            $displayReason = ucfirst($mainReason ?? 'Unknown');
                                        }

                                        if ($additional) {
                                            $displayReason .= ' - ' . ucfirst($additional);
                                        }
                                    @endphp

                                    <div class="reason-text">{{ $displayReason }}</div>
                                </td>

                                <td class="evidence-col" data-label="Evidence">
                                    @if ($userReported->attachment)
                                        <button class="btn-evidence" data-bs-toggle="modal"
                                            data-bs-target="#viewEvidenceModal{{ $userReported->id }}">
                                            <i class="fas fa-eye me-1"></i> View
                                        </button>

                                        <!-- Modal for Viewing Evidence -->
                                        <div class="modal fade" id="viewEvidenceModal{{ $userReported->id }}"
                                            tabindex="-1"
                                            aria-labelledby="viewEvidenceModalLabel{{ $userReported->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="viewEvidenceModalLabel{{ $userReported->id }}">
                                                            Photo Evidence
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('storage/' . $userReported->attachment) }}"
                                                            class="img-fluid rounded shadow" alt="Evidence">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="no-evidence">No evidence</span>
                                    @endif
                                </td>

                                <td class="action-col" data-label="Action">
                                    <form
                                        action="{{ route('employer.remove.report.applicant.store', $userReported->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to remove this report?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-remove">
                                            <i class="fas fa-trash-alt me-1"></i> Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-flag fa-4x text-muted mb-3"></i>
                <h4>No reports yet</h4>
                <p class="text-muted">All applicants are in good standing.</p>
            </div>
        @endif
    </div>
</div>

<style>
    /* Modern Variables */
    :root {
        --primary: #4F46E5;
        --danger: #EF4444;
        --danger-light: #FEE2E2;
        --success: #10B981;
        --gray-50: #F9FAFB;
        --gray-100: #F3F4F6;
        --gray-200: #E5E7EB;
        --gray-300: #D1D5DB;
        --gray-400: #9CA3AF;
        --gray-500: #6B7280;
        --gray-600: #4B5563;
        --gray-700: #374151;
        --gray-800: #1F2937;
        --gray-900: #111827;
        --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --radius: 12px;
        --radius-sm: 8px;
    }

    .page-section {
        padding: 2rem;
        background: var(--gray-50);
        min-height: 100vh;
    }

    .content-section {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        border: 1px solid var(--gray-200);
    }

    /* Reports Header */
    .reports-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--gray-200);
        background: white;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .header-content h3 {
        font-size: 1.5rem;
        color: var(--gray-900);
        display: flex;
        align-items: center;
    }

    .reports-badge {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-weight: 600;
    }

    /* Table Container */
    .table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .reports-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .reports-table thead {
        background: var(--gray-50);
        border-bottom: 2px solid var(--gray-200);
    }

    .reports-table th {
        padding: 1rem 1.5rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        white-space: nowrap;
    }

    .reports-table tbody tr {
        border-bottom: 1px solid var(--gray-200);
        transition: background 0.2s ease;
    }

    .reports-table tbody tr:hover {
        background: var(--gray-50);
    }

    .reports-table td {
        padding: 1.25rem 1.5rem;
        vertical-align: middle;
    }

    /* Number Column */
    .number-col {
        width: 60px;
        font-weight: 600;
        color: var(--gray-700);
    }

    /* Applicant Info */
    .applicant-info {
        display: flex;
        align-items: center;
        gap: 0.875rem;
    }

    .applicant-photo {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--gray-200);
        flex-shrink: 0;
    }

    .applicant-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366F1, var(--primary));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.875rem;
        flex-shrink: 0;
    }

    .applicant-details {
        min-width: 0;
    }

    .applicant-name {
        font-weight: 600;
        color: var(--gray-900);
        font-size: 0.9375rem;
        margin-bottom: 0.25rem;
    }

    .applicant-position {
        font-size: 0.8125rem;
        color: var(--gray-500);
    }

    /* Reason Column */
    .reason-text {
        color: var(--gray-700);
        font-size: 0.875rem;
        line-height: 1.5;
    }

    /* Evidence Column */
    .btn-evidence {
        padding: 0.5rem 1rem;
        border: 1px solid var(--primary);
        background: white;
        color: var(--primary);
        border-radius: var(--radius-sm);
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
    }

    .btn-evidence:hover {
        background: var(--primary);
        color: white;
    }

    .no-evidence {
        color: var(--gray-400);
        font-size: 0.875rem;
        font-style: italic;
    }

    /* Action Button */
    .btn-remove {
        padding: 0.5rem 1rem;
        border: 1px solid var(--danger);
        background: white;
        color: var(--danger);
        border-radius: var(--radius-sm);
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        white-space: nowrap;
    }

    .btn-remove:hover {
        background: var(--danger);
        color: white;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state i {
        display: block;
        margin-bottom: 1rem;
    }

    .empty-state h4 {
        color: var(--gray-700);
        margin-bottom: 0.5rem;
    }

    /* Modal Enhancements */
    .modal-content {
        border-radius: var(--radius);
        border: none;
        box-shadow: var(--shadow-lg);
    }

    .modal-header {
        background: var(--gray-50);
        border-bottom: 1px solid var(--gray-200);
        border-radius: var(--radius) var(--radius) 0 0;
    }

    .modal-body img {
        max-width: 100%;
        height: auto;
        border-radius: var(--radius-sm);
    }

    /* RESPONSIVE BREAKPOINTS */

    /* Large Tablets (992px - 1200px) */
    @media (max-width: 1200px) {

        .reports-table th,
        .reports-table td {
            padding: 1rem;
            font-size: 0.875rem;
        }

        .applicant-name {
            font-size: 0.875rem;
        }

        .applicant-position {
            font-size: 0.75rem;
        }

        .reason-text {
            font-size: 0.8125rem;
        }
    }

    /* Tablets (768px - 992px) */
    @media (max-width: 992px) {
        .page-section {
            padding: 1.5rem;
        }

        .reports-header {
            padding: 1.25rem 1.5rem;
        }

        .header-content h3 {
            font-size: 1.25rem;
        }

        /* Hide number column on tablets */
        .number-col {
            display: none;
        }

        .btn-evidence,
        .btn-remove {
            padding: 0.4rem 0.75rem;
            font-size: 0.8125rem;
        }
    }

    /* Mobile Devices (max-width: 768px) */
    @media (max-width: 768px) {
        .page-section {
            padding: 1rem;
        }

        .reports-header {
            padding: 1rem;
        }

        .header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        /* Transform table into cards */
        .reports-table thead {
            display: none;
        }

        .reports-table,
        .reports-table tbody,
        .reports-table tr,
        .reports-table td {
            display: block;
            width: 100%;
        }

        .reports-table tr {
            margin-bottom: 1.25rem;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-sm);
            padding: 1.25rem;
            background: white;
            box-shadow: var(--shadow);
        }

        .reports-table tbody tr:hover {
            background: white;
        }

        .reports-table td {
            padding: 0.75rem 0;
            border: none;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .reports-table td:before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--gray-600);
            font-size: 0.75rem;
            text-transform: uppercase;
            min-width: 100px;
            flex-shrink: 0;
            padding-top: 0.25rem;
        }

        .number-col {
            display: none !important;
        }

        .name-col {
            border-bottom: 1px solid var(--gray-200);
            padding-bottom: 1rem !important;
            margin-bottom: 0.75rem;
        }

        .name-col:before {
            display: none;
        }

        .applicant-info {
            width: 100%;
        }

        .reason-col,
        .evidence-col {
            padding: 0.5rem 0 !important;
        }

        .action-col {
            padding-top: 1rem !important;
            border-top: 1px solid var(--gray-200);
            margin-top: 0.75rem;
        }

        .action-col:before {
            content: "Action";
        }

        .btn-remove {
            flex: 1;
            justify-content: center;
        }

        .reason-text {
            flex: 1;
            text-align: right;
        }
    }

    /* Small Mobile (max-width: 576px) */
    @media (max-width: 576px) {
        .reports-badge {
            font-size: 0.75rem;
            padding: 0.375rem 0.75rem;
        }

        .applicant-photo,
        .applicant-avatar {
            width: 36px;
            height: 36px;
            font-size: 0.75rem;
        }

        .applicant-name {
            font-size: 0.8125rem;
        }

        .applicant-position {
            font-size: 0.6875rem;
        }

        .reports-table td {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .reports-table td:before {
            margin-bottom: 0.25rem;
        }

        .reason-text {
            text-align: left;
            width: 100%;
        }

        .btn-evidence,
        .btn-remove {
            width: 100%;
            justify-content: center;
        }

        .applicant-info {
            flex-direction: row;
        }

        .action-col {
            display: block;
        }

        .action-col form {
            width: 100%;
        }
    }

    /* Extra Small Mobile (max-width: 400px) */
    @media (max-width: 400px) {
        .page-section {
            padding: 0.75rem;
        }

        .reports-header {
            padding: 0.75rem;
        }

        .header-content h3 {
            font-size: 1.125rem;
        }

        .header-content h3 i {
            font-size: 1rem;
        }

        .reports-table tr {
            padding: 1rem;
        }

        .applicant-details {
            word-break: break-word;
        }
    }
</style>
