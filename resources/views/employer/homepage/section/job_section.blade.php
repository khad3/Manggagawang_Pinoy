   <div class="page-section" id="jobposts-section">
       <div class="d-flex justify-content-between align-items-start mb-4">
           <div>
               <h2 class="mb-2 fw-bold">Job Posts Management</h2>
               <p class="text-muted mb-0">Create and manage your job postings</p>
           </div>
           @php
               $employerId = session('employer_id');

               // Get the latest suspension for this employer
               $suspension = \App\Models\Admin\SuspensionModel::where('employer_id', $employerId)->latest()->first();

               $isSuspended = false;
               $remainingDaysText = '';

               if ($suspension) {
                   $startDate = \Carbon\Carbon::parse($suspension->created_at);
                   $endDate = $startDate->copy()->addDays($suspension->suspension_duration);

                   if (\Carbon\Carbon::now()->lt($endDate)) {
                       $isSuspended = true;

                       // Calculate remaining days, rounding up
                       $remainingDays = $endDate->diffInDays(\Carbon\Carbon::now());

                       // Ensure remainingDays is at least 1 and at most suspension_duration
                       $remainingDays = max(1, min($remainingDays, $suspension->suspension_duration));

                       $remainingDaysText = $remainingDays . ' day(s)';
                   }
               }
           @endphp

           <button class="btn-modern {{ $isSuspended ? 'btn-secondary' : 'btn-primary-modern' }}"
               @if ($isSuspended) disabled @else data-bs-toggle="modal" data-bs-target="#newJobModal" @endif>
               <i class="fas fa-plus"></i>
               @if ($isSuspended)
                   You are suspended for {{ $remainingDaysText }}
                   (Reason: {{ ucfirst(str_replace('_', ' ', $suspension->reason)) }}
                   {{ $suspension->additional_info ? '- ' . $suspension->additional_info : '' }})
               @else
                   Post New Job
               @endif
           </button>



       </div>

       <!-- Job Stats Cards -->
       <div class="stats-grid">
           <!-- Repeat this structure for each stat -->
           <div class="stat-card">
               <div class="stat-header">
                   <div>
                       <div class="stat-value">
                           {{ $JobPostRetrieved->where('status_post', 'published')->count() }}</div>
                       <div class="stat-label">Active Jobs</div>
                       <!-- <small class="text-success mt-1">↗ 12% this month</small> -->
                   </div>
                   <div class="stat-icon primary">
                       <i class="fas fa-briefcase"></i>
                   </div>
               </div>
           </div>
           <div class="stat-card">
               <div class="stat-header">
                   <div>
                       <div class="stat-value">{{ $JobPostRetrieved->where('status_post', 'draft')->count() }}
                       </div>
                       <div class="stat-label">Draft Jobs</div>
                       <small class="text-warning mt-1">⏱ Pending review</small>
                   </div>
                   <div class="stat-icon warning">
                       <i class="fas fa-file-alt"></i>
                   </div>
               </div>
           </div>

           <div class="stat-card">
               <div class="stat-header">
                   <div>
                       <div class="stat-value">{{ $retrievedApplicantApproved }}</div>
                       @if ($retrievedApplicantApproved == 1)
                           <div class="stat-label">Total Applicant Approved</div>
                       @else
                           <div class="stat-label">Total Applicants Approved</div>
                       @endif
                       {{-- <small class="text-primary mt-1"> This quarter</small> --}}
                   </div>
                   <div class="stat-icon success">
                       <i class="fas fa-users"></i>
                   </div>
               </div>
           </div>
       </div>


       <div class="job-cards-grid">
           @forelse ($JobPostRetrieved as $jobDetail)
               <div class="job-card">
                   <div class="job-card-header">
                       <div class="d-flex justify-content-between align-items-start mb-2">
                           <span
                               class="status-badge {{ $jobDetail->status_post === 'published' ? 'status-active' : 'status-draft' }}">
                               {{ ucfirst($jobDetail->status_post) }}
                           </span>

                           <div class="dropdown">
                               <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                   data-bs-toggle="dropdown">
                                   <i class="fas fa-ellipsis-v"></i>
                               </button>
                               <ul class="dropdown-menu">

                                   @if ($jobDetail->status_post !== 'draft')
                                       <li>
                                           <form
                                               action="{{ route('employer.updatejobpost.store', ['id' => $jobDetail->id]) }}"
                                               method="POST">
                                               @csrf
                                               @method('PUT')
                                               <input type="hidden" name="status_post" value="draft">
                                               <button class="dropdown-item text-warning" type="submit">
                                                   <i class="fas fa-file-alt me-2"></i> Save as Draft
                                               </button>
                                           </form>
                                       </li>
                                   @endif

                                   @if ($jobDetail->status_post !== 'published')
                                       <li>
                                           <form
                                               action="{{ route('employer.updatejobpost.store', ['id' => $jobDetail->id]) }}"
                                               method="POST">
                                               @csrf
                                               @method('PUT')
                                               <input type="hidden" name="status_post" value="published">
                                               <button class="dropdown-item text-success" type="submit">
                                                   <i class="fas fa-bullhorn me-2"></i> Publish
                                               </button>
                                           </form>
                                       </li>
                                   @endif

                                   <li>
                                       <form
                                           action="{{ route('employer.deletejobpost.store', ['id' => $jobDetail->id]) }}"
                                           method="POST"
                                           onsubmit="return confirm('Are you sure you want to delete this job post?');">
                                           @csrf
                                           @method('DELETE')
                                           <button class="dropdown-item text-danger" type="submit">
                                               <i class="fas fa-trash-alt me-2"></i> Delete
                                           </button>
                                       </form>
                                   </li>
                               </ul>

                           </div>
                       </div>

                       <h5 class="job-title">{{ $jobDetail->title }}</h5>
                       <p class="mb-1 text-muted small">
                           <i class="fas fa-briefcase me-1"></i> Category: {{ $jobDetail->department }}
                       </p>
                       <div class="job-meta">
                           <span><i class="fas fa-map-marker-alt me-1"></i> {{ $jobDetail->location }}</span>
                           <span><i class="fas fa-clock me-1"></i> {{ $jobDetail->job_type }}</span>
                           <span><i class="fas fa-peso-sign me-1"></i> ₱{{ $jobDetail->job_salary ?? 'N/A' }} /
                               month</span>
                       </div>
                   </div>

                   <div class="job-body">
                       <p class="job-description">
                           {{ Str::limit($jobDetail->job_description, 150) }}
                       </p>

                       <div class="requirement-tags">
                           <span class="requirement-tag">{{ $jobDetail->experience_level }}</span>
                           @if ($jobDetail->tesda_certification)
                               <span class="requirement-tag">TESDA: {{ $jobDetail->tesda_certification }}</span>
                           @elseif($jobDetail->none_certifications_qualification)
                               <span class="requirement-tag">Other Cert:
                                   {{ $jobDetail->none_certifications_qualification }}</span>
                           @endif
                       </div>

                       <div class="job-stats mt-3 d-flex justify-content-center gap-4 text-center">
                           <div class="job-stat">
                               <strong>{{ $jobDetail->applications->count() }}</strong>
                               <small>Applications</small>
                           </div>
                           {{-- <div class="job-stat">
        <strong>12</strong>
        <small>Shortlisted</small>
    </div> --}}
                           <div class="job-stat">
                               <strong>{{ $jobDetail->appalicationsApproved->count() }}</strong>
                               <small>Hired</small>
                           </div>

                       </div>


                       {{-- Button to open modal --}}
                       <button class="btn btn-outline-primary w-100 mt-3" data-bs-toggle="modal"
                           data-bs-target="#applicationsModal-{{ $jobDetail->id }}">
                           <i class="fas fa-users me-2"></i> View Applications
                           {{ $jobDetail->applications->count() }}

                       </button>

                       <small class="text-muted d-block mt-2">Posted
                           {{ $jobDetail->created_at->diffForHumans() }}</small>
                   </div>
               </div>

               <!-- Balanced Theme Professional Job Applications Modal -->
               <div class="modal fade balanced-modal" id="applicationsModal-{{ $jobDetail->id }}" tabindex="-1"
                   aria-labelledby="applicationsModalLabel-{{ $jobDetail->id }}" aria-hidden="true">
                   <div class="modal-dialog modal-lg modal-xl modal-dialog-centered modal-dialog-scrollable">
                       <div class="modal-content bg-balanced border-0 shadow-lg">
                           <!-- Professional Header -->
                           <div class="modal-header bg-gradient-balanced text-white border-0 py-3">
                               <div class="d-flex align-items-center">
                                   <div class="me-3">
                                       <i class="fas fa-users-cog fa-lg text-accent-blue"></i>
                                   </div>
                                   <div>
                                       <h5 class="modal-title mb-0 text-white"
                                           id="applicationsModalLabel-{{ $jobDetail->id }}">
                                           Job Applications
                                       </h5>
                                       <small class="text-balanced-light opacity-90">{{ $jobDetail->title }}</small>
                                   </div>
                               </div>
                               <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                   aria-label="Close"></button>
                           </div>

                           <div class="modal-body p-0 bg-balanced-secondary">
                               <!-- Statistics Dashboard -->
                               <div class="stats-dashboard p-3 bg-balanced-tertiary border-bottom border-balanced">
                                   <div class="row g-2">
                                       <div class="col-6 col-md-3">
                                           <div
                                               class="stat-card bg-balanced-card p-3 rounded shadow-sm border-start border-4 border-accent-blue">
                                               <div class="d-flex d-md-block text-center text-md-start">
                                                   <div class="me-2 me-md-0 mb-md-1">
                                                       <i class="fas fa-users text-accent-blue"></i>
                                                   </div>
                                                   <div>
                                                       <h6 class="mb-0 fw-bold text-accent-blue">
                                                           {{ $jobDetail->applications->count() }}</h6>
                                                       <small class="text-balanced-muted">Total</small>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-6 col-md-3">
                                           <div
                                               class="stat-card bg-balanced-card p-3 rounded shadow-sm border-start border-4 border-accent-orange">
                                               <div class="d-flex d-md-block text-center text-md-start">
                                                   <div class="me-2 me-md-0 mb-md-1">
                                                       <i class="fas fa-clock text-accent-orange"></i>
                                                   </div>
                                                   <div>
                                                       <h6 class="mb-0 fw-bold text-accent-orange">
                                                           {{ $jobDetail->applications->where('status', 'pending')->count() }}
                                                       </h6>
                                                       <small class="text-balanced-muted">Pending</small>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-6 col-md-3">
                                           <div
                                               class="stat-card bg-balanced-card p-3 rounded shadow-sm border-start border-4 border-accent-purple">
                                               <div class="d-flex d-md-block text-center text-md-start">
                                                   <div class="me-2 me-md-0 mb-md-1">
                                                       <i class="fas fa-eye text-accent-purple"></i>
                                                   </div>
                                                   <div>
                                                       <h6 class="mb-0 fw-bold text-accent-purple">
                                                           {{ $jobDetail->applications->where('status', 'reviewed')->count() }}
                                                       </h6>
                                                       <small class="text-balanced-muted">Reviewed</small>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-6 col-md-3">
                                           <div
                                               class="stat-card bg-balanced-card p-3 rounded shadow-sm border-start border-4 border-accent-green">
                                               <div class="d-flex d-md-block text-center text-md-start">
                                                   <div class="me-2 me-md-0 mb-md-1">
                                                       <i class="fas fa-check-circle text-accent-green"></i>
                                                   </div>
                                                   <div>
                                                       <h6 class="mb-0 fw-bold text-accent-green">
                                                           {{ $jobDetail->applications->where('status', 'approved')->count() }}
                                                       </h6>
                                                       <small class="text-balanced-muted">Approved</small>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>

                               <!-- Applications List -->
                               <div class="applications-section p-3">
                                   <div
                                       class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
                                       <h6 class="mb-0 text-balanced-dark fw-semibold">
                                           <i class="fas fa-list me-2 text-accent-blue"></i>
                                           Applications
                                       </h6>
                                       <select
                                           class="form-select form-select-sm bg-balanced-card text-balanced-dark border-balanced-light"
                                           style="max-width: 200px;">
                                           <option>All Status</option>
                                           <option>Pending</option>
                                           <option>Reviewed</option>
                                           <option>Approved</option>
                                           <option>Rejected</option>
                                       </select>
                                   </div>

                                   <div class="applications-list">
                                       @forelse ($jobDetail->applications as $application)
                                           <div class="application-item mb-3 bg-balanced-card rounded shadow-sm border border-balanced-light"
                                               id="application-{{ $application->id }}">
                                               <!-- Candidate Info Header -->
                                               <div class="p-3 border-bottom border-balanced">
                                                   <div class="row align-items-center g-2">
                                                       <div class="col-12 col-sm-8">
                                                           <div class="d-flex align-items-center">
                                                               <div class="candidate-avatar me-3 flex-shrink-0">
                                                                   <div class="bg-gradient-accent text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                                                       style="width: 45px; height: 45px; font-size: 14px; font-weight: 600;">
                                                                       {{ strtoupper(substr($application->applicant->personal_info->first_name ?? 'N', 0, 1)) }}{{ strtoupper(substr($application->applicant->personal_info->last_name ?? 'A', 0, 1)) }}
                                                                   </div>
                                                               </div>
                                                               <div class="candidate-details min-w-0 flex-grow-1">
                                                                   <h6
                                                                       class="mb-1 fw-bold text-truncate text-balanced-dark">
                                                                       {{ $application->applicant->personal_info->first_name ?? 'No name' }}
                                                                       {{ $application->applicant->personal_info->last_name ?? '' }}

                                                                   </h6>
                                                                   <div class="text-balanced-muted small">
                                                                       <div class="mb-1">
                                                                           <i
                                                                               class="fas fa-envelope me-1 text-accent-blue"></i>
                                                                           <span class="text-truncate d-inline-block"
                                                                               style="max-width: 200px;">{{ $application->applicant->email ?? 'No email' }}</span>
                                                                       </div>
                                                                       <div class="d-none d-sm-block">
                                                                           <i
                                                                               class="fas fa-phone me-1 text-accent-blue"></i>
                                                                           {{ $application->cellphone_number ?? 'No phone' }}
                                                                       </div>
                                                                   </div>
                                                               </div>
                                                           </div>
                                                       </div>
                                                       <div class="col-12 col-sm-4 text-start text-sm-end">
                                                           <div
                                                               class="d-flex flex-column align-items-start align-items-sm-end gap-1">
                                                               <span
                                                                   class="badge fw-medium px-3 py-1 rounded-pill shadow-sm
                                @if ($application->status == 'approved') bg-success-balanced text-white
                                @elseif($application->status == 'rejected') bg-danger-balanced text-white
                                @elseif($application->status == 'interview') bg-info-balanced text-white
                                @else bg-warning-balanced text-dark @endif">
                                                                   <i class="fas fa-circle me-1"
                                                                       style="font-size: 6px;"></i>
                                                                   {{ ucfirst($application->status ?? 'Pending') }}
                                                               </span>
                                                               <small class="text-balanced-muted">
                                                                   {{ $application->created_at->diffForHumans() }}
                                                               </small>
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>

                                               <!-- Application Details -->
                                               <div class="p-3">
                                                   <div class="row g-3">
                                                       <div class="col-12 col-lg-6">
                                                           <div class="content-section">
                                                               <h6 class="text-accent-blue mb-2 fw-semibold">
                                                                   <i class="fas fa-file-alt me-1"></i> Cover
                                                                   Letter
                                                               </h6>
                                                               <div
                                                                   class="bg-balanced-tertiary p-3 rounded border-start border-3 border-accent-blue">
                                                                   <p class="mb-0 text-balanced-dark small lh-base">
                                                                       {{ Str::limit($application->cover_letter ?? 'No cover letter provided.', 100) }}
                                                                   </p>
                                                               </div>
                                                           </div>
                                                       </div>
                                                       <div class="col-12 col-lg-6">
                                                           <div class="content-section">
                                                               <h6 class="text-accent-purple mb-2 fw-semibold">
                                                                   <i class="fas fa-info-circle me-1"></i>
                                                                   Additional Info
                                                               </h6>
                                                               <div
                                                                   class="bg-balanced-tertiary p-3 rounded border-start border-3 border-accent-purple">
                                                                   <p class="mb-0 text-balanced-dark small lh-base">
                                                                       {{ Str::limit($application->additional_information ?? 'No additional information provided.', 100) }}
                                                                   </p>
                                                               </div>
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>

                                               <!-- Actions Footer -->
                                               <div class="p-3 border-top border-balanced bg-balanced-tertiary">
                                                   <div class="row align-items-center g-2">
                                                       <div class="col-12 col-md-6">
                                                           <div class="d-flex flex-wrap gap-2">
                                                               @if ($application->resume)
                                                                   <a href="{{ asset('storage/' . $application->resume) }}"
                                                                       target="_blank"
                                                                       class="btn btn-outline-balanced btn-sm text-accent-blue border-accent-blue">
                                                                       <i class="fas fa-file-pdf me-1"></i>
                                                                       <span class="d-none d-sm-inline">View
                                                                       </span>Resume
                                                                   </a>
                                                               @else
                                                                   <button
                                                                       class="btn btn-outline-muted-balanced btn-sm text-balanced-muted"
                                                                       disabled>
                                                                       <i class="fas fa-file-times me-1"></i>
                                                                       No Resume
                                                                   </button>
                                                               @endif

                                                               @if ($application->tesda_certification)
                                                                   <a href="{{ asset('storage/' . $application->tesda_certification) }}"
                                                                       target="_blank"
                                                                       class="btn btn-outline-balanced btn-sm text-accent-orange border-accent-orange">
                                                                       <i class="fas fa-certificate me-1"></i>
                                                                       <span class="d-none d-sm-inline">TESDA</span>
                                                                   </a>
                                                               @else
                                                                   <button
                                                                       class="btn btn-outline-muted-balanced btn-sm text-balanced-muted"
                                                                       disabled>
                                                                       <i class="fas fa-certificate me-1"></i>
                                                                       No TESDA
                                                                   </button>
                                                               @endif
                                                           </div>
                                                       </div>
                                                       <div class="col-12 col-md-6">
                                                           <div
                                                               class="d-flex justify-content-start justify-content-md-end gap-1 flex-wrap">
                                                               <!-- Approve Button -->
                                                               <form
                                                                   action="{{ route('employer.approveapplicant.store', $application->id) }}"
                                                                   method="POST" class="d-inline">
                                                                   @csrf
                                                                   @method('PUT')
                                                                   <button type="submit"
                                                                       class="btn btn-success-balanced btn-sm text-white shadow-sm">
                                                                       <i class="fas fa-check me-1"></i>
                                                                       <span class="d-none d-sm-inline">Approve</span>
                                                                   </button>
                                                               </form>
                                                               <button
                                                                   class="btn btn-info-balanced btn-sm text-white shadow-sm">
                                                                   <i class="fas fa-calendar me-1"></i>
                                                                   <span class="d-none d-sm-inline">Interview</span>
                                                               </button>

                                                               <!-- Modified Reject Button with JavaScript -->
                                                               <form
                                                                   action="{{ route('employer.rejectapplicant.store', $application->id) }}"
                                                                   method="POST" class="d-inline reject-form">
                                                                   @csrf
                                                                   @method('PUT')
                                                                   <button type="submit"
                                                                       class="btn btn-outline-balanced btn-sm text-accent-red border-accent-red reject-btn"
                                                                       data-application-id="{{ $application->id }}">
                                                                       <i class="fas fa-times me-1"></i>
                                                                       <span class="d-none d-sm-inline">Reject</span>
                                                                   </button>
                                                               </form>
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       @empty
                                           <div class="text-center py-5" id="no-applications">
                                               <div class="mb-3">
                                                   <i class="fas fa-inbox fa-3x text-balanced-muted opacity-50"></i>
                                               </div>
                                               <h6 class="text-balanced-muted mb-2">No Applications Yet</h6>
                                               <p class="text-balanced-muted small">Applications will appear here
                                                   when candidates apply.</p>
                                           </div>
                                       @endforelse
                                   </div>

                                   <script>
                                       document.addEventListener('DOMContentLoaded', function() {
                                           // Handle reject button clicks
                                           document.querySelectorAll('.reject-form').forEach(form => {
                                               form.addEventListener('submit', function(e) {
                                                   e.preventDefault(); // Prevent default form submission

                                                   const applicationId = this.querySelector('.reject-btn').dataset.applicationId;
                                                   const applicationElement = document.getElementById(
                                                       `application-${applicationId}`);

                                                   // Show confirmation dialog
                                                   if (confirm('Are you sure you want to reject this application?')) {
                                                       // Add fade out animation
                                                       applicationElement.style.transition =
                                                           'opacity 0.5s ease-out, transform 0.5s ease-out';
                                                       applicationElement.style.opacity = '0';
                                                       applicationElement.style.transform = 'translateX(-20px)';

                                                       // Submit the form via AJAX
                                                       const formData = new FormData(this);

                                                       fetch(this.action, {
                                                               method: 'POST',
                                                               body: formData,
                                                               headers: {
                                                                   'X-Requested-With': 'XMLHttpRequest'
                                                               }
                                                           })
                                                           .then(response => {
                                                               if (response.ok) {
                                                                   // Remove element after animation completes
                                                                   setTimeout(() => {
                                                                       applicationElement.remove();

                                                                       // Check if no applications left, show empty state
                                                                       const remainingApplications = document
                                                                           .querySelectorAll('.application-item');
                                                                       if (remainingApplications.length === 0) {
                                                                           document.querySelector('.applications-list')
                                                                               .innerHTML = `
                                    <div class="text-center py-5" id="no-applications">
                                        <div class="mb-3">
                                            <i class="fas fa-inbox fa-3x text-balanced-muted opacity-50"></i>
                                        </div>
                                        <h6 class="text-balanced-muted mb-2">No Applications Yet</h6>
                                        <p class="text-balanced-muted small">Applications will appear here when candidates apply.</p>
                                    </div>
                                `;
                                                                       }
                                                                   }, 500);

                                                                   // Show success message (optional)
                                                                   showNotification('Application rejected successfully',
                                                                       'success');
                                                               } else {
                                                                   // Revert animation if request failed
                                                                   applicationElement.style.opacity = '1';
                                                                   applicationElement.style.transform = 'translateX(0)';
                                                                   showNotification('Failed to reject application', 'error');
                                                               }
                                                           })
                                                           .catch(error => {
                                                               // Revert animation if request failed
                                                               applicationElement.style.opacity = '1';
                                                               applicationElement.style.transform = 'translateX(0)';
                                                               showNotification('An error occurred', 'error');
                                                           });
                                                   }
                                               });
                                           });
                                       });

                                       // Optional: Simple notification function
                                       function showNotification(message, type = 'info') {
                                           // Create notification element
                                           const notification = document.createElement('div');
                                           notification.className =
                                               `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
                                           notification.style.cssText = 'top: 20px; right: 20px; z-index: 1050; min-width: 300px;';
                                           notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

                                           document.body.appendChild(notification);

                                           // Auto remove after 3 seconds
                                           setTimeout(() => {
                                               if (notification.parentNode) {
                                                   notification.remove();
                                               }
                                           }, 3000);
                                       }
                                   </script>
                               </div>
                           </div>

                           <!-- Footer -->
                           <div class="modal-footer bg-balanced-tertiary border-top border-balanced p-3">
                               <div
                                   class="d-flex flex-column flex-sm-row justify-content-between align-items-center w-100 gap-2">
                                   <small class="text-balanced-muted order-2 order-sm-1">
                                       <i class="fas fa-clock me-1"></i>
                                       Updated {{ now()->format('M d, Y') }}
                                   </small>
                                   <div class="order-1 order-sm-2 d-flex gap-2">
                                       <button
                                           class="btn btn-outline-balanced btn-sm text-balanced-dark border-balanced-light"
                                           data-bs-dismiss="modal">
                                           <i class="fas fa-times me-1"></i>
                                           Close
                                       </button>
                                       <button class="btn btn-accent-balanced btn-sm text-white shadow-sm"
                                           onclick="exportApplications()">
                                           <i class="fas fa-download me-1"></i>
                                           Export
                                       </button>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>

           @empty
               <p class="text-muted">No job posts available.</p>
           @endforelse
       </div>
   </div>
