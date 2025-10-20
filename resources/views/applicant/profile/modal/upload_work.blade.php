 <div class="modal fade" id="uploadImageModal" tabindex="-1" aria-labelledby="uploadImageModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <form action="{{ route('applicant.portfolio.store') }}" method="POST" enctype="multipart/form-data">
             @csrf
             <input type="hidden" name="personal_info_id" value="{{ $retrievedProfile->personal_info->id }}">
             <input type="hidden" name="work_experience_id" value="{{ $retrievedProfile->work_background->id }}">
             <input type="hidden" name="template_final_step_register_id" value="{{ $retrievedProfile->template->id }}">
             <input type="hidden" name="applicant_id" value="{{ session('applicant_id') }}">

             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="uploadImageModalLabel">
                         Upload Portfolio Work
                     </h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                 </div>
                 <div class="modal-body">

                     <div class="mb-3">
                         <label class="form-label">Select Image</label>
                         <input type="file" name="sample_work_image" class="form-control" accept="image/*"
                             required />
                     </div>
                     <div class="mb-3">
                         <label class="form-label">Project Title</label>
                         <input type="text" name="sample_work_title" class="form-control"
                             placeholder="Enter work title" />
                     </div>
                     <div class="mb-3">
                         <label class="form-label">Description</label>
                         <textarea name="sample_work_description" class="form-control" rows="3" placeholder="Describe your sample work"></textarea>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button class="btn btn-secondary" data-bs-dismiss="modal">
                         Cancel
                     </button>
                     <button class="btn btn-tesda btn-primary-tesda">Upload</button>
                 </div>
             </div>
         </form>
     </div>
 </div>
