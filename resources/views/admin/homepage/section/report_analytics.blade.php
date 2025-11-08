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

           </ <!-- Recent Activity Log -->
           <div class="report-card" style="grid-column: 1 / -1;">
               <div class="report-card-header">
                   <h3 class="report-title">Recent Activity logs</h3>
                   <div class="report-actions">
                       <button class="action-btn btn-view" title="View All">
                           <i class="fas fa-list"></i>
                       </button>
                   </div>
               </div>
               <!--- Activity logs status --->
               <div id="activityLog">
                   @foreach ($activityLogs as $log)
                       <div class="activity-item">
                           <div class="activity-icon activity-{{ $log['action'] }}">
                               @if ($log['action'] === 'banned')
                                   <i class="fa-solid fa-ban"></i>
                               @elseif($log['action'] === 'unbanned')
                                   <i class="fas fa-check"></i>
                               @elseif($log['action'] === 'suspended')
                                   <i class="fas fa-pause"></i>
                               @elseif($log['action'] === 'post')
                                   <i class="fas fa-bullhorn"></i>
                               @elseif($log['action'] === 'login')
                                   <i class="fas fa-sign-in-alt"></i>
                               @elseif($log['action'] === 'created_account')
                                   <i class="fas fa-user-plus"></i>
                               @elseif($log['action'] === 'upload_certification')
                                   <i class="fas fa-certificate" style="color: gold;"></i>
                               @elseif($log['action'] === 'approved_certification')
                                   <i class="bi bi-patch-check-fill" style="color: green;"></i>
                               @elseif($log['action'] === 'rejected_certification')
                                   <i class="bi bi-patch-minus-fill" style="color: red;"></i>
                               @elseif($log['action'] === 'request_revision_certification')
                                   <i class="bi bi-patch-exclamation-fill" style="color: orange;"></i>
                               @elseif($log['action'] === 'apply_job')
                                   <i class="bi bi-file-earmark-person-fill" style="color:brown;"></i>
                               @elseif($log['action'] === 'reject_job')
                                   <i class="bi bi-x-circle-fill text-danger" style="color:red;"></i>
                               @elseif($log['action'] === 'post_announcement')
                                   <i class="bi bi-megaphone-fill" style="color:green"></i>
                               @elseif($log['action'] === 'report_job')
                                   <i class="bi bi-flag-fill" style="color:darkred"></i>
                               @elseif($log['action'] === 'report_applicant')
                                   <i class="bi bi-flag-fill" style="color:darkred"></i>
                               @elseif($log['action'] === 'approved_job')
                                   <i class="bi bi-patch-check-fill" style="color:green;"></i>
                               @elseif($log['action'] === 'published_job')
                                   <i class="bi bi-briefcase-fill text-success"></i>
                               @elseif($log['action'] === 'draft_job')
                                   <i class="bi bi-briefcase text-warning"></i>
                               @elseif($log['action'] === 'interview_job')
                                   <i class="fas fa-calendar text-info-balanced me-1" style="color: blue;"></i>
                               @elseif($log['action'] === 'send_rating_to_job_post')
                                   <i class="bi bi-star-fill" style="color: gold;"></i>
                               @elseif($log['action'] === 'send_rating_to_applicant')
                                   <i class="bi bi-star-fill" style="color: gold;"></i>
                               @endif
                           </div>
                           <div class="activity-content">
                               @php
                                   $adminActions = ['banned', 'unbanned', 'suspended', 'post_announcement'];

                                   // Convert action to professional label
                                   $actionLabel = ucwords(str_replace('_', ' ', $log['action']));
                               @endphp

                               @if (in_array($log['action'], $adminActions))
                                   <h6>Admin {{ $actionLabel }}</h6>
                               @else
                                   <h6>User {{ $actionLabel }}</h6>
                               @endif

                               <p>{!! $log['description'] !!}</p>

                               {{-- Display attachment as a button if exists --}}
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
       </div>
   </section>
