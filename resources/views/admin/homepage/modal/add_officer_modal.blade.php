 <div id="addOfficerModal" class="modal">
     <div class="modal-content">
         <div class="modal-header">
             <h2 class="modal-title">Add New Officer</h2>
             <p class="modal-subtitle">Create a new TESDA officer account with full credentials</p>
             <button class="modal-close" onclick="closeModal('addOfficerModal')">
                 <i class="fas fa-times"></i>
             </button>
         </div>
         <div class="modal-body">
             <form id="addOfficerForm" action="{{ route('admin.addofficer.store') }}" method="POST">
                 @csrf
                 <div class="form-grid">
                     <div class="form-group">
                         <label class="form-label">First Name</label>
                         <input type="text" class="form-input" name="first_name" id="officerFirstName" required>
                     </div>
                     <div class="form-group">
                         <label class="form-label">Last Name</label>
                         <input type="text" class="form-input" name="last_name" id="officerLastName" required>
                     </div>

                     <div class="form-group form-grid-full">
                         <label class="form-label">Email Address</label>
                         <input type="email" class="form-input" name="email" id="officerEmail"
                             placeholder="john.doe@tesda.gov.ph" required>
                     </div>

                     <div class="form-group">
                         <label class="form-label">Temporary Password</label>
                         <input type="password" class="form-input" name="temporary_password" id="officerPassword"
                             required>
                     </div>

                     <div class="form-group">
                         <label class="form-label">Status</label>
                         <select class="form-select" id="officerStatus" name="status" required>
                             <option value="active">Active</option>
                             <option value="inactive">Inactive</option>
                         </select>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-cancel"
                         onclick="closeModal('addOfficerModal')">Cancel</button>
                     <button type="submit" class="btn btn-primary">
                         <i class="fas fa-plus"></i> Create Officer Account
                     </button>
                 </div>
             </form>
         </div>

     </div>
 </div>
