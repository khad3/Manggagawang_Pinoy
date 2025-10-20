  <div class="modal fade" id="reportJobModal" tabindex="-1" aria-labelledby="reportJobModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
              <div class="modal-header bg-danger text-white">
                  <h5 class="modal-title" id="reportJobModalLabel">
                      <i class="bi bi-flag-fill me-2"></i>Report Job Post
                  </h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                      aria-label="Close"></button>
              </div>


              <form action="{{ route('applicant.report.employerjobpost.store') }}" method="POST" id="reportJobForm"
                  enctype="multipart/form-data">
                  @csrf
                  <div class="modal-body" style="max-height: 65vh; overflow-y: auto;">
                      <input type="hidden" name="reported_id_job_id" id="report_job_id">
                      <input type="hidden" name="employer_id" id="report_employer_id">

                      <!-- Job Information -->
                      <div class="alert alert-light border mb-3">
                          <div class="d-flex align-items-start">
                              <i class="bi bi-briefcase-fill text-primary me-2 mt-1"></i>
                              <div>
                                  <h6 class="mb-1 fw-bold" id="report_job_title">Job Title</h6>
                                  <small class="text-muted">
                                      <i class="bi bi-building me-1"></i><span id="report_company_name">Company</span>
                                  </small>
                              </div>
                          </div>
                      </div>

                      <!-- Report Reason -->
                      <div class="mb-3">
                          <label for="report_reason" class="form-label fw-semibold">
                              Reason for Report <span class="text-danger">*</span>
                          </label>
                          <select class="form-select" id="report_reason" name="reason" required>
                              <option value="">Select a reason...</option>
                              <option value="fraudulent">Fraudulent or Scam Job</option>
                              <option value="misleading">Misleading Information</option>
                              <option value="discriminatory">Discriminatory Content</option>
                              <option value="inappropriate">Inappropriate Content</option>
                              <option value="other">Other</option>
                          </select>
                      </div>

                      <!-- Other Reason (Hidden by default) -->
                      <div class="mb-3 d-none" id="other_reason_wrapper">
                          <label for="other_reason" class="form-label fw-semibold">
                              Please specify your reason <span class="text-danger">*</span>
                          </label>
                          <input type="text" class="form-control" id="other_reason" name="other_reason"
                              placeholder="Type your reason here...">
                      </div>

                      <script>
                          const reportReasonSelect = document.getElementById('report_reason');
                          const otherReasonWrapper = document.getElementById('other_reason_wrapper');
                          const otherReasonInput = document.getElementById('other_reason');

                          reportReasonSelect.addEventListener('change', function() {
                              if (this.value === 'other') {
                                  otherReasonWrapper.classList.remove('d-none');
                                  otherReasonInput.setAttribute('required', 'required');
                              } else {
                                  otherReasonWrapper.classList.add('d-none');
                                  otherReasonInput.removeAttribute('required');
                                  otherReasonInput.value = '';
                              }
                          });
                      </script>

                      <!-- Additional Details -->
                      <div class="mb-3">
                          <label for="report_details" class="form-label fw-semibold">
                              Additional Details <span class="text-danger">*</span>
                          </label>
                          <textarea class="form-control" id="report_details" name="details" rows="4"
                              placeholder="Please provide specific details about your concern..." required minlength="20"></textarea>
                          <small class="text-muted">Minimum 20 characters required</small>
                      </div>

                      <!-- Insert Photo (optional) -->
                      <div class="mb-3">
                          <label for="report_photo" class="form-label fw-semibold">
                              Upload Screenshot / Photo (Optional)
                          </label>
                          <input type="file" class="form-control" id="report_photo" name="attachment"
                              accept="image/*">
                          <small class="text-muted">You may attach an image as evidence (max
                              5MB).</small>

                          <!-- Preview selected image -->
                          <div class="mt-2 d-none" id="photo_preview_wrapper">
                              <img id="photo_preview" src="" alt="Preview" class="img-fluid rounded border"
                                  style="max-height: 200px;">
                          </div>
                      </div>

                      <script>
                          const photoInput = document.getElementById('report_photo');
                          const photoPreviewWrapper = document.getElementById('photo_preview_wrapper');
                          const photoPreview = document.getElementById('photo_preview');

                          photoInput.addEventListener('change', (e) => {
                              const file = e.target.files[0];
                              if (file) {
                                  const reader = new FileReader();
                                  reader.onload = (event) => {
                                      photoPreview.src = event.target.result;
                                      photoPreviewWrapper.classList.remove('d-none');
                                  };
                                  reader.readAsDataURL(file);
                              } else {
                                  photoPreviewWrapper.classList.add('d-none');
                                  photoPreview.src = '';
                              }
                          });
                      </script>

                      <!-- Warning Notice -->
                      <div class="alert alert-warning mb-0" role="alert">
                          <i class="bi bi-exclamation-triangle-fill me-2"></i>
                          <strong>Important:</strong> False reports may result in account restrictions.
                          Please ensure your report is legitimate and accurate.
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                          <i class="bi bi-x-circle me-1"></i>Cancel
                      </button>
                      <button type="submit" class="btn btn-danger">
                          <i class="bi bi-flag-fill me-1"></i>Submit Report
                      </button>
                  </div>
              </form>
          </div>
      </div>
  </div>
