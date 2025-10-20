   <section id="announcements" class="content-section">
       <div class="section-header">
           <h2 class="section-title">
               <i class="fas fa-bullhorn"></i>
               Announcements Management
           </h2>
           <button class="btn btn-primary" onclick="openAddAnnouncementModal()">
               <i class="fas fa-plus"></i>
               Create Announcement
           </button>
       </div>

       <div class="section-content">
           <div class="announcements-container">
               <!-- Filter and Search Controls -->
               <div class="announcements-header">
                   <div class="announcements-controls">
                       <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                           <div class="filter-group">
                               <label for="priorityFilter">Priority:</label>
                               <select id="priorityFilter" class="filter-select">
                                   <option value="">All Priorities</option>
                                   <option value="urgent">Urgent</option>
                                   <option value="high">High</option>
                                   <option value="medium">Medium</option>
                                   <option value="low">Low</option>
                               </select>
                           </div>

                           <div class="filter-group">
                               <label for="statusFilter">Status:</label>
                               <select id="statusFilter" class="filter-select">
                                   <option value="">All Status</option>
                                   <option value="published">Published</option>
                                   <option value="draft">Draft</option>
                                   <option value="archived">Archived</option>
                               </select>
                           </div>

                           <div class="filter-group">
                               <label for="searchFilter">Search:</label>
                               <input type="text" id="searchFilter" class="search-input"
                                   placeholder="Search announcements...">
                           </div>
                       </div>

                       <div class="announcements-stats">
                           <div class="stat-badge">
                               <i class="fas fa-list"></i>
                               <span id="totalCount">{{ count($retrieveAnnouncements) }}</span> Total
                           </div>
                           <div class="stat-badge">
                               <i class="fas fa-eye"></i>
                               <span id="publishedCount">{{ $publishedAnnouncementTotal }}</span>
                               Published
                           </div>
                       </div>
                   </div>
               </div>

               <!-- Announcements List -->
               <div class="announcements-grid">
                   <!-- Announcements -->
                   @if (isset($retrieveAnnouncements) && count($retrieveAnnouncements) > 0)
                       @foreach ($retrieveAnnouncements as $announcement)
                           <div class="announcement-item" data-priority="{{ $announcement->priority }}"
                               data-status="{{ $announcement->status }}">

                               <div class="announcement-header">
                                   <div class="announcement-badges">
                                       <span class="priority-badge priority-{{ $announcement->priority }}">
                                           {{ ucfirst($announcement->priority) }}
                                       </span>
                                       <span class="status-badge status-{{ $announcement->status }}">
                                           {{ ucfirst($announcement->status) }}
                                       </span>
                                   </div>
                                   <div class="announcement-actions">
                                       <button class="action-btn btn-view" title="View Details" data-bs-toggle="modal"
                                           data-bs-target="#viewAnnouncementModal">
                                           <i class="fas fa-eye"></i>
                                       </button>
                                       <button class="action-btn btn-edit" title="Edit" data-bs-toggle="modal"
                                           data-bs-target="#editAnnouncementModal-{{ $announcement->id }}">
                                           <i class="fas fa-edit"></i>
                                       </button>

                                       <form
                                           action="{{ route('admin.delete-announcement.destroy', $announcement->id) }}"
                                           method="POST" style="display:inline;">
                                           @csrf
                                           @method('DELETE')
                                           <button type="submit" class="action-btn btn-delete" title="Delete"
                                               onclick="return confirm('Are you sure you want to delete this announcement?')">
                                               <i class="fas fa-trash"></i>
                                           </button>
                                       </form>

                                   </div>
                               </div>

                               <h3 class="announcement-title">{{ $announcement->title }}</h3>
                               <p class="announcement-content">
                                   {{ $announcement->content }}
                               </p>

                               {{-- Show image only if not null --}}
                               @if ($announcement->image)
                                   <img src="{{ asset('storage/' . $announcement->image) }}" alt="Announcement Image"
                                       style="width:100%; border-radius:8px; margin-bottom:10px;">
                               @endif

                               <div class="tags-container">
                                   @if ($announcement->tag)
                                       @php
                                           $tags = explode(',', $announcement->tag);
                                       @endphp
                                       @foreach ($tags as $tag)
                                           <span class="tag">#{{ trim($tag) }}</span>
                                       @endforeach
                                   @endif
                               </div>

                               <div class="announcement-meta">
                                   <div class="meta-info">
                                       <div class="meta-item">
                                           <i class="fas fa-user"></i>
                                           <span>Admin User</span>
                                       </div>

                                       {{-- Created date --}}
                                       <div class="meta-item">
                                           <i class="fas fa-calendar-plus"></i>
                                           <span>
                                               Created on
                                               ({{ $announcement->created_at->diffForHumans() }})
                                           </span>
                                       </div>

                                       {{-- Publication date if exists --}}
                                       @if ($announcement->publication_date)
                                           <div class="meta-item">
                                               <i class="fas fa-calendar-check"></i>
                                               <span>
                                                   Published on
                                                   {{ \Carbon\Carbon::parse($announcement->publication_date)->format('F j, Y \a\t g:i A') }}
                                                   ({{ \Carbon\Carbon::parse($announcement->publication_date)->diffForHumans() }})
                                               </span>
                                           </div>
                                       @endif

                                       <div class="meta-item">
                                           <i class="fas fa-users"></i>
                                           <span>{{ ucfirst($announcement->target_audience) }}</span>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       @endforeach
                   @endif
               </div>


               @foreach ($retrieveAnnouncements as $announcement)
                   <!-- Edit Announcement Modal -->
                   <div class="modal fade" id="editAnnouncementModal-{{ $announcement->id }}" tabindex="-1"
                       aria-labelledby="editAnnouncementModalLabel-{{ $announcement->id }}" aria-hidden="true">
                       <div class="modal-dialog modal-lg modal-dialog-centered">
                           <div class="modal-content">
                               <form action="{{ route('admin.update-announcement', $announcement->id) }}"
                                   method="POST">
                                   @csrf
                                   @method('PUT')

                                   <div class="modal-header">
                                       <h5 class="modal-title" id="editAnnouncementModalLabel-{{ $announcement->id }}">
                                           <i class="fas fa-edit me-2"></i>Edit Announcement
                                       </h5>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal"
                                           aria-label="Close"></button>
                                   </div>

                                   <div class="modal-body">
                                       <div class="form-group mb-3">
                                           <label class="form-label">Title</label>
                                           <input type="text" name="title" class="form-control"
                                               value="{{ $announcement->title }}" required>
                                       </div>

                                       <div class="form-group mb-3">
                                           <label class="form-label">Content</label>
                                           <textarea name="content" class="form-control" rows="4" required>{{ $announcement->content }}</textarea>
                                       </div>

                                       {{-- Show current image --}}
                                       @if ($announcement->image)
                                           <div class="mb-3">
                                               <label class="form-label d-block">Current Image</label>
                                               <img src="{{ asset('storage/' . $announcement->image) }}"
                                                   alt="Announcement Image"
                                                   style="width: 150px; border-radius: 8px; margin-bottom:10px;">
                                           </div>
                                       @endif

                                       <div class="form-group mb-3">
                                           <label class="form-label">Upload New Image</label>
                                           <input type="file" name="image" class="form-control">
                                       </div>

                                       <div class="row">
                                           <div class="col-md-6 mb-3">
                                               <label class="form-label">Priority</label>
                                               <select name="priority" class="form-select" required>
                                                   <option value="low"
                                                       {{ $announcement->priority == 'low' ? 'selected' : '' }}>
                                                       Low</option>
                                                   <option value="medium"
                                                       {{ $announcement->priority == 'medium' ? 'selected' : '' }}>
                                                       Medium</option>
                                                   <option value="high"
                                                       {{ $announcement->priority == 'high' ? 'selected' : '' }}>
                                                       High</option>
                                                   <option value="urgent"
                                                       {{ $announcement->priority == 'urgent' ? 'selected' : '' }}>
                                                       Urgent</option>
                                               </select>
                                           </div>
                                           <div class="col-md-6 mb-3">
                                               <label class="form-label">Target Audience</label>
                                               <select name="target_audience" class="form-select" required>
                                                   <option value="all"
                                                       {{ $announcement->target_audience == 'all' ? 'selected' : '' }}>
                                                       All</option>
                                                   <option value="applicants"
                                                       {{ $announcement->target_audience == 'applicants' ? 'selected' : '' }}>
                                                       Applicants</option>
                                                   <option value="employers"
                                                       {{ $announcement->target_audience == 'employers' ? 'selected' : '' }}>
                                                       Employers</option>
                                                   <option value="tesda_officers"
                                                       {{ $announcement->target_audience == 'tesda_officers' ? 'selected' : '' }}>
                                                       TESDA Officers</option>
                                               </select>
                                           </div>
                                       </div>

                                       <div class="form-group mb-3">
                                           <label class="form-label">Publication Date</label>
                                           <input type="datetime-local" name="publication_date" class="form-control"
                                               value="{{ $announcement->publication_date ? \Carbon\Carbon::parse($announcement->publication_date)->format('Y-m-d\TH:i') : '' }}">
                                       </div>

                                       <div class="form-group mb-3">
                                           <label class="form-label">Status</label>
                                           <select name="status" class="form-select" required>
                                               <option value="draft"
                                                   {{ $announcement->status == 'draft' ? 'selected' : '' }}>
                                                   Draft</option>
                                               <option value="published"
                                                   {{ $announcement->status == 'published' ? 'selected' : '' }}>
                                                   Published</option>
                                               <option value="scheduled"
                                                   {{ $announcement->status == 'scheduled' ? 'selected' : '' }}>
                                                   Scheduled</option>
                                               <option value="archived"
                                                   {{ $announcement->status == 'archived' ? 'selected' : '' }}>
                                                   Archived</option>
                                           </select>
                                       </div>

                                       <div class="form-group mb-3">
                                           <label class="form-label">Tags (optional)</label>
                                           <input type="text" name="tags" class="form-control"
                                               value="{{ $announcement->tag }}">
                                       </div>
                                   </div>

                                   <div class="modal-footer">
                                       <button type="button" class="btn btn-secondary"
                                           data-bs-dismiss="modal">Cancel</button>
                                       <button type="submit" class="btn btn-primary">
                                           <i class="fas fa-save me-1"></i> Save Changes
                                       </button>
                                   </div>
                               </form>
                           </div>
                       </div>
                   </div>
               @endforeach
           </div>

           <script>
               document.addEventListener('DOMContentLoaded', function() {
                   const priorityFilter = document.getElementById('priorityFilter');
                   const statusFilter = document.getElementById('statusFilter');
                   const searchFilter = document.getElementById('searchFilter');

                   const items = document.querySelectorAll('.announcement-item');

                   function filterAnnouncements() {
                       const priority = priorityFilter.value;
                       const status = statusFilter.value;
                       const searchText = searchFilter.value.toLowerCase();

                       let totalCount = 0;
                       let publishedCount = 0;

                       items.forEach(item => {
                           const itemPriority = item.getAttribute('data-priority');
                           const itemStatus = item.getAttribute('data-status');
                           const itemTitle = item.getAttribute('data-title');

                           const matchesPriority = !priority || itemPriority === priority;
                           const matchesStatus = !status || itemStatus === status;
                           const matchesSearch = !searchText || itemTitle.includes(searchText);

                           if (matchesPriority && matchesStatus && matchesSearch) {
                               item.style.display = 'block';
                               totalCount++;
                               if (itemStatus === 'published') publishedCount++;
                           } else {
                               item.style.display = 'none';
                           }
                       });

                       document.getElementById('totalCount').textContent = totalCount;
                       document.getElementById('publishedCount').textContent = publishedCount;
                   }

                   // Event listeners
                   priorityFilter.addEventListener('change', filterAnnouncements);
                   statusFilter.addEventListener('change', filterAnnouncements);
                   searchFilter.addEventListener('input', filterAnnouncements);
               });
           </script>

       </div>
   </section>
