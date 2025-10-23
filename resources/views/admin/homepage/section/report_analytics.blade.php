   <section id="reports" class="content-section">
       <div class="section-header">
           <h2 class="section-title">
               <i class="fas fa-chart-line"></i>
               Reports & Analytics
           </h2>
           <button class="btn btn-primary" onclick="generateReport()">
               <i class="fas fa-download"></i>
               Generate Report
           </button>
       </div>
       <div class="reports-container">
           <!-- <div class="reports-header">
                        <div class="report-filters">
                            <div class="filter-group">
                                <label>Time Period:</label>
                                <select class="filter-select" id="timePeriod">
                                    <option value="7days">Last 7 Days</option>
                                    <option value="30days" selected>Last 30 Days</option>
                                    <option value="90days">Last 90 Days</option>
                                    <option value="1year">Last Year</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>User Type:</label>
                                <select class="filter-select" id="userType">
                                    <option value="all">All Users</option>
                                    <option value="applicants">Applicants</option>
                                    <option value="employers">Employers</option>
                                </select>
                            </div>
                        </div>
                    </div> -->

           <div class="reports-grid">
               <!-- User trends report Card -->
               <div class="report-card">
                   <div class="report-card-header">
                       <h3 class="report-title">User Registrations</h3>
                   </div>

                   <!-- Show total registrations -->
                   <div class="report-metric">
                       {{ $totalUsers }}
                   </div>

                   <!-- Static trend placeholder (can be made dynamic later) -->
                   <!-- <div class="report-change">
                                <i class="fas fa-trending-up text-success"></i>
                                +18.2% from last period
                            </div> -->

                   <!-- Chart Container -->
                   <div class="chart-container mt-3">
                       <div id="userRegistrationCharts" style="width: 100%; height: 400px;"></div>
                   </div>
               </div>

               <!-- Google Charts Script -->
               <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
               <script type="text/javascript">
                   google.charts.load('current', {
                       packages: ['corechart']
                   });
                   google.charts.setOnLoadCallback(drawChart);

                   function drawChart() {
                       var data = google.visualization.arrayToDataTable([
                           {!! implode(',', $chartData) !!}
                       ]);

                       var options = {
                           title: 'User Registration Trends',
                           chartArea: {
                               width: '70%'
                           },
                           hAxis: {
                               title: 'Month'
                           },
                           vAxis: {
                               title: 'Total Registrations',
                               minValue: 0,
                               gridlines: {
                                   count: 5
                               },
                               format: '0'
                           },
                           colors: {!! json_encode($colors) !!}
                       };

                       var chart = new google.visualization.ColumnChart(
                           document.getElementById('userRegistrationCharts')
                       );
                       chart.draw(data, options);
                   }
               </script>






               <div class="report-card">
                   <div class="report-card-header">
                       <h3 class="report-title">Account Bans</h3>
                   </div>

                   {{-- Show total bans (Applicants + Employers) --}}
                   <div class="report-metric">
                       {{ $retrieveAccountBanApplicant + $retrieveAccountBanEmployer }}
                   </div>

                   {{-- Static trend placeholder (can be made dynamic later) --}}
                   <!-- <div class="report-change">
                                <i class="fas fa-trending-down text-danger"></i>
                                -12.8% from last period
                            </div> -->

                   <!-- Chart Container -->
                   <div class="chart-container mt-3">
                       <div id="accountBanChart" style="width: 100%; height: 400px;"></div>
                   </div>
               </div>

               <!-- Google Charts Script -->
               <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
               <script type="text/javascript">
                   google.charts.load('current', {
                       packages: ['corechart']
                   });
                   google.charts.setOnLoadCallback(drawBanChart);

                   function drawBanChart() {
                       var data = google.visualization.arrayToDataTable([
                           {!! implode(',', $banChartData) !!}
                       ]);

                       var options = {
                           title: 'Banned Accounts (Applicants vs Employers)',
                           chartArea: {
                               width: '100%'
                           },
                           pieHole: 0.3,
                           colors: {!! json_encode($banColors) !!},
                           legend: {
                               position: 'top',
                               alignment: 'center'
                           }
                       };

                       var chart = new google.visualization.PieChart(
                           document.getElementById('accountBanChart')
                       );
                       chart.draw(data, options);
                   }
               </script>


               <div class="report-card">
                   <div class="report-card-header d-flex justify-content-between align-items-center">
                       <h3 class="report-title">Certificate Issuance</h3>
                       <div
                           class="report-change text-end {{ $percentageChange >= 0 ? 'text-success' : 'text-danger' }}">
                           <i class="fas fa-trending-{{ $percentageChange >= 0 ? 'up' : 'down' }}"></i>
                           {{ $percentageChange >= 0 ? '+' : '' }}{{ $percentageChange }}% from last month
                       </div>
                   </div>

                   <!-- Chart Container -->
                   <div id="certificationLineChart" style="width: 100%; height: 400px;"></div>

                   <!-- Total Metric -->
                   <div class="d-flex justify-content-between align-items-center mt-2">
                       <div class="report-metric">{{ $totalIssueCertifications ?? 0 }}</div>

                       <!-- Legend -->
                       <div class="custom-legend">
                           <span>
                               <span class="legend-box" style="background-color: {{ $certificationsColors[0] }}"></span>
                               Approved
                           </span>
                           <span>
                               <span class="legend-box" style="background-color: {{ $certificationsColors[1] }}"></span>
                               Pending
                           </span>
                           <span>
                               <span class="legend-box" style="background-color: {{ $certificationsColors[2] }}"></span>
                               Rejected
                           </span>
                           <span>
                               <span class="legend-box"
                                   style="background-color: {{ $certificationsColors[3] }}"></span>
                               Request Revision
                           </span>
                       </div>
                   </div>
               </div>

               <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
               <script type="text/javascript">
                   google.charts.load('current', {
                       packages: ['corechart']
                   });
                   google.charts.setOnLoadCallback(drawCertChart);

                   function drawCertChart() {
                       var data = google.visualization.arrayToDataTable([
                           {!! implode(',', $certificationsChartData) !!}
                       ]);

                       var options = {
                           title: 'Certification Status Trends',
                           curveType: 'function',
                           legend: {
                               position: 'none'
                           }, //  Hide default legend
                           chartArea: {
                               width: '80%',
                               height: '70%'
                           },
                           colors: {!! json_encode($certificationsColors) !!},
                           hAxis: {
                               title: 'Month',
                               slantedText: true,
                               slantedTextAngle: 45
                           },
                           vAxis: {
                               title: 'Number of Certifications',
                               minValue: 0,
                               format: '0'
                           }
                       };

                       var chart = new google.visualization.LineChart(
                           document.getElementById('certificationLineChart')
                       );
                       chart.draw(data, options);
                   }
               </script>




               <div class="report-card">
                   <div class="report-card-header">
                       <h3 class="report-title">Suspended Accounts</h3>
                   </div>

                   <!-- Show total suspended accounts -->
                   <div class="report-metric">
                       {{ $retrievedSuspendedApplicants + $retrievedSuspendedEmployers }}
                   </div>

                   <!-- Static trend placeholder -->
                   <div class="report-change">
                       <i class="fas fa-trending-up text-warning"></i>
                       <!-- +3.4% from last period -->
                   </div>

                   <!-- Chart Container -->
                   <div class="chart-container mt-3">
                       <div id="suspendedAccountChart" style="width: 100%; height: 400px;"></div>
                   </div>
               </div>

               <!-- Google Charts Script -->
               <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
               <script type="text/javascript">
                   google.charts.load('current', {
                       packages: ['corechart']
                   });
                   google.charts.setOnLoadCallback(drawSuspendedChart);

                   function drawSuspendedChart() {
                       var data = google.visualization.arrayToDataTable([
                           {!! implode(',', $suspendedChartData) !!}
                       ]);

                       var options = {
                           title: 'Suspended Accounts (Applicants vs Employers)',
                           chartArea: {
                               width: '100%'
                           },
                           pieHole: 0.3, // donut chart
                           colors: {!! json_encode($suspendedColors) !!},
                           legend: {
                               position: 'top',
                               alignment: 'center'
                           }
                       };

                       var chart = new google.visualization.PieChart(
                           document.getElementById('suspendedAccountChart')
                       );
                       chart.draw(data, options);
                   }
               </script>


           </div>

           <!-- Recent Activity Log -->
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
