   <div class="modal fade" id="applyJobModal" tabindex="-1" aria-labelledby="applyJobModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg modal-dialog-scrollable">
           <div class="modal-content">
               <form action="{{ route('jobs.apply.store') }}" method="POST" enctype="multipart/form-data">
                   @csrf
                   <input type="hidden" name="job_id" id="apply-job-id-input">

                   <div class="modal-header">
                       <h5 class="modal-title" id="applyJobModalLabel">
                           <i class="fas fa-paper-plane me-2"></i>Apply for Position
                       </h5>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                   </div>

                   <!-- Make body scrollable -->
                   <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                       <!-- Job Info -->
                       <div class="row mb-4">
                           <div class="col-12">
                               <div class="p-3 bg-light rounded">
                                   <h6 class="fw-bold mb-2" id="apply-job-title">Job Title</h6>
                                   <p class="mb-1 text-muted" id="apply-company-name">Company Name</p>
                                   <p class="mb-0 text-muted">
                                       <i class="fas fa-map-marker-alt me-1"></i>
                                       <span id="apply-job-location">Location</span>
                                   </p>
                               </div>
                           </div>
                       </div>

                       <!-- Phone -->
                       <div class="row">
                           <div class="col-md-6">
                               <div class="mb-3">
                                   <label class="form-label fw-semibold">Phone Number <span
                                           style="color: red;">*</span></label>
                                   <input type="tel" class="form-control" name="phone_number"
                                       placeholder="09********0" required minlength="11" maxlength="11"
                                       pattern="[0-9]{11}" inputmode="numeric"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                               </div>
                           </div>
                       </div>

                       <!-- Resume -->
                       <div class="mb-3">
                           <label class="form-label fw-semibold">Resume/CV <span style="color: red;">*</span></label>
                           <input type="file" class="form-control" name="resume" accept=".pdf,.doc,.docx" required>
                           <div class="form-text">Accepted formats: PDF, DOC, DOCX (Max 5MB)</div>
                       </div>

                       <!-- TESDA Cert -->
                       <div class="mb-3">
                           <label class="form-label">Upload TESDA Certificate (PDF, DOC)</label>
                           <input type="file" name="tesda_certificate" class="form-control" accept=".pdf,.doc,.docx"
                               @if (!$tesdaCertification || $tesdaCertification->status != 'approved') disabled @endif>

                           @if ($tesdaCertification && $tesdaCertification->status == 'pending')
                               <p class="text-warning mt-2">Your TESDA Certificate is under review.</p>
                           @elseif (!$tesdaCertification || $tesdaCertification->status != 'approved')
                               <p class="text-danger mt-2">Please upload your TESDA Certificate before
                                   applying.</p>
                           @endif
                       </div>

                       <!-- Cover Letter -->
                       <div class="mb-3">
                           <label class="form-label fw-semibold">Cover Letter<span style="color: red;">*</span></label>
                           <textarea class="form-control" name="cover_letter" rows="4"
                               placeholder="Tell us why you're interested in this position..." required></textarea>
                       </div>

                       <!-- Additional Info -->
                       <div class="mb-3">
                           <label class="form-label fw-semibold">Additional Information</label>
                           <textarea class="form-control" name="additional_info" rows="3"
                               placeholder="Any additional information you'd like to share..."></textarea>
                       </div>
                   </div>

                   <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                           <i class="fas fa-times me-2"></i>Cancel
                       </button>
                       <button type="submit" class="btn btn-success">
                           <i class="fas fa-paper-plane me-2"></i>Submit Application
                       </button>
                   </div>
               </form>
           </div>
       </div>
   </div>
