<div class="page-section" id="reports-section">
    <div class="content-section">
        <div class="reports-header">
            <div class="header-content">
                <h3 class="fw-bold mb-0">
                  Reported Applicants
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
