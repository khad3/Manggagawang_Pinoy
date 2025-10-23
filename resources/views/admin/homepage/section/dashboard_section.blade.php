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



      @php
          // ✅ Example dummy data for approved hires this year
          $chartData = [
              "['Month', 'Approved Hires']",
              "['January', 8]",
              "['February', 14]",
              "['March', 22]",
              "['April', 19]",
              "['May', 25]",
              "['June', 21]",
              "['July', 28]",
              "['August', 32]",
              "['September', 30]",
              "['October', 35]",
              "['November', 40]",
              "['December', 45]",
          ];

          // 🎨 Chart color (you can change it if you like)
          $colors = ['#2196F3']; // blue tone
      @endphp

      <div class="chart-container">
          <h3 class="chart-title">Approved Hires Per Month</h3>
          <div class="chart-placeholder">
              <div id="approvedHiresChart" style="width: 100%; height: 400px;"></div>
          </div>
      </div>

      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript">
          google.charts.load('current', {
              packages: ['corechart']
          });
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {
              // ✅ Convert PHP data into Google Chart format
              var data = google.visualization.arrayToDataTable([
                  {!! implode(',', $chartData) !!}
              ]);

              // ✅ Chart configuration
              var options = {
                  title: 'Approved Hires Per Month (2025)',
                  chartArea: {
                      width: '70%'
                  },
                  hAxis: {
                      title: 'Month'
                  },
                  vAxis: {
                      title: 'Total Approved Hires',
                      minValue: 0,
                      gridlines: {
                          count: 5
                      },
                      format: '0'
                  },
                  colors: {!! json_encode($colors) !!}
              };

              // ✅ Draw the chart
              var chart = new google.visualization.ColumnChart(
                  document.getElementById('approvedHiresChart')
              );
              chart.draw(data, options);
          }
      </script>

      @php
          // ✅ Dummy data for Top 10 Jobs (Approved Applicants)
          $chartData = [
              "['Job Title', 'Approved Applicants']",
              "['Software Developer', 48]",
              "['Graphic Designer', 36]",
              "['Customer Support', 33]",
              "['Web Developer', 30]",
              "['Data Analyst', 27]",
              "['IT Technician', 25]",
              "['Marketing Assistant', 22]",
              "['Accountant', 20]",
              "['HR Coordinator', 18]",
              "['Delivery Driver', 15]",
          ];

          // 🎨 Example color palette
          $colors = ['#FF9800']; // orange tone
      @endphp

      <div class="chart-container">
          <h3 class="chart-title">Top 10 Jobs with Most Approved Applicants</h3>
          <div class="chart-placeholder">
              <div id="topJobsChart" style="width: 100%; height: 400px;"></div>
          </div>
      </div>

      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript">
          google.charts.load('current', {
              packages: ['corechart']
          });
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {
              // ✅ Convert PHP data into chart format
              var data = google.visualization.arrayToDataTable([
                  {!! implode(',', $chartData) !!}
              ]);

              // ✅ Chart options
              var options = {
                  title: 'Top 10 Jobs with Most Approved Applicants (2025)',
                  chartArea: {
                      width: '70%'
                  },
                  hAxis: {
                      title: 'Job Title'
                  },
                  vAxis: {
                      title: 'Approved Applicants',
                      minValue: 0,
                      gridlines: {
                          count: 5
                      },
                      format: '0'
                  },
                  colors: {!! json_encode($colors) !!},
                  bar: {
                      groupWidth: '60%'
                  },
              };

              // ✅ Draw chart
              var chart = new google.visualization.ColumnChart(
                  document.getElementById('topJobsChart')
              );
              chart.draw(data, options);
          }
      </script>

      @php
          // ✅ Dummy data for applicants by location
          $locationChartData = [
              "['Location', 'Total Applicants']",
              "['Indang', 40]",
              "['Silang', 55]",
              "['Dasmariñas', 60]",
              "['Trece Martires', 35]",
              "['General Trias', 45]",
              "['Tagaytay', 25]",
              "['Amadeo', 20]",
              "['Carmona', 30]",
              "['Alfonso', 15]",
              "['Mendez', 10]",
          ];

          // 🎨 Chart color (green tone)
          $locationColors = ['#4CAF50'];
      @endphp

      <div class="chart-container">
          <h3 class="chart-title">Applicants by Location</h3>
          <div class="chart-placeholder">
              <div id="applicantsByLocationChart" style="width: 100%; height: 400px;"></div>
          </div>
      </div>

      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript">
          google.charts.load('current', {
              packages: ['corechart']
          });
          google.charts.setOnLoadCallback(drawLocationChart);

          function drawLocationChart() {
              var data = google.visualization.arrayToDataTable([
                  {!! implode(',', $locationChartData) !!}
              ]);

              var options = {
                  title: 'Applicants by Location (2025)',
                  chartArea: {
                      width: '70%'
                  },
                  hAxis: {
                      title: 'Location'
                  },
                  vAxis: {
                      title: 'Total Applicants',
                      minValue: 0,
                      gridlines: {
                          count: 5
                      }
                  },
                  colors: {!! json_encode($locationColors) !!}
              };

              var chart = new google.visualization.ColumnChart(
                  document.getElementById('applicantsByLocationChart')
              );
              chart.draw(data, options);
          }
      </script>

      @php
          // 🏢 Dummy data for employers by location
          $employerLocationChartData = [
              "['Location', 'Number of Employers']",
              "['Indang', 8]",
              "['Silang', 12]",
              "['Dasmariñas', 15]",
              "['Trece Martires', 9]",
              "['General Trias', 10]",
              "['Tagaytay', 6]",
              "['Amadeo', 4]",
              "['Carmona', 7]",
              "['Alfonso', 5]",
              "['Mendez', 3]",
          ];

          // 🎨 Chart color (purple tone)
          $employerLocationColors = ['#9C27B0'];
      @endphp

      <div class="chart-container">
          <h3 class="chart-title">Employers by Location</h3>
          <div class="chart-placeholder">
              <div id="employersByLocationChart" style="width: 100%; height: 400px;"></div>
          </div>
      </div>

      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript">
          google.charts.load('current', {
              packages: ['corechart']
          });
          google.charts.setOnLoadCallback(drawEmployersByLocationChart);

          function drawEmployersByLocationChart() {
              // ✅ Convert Blade array to chart data
              var data = google.visualization.arrayToDataTable([
                  {!! implode(',', $employerLocationChartData) !!}
              ]);

              // ✅ Chart setup
              var options = {
                  title: 'Employers by Location (2025)',
                  chartArea: {
                      width: '70%'
                  },
                  hAxis: {
                      title: 'Location'
                  },
                  vAxis: {
                      title: 'Number of Employers',
                      minValue: 0,
                      gridlines: {
                          count: 5
                      },
                      format: '0'
                  },
                  colors: {!! json_encode($employerLocationColors) !!}
              };

              // ✅ Draw chart
              var chart = new google.visualization.ColumnChart(
                  document.getElementById('employersByLocationChart')
              );
              chart.draw(data, options);
          }
      </script>

      @php
          // 📈 Dummy data for employment rate by location (percentage of applicants hired)
          $employmentRateChartData = [
              "['Location', 'Employment Rate (%)']",
              "['Silang', 85]",
              "['Dasmariñas', 80]",
              "['General Trias', 75]",
              "['Indang', 70]",
              "['Trece Martires', 65]",
              "['Carmona', 60]",
              "['Tagaytay', 55]",
              "['Amadeo', 50]",
              "['Alfonso', 45]",
              "['Mendez', 40]",
          ];

          // 🎨 Chart color (gold tone)
          $employmentRateColors = ['#FFC107']; // amber
      @endphp

      <div class="chart-container">
          <h3 class="chart-title">Employment Rate by Location</h3>
          <div class="chart-placeholder">
              <div id="employmentRateChart" style="width: 100%; height: 400px;"></div>
          </div>
      </div>

      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript">
          google.charts.load('current', {
              packages: ['corechart']
          });
          google.charts.setOnLoadCallback(drawEmploymentRateChart);

          function drawEmploymentRateChart() {
              // ✅ Convert Blade array to Google Chart data
              var data = google.visualization.arrayToDataTable([
                  {!! implode(',', $employmentRateChartData) !!}
              ]);

              // ✅ Chart setup
              var options = {
                  title: 'Employment Rate by Location (2025)',
                  chartArea: {
                      width: '70%'
                  },
                  hAxis: {
                      title: 'Location'
                  },
                  vAxis: {
                      title: 'Employment Rate (%)',
                      minValue: 0,
                      maxValue: 100,
                      gridlines: {
                          count: 5
                      },
                      format: '#\'%\''
                  },
                  colors: {!! json_encode($employmentRateColors) !!}
              };

              // ✅ Draw chart
              var chart = new google.visualization.ColumnChart(
                  document.getElementById('employmentRateChart')
              );
              chart.draw(data, options);
          }
      </script>


  </section>
