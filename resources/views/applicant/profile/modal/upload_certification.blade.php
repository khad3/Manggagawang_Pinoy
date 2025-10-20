  <div class="modal fade" id="uploadCertificationModal" tabindex="-1" aria-labelledby="uploadCertificationModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <form action="{{ route('applicant.certification.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="uploadCertificationModalLabel">
                          Upload TESDA Certification
                      </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>

                  <div class="modal-body">
                      <div class="mb-3">
                          <label class="form-label">Certificate File</label>
                          <input type="file" class="form-control" name="certificate_file"
                              accept="application/pdf,image/*" />
                          <small class="text-muted">Accepted: PDF, JPG, PNG (Max 5MB)</small>
                      </div>

                      <div class="mb-3">
                          <label class="form-label">Certification Program</label>
                          <select id="certificationSelect" class="form-control" name="certification_program" required>
                              <option disabled selected>Select Certification Program</option>
                              <!-- Automotive & Transportation -->
                              <option value="Automotive Servicing NC I">Automotive Servicing NC I</option>
                              <option value="Automotive Servicing NC II">Automotive Servicing NC II</option>
                              <option value="Driving NC II">Driving NC II</option>
                              <option value="Motorcycle/Small Engine Servicing NC II">Motorcycle/Small Engine
                                  Servicing NC II</option>

                              <!-- Construction -->
                              <option value="Carpentry NC II">Carpentry NC II</option>
                              <option value="Masonry NC I">Masonry NC I</option>
                              <option value="Masonry NC II">Masonry NC II</option>
                              <option value="Plumbing NC II">Plumbing NC II</option>
                              <option value="Pipefitting NC II">Pipefitting NC II</option>
                              <option value="Tile Setting NC II">Tile Setting NC II</option>
                              <option value="Scaffolding Works NC II">Scaffolding Works NC II</option>

                              <!-- Welding -->
                              <option value="Shielded Metal Arc Welding (SMAW) NC I">Shielded Metal Arc Welding
                                  (SMAW) NC I</option>
                              <option value="Shielded Metal Arc Welding (SMAW) NC II">Shielded Metal Arc Welding
                                  (SMAW) NC II</option>
                              <option value="Gas Metal Arc Welding (GMAW) NC II">Gas Metal Arc Welding (GMAW) NC II
                              </option>
                              <option value="Gas Tungsten Arc Welding (GTAW) NC II">Gas Tungsten Arc Welding (GTAW)
                                  NC II</option>
                              <option value="Flux-Cored Arc Welding (FCAW) NC II">Flux-Cored Arc Welding (FCAW) NC II
                              </option>

                              <!-- Electrical & Electronics -->
                              <option value="Electrical Installation & Maintenance NC II">Electrical Installation &
                                  Maintenance NC II</option>
                              <option value="Electronics Products Assembly & Servicing NC II">Electronic Products
                                  Assembly & Servicing NC II</option>
                              <option value="Computer Systems Servicing NC II">Computer Systems Servicing NC II
                              </option>

                              <!-- HVAC/R -->
                              <option value="Refrigeration and Air Conditioning Servicing NC II">Refrigeration and
                                  Air Conditioning Servicing NC II</option>

                              <!-- Agriculture -->
                              <option value="Agricultural Crops Production NC II">Agricultural Crops Production NC II
                              </option>
                              <option value="Organic Agriculture Production NC II">Organic Agriculture Production NC
                                  II</option>
                              <option value="Animal Production NC II">Animal Production NC II</option>

                              <!-- Miscellaneous -->
                              <option value="Domestic Work NC II">Domestic Work NC II</option>
                              <option value="Housekeeping NC II">Housekeeping NC II</option>
                              <option value="Dressmaking NC II">Dressmaking NC II</option>
                              <option value="Tailoring NC II">Tailoring NC II</option>
                              <option value="Food Processing NC II">Food Processing NC II</option>
                              <option value="Barista NC II">Barista NC II</option>
                              <option value="Bartending NC II">Bartending NC II</option>

                              <!-- IT / Programming -->
                              <option value="Web Development NC III">Web Development NC III</option>
                              <option value="Computer Programming NC IV">Computer Programming NC IV</option>

                              <!-- Other -->
                              <option value="Other">Other</option>
                          </select>

                          <!-- Hidden input that appears if 'Other' is selected -->
                          <div id="otherCertInput" style="display: none; margin-top: 10px;">
                              <label for="otherInput" class="form-label">Please specify</label>
                              <input type="text" name="other_certification_program" class="form-control"
                                  id="otherInput" placeholder="Enter your certification">
                          </div>
                      </div>

                      <div class="mb-3">
                          <label class="form-label">Date Obtained</label>
                          <input type="date" name="date_obtained" class="form-control" />
                      </div>
                  </div>

                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                          Cancel
                      </button>
                      <button type="submit" class="btn btn-tesda btn-primary-tesda">
                          Upload Certificate
                      </button>
                  </div>
              </div>
          </form>

          <script>
              document.addEventListener('DOMContentLoaded', function() {
                  const certificationSelect = document.getElementById('certificationSelect');
                  const otherCertInput = document.getElementById('otherCertInput');

                  certificationSelect.addEventListener('change', function() {
                      if (this.value === 'Other') {
                          otherCertInput.style.display = 'block';
                      } else {
                          otherCertInput.style.display = 'none';
                      }
                  });
              });
          </script>

      </div>
  </div>
