 <div class="page-section" id="reports-section">
     <div class="content-section">
         <div class="d-flex justify-content-between align-items-center mb-4">
             <h3 class="fw-bold mb-0"><i class="fas fa-flag me-2 text-danger"></i>Reported Applicants</h3>
             @if (count($retrievedApplicantReported) === 1)
                 <span class="badge bg-danger fs-6">{{ count($retrievedApplicantReported) }} Report</span>
             @elseif (count($retrievedApplicantReported) > 1)
                 <span class="badge bg-danger fs-6">{{ count($retrievedApplicantReported) }} Reports</span>
             @else
                 <span class="badge bg-secondary fs-6">No Reports</span>
             @endif

         </div>

         @if ($retrievedApplicantReported->isNotEmpty())
             <!-- Reports Table -->
             <div class="table-responsive shadow rounded bg-white p-3">
                 <table class="table table-hover align-middle mb-0">
                     <thead class="table-light">
                         <tr>
                             <th>#</th>
                             <th>Name</th>
                             <th>Reason</th>
                             <th>Photo Evidence</th>
                             <th>Action</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($retrievedApplicantReported as $index => $userReported)
                             @php
                                 $applicant = $userReported->appplicantReported ?? null;
                                 $personal = $applicant->personal_info ?? null;
                                 $work = $applicant->work_background ?? null;
                             @endphp

                             <tr>
                                 <td>{{ $index + 1 }}</td>
                                 <td>
                                     <div class="d-flex align-items-center">
                                         @if ($applicant?->profile_photo)
                                             <!-- Show uploaded profile photo -->
                                             <img src="{{ asset('storage/' . $applicant->profileimage_path) }}"
                                                 class="rounded-circle me-2 shadow-sm border" alt="Applicant"
                                                 width="40" height="40">
                                         @else
                                             <!-- Show initials when no profile photo -->
                                             @php
                                                 $firstInitial = strtoupper(
                                                     substr($personal?->first_name ?? 'U', 0, 1),
                                                 );
                                                 $lastInitial = strtoupper(substr($personal?->last_name ?? 'N', 0, 1));
                                                 $initials = $firstInitial . $lastInitial;
                                             @endphp

                                             <div class="rounded-circle bg-secondary text-white d-flex justify-content-center align-items-center me-2"
                                                 style="width: 40px; height: 40px; font-weight: bold; font-size: 14px;">
                                                 {{ $initials }}
                                             </div>
                                         @endif

                                         <div>
                                             <strong>{{ $personal?->first_name ?? 'Unknown' }}
                                                 {{ $personal?->last_name ?? '' }}</strong><br>
                                             <small
                                                 class="text-muted">{{ $work?->position ?? 'Unknown Position' }}</small>
                                         </div>
                                     </div>

                                 </td>
                                 <td>
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

                                     {{ $displayReason }}
                                 </td>


                                 <td>
                                     @if ($userReported->attachment)
                                         <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
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
                                                         <button type="button" class="btn-close"
                                                             data-bs-dismiss="modal" aria-label="Close"></button>
                                                     </div>
                                                     <div class="modal-body text-center">
                                                         <img src="{{ asset('storage/' . $userReported->attachment) }}"
                                                             class="img-fluid rounded shadow" alt="Evidence">
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     @else
                                         <span class="text-muted">No evidence</span>
                                     @endif
                                 </td>

                                 <td>
                                     <form
                                         action="{{ route('employer.remove.report.applicant.store', $userReported->id) }}"
                                         method="POST"
                                         onsubmit="return confirm('Are you sure you want to remove this report?');">
                                         @csrf
                                         @method('DELETE')
                                         <button type="submit" class="btn btn-sm btn-outline-danger">
                                             <i class="fas fa-trash-alt me-1"></i> Remove Report
                                         </button>
                                     </form>

                                 </td>
                             </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>
         @else
             <div class="text-center py-5">
                 <i class="fas fa-flag fa-4x text-muted mb-3"></i>
                 <h4>No reports yet</h4>
                 <p class="text-muted">All applicants are in good standing.</p>
             </div>
         @endif
     </div>
 </div>
