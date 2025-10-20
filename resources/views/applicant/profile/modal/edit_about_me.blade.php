 <!-- Edit About Modal -->
 <div class="modal fade" id="editAboutModal" tabindex="-1" aria-labelledby="editAboutModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <form action="{{ route('applicant.editprofile', ['id' => $retrievedProfile->id]) }}" method="POST">
             @csrf
             @method('PUT')
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="editAboutModalLabel">Edit About Info</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>

                 <div class="modal-body">
                     <div class="mb-3">
                         <label for="email" class="form-label">Email Address</label>
                         <input type="email" name="email" class="form-control"
                             value="{{ $retrievedProfile->email ?? '' }}" required>
                     </div>

                     <div class="mb-3">
                         <label class="form-label">House / Street</label>
                         <input type="text" name="house_street" class="form-control"
                             value="{{ $retrievedDecrytedProfile['personal_info']['house_street'] ?? '' }}">
                     </div>

                     <div class="mb-3">
                         <label class="form-label">Barangay</label>
                         <input type="text" name="barangay" class="form-control"
                             value="{{ $retrievedDecrytedProfile['personal_info']['barangay'] ?? '' }}">
                     </div>

                     <div class="mb-3">
                         <label class="form-label">City</label>
                         <input type="text" name="city" class="form-control"
                             value="{{ $retrievedDecrytedProfile['personal_info']['city'] ?? '' }}">
                     </div>

                     <div class="mb-3">
                         <label class="form-label">Province</label>
                         <input type="text" name="province" class="form-control"
                             value="{{ $retrievedDecrytedProfile['personal_info']['province'] ?? '' }}">
                     </div>

                     <div class="mb-3">
                         <label class="form-label">About</label>
                         <textarea name="description" rows="3" class="form-control">{{ $retrievedDecrytedProfile['template']['description'] ?? '' }}</textarea>
                     </div>
                 </div>

                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                     <button type="submit" class="btn btn-tesda btn-primary-tesda">Save Changes</button>
                 </div>
             </div>
         </form>
     </div>
 </div>
