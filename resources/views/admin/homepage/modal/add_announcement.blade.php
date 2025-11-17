   <div id="addAnnouncementModal" class="modal">
       <div class="modal-content">
           <div class="modal-header">
               <h2 class="modal-title">Create New Announcement</h2>
               <p class="modal-subtitle">Create and publish announcements for users</p>
               <button class="modal-close" onclick="closeModal('addAnnouncementModal')">
                   <i class="fas fa-times"></i>
               </button>
           </div>
           <div class="modal-body">
               <form action="{{ route('admin.create-announcement') }}" method="POST" enctype="multipart/form-data">
                   @csrf
                   <div class="form-group">
                       <label class="form-label">Announcement Title</label>
                       <input type="text" class="form-input" name="title" id="announcementTitle" required
                           placeholder="Enter announcement title">
                   </div>
                   <div class="form-group">
                       <label class="form-label">Content</label>
                       <textarea class="form-input form-textarea" name="content" id="announcementContent" required
                           placeholder="Enter announcement content..."></textarea>
                   </div>
                   <div class="form-group">
                       <label class="form-label">Image</label>
                       <input type="file" class="form-input" name="image" id="announcementImage" name="image"
                           accept="image/*">
                   </div>


                   <div class="form-grid">
                       <div class="form-group">
                           <label class="form-label">Priority Level</label>
                           <select class="form-select" name="priority" id="announcementPriority" required>
                               <option value="">Select Priority</option>
                               <option value="low">Low Priority</option>
                               <option value="medium">Medium Priority</option>
                               <option value="high">High Priority</option>
                               <option value="urgent">Urgent</option>
                           </select>
                       </div>
                       <div class="form-group">
                           <label class="form-label">Target Audience</label>
                           <select class="form-select" name="audience" id="announcementAudience" required>
                               <option value="">Select Audience</option>
                               <option value="all">All Users</option>
                               <option value="applicants">Job Applicants Only</option>
                               <option value="employers">Employers Only</option>
                               {{-- <option value="tesda_officers">TESDA Officers Only</option> --}}
                           </select>
                       </div>
                       <div class="form-group">
                           <label class="form-label">Publication Date</label>
                           <input type="datetime-local" name="date" class="form-input" id="announcementDate"
                               required>
                       </div>
                       <div class="form-group">
                           <label class="form-label">Status</label>
                           <select class="form-select" name="status" id="announcementStatus" required>
                               <option value="">Select Status</option>
                               <option value="draft">Save as Draft</option>
                               <option value="published">Publish Immediately</option>
                               {{-- <option value="scheduled">Schedule for Later</option>
                               <option value="archived">archived</option> --}}
                           </select>
                       </div>
                   </div>
                   <div class="form-group">
                       <label class="form-label">Tags (Optional)</label>
                       <input type="text" class="form-input" name="tags" id="announcementTags"
                           placeholder="Enter tags separated by commas">
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-cancel"
                           onclick="closeModal('addAnnouncementModal')">Cancel</button>
                       <button type="submit" class="btn btn-primary" onclick="submitAnnouncementForm()">
                           <i class="fas fa-bullhorn"></i> Create Announcement
                       </button>
                   </div>
               </form>
           </div>
       </div>
   </div>
