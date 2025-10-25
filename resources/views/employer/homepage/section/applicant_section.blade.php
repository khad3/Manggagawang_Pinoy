<div class="page-section" id="applicants-section">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="mb-2 fw-bold">Applicant Management</h2>
            <p class="text-muted mb-0">Review and manage job applications</p>
        </div>
    </div>

    <!-- Filter Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-value">
                        {{ isset($retrievedApplicants) ? $retrievedApplicants->count() : '0' }}</div>
                    <div class="stat-label">Total Applicants</div>
                </div>
                <div class="stat-icon primary">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Applicants Table -->
    <div class="content-section">
        <div
            class="section-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 w-100">
            <!-- Section Title -->
            <div class="section-title mb-3 mb-md-0 d-flex align-items-center">
                <i class="fas fa-users me-2"></i>
                <h4 class="mb-0">All Applicants</h4>
            </div>

            <!-- Section Actions: Search + Filters -->
            <div class="d-flex flex-column flex-md-row gap-2 w-100 align-items-stretch align-items-md-center">
                <!-- Search Input: flex-grow to fill space -->
                <div class="search-input flex-grow-1 position-relative">
                    <i class="fas fa-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" class="form-control ps-5" placeholder="Search by name or location..."
                        id="searchApplicants">
                </div>

                <!-- Filters Container: fixed width -->
                <div class="d-flex gap-2 mt-2 mt-md-0 flex-wrap">
                    <select class="form-select filter-select" id="positionFilter">
                        <option value="">Filter by Position</option>
                        @if (isset($retrievedApplicants))
                            @foreach ($retrievedApplicants->pluck('work_background.position')->filter()->unique() as $position)
                                <option value="{{ $position }}">{{ $position }}</option>
                            @endforeach
                        @endif
                    </select>

                    <select class="form-select filter-select" id="certificationFilter">
                        <option value="">Filter by Certification</option>
                        @if (isset($retrievedCertifications))
                            @foreach ($retrievedCertifications as $certification)
                                <option value="{{ $certification }}">{{ $certification }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table modern-table" id="applicantsTable">
                <thead>
                    <tr>
                        <th class="checkbox-col"><input type="checkbox" class="form-check-input"></th>
                        <th class="applicant-col">Applicant</th>
                        <th class="position-col">Position Applied</th>
                        <th class="experience-col">Experience</th>
                        <th class="rating-col">Rating</th>
                        <th class="actions-col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($retrievedApplicants))
                        @foreach ($retrievedApplicants as $applicant)
                            <tr
                                data-certifications="{{ implode(',', $applicant->certifications->pluck('certification_program')->toArray()) }}">
                                <td class="checkbox-col" data-label="">
                                    <input type="checkbox" class="form-check-input">
                                </td>
                                <td class="applicant-col" data-label="Applicant">
                                    <div class="applicant-info">
                                        <div class="applicant-avatar">
                                            {{ strtoupper(substr($applicant->personal_info->first_name ?? 'N', 0, 1)) }}{{ strtoupper(substr($applicant->personal_info->last_name ?? 'A', 0, 1)) }}
                                        </div>
                                        <div class="applicant-details">
                                            <h6>{{ $applicant->personal_info->first_name ?? 'N/A' }}
                                                {{ $applicant->personal_info->last_name ?? '' }}</h6>
                                            <p>{{ $applicant->email ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="position-col" data-label="Position">
                                    <div class="position-info">
                                        <strong class="position-title">
                                            @if (isset($applicant->work_background->position) || isset($applicant->work_background->other_position))
                                                {{ $applicant->work_background->position ?? '' }}
                                                {{ $applicant->work_background->other_position ?? '' }}
                                            @else
                                                N/A
                                            @endif
                                        </strong>
                                        <small class="text-muted position-meta">
                                            @php
                                                $employedStatus = isset($applicant->work_background->employed)
                                                    ? ($applicant->work_background->employed == 'No' ||
                                                    $applicant->work_background->employed == false
                                                        ? 'Unemployed'
                                                        : 'Employed')
                                                    : 'Not Specified';
                                            @endphp
                                            <span class="employment-status">{{ $employedStatus }}</span>
                                            <span class="separator">•</span>
                                            <span class="location">{{ $applicant->personal_info->city ?? '' }}
                                                {{ $applicant->personal_info->province ?? '' }}</span>
                                        </small>
                                    </div>
                                </td>
                                <td class="experience-col" data-label="Experience">
                                    <span class="badge bg-success">
                                        {{ $applicant->work_background->work_duration ?? 'N/A' }}
                                        {{ $applicant->work_background->work_duration_unit ?? '' }}
                                    </span>
                                </td>
                                <td class="rating-col" data-label="Rating">
                                    @php
                                        $averageRating = $applicant->rating ?? 0;
                                    @endphp
                                    <div class="stars d-flex align-items-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($averageRating))
                                                <i class="fas fa-star text-warning"></i>
                                            @elseif($i - $averageRating < 1)
                                                <i class="fas fa-star-half-alt text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                        <small class="ms-1 text-muted">{{ number_format($averageRating, 1) }}</small>
                                    </div>
                                </td>
                                <td class="actions-col" data-label="Actions">
                                    <div class="action-buttons-wrapper">
                                        @if ($applicant->personal_info)
                                            <a href="{{ route('employer.applicantsprofile.display', $applicant->id) }}"
                                                class="action-btn primary" title="View Profile">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('display.notfound') }}" class="action-btn secondary"
                                                title="Profile Not Found">
                                                <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                                            </a>
                                        @endif

                                        <button class="action-btn success message-btn" title="Message"
                                            data-applicant-id="{{ $applicant->id }}"
                                            data-applicant-name="{{ $applicant->personal_info->first_name ?? '' }} {{ $applicant->personal_info->last_name ?? '' }}"
                                            data-applicant-email="{{ $applicant->email ?? '' }}">
                                            <i class="fas fa-envelope"></i>
                                        </button>

                                        @php
                                            $alreadyReported = in_array($applicant->id, $reportedApplicantIds ?? []);
                                        @endphp

                                        <button class="action-btn danger report-applicant-btn"
                                            data-applicant-id="{{ $applicant->id }}"
                                            data-applicant-name="{{ $applicant->personal_info->first_name ?? '' }} {{ $applicant->personal_info->last_name ?? '' }}"
                                            data-applicant-email="{{ $applicant->email ?? '' }}" data-bs-toggle="modal"
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
                            <td colspan="6" class="text-center py-4 empty-state-row">
                                <div class="empty-state-content">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No applicants found</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if (isset($retrievedApplicants) && method_exists($retrievedApplicants, 'links'))
            <div class="d-flex justify-content-between align-items-center p-3 pagination-wrapper">
                <div class="text-muted pagination-info">
                    Showing {{ $retrievedApplicants->firstItem() }} to {{ $retrievedApplicants->lastItem() }}
                    out of {{ $retrievedApplicants->total() }} applicants
                </div>
                <div>
                    {{ $retrievedApplicants->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Report Applicant Modal -->
<div class="modal fade" id="reportApplicantModal" tabindex="-1" aria-labelledby="reportApplicantModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="reportApplicantModalLabel">
                    <i class="bi bi-flag-fill me-2"></i> Report Applicant
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <form action="{{ route('employer.report.applicant.store') }}" method="POST" id="reportApplicantForm"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body" style="max-height:65vh; overflow-y:auto;">
                    <input type="hidden" name="reported_id" id="report_applicant_id">

                    <!-- Applicant Info -->
                    <div class="alert alert-light border mb-3">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-person-fill text-primary me-2 mt-1"></i>
                            <div>
                                <h6 class="mb-1 fw-bold" id="report_applicant_name">Applicant Name</h6>
                                <small class="text-muted" id="report_applicant_email">Email</small>
                            </div>
                        </div>
                    </div>

                    <!-- Reason -->
                    <div class="mb-3">
                        <label for="report_reason_applicant" class="form-label fw-semibold">
                            Reason for Report <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="report_reason_applicant" name="reason" required>
                            <option value="">Select a reason...</option>
                            <option value="fraudulent">Fraudulent or Scam Applicant</option>
                            <option value="misleading">Misleading Information</option>
                            <option value="discriminatory">Discriminatory Content</option>
                            <option value="inappropriate">Inappropriate Content</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <!-- Other Reason -->
                    <div class="mb-3 d-none" id="other_reason_applicant_wrapper">
                        <label for="other_reason_applicant" class="form-label fw-semibold">
                            Please specify your reason <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="other_reason_applicant" name="other_reason"
                            placeholder="Type your reason here...">
                    </div>

                    <!-- Details -->
                    <div class="mb-3">
                        <label for="report_details_applicant" class="form-label fw-semibold">
                            Additional Details <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="report_details_applicant" name="additional_info" rows="4"
                            placeholder="Provide details..." required minlength="20"></textarea>
                        <small class="text-muted">Minimum 20 characters required</small>
                    </div>

                    <!-- Optional Screenshot -->
                    <div class="mb-3">
                        <label for="report_photo_applicant" class="form-label fw-semibold">
                            Upload Screenshot / Photo (Optional)
                        </label>
                        <input type="file" class="form-control" id="report_photo_applicant" name="attachment"
                            accept="image/*">
                        <small class="text-muted">Max 5MB</small>

                        <div class="mt-2 d-none" id="photo_preview_applicant_wrapper">
                            <img id="photo_preview_applicant" src="" alt="Preview"
                                class="img-fluid rounded border" style="max-height:200px;">
                        </div>
                    </div>

                    <!-- Warning -->
                    <div class="alert alert-warning mb-0">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Important:</strong> False reports may result in account restrictions.
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-flag-fill me-1"></i> Submit Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Message Button Handler
        document.querySelectorAll('.message-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const applicantId = this.dataset.applicantId;
                const applicantName = this.dataset.applicantName;
                const applicantEmail = this.dataset.applicantEmail;

                // Go to Messages Section
                if (typeof openSection === 'function') {
                    openSection('messages-section');
                }

                // Select that applicant's conversation
                const applicantItem = document.querySelector(
                    `.conversation-item[data-applicant-id="${applicantId}"]`);
                if (applicantItem) {
                    applicantItem.click();
                } else {
                    // Fallback if not in list
                    const chatHeader = document.getElementById('chatHeader');
                    const chatUserName = document.getElementById('chatUserName');
                    const chatUserStatus = document.getElementById('chatUserStatus');
                    const receiverId = document.getElementById('receiver_id');
                    const chatComposer = document.getElementById('chatComposer');
                    const chatMessages = document.getElementById('chatMessages');

                    if (chatHeader) chatHeader.style.display = 'flex';
                    if (chatUserName) chatUserName.textContent = applicantName;
                    if (chatUserStatus) chatUserStatus.textContent = applicantEmail;
                    if (receiverId) receiverId.value = applicantId;
                    if (chatComposer) chatComposer.style.display = 'flex';
                    if (chatMessages) {
                        chatMessages.innerHTML =
                            `<div class="no-messages"><p>No messages yet with ${applicantName}</p></div>`;
                    }
                }
            });
        });

        // Report Modal Handler
        const reportApplicantModal = document.getElementById('reportApplicantModal');
        if (reportApplicantModal) {
            reportApplicantModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const applicantId = button.getAttribute('data-applicant-id');
                const applicantName = button.getAttribute('data-applicant-name');
                const applicantEmail = button.getAttribute('data-applicant-email');

                document.getElementById('report_applicant_id').value = applicantId;
                document.getElementById('report_applicant_name').textContent = applicantName;
                document.getElementById('report_applicant_email').textContent = applicantEmail;
            });

            // Reset form on close
            reportApplicantModal.addEventListener('hidden.bs.modal', function() {
                const form = document.getElementById('reportApplicantForm');
                if (form) form.reset();
                const otherWrapper = document.getElementById('other_reason_applicant_wrapper');
                if (otherWrapper) otherWrapper.classList.add('d-none');
                const photoWrapper = document.getElementById('photo_preview_applicant_wrapper');
                if (photoWrapper) photoWrapper.classList.add('d-none');
            });
        }

        // Other reason toggle
        const reasonSelect = document.getElementById('report_reason_applicant');
        const otherWrapper = document.getElementById('other_reason_applicant_wrapper');
        const otherInput = document.getElementById('other_reason_applicant');

        if (reasonSelect && otherWrapper && otherInput) {
            reasonSelect.addEventListener('change', function() {
                if (this.value === 'other') {
                    otherWrapper.classList.remove('d-none');
                    otherInput.setAttribute('required', 'required');
                } else {
                    otherWrapper.classList.add('d-none');
                    otherInput.removeAttribute('required');
                    otherInput.value = '';
                }
            });
        }

        // Form validation
        const form = document.getElementById('reportApplicantForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                const details = document.getElementById('report_details_applicant').value;
                if (details.length < 20) {
                    e.preventDefault();
                    alert('Please provide at least 20 characters in the details section.');
                    return false;
                }
            });
        }

        // Photo preview
        const photoInput = document.getElementById('report_photo_applicant');
        const photoWrapper = document.getElementById('photo_preview_applicant_wrapper');
        const photoPreview = document.getElementById('photo_preview_applicant');

        if (photoInput && photoWrapper && photoPreview) {
            photoInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    // Check file size (5MB max)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('File size must be less than 5MB');
                        photoInput.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = (event) => {
                        photoPreview.src = event.target.result;
                        photoWrapper.classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                } else {
                    photoWrapper.classList.add('d-none');
                    photoPreview.src = '';
                }
            });
        }
    });
</script>
