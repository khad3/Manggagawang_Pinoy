   <section id="reports" class="content-section">
       <div class="section-header">
           <h2 class="section-title">
               <i class="fas fa-chart-line"></i>
               Reports & Analytics
           </h2>

       </div>
       <div class="reports-container">
           <div class="chart-container">
               <h3 class="chart-title">User Registrations</h3>
               <div class="chart-placeholder">
                   <div id="userRegistrationCharts"></div>
               </div>
           </div>

           <script type="text/javascript">
               google.charts.load('current', {
                   packages: ['corechart']
               });
               google.charts.setOnLoadCallback(drawUserChart);

               function drawUserChart() {
                   var data = google.visualization.arrayToDataTable([
                       {!! implode(',', $chartData) !!}
                   ]);

                   var options = {
                       title: 'User Registration Trends',
                       chartArea: {
                           left: 60,
                           top: 50,
                           bottom: 60,
                           width: '90%', // make chart almost full width
                           height: '80%' // make chart almost full height
                       },
                       bar: {
                           groupWidth: '60%'
                       },
                       hAxis: {
                           title: 'Month',
                           textStyle: {
                               fontSize: 14
                           }
                       },
                       vAxis: {
                           title: 'Total Registrations',
                           minValue: 0,
                           gridlines: {
                               count: 5
                           },
                           textStyle: {
                               fontSize: 14
                           },
                           format: '0'
                       },
                       colors: {!! json_encode($colors) !!},
                       legend: {
                           position: 'none'
                       },
                       titleTextStyle: {
                           fontSize: 18,
                           bold: true
                       }
                   };

                   var chart = new google.visualization.ColumnChart(document.getElementById('userRegistrationCharts'));
                   chart.draw(data, options);
               }

               // Optional: redraw on window resize for responsiveness
               window.addEventListener('resize', drawUserChart);
           </script>





           <!-- Account Bans -->
           <div class="chart-container">
               <h3 class="chart-title">Account Bans</h3>
               <div class="chart-placeholder">
                   <div id="accountBanChart"></div>
               </div>
           </div>

           <script type="text/javascript">
               google.charts.setOnLoadCallback(drawBanChart);

               function drawBanChart() {
                   var data = google.visualization.arrayToDataTable([
                       {!! implode(',', $banChartData) !!}
                   ]);

                   var options = {
                       title: 'Banned Accounts (Applicants vs Employers)',
                       chartArea: {
                           left: 60,
                           top: 50,
                           width: '90%',
                           height: '80%'
                       },
                       pieHole: 0.3,
                       colors: {!! json_encode($banColors) !!},
                       legend: {
                           position: 'right',
                           textStyle: {
                               fontSize: 14
                           }
                       },
                       titleTextStyle: {
                           fontSize: 18,
                           bold: true
                       }
                   };

                   var chart = new google.visualization.PieChart(document.getElementById('accountBanChart'));
                   chart.draw(data, options);
               }
               window.addEventListener('resize', drawBanChart);
           </script>

           <!-- Certificate Issuance -->
           <div class="chart-container">
               <h3 class="chart-title">Certificate Issuance</h3>
               <div class="chart-placeholder">
                   <div id="certificationLineChart"></div>
               </div>
           </div>

           <script type="text/javascript">
               google.charts.setOnLoadCallback(drawCertChart);

               function drawCertChart() {
                   var data = google.visualization.arrayToDataTable([
                       {!! implode(',', $certificationsChartData) !!}
                   ]);

                   var options = {
                       title: 'Certification Status Trends',
                       curveType: 'function',
                       chartArea: {
                           left: 60,
                           top: 50,
                           width: '90%',
                           height: '80%'
                       },
                       hAxis: {
                           title: 'Month',
                           slantedText: true,
                           slantedTextAngle: 45,
                           textStyle: {
                               fontSize: 14
                           }
                       },
                       vAxis: {
                           title: 'Number of Certifications',
                           minValue: 0,
                           format: '0',
                           textStyle: {
                               fontSize: 14
                           }
                       },
                       colors: {!! json_encode($certificationsColors) !!},
                       legend: {
                           position: 'bottom',
                           textStyle: {
                               fontSize: 14
                           }
                       },
                       titleTextStyle: {
                           fontSize: 18,
                           bold: true
                       }
                   };

                   var chart = new google.visualization.LineChart(document.getElementById('certificationLineChart'));
                   chart.draw(data, options);
               }
               window.addEventListener('resize', drawCertChart);
           </script>

           <!-- Suspended Accounts -->
           <div class="chart-container">
               <h3 class="chart-title">Suspended Accounts</h3>
               <div class="chart-placeholder">
                   <div id="suspendedAccountChart"></div>
               </div>
           </div>

           <script type="text/javascript">
               google.charts.setOnLoadCallback(drawSuspendedChart);

               function drawSuspendedChart() {
                   var data = google.visualization.arrayToDataTable([
                       {!! implode(',', $suspendedChartData) !!}
                   ]);

                   var options = {
                       title: 'Suspended Accounts (Applicants vs Employers)',
                       chartArea: {
                           left: 60,
                           top: 50,
                           width: '90%',
                           height: '80%'
                       },
                       pieHole: 0.3,
                       colors: {!! json_encode($suspendedColors) !!},
                       legend: {
                           position: 'right',
                           textStyle: {
                               fontSize: 14
                           }
                       },
                       titleTextStyle: {
                           fontSize: 18,
                           bold: true
                       }
                   };

                   var chart = new google.visualization.PieChart(document.getElementById('suspendedAccountChart'));
                   chart.draw(data, options);
               }
               window.addEventListener('resize', drawSuspendedChart);
           </script>

           <!-- Recent Activity Log -->
           <!-- Recent Activity Log -->
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



       </div>
   </section>
