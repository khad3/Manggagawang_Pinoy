  <div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <form action="{{ route('applicant.applicantposts.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <!-- ✅ Add these hidden fields -->
              <input type="hidden" name="personal_info_id" value="{{ $retrievedProfile->personal_info->id ?? '' }}">
              <input type="hidden" name="work_experience_id"
                  value="{{ $retrievedProfile->work_background->id ?? '' }}">

              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="addPostModalLabel">
                          Create New Post
                      </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <div class="mb-3">
                          <label for="postContent" class="form-label">What's on your mind?</label>
                          <textarea name="content" id="postContent" class="form-control" rows="4"
                              placeholder="Share your thoughts, achievements, or updates..." required></textarea>
                      </div>
                      <div class="mb-3">
                          <label for="postImage" class="form-label">Upload Image (optional)</label>
                          <input type="file" name="image" id="postImage" class="form-control" accept="image/*" />
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                          Cancel
                      </button>
                      <button type="submit" class="btn btn-tesda btn-primary-tesda" data-bs-dismiss="modal"
                          onclick="createPost()">
                          Post
                      </button>
                  </div>
              </div>
          </form>
      </div>
  </div>
