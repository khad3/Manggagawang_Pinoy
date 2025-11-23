   <section id="recent-activity" class="content-section"> <!-- Recent Activity Log -->
       <div class="report-card" style="grid-column: 1 / -1;">
           <div class="report-card-header d-flex justify-content-between align-items-center">
               <h3 class="report-title">Recent Activity Logs</h3>
               <div class="report-actions">
                   <button class="action-btn btn-view" title="View All">
                       <i class="fas fa-list"></i>
                   </button>
               </div>
           </div>

           <!-- Filter Buttons -->
           <div class="activity-filters mb-3 d-flex flex-wrap gap-2">
               <button class="btn btn-sm btn-outline-primary filter-btn active" data-filter="all">All</button>
               <button class="btn btn-sm btn-outline-secondary filter-btn"
                   data-filter="certification">Certifications</button>
               <button class="btn btn-sm btn-outline-success filter-btn" data-filter="job">Jobs</button>
               <button class="btn btn-sm btn-outline-warning filter-btn"
                   data-filter="announcement">Announcements</button>
               <button class="btn btn-sm btn-outline-danger filter-btn" data-filter="report_applicant">Applicant
                   Reports</button>
               <button class="btn btn-sm btn-outline-danger filter-btn" data-filter="report_employer">Employer
                   Reports</button>
               <button class="btn btn-sm btn-outline-info filter-btn" data-filter="rating">Ratings</button>
               <button class="btn btn-sm btn-outline-dark filter-btn" data-filter="system">System</button>
           </div>

           <div id="activityLog">
               @foreach ($activityLogs as $log)
                   @php
                       $action = $log['action'];
                       $category = 'system'; // default

                       // Set category
                       if (Str::contains($action, ['certification'])) {
                           $category = 'certification';
                       } elseif (in_array($action, ['report_job'])) {
                           $category = 'report_employer';
                       } elseif (in_array($action, ['report_applicant'])) {
                           $category = 'report_applicant';
                       } elseif (Str::contains($action, ['job', 'interview']) && $action !== 'report_job') {
                           // Exclude report_job from job category
                           $category = 'job';
                       } elseif (Str::contains($action, ['announcement', 'post_announcement'])) {
                           $category = 'announcement';
                       } elseif (Str::contains($action, ['rating'])) {
                           $category = 'rating';
                       }
                   @endphp

                   <div class="activity-item" data-category="{{ $category }}">
                       <div class="activity-icon activity-{{ $log['action'] }}">
                           @switch($log['action'])
                               @case('report_applicant')
                                   <i class="bi bi-flag-fill text-danger"></i>
                               @break

                               @case('report_job')
                                   <i class="bi bi-flag-fill text-darkred"></i>
                               @break

                               @case('banned')
                                   <i class="fa-solid fa-ban text-danger"></i>
                               @break

                               @case('unbanned')
                                   <i class="fas fa-check text-success"></i>
                               @break

                               @case('suspended')
                                   <i class="fas fa-pause text-warning"></i>
                               @break

                               @case('post')
                                   <i class="fas fa-bullhorn text-info"></i>
                               @break

                               @case('login')
                                   <i class="fas fa-sign-in-alt text-primary"></i>
                               @break

                               @case('created_account')
                                   <i class="fas fa-user-plus text-success"></i>
                               @break

                               @case('upload_certification')
                                   <i class="fas fa-certificate" style="color: gold;"></i>
                               @break

                               @case('approved_certification')
                                   <i class="bi bi-patch-check-fill" style="color: green;"></i>
                               @break

                               @case('rejected_certification')
                                   <i class="bi bi-patch-minus-fill" style="color: red;"></i>
                               @break

                               @case('request_revision_certification')
                                   <i class="bi bi-patch-exclamation-fill" style="color: orange;"></i>
                               @break

                               @case('apply_job')
                                   <i class="bi bi-file-earmark-person-fill" style="color:brown;"></i>
                               @break

                               @case('reject_job')
                                   <i class="bi bi-x-circle-fill text-danger"></i>
                               @break

                               @case('approved_job')
                                   <i class="bi bi-patch-check-fill text-success"></i>
                               @break

                               @case('published_job')
                                   <i class="bi bi-briefcase-fill text-success"></i>
                               @break

                               @case('draft_job')
                                   <i class="bi bi-briefcase text-warning"></i>
                               @break

                               @case('interview_job')
                                   <i class="fas fa-calendar" style="color: blue;"></i>
                               @break

                               @case('post_announcement')
                                   <i class="bi bi-megaphone-fill" style="color:green"></i>
                               @break

                               @case('send_rating_to_job_post')
                               @case('send_rating_to_applicant')
                                   <i class="bi bi-star-fill" style="color: gold;"></i>
                               @break

                               @default
                                   <i class="fas fa-info-circle text-secondary"></i>
                           @endswitch
                       </div>

                       <div class="activity-content">
                           <h6>{{ ucwords(str_replace('_', ' ', $log['action'])) }}</h6>
                           <p>{!! $log['description'] !!}</p>

                           @if (!empty($log['attachment']))
                               <div class="mt-2">
                                   <strong>Attachment:</strong><br>
                                   <a href="{{ $log['attachment'] }}" target="_blank"
                                       class="btn btn-sm btn-outline-primary">
                                       <i class="bi bi-eye me-1"></i> View Attachment
                                   </a>
                               </div>
                           @endif
                       </div>

                       <div class="activity-time">
                           {{ \Carbon\Carbon::parse($log['created_at'])->diffForHumans() }}
                       </div>
                   </div>
               @endforeach
           </div>
       </div>

       <script>
           document.querySelectorAll('.filter-btn').forEach(button => {
               button.addEventListener('click', () => {
                   // Remove active class from all buttons
                   document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
                   button.classList.add('active');

                   const filter = button.dataset.filter;
                   const items = document.querySelectorAll('#activityLog .activity-item');

                   items.forEach(item => {
                       if (filter === 'all' || item.dataset.category === filter) {
                           item.style.display = 'flex';
                       } else {
                           item.style.display = 'none';
                       }
                   });
               });
           });
       </script>
   </section>
