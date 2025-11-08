   <div class="page-section" id="settings-section">
       <div class="content-section container py-5">



           <div class="row g-4">

               <h3 class="fw-bold mb-4">
                   <i class="fas fa-cog me-2 text-primary" aria-hidden="true"></i> Account Settings
               </h3>

               <div class="row g-4">

                   <!-- Company Logo Upload -->
                   <div class="col-lg-6">
                       <div class="card shadow-sm border-0 rounded-4">
                           <div class="card-header bg-light fw-bold d-flex align-items-center">
                               <i class="fas fa-image me-2 text-primary" aria-hidden="true"></i>
                               <span>Company Logo</span>
                           </div>
                           <div class="card-body text-center">
                               <form action="{{ route('employer.companylogo.store') }}" method="POST"
                                   enctype="multipart/form-data" novalidate
                                   onsubmit="this.querySelector('button[type=submit]').disabled=true;">
                                   @csrf


                                   <!-- Preview Section -->
                                   <div class="mb-3">
                                       <img id="logoPreview"
                                           src="{{ $retrievedPersonalInformation->addressCompany->company_logo
                                               ? asset('storage/' . $retrievedPersonalInformation->addressCompany->company_logo)
                                               : asset('img/logo.png') }}"
                                           alt="Company Logo Preview" class="img-fluid rounded-circle border shadow-sm"
                                           style="width: 120px; height: 120px; object-fit: cover;">
                                   </div>

                                   <!-- File Input -->
                                   <div class="mb-3">
                                       <label for="companyLogo" class="form-label fw-semibold">Upload New Logo</label>
                                       <input type="file" name="company_logo" id="companyLogo"
                                           class="form-control form-control-lg rounded-3 @error('company_logo') is-invalid @enderror"
                                           accept="image/*" onchange="previewCompanyLogo(event)" required>
                                       @error('company_logo')
                                           <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                       <div class="form-text text-muted">Accepted formats: JPG, PNG (max 2MB).</div>
                                   </div>

                                   <button type="submit" class="btn btn-primary w-100" aria-label="Upload Logo">
                                       <i class="fas fa-upload me-1" aria-hidden="true"></i> Upload Logo
                                   </button>
                               </form>
                           </div>
                       </div>
                   </div>

                   <!-- 🪄 Preview Script -->
                   <script>
                       function previewCompanyLogo(event) {
                           const input = event.target;
                           const reader = new FileReader();
                           reader.onload = function() {
                               document.getElementById('logoPreview').src = reader.result;
                           };
                           reader.readAsDataURL(input.files[0]);
                       }
                   </script>


                   <!-- Edit Company Info -->
                   <div class="col-lg-6">
                       <div class="card shadow-sm border-0 rounded-4">
                           <div class="card-header bg-light fw-bold d-flex align-items-center">
                               <i class="fas fa-building me-2 text-secondary" aria-hidden="true"></i>
                               <span>Edit Company Name</span>
                           </div>
                           <div class="card-body">
                               <form action="{{ route('employer.updatecompanyname.store') }}" method="POST" novalidate
                                   onsubmit="this.querySelector('button[type=submit]').disabled=true;">
                                   @csrf
                                   @method('PUT')

                                   <div class="mb-3">
                                       <label for="companyName" class="form-label">Company Name</label>
                                       <input type="text" id="companyName" name="company_name"
                                           class="form-control form-control-lg rounded-3 @error('company_name') is-invalid @enderror"
                                           value="{{ old('company_name', $retrievedPersonalInformation->addressCompany->company_name ?? '') }}"
                                           placeholder="Enter your company name" aria-describedby="companyNameHelp"
                                           required>
                                       @error('company_name')
                                           <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                       <div id="companyNameHelp" class="form-text text-muted">This name appears
                                           on job posts and your company profile.</div>
                                   </div>

                                   <button type="submit" class="btn btn-primary w-100" aria-label="Save Changes">
                                       <i class="fas fa-save me-1" aria-hidden="true"></i> Save Changes
                                   </button>
                               </form>
                           </div>
                       </div>
                   </div>

                   <!-- Change Password -->
                   <div class="col-lg-6">
                       <div class="card shadow-sm border-0 rounded-4">
                           <div class="card-header bg-light fw-bold d-flex align-items-center">
                               <i class="fas fa-lock me-2 text-warning" aria-hidden="true"></i>
                               <span>Change Password</span>
                           </div>
                           <div class="card-body">
                               <form action="{{ route('employer.updatecompanypassword.store') }}" method="POST"
                                   novalidate onsubmit="this.querySelector('button[type=submit]').disabled=true;">
                                   @csrf
                                   @method('PUT')

                                   <div class="mb-3">
                                       <label for="currentPassword" class="form-label">Current Password</label>
                                       <input type="password" id="currentPassword" name="old_password"
                                           class="form-control form-control-lg rounded-3 @error('old_password') is-invalid @enderror"
                                           placeholder="Enter current password" autocomplete="current-password"
                                           required>
                                       @error('old_password')
                                           <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                   </div>

                                   <div class="mb-3">
                                       <label for="newPassword" class="form-label">New Password</label>
                                       <input type="password" id="newPassword" name="new_password"
                                           class="form-control form-control-lg rounded-3 @error('new_password') is-invalid @enderror"
                                           placeholder="Enter new password" autocomplete="new-password" required>
                                       @error('new_password')
                                           <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                   </div>

                                   <div class="mb-3">
                                       <label for="confirmPassword" class="form-label">Confirm New
                                           Password</label>
                                       <input type="password" id="confirmPassword" name="confirm_password"
                                           class="form-control form-control-lg rounded-3 @error('confirm_password') is-invalid @enderror"
                                           placeholder="Confirm new password" autocomplete="new-password" required>
                                       @error('confirm_password')
                                           <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                   </div>

                                   <button type="submit" class="btn btn-warning w-100" aria-label="Update Password">
                                       <i class="fas fa-key me-1" aria-hidden="true"></i> Update Password
                                   </button>
                               </form>
                           </div>
                       </div>
                   </div>

                   <!-- 🧨 Delete Account Section -->
                   <div class="col-12">
                       <div class="card shadow-sm border-0 rounded-4 mt-4 overflow-hidden">
                           <div
                               class="card-header bg-danger bg-opacity-10 text-danger fw-bold d-flex align-items-center">
                               <i class="fas fa-user-slash me-2 text-danger" aria-hidden="true"></i>
                               Delete Account
                           </div>
                           <div class="card-body text-center">
                               <div class="mb-3">
                                   <i class="fas fa-exclamation-triangle text-danger fs-1 mb-3"
                                       aria-hidden="true"></i>
                                   <p class="text-muted mb-1">
                                       Deleting your account will permanently remove all your company data, job
                                       posts, and applicants.
                                   </p>
                                   <p class="text-danger fw-semibold mb-4">
                                       This action <strong>cannot be undone</strong>.
                                   </p>
                               </div>

                               <button type="button" class="btn btn-outline-danger btn-lg w-50 rounded-3 fw-semibold"
                                   data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" aria-haspopup="dialog"
                                   aria-controls="confirmDeleteModal">
                                   <i class="fas fa-trash-alt me-1" aria-hidden="true"></i> Delete My Account
                               </button>
                           </div>
                       </div>
                   </div>

                   <!-- Confirm Delete Modal -->
                   <div class="modal fade" id="confirmDeleteModal" tabindex="-1"
                       aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                       <div class="modal-dialog modal-dialog-centered">
                           <div class="modal-content border-0 rounded-4 shadow-lg">
                               <div class="modal-header bg-danger text-white border-0 rounded-top-4">
                                   <h5 class="modal-title fw-bold" id="confirmDeleteModalLabel">
                                       <i class="fas fa-exclamation-circle me-2" aria-hidden="true"></i> Confirm
                                       Account Deletion
                                   </h5>
                                   <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                       aria-label="Close"></button>
                               </div>
                               <div class="modal-body text-center py-4">
                                   <i class="fas fa-heart-broken text-danger fs-1 mb-3" aria-hidden="true"></i>
                                   <p class="mb-2 text-secondary">
                                       We're sad to see you go, <strong>dear employer</strong>. 💛
                                   </p>
                                   <p class="text-muted">
                                       Are you sure you want to permanently delete your account? All your data will
                                       be lost.
                                   </p>
                               </div>
                               <div class="modal-footer border-0 d-flex justify-content-center pb-4">
                                   <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal"
                                       aria-label="Cancel">
                                       <i class="fas fa-times me-1" aria-hidden="true"></i> Cancel
                                   </button>

                                   <form
                                       action="{{ route('employer.deleteaccount.destroy', $retrievedPersonalInformation->id ?? '') }}"
                                       method="POST" class="d-inline"
                                       onsubmit="this.querySelector('button[type=submit]').disabled=true;">
                                       @csrf
                                       @method('DELETE')
                                       <button type="submit" class="btn btn-danger px-4"
                                           aria-label="Confirm Delete">
                                           <i class="fas fa-trash-alt me-1" aria-hidden="true"></i> Yes, Delete
                                       </button>
                                   </form>
                               </div>
                           </div>
                       </div>
                   </div>


               </div>

           </div>
       </div>
   </div>
