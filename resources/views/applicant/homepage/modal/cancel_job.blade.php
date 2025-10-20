 <div class="modal fade" id="cancelApplicationModal" tabindex="-1" aria-labelledby="cancelApplicationModalLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <form method="POST" action="{{ route('jobs.cancel.delete') }}">
                 @csrf
                 @method('DELETE')
                 <input type="hidden" name="job_id" id="cancelJobId">

                 <div class="modal-header">
                     <h5 class="modal-title" id="cancelApplicationModalLabel">
                         <i class="fas fa-exclamation-triangle text-danger me-2"></i>Cancel Application
                     </h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                 </div>

                 <div class="modal-body">
                     <p>Are you sure you want to cancel your application for this job?</p>
                     <p class="text-muted mb-0"><small>This action cannot be undone.</small></p>
                 </div>

                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                         <i class="fas fa-times me-1"></i>Close
                     </button>
                     <button type="submit" class="btn btn-danger">
                         <i class="fas fa-trash me-1"></i>Yes, Cancel
                     </button>
                 </div>
             </form>
         </div>
     </div>
 </div>
