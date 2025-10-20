  <section id="dashboard" class="content-section active">
      <div class="stats-grid">
          <div class="stat-card users">
              <div class="stat-card-content">
                  <div class="stat-info">
                      <h3 id="totalUsers">{{ $totalUsers ?? 0 }}</h3>
                      <p>Total Users</p>
                  </div>
                  <div class="stat-icon">
                      <i class="fas fa-users"></i>
                  </div>
              </div>
              <div class="stat-change">
                  <i class="fas fa-trending-up"></i>
                  {{ round($percentageGrowth, 1) }}% this month
              </div>
          </div>

          <div class="stat-card employers">
              <div class="stat-card-content">
                  <div class="stat-info">
                      <h3 id="totalEmployers">{{ $employerCount ?? 0 }}</h3>
                      <p>Employers</p>
                  </div>
                  <div class="stat-icon">
                      <i class="fas fa-building"></i>
                  </div>
              </div>
              <div class="stat-change {{ $employersTrendingUp ? 'text-success' : 'text-danger' }}">
                  <i class="fas {{ $employersTrendingUp ? 'fa-trending-up' : 'fa-trending-down' }}"></i>
                  {{ $employersTrendingUp ? '+' : '-' }}{{ number_format(abs($employerChange), 1) }}% this
                  month
              </div>
          </div>

          <div class="stat-card applicants">
              <div class="stat-card-content">
                  <div class="stat-info">
                      <h3 id="totalApplicants">{{ $applicantsCount }}</h3>
                      <p>Job Applicants</p>
                  </div>
                  <div class="stat-icon">
                      <i class="fas fa-user-graduate"></i>
                  </div>
              </div>
              <div class="stat-change {{ $isTrendingUp ? 'text-success' : 'text-danger' }}">
                  <i class="fas {{ $isTrendingUp ? 'fa-trending-up' : 'fa-trending-down' }}"></i>
                  {{ $isTrendingUp ? '+' : '-' }}{{ number_format(abs($change), 1) }}% this month
              </div>

          </div>

          <div class="stat-card certificates">
              <div class="stat-card-content">
                  <div class="stat-info">
                      <h3 id="totalCertificates">{{ $totalIssueCertifications ?? 0 }}</h3>
                      <p>Certificates Issued</p>
                  </div>
                  <div class="stat-icon">
                      <i class="fas fa-certificate"></i>
                  </div>
              </div>
              <div class="stat-change {{ $percentageChange >= 0 ? 'text-success' : 'text-danger' }}">
                  <i class="fas fa-trending-{{ $percentageChange >= 0 ? 'up' : 'down' }}"></i>
                  {{ $percentageChange >= 0 ? '+' : '' }}{{ $percentageChange }}% this month
              </div>
          </div>

          <div class="stat-card officers">
              <div class="stat-card-content">
                  <div class="stat-info">
                      <h3 id="totalOfficers">{{ $tesdaOfficersCount ?? 0 }}</h3>
                      <p>TESDA Officers</p>
                  </div>
                  <div class="stat-icon">
                      <i class="fas fa-user-tie"></i>
                  </div>
              </div>
              <div class="stat-change">
                  <i class="fas fa-trending-up"></i>
                  +{{ $newTesdaOfficers ?? 0 }} new
              </div>
          </div>

          <div class="stat-card announcements">
              <div class="stat-card-content">
                  <div class="stat-info">
                      <h3 id="totalAnnouncements">{{ $retrieveAnnouncementsTotal }}</h3>
                      <p>Announcements</p>
                  </div>
                  <div class="stat-icon">
                      <i class="fas fa-bullhorn"></i>
                  </div>
              </div>
              <div class="stat-change">
                  <i class="fas fa-trending-up"></i>
                  {{ $weeklyAnnouncements }}+ this week
              </div>
          </div>
      </div>

      <div class="chart-container">
          <h3 class="chart-title">User Registration Trends</h3>
          <div class="chart-placeholder">
              <div id="userRegistrationChart" style="width: 100%; height: 400px;"></div>
          </div>
      </div>

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
                  document.getElementById('userRegistrationChart')
              );
              chart.draw(data, options);
          }
      </script>
  </section>
