 <div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="false">
     <div class="modal-dialog modal-lg modal-dialog-centered">
         <div class="modal-content">

             <!-- Header -->
             <div class="modal-header">
                 <h5 class="modal-title">Edit Profile</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>

             <!-- Body -->

             <form
                 action="{{ route('applicant.profile.info.update', ['id' => $retrievedProfile->id ?? session('applicant_id')]) }}"
                 method="POST" enctype="multipart/form-data">
                 @csrf
                 @method('PUT')
                 <div class="modal-body">

                     <!-- Profile Image -->
                     <div class="text-center mb-3">
                         <!-- Profile Image Preview -->
                         <img id="profilePreview"
                             src="{{ asset('storage/' . $retrievedProfile->work_background->profileimage_path) }}"
                             class="rounded-circle" alt="Profile Image" width="120" height="120"
                             style="object-fit: cover;">

                         <div class="mt-2">
                             <input type="file" class="form-control" name="profile_picture" id="profileInput"
                                 accept="image/*">
                         </div>
                     </div>

                     <!-- Live Preview Script -->
                     <script>
                         document.getElementById('profileInput').addEventListener('change', function(event) {
                             const file = event.target.files[0];
                             if (file) {
                                 const reader = new FileReader();
                                 reader.onload = function(e) {
                                     document.getElementById('profilePreview').src = e.target.result;
                                 }
                                 reader.readAsDataURL(file);
                             }
                         });
                     </script>

                     <!-- Name -->
                     <div class="row">
                         <div class="col-md-6 mb-3">
                             <label class="form-label">First Name</label>
                             <input type="text" class="form-control" name="first_name"
                                 value="{{ $retrievedDecrytedProfile['personal_info']['first_name'] ?? '' }}" required>
                         </div>
                         <div class="col-md-6 mb-3">
                             <label class="form-label">Last Name</label>
                             <input type="text" class="form-control" name="last_name"
                                 value="{{ $retrievedDecrytedProfile['personal_info']['last_name'] ?? '' }}" required>
                         </div>
                     </div>

                     <!-- Work Info -->
                     <div class="mb-3">
                         <label class="form-label">Position</label>
                         <select class="form-select" id="position" name="position" required
                             onchange="toggleOtherPosition()">
                             <option value="" disabled
                                 {{ empty($retrievedDecrytedProfile['work_background']['position']) ? 'selected' : '' }}>
                                 Select job position
                             </option>
                             <option value="Automotive Servicing"
                                 {{ $retrievedDecrytedProfile['work_background']['position'] == 'Automotive Servicing' ? 'selected' : '' }}>
                                 Automotive Servicing</option>
                             <option value="Bartender"
                                 {{ $retrievedDecrytedProfile['work_background']['position'] == 'Bartender' ? 'selected' : '' }}>
                                 Bartender</option>
                             <option value="Barista"
                                 {{ $retrievedDecrytedProfile['work_background']['position'] == 'Barista' ? 'selected' : '' }}>
                                 Barista</option>
                             <option value="Beauty Care Specialist"
                                 {{ $retrievedDecrytedProfile['work_background']['position'] == 'Beauty Care Specialist' ? 'selected' : '' }}>
                                 Beauty Care Specialist</option>
                             <option value="Carpenter"
                                 {{ $retrievedDecrytedProfile['work_background']['position'] == 'Carpenter' ? 'selected' : '' }}>
                                 Carpenter</option>
                             <option value="Cook"
                                 {{ $retrievedDecrytedProfile['work_background']['position'] == 'Cook' ? 'selected' : '' }}>
                                 Cook</option>
                             <option value="Customer Service Representative"
                                 {{ $retrievedDecrytedProfile['work_background']['position'] == 'Customer Service Representative' ? 'selected' : '' }}>
                                 Customer Service Representative</option>
                             <option value="Dressmaker/Tailor"
                                 {{ $retrievedDecrytedProfile['work_background']['position'] == 'Dressmaker/Tailor' ? 'selected' : '' }}>
                                 Dressmaker/Tailor</option>
                             <option value="Electrician"
                                 {{ $retrievedDecrytedProfile['work_background']['position'] == 'Electrician' ? 'selected' : '' }}>
                                 Electrician</option>
                             <option value="Food and Beverage Server"
                                 {{ $retrievedDecrytedProfile['work_background']['position'] == 'Food and Beverage Server' ? 'selected' : '' }}>
                                 Food and Beverage Server</option>
                             <option value="Hairdresser"
                                 {{ $retrievedDecrytedProfile['work_background']['position'] == 'Hairdresser' ? 'selected' : '' }}>
                                 Hairdresser</option>
                             <option value="Heavy Equipment Operator"
                                 {{ $retrievedDecrytedProfile['work_background']['position'] == 'Heavy Equipment Operator' ? 'selected' : '' }}>
                                 Heavy Equipment Operator</option>
                             <option value="Housekeeping"
                                 {{ $retrievedDecrytedProfile['work_background']['position'] == 'Housekeeping' ? 'selected' : '' }}>
                                 Housekeeping</option>
                             <option value="Mason"
                                 {{ $retrievedDecrytedProfile['work_background']['position'] == 'Mason' ? 'selected' : '' }}>
                                 Mason</option>
                             <option value="Massage Therapist"
                                 {{ $retrievedDecrytedProfile['work_background']['position'] == 'Massage Therapist' ? 'selected' : '' }}>
                                 Massage Therapist</option>
                             <option value="Mechanic"
                                 {{ $retrievedDecrytedProfile['work_background']['position'] == 'Mechanic' ? 'selected' : '' }}>
                                 Mechanic</option>
                             <option value="Plumber"
                                 {{ $retrievedDecrytedProfile['work_background']['position'] == 'Plumber' ? 'selected' : '' }}>
                                 Plumber</option>
                             <option value="Security Guard"
                                 {{ $retrievedDecrytedProfile['work_background']['position'] == 'Security Guard' ? 'selected' : '' }}>
                                 Security Guard</option>
                             <option value="SMAW Welder"
                                 {{ $retrievedDecrytedProfile['work_background']['position'] == 'SMAW Welder' ? 'selected' : '' }}>
                                 SMAW Welder</option>
                             <option value="Tile Setter"
                                 {{ $retrievedDecrytedProfile['work_background']['position'] == 'Tile Setter' ? 'selected' : '' }}>
                                 Tile Setter</option>
                             <option value="Tourism Services Staff"
                                 {{ $retrievedDecrytedProfile['work_background']['position'] == 'Tourism Services Staff' ? 'selected' : '' }}>
                                 Tourism Services Staff</option>
                             <option value="Waiter/Waitress"
                                 {{ $retrievedDecrytedProfile['work_background']['position'] == 'Waiter/Waitress' ? 'selected' : '' }}>
                                 Waiter/Waitress</option>
                             <option value="Other"
                                 {{ !in_array($retrievedDecrytedProfile['work_background']['position'], [
                                     'Automotive Servicing',
                                     'Bartender',
                                     'Barista',
                                     'Beauty Care Specialist',
                                     'Carpenter',
                                     'Cook',
                                     'Customer Service Representative',
                                     'Dressmaker/Tailor',
                                     'Electrician',
                                     'Food and Beverage Server',
                                     'Hairdresser',
                                     'Heavy Equipment Operator',
                                     'Housekeeping',
                                     'Mason',
                                     'Massage Therapist',
                                     'Mechanic',
                                     'Plumber',
                                     'Security Guard',
                                     'SMAW Welder',
                                     'Tile Setter',
                                     'Tourism Services Staff',
                                     'Waiter/Waitress',
                                 ]) && $retrievedDecrytedProfile['work_background']['position'] == 'Other'
                                     ? 'selected'
                                     : '' }}>
                                 Other (Please specify)
                             </option>
                         </select>

                         <!-- Other Position Input -->
                         <div class="mt-2" id="otherPositionContainer" style="display: none;">
                             <input type="text" class="form-control" id="other_position" name="other_position"
                                 placeholder="Please specify your position"
                                 value="{{ !in_array($retrievedProfile->work_background->position, [
                                     'Automotive Servicing',
                                     'Bartender',
                                     'Barista',
                                     'Beauty Care Specialist',
                                     'Carpenter',
                                     'Cook',
                                     'Customer Service Representative',
                                     'Dressmaker/Tailor',
                                     'Electrician',
                                     'Food and Beverage Server',
                                     'Hairdresser',
                                     'Heavy Equipment Operator',
                                     'Housekeeping',
                                     'Mason',
                                     'Massage Therapist',
                                     'Mechanic',
                                     'Plumber',
                                     'Security Guard',
                                     'SMAW Welder',
                                     'Tile Setter',
                                     'Tourism Services Staff',
                                     'Waiter/Waitress',
                                 ])
                                     ? $retrievedProfile->work_background->position
                                     : '' }}">
                         </div>
                     </div>

                     <script>
                         function toggleOtherPosition() {
                             const select = document.getElementById('position');
                             const otherContainer = document.getElementById('otherPositionContainer');
                             if (select.value === 'Other') {
                                 otherContainer.style.display = 'block';
                             } else {
                                 otherContainer.style.display = 'none';
                                 document.getElementById('other_position').value = '';
                             }
                         }

                         // Run on page load (to show Other if already selected)
                         document.addEventListener('DOMContentLoaded', toggleOtherPosition);
                     </script>


                     <div class="row">
                         <div class="col-md-6 mb-3">
                             <label class="form-label">Work Duration</label>
                             <input type="number" class="form-control" name="work_duration"
                                 value="{{ $retrievedProfile->work_background->work_duration ?? '' }}">
                         </div>
                         <div class="col-md-6 mb-3">
                             <label class="form-label">Duration Unit</label>
                             <select class="form-select" name="work_duration_unit">
                                 <option value="months"
                                     {{ isset($retrievedDecryptedProfile['work_background']) && $retrievedDecryptedProfile['work_background']['work_duration_unit'] == 'months' ? 'selected' : '' }}>
                                     Months
                                 </option>
                                 <option value="years"
                                     {{ isset($retrievedDecryptedProfile['work_background']) && $retrievedDecryptedProfile['work_background']['work_duration_unit'] == 'years' ? 'selected' : '' }}>
                                     Years
                                 </option>

                             </select>
                         </div>
                     </div>

                 </div>

                 <!-- Footer -->
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                     <button type="submit" class="btn btn-primary">Save Changes</button>
                 </div>
             </form>


         </div>
     </div>
 </div>
