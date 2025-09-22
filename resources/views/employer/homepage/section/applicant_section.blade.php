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
         <div class="stat-card">
             <div class="stat-header">
                 <div>
                     <div class="stat-value">156</div>
                     <div class="stat-label">Pending Review</div>
                 </div>
                 <div class="stat-icon warning">
                     <i class="fas fa-clock"></i>
                 </div>
             </div>
         </div>
         <div class="stat-card">
             <div class="stat-header">
                 <div>
                     <div class="stat-value">89</div>
                     <div class="stat-label">Approved</div>
                 </div>
                 <div class="stat-icon success">
                     <i class="fas fa-check-circle"></i>
                 </div>
             </div>
         </div>
     </div>

     <!-- Applicants Table -->
     <div class="content-section">
         <div class="section-header">
             <div class="section-title">
                 <i class="fas fa-users"></i>
                 All Applicants
             </div>
             <div class="section-actions">
                 <div class="search-input">
                     <i class="fas fa-search"></i>
                     <input type="text" class="form-control" placeholder="Search by name or location..."
                         id="searchApplicants">
                 </div>
                 <select class="form-select" id="positionFilter" style="width: auto;">
                     <option value="">Filter by Position</option>
                     @if (isset($retrievedApplicants))
                         @foreach ($retrievedApplicants->pluck('work_background.position')->filter()->unique() as $position)
                             <option value="{{ $position }}">{{ $position }}</option>
                         @endforeach
                     @endif
                 </select>
             </div>
         </div>

         <div class="table-responsive">
             <table class="table modern-table" id="applicantsTable">
                 <thead>
                     <tr>
                         <th><input type="checkbox" class="form-check-input"></th>
                         <th>Applicant</th>
                         <th>Position Applied</th>
                         <th>Experience</th>
                         <th>Rating</th>
                         <th>Actions</th>
                     </tr>
                 </thead>
                 <tbody>
                     @if (isset($retrievedApplicants))
                         @foreach ($retrievedApplicants as $applicant)
                             <tr>
                                 <td><input type="checkbox" class="form-check-input"></td>
                                 <td>
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
                                 <td>
                                     <strong>
                                         @if (isset($applicant->work_background->position) || isset($applicant->work_background->other_position))
                                             {{ $applicant->work_background->position ?? '' }}
                                             {{ $applicant->work_background->other_position ?? '' }}
                                         @else
                                             N/A
                                         @endif
                                     </strong><br>
                                     <small class="text-muted">
                                         {{ isset($applicant->work_background->employed) && $applicant->work_background->employed ? 'Employed' : 'Not Employed' }}
                                         •
                                         {{ $applicant->personal_info->city ?? '' }}
                                         {{ $applicant->personal_info->province ?? '' }}
                                     </small>
                                 </td>
                                 <td>
                                     <span class="badge bg-success">
                                         {{ $applicant->work_background->work_duration ?? 'N/A' }}
                                         {{ $applicant->work_background->work_duration_unit ?? '' }}
                                     </span>
                                 <td>
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


                                 <td>
                                     <a href="{{ route('employer.applicantsprofile.display', $applicant->id) }}"
                                         class="action-btn primary" title="View Profile">
                                         <i class="fas fa-eye"></i>
                                     </a>


                                     <button class="action-btn success" title="Approve">
                                         <i class="fas fa-check"></i>
                                     </button>
                                     <button class="action-btn danger" title="Reject">
                                         <i class="fas fa-times"></i>
                                     </button>
                                     <button class="action-btn message-btn" title="Message"
                                         data-applicant-id="{{ $applicant->id }}"
                                         data-applicant-name="{{ $applicant->personal_info->first_name ?? '' }} {{ $applicant->personal_info->last_name ?? '' }}"
                                         data-applicant-email="{{ $applicant->email ?? '' }}">
                                         <i class="fas fa-envelope"></i>
                                     </button>


                                     <script>
                                         document.querySelectorAll('.message-btn').forEach(btn => {
                                             btn.addEventListener('click', function() {
                                                 const applicantId = this.dataset.applicantId;
                                                 const applicantName = this.dataset.applicantName;
                                                 const applicantEmail = this.dataset.applicantEmail;

                                                 // Go to Messages Section
                                                 openSection('messages-section');

                                                 // Select that applicant's conversation
                                                 const applicantItem = document.querySelector(
                                                     `.conversation-item[data-applicant-id="${applicantId}"]`);
                                                 if (applicantItem) {
                                                     applicantItem.click(); // trigger same logic as if clicked manually
                                                 } else {
                                                     // fallback if not in list
                                                     document.getElementById('chatHeader').style.display = 'flex';
                                                     document.getElementById('chatUserName').textContent = applicantName;
                                                     document.getElementById('chatUserStatus').textContent = applicantEmail;
                                                     document.getElementById('receiver_id').value = applicantId;
                                                     document.getElementById('chatComposer').style.display = 'flex';
                                                     document.getElementById('chatMessages').innerHTML =
                                                         `<div class="no-messages"><p>No messages yet with ${applicantName}</p></div>`;
                                                 }
                                             });
                                         });
                                     </script>



                                 </td>
                             </tr>
                         @endforeach
                     @else
                         <tr>
                             <td colspan="6" class="text-center py-4">
                                 <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                 <p class="text-muted">No applicants found</p>
                             </td>
                         </tr>
                     @endif
                 </tbody>
             </table>
         </div>

         <!-- Pagination -->
         @if (isset($retrievedApplicants) && method_exists($retrievedApplicants, 'links'))
             <div class="d-flex justify-content-between align-items-center p-3">
                 <div class="text-muted">
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
