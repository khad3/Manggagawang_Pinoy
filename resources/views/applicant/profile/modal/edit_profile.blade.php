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

                         <!-- Restore Default Button -->
                         <button type="button" class="btn btn-outline-danger w-100 mt-2"
                             onclick="restoreProfileImage()">
                             <i class="fas fa-undo me-1"></i> Restore Default Photo
                         </button>

                     </div>

                     <!-- Live Preview Script -->
                     <script>
                         function restoreProfileImage() {
                             const defaultImg = "{{ asset('img/workerdefault.png') }}"; // <-- your default image here
                             document.getElementById('profilePreview').src = defaultImg;

                             fetch("{{ route('applicant.profile.restore') }}", {
                                     method: "POST",
                                     headers: {
                                         "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                         "Accept": "application/json",
                                     }
                                 })
                                 .then(res => res.json())
                                 .then(data => {
                                     alert(data.message);
                                 })
                                 .catch(err => console.error(err));
                         }
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
                             @php
                                 $positions = [
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
                                 ];
                                 $currentPosition = $retrievedDecrytedProfile['work_background']['position'] ?? '';
                             @endphp

                             @foreach ($positions as $pos)
                                 <option value="{{ $pos }}" {{ $currentPosition === $pos ? 'selected' : '' }}>
                                     {{ $pos }}</option>
                             @endforeach

                             <option value="Other" {{ !in_array($currentPosition, $positions) ? 'selected' : '' }}>
                                 Other (Please specify)
                             </option>
                         </select>

                         <!-- Other Position Input -->
                         <div class="mt-2" id="otherPositionContainer"
                             style="{{ !in_array($currentPosition, $positions) ? 'display:block;' : 'display:none;' }}">
                             <input type="text" class="form-control" id="other_position" name="other_position"
                                 placeholder="Please specify your position"
                                 value="{{ !in_array($currentPosition, $positions) ? decrypt($retrievedProfile->work_background->other_position) : '' }}">
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
