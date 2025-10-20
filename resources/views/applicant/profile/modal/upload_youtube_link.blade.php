 <div class="modal fade" id="addYoutubeModal" tabindex="-1" aria-labelledby="addYoutubeModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <form action="{{ route('applicant.youtubevideo.store') }}" method="POST">
             @csrf
             <input type="hidden" name="personal_info_id" value="{{ $retrievedProfile->personal_info->id }}">
             <input type="hidden" name="work_experience_id" value="{{ $retrievedProfile->work_background->id }}">
             <input type="hidden" name="applicant_id" value="{{ session('applicant_id') }}">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="addYoutubeModalLabel">
                         Add YouTube Video
                     </h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                 </div>
                 <div class="modal-body">
                     <div class="mb-3">
                         <label class="form-label">YouTube URL</label>
                         <input type="url" name="youtube_link" class="form-control"
                             placeholder="https://www.youtube.com/watch?v=..." required />
                     </div>
                     <div class="mb-3">
                         <label class="form-label">Video Title</label>
                         <input type="text" name="youtube_title" class="form-control"
                             placeholder="Enter video title" />
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button class="btn btn-secondary" data-bs-dismiss="modal">
                         Cancel
                     </button>
                     <button class="btn btn-tesda btn-primary-tesda">Add Video</button>
                 </div>
             </div>
         </form>
     </div>
 </div>
