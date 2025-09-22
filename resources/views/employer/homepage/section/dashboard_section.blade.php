   <div class="page-section active" id="dashboard-section">
       <!-- Statistics Cards -->
       <div class="stats-grid">
           <div class="stat-card">
               <div class="stat-header">
                   <div>
                       <div class="stat-value">128</div>
                       <div class="stat-label">Total Applicants Hired</div>
                   </div>
                   <div class="stat-icon primary">
                       <i class="fas fa-users"></i>
                   </div>
               </div>
           </div>

           <div class="stat-card">
               <div class="stat-header">
                   <div>
                       <div class="stat-value">{{ $JobPostRetrieved->where('status_post', 'published')->count() }}
                       </div>
                       <div class="stat-label">Active Job Posts</div>
                   </div>
                   <div class="stat-icon success">
                       <i class="fas fa-briefcase"></i>
                   </div>
               </div>
           </div>

           <div class="stat-card">
               <div class="stat-header">
                   <div>
                       <div class="stat-value">5</div>
                       <div class="stat-label">Unread Messages</div>
                   </div>
                   <div class="stat-icon warning">
                       <i class="fas fa-envelope"></i>
                   </div>
               </div>
           </div>
       </div>

       <!-- Recent Applicants Section -->
       <div class="content-section">
           <div class="section-header">
               <div class="section-title">
                   <i class="fas fa-clock"></i>
                   Recent Applicants
               </div>
               <div class="section-actions">
                   <button class="btn-modern btn-primary-modern">
                       <i class="fas fa-plus"></i> View All
                   </button>
               </div>
           </div>

           <div class="table-responsive">
               <table class="table modern-table">
                   <thead>
                       <tr>
                           <th>Applicant</th>
                           <th>Position</th>
                           <th>Status</th>
                           <th>Applied Date</th>
                           <th>Actions</th>
                       </tr>
                   </thead>
                   <tbody>
                       <tr>
                           <td>
                               <div class="applicant-info">
                                   <div class="applicant-avatar">JD</div>
                                   <div class="applicant-details">
                                       <h6>Juan Dela Cruz</h6>
                                       <p>juan.delacruz@email.com</p>
                                   </div>
                               </div>
                           </td>
                           <td>Electrician</td>
                           <td><span class="status-badge status-approved">Approved</span></td>
                           <td>July 7, 2025</td>
                           <td>
                               <button class="action-btn primary" title="View">
                                   <i class="fas fa-eye"></i>
                               </button>
                           </td>
                       </tr>
                       <tr>
                           <td>
                               <div class="applicant-info">
                                   <div class="applicant-avatar">AS</div>
                                   <div class="applicant-details">
                                       <h6>Ana Santos</h6>
                                       <p>ana.santos@email.com</p>
                                   </div>
                               </div>
                           </td>
                           <td>Cook</td>
                           <td><span class="status-badge status-pending">Pending</span></td>
                           <td>July 6, 2025</td>
                           <td>
                               <button class="action-btn primary" title="View">
                                   <i class="fas fa-eye"></i>
                               </button>
                           </td>
                       </tr>
                       <tr>
                           <td>
                               <div class="applicant-info">
                                   <div class="applicant-avatar">MR</div>
                                   <div class="applicant-details">
                                       <h6>Mark Reyes</h6>
                                       <p>mark.reyes@email.com</p>
                                   </div>
                               </div>
                           </td>
                           <td>Construction Worker</td>
                           <td><span class="status-badge status-rejected">Rejected</span></td>
                           <td>July 5, 2025</td>
                           <td>
                               <button class="action-btn primary" title="View">
                                   <i class="fas fa-eye"></i>
                               </button>
                           </td>
                       </tr>
                   </tbody>
               </table>
           </div>
       </div>
   </div>
