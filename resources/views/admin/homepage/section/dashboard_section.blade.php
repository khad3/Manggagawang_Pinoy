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

      <!---- User Registration Trends --->
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
                      width: '70%',
                      height: '40%'
                  },
                  bar: {
                      groupWidth: '45%'
                  }, // thinner bars → more space between months
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



      <!----Approved Applicants Per Month---->
      <!-- Chart Container -->
      <div class="chart-container">
          <h3 class="chart-title">Approved Applicants Per Month</h3>
          <div class="chart-placeholder">
              <div id="approvedApplicantsChart" style="width: 100%; height: 350px;"></div>
          </div>
      </div>

      <!--  Google Charts Script -->
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript">
          google.charts.load('current', {
              packages: ['corechart']
          });
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {
              // Data
              var data = google.visualization.arrayToDataTable([
                  {!! implode(',', $approvedChartData) !!}
              ]);

              // Options
              var options = {
                  title: 'Approved Applicants Per Month (2025)',
                  chartArea: {
                      width: '70%',
                      height: '40%'
                  },
                  bar: {
                      groupWidth: '45%'
                  }, // thinner bars → more space between months
                  hAxis: {
                      title: 'Month',
                      textStyle: {
                          fontSize: 11
                      }
                  },
                  vAxis: {
                      title: 'Total Approved Applicants',
                      minValue: 0,
                      gridlines: {
                          count: 5
                      },
                      textStyle: {
                          fontSize: 11
                      },
                      format: '0'
                  },
                  colors: {!! json_encode($Approvedcolors) !!},
                  legend: {
                      position: 'none'
                  },
                  titleTextStyle: {
                      fontSize: 15
                  }
              };

              // Draw the chart
              var chart = new google.visualization.ColumnChart(
                  document.getElementById('approvedApplicantsChart')
              );
              chart.draw(data, options);
          }
      </script>

      <!---- Top 10 Jobs with Most Hired Applicants --->
      <div class="chart-container">
          <h3 class="chart-title">Top 10 Jobs with Most Hired Applicants</h3>
          <div class="chart-placeholder">
              <!--  Reduced chart height -->
              <div id="topJobsChart" style="width: 100%; height: 300px;"></div>
          </div>
      </div>

      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript">
          google.charts.load('current', {
              packages: ['corechart']
          });
          google.charts.setOnLoadCallback(drawTopJobsChart);

          function drawTopJobsChart() {

              var data = google.visualization.arrayToDataTable([
                  {!! implode(',', $topJobsChartData) !!}
              ]);

              var options = {
                  title: 'Top 10 Jobs with Most Hired Applicants (2025)',
                  chartArea: {
                      width: '70%',
                      height: '40%'
                  }, // controls chart area
                  bar: {
                      groupWidth: '15%'
                  }, // smaller bar width
                  hAxis: {
                      title: 'Job Title',
                      textStyle: {
                          fontSize: 10
                      },
                      slantedText: true,
                      slantedTextAngle: 45
                  },
                  vAxis: {
                      title: 'Hired Applicants',
                      minValue: 0,
                      gridlines: {
                          count: 5
                      },
                      textStyle: {
                          fontSize: 10
                      },
                      format: '0'
                  },
                  colors: {!! json_encode($topJobsColors) !!},
                  legend: {
                      position: 'none'
                  },
                  titleTextStyle: {
                      fontSize: 14
                  }
              };


              var chart = new google.visualization.ColumnChart(
                  document.getElementById('topJobsChart')
              );
              chart.draw(data, options);
          }
      </script>


      <!--- Hired Applicants by Location ---->
      <div class="chart-container">
          <h3 class="chart-title">Hired Applicants by Location</h3>
          <div class="chart-placeholder">
              <div id="approvedByLocationChart" style="width: 100%; height: 350px;"></div>
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
                  {!! implode(',', $locationChartData) !!}
              ]);

              var options = {
                  title: 'Hired Applicants by Location (2025)',
                  chartArea: {
                      width: '70%',
                      height: '40%'
                  },
                  bar: {
                      groupWidth: '15%'
                  }, // thinner bars
                  hAxis: {
                      title: 'City',
                      textStyle: {
                          fontSize: 11
                      },
                      slantedText: true,
                      slantedTextAngle: 30 // tilt labels for readability
                  },
                  vAxis: {
                      title: 'Approved Applicants',
                      minValue: 0,
                      gridlines: {
                          count: 5
                      },
                      textStyle: {
                          fontSize: 11
                      },
                      format: '0'
                  },
                  colors: {!! json_encode($locationColors) !!},
                  legend: {
                      position: 'none'
                  },
                  titleTextStyle: {
                      fontSize: 14
                  }
              };

              var chart = new google.visualization.ColumnChart(
                  document.getElementById('approvedByLocationChart')
              );
              chart.draw(data, options);
          }
      </script>

      <!--- Jobs Posted by Employers per Location --->
      <div class="chart-container">
          <h3 class="chart-title">Jobs Posted by Employers per Location</h3>
          <div class="chart-placeholder">
              <div id="jobsByLocationChart" style="width: 100%; height: 350px;"></div>
          </div>
      </div>

      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript">
          google.charts.load('current', {
              packages: ['corechart']
          });
          google.charts.setOnLoadCallback(drawJobsByLocationChart);

          function drawJobsByLocationChart() {
              var data = google.visualization.arrayToDataTable([
                  {!! implode(',', $jobsLocationChartData) !!}
              ]);

              var options = {
                  title: 'Jobs Posted by Employers per Location (2025)',
                  chartArea: {
                      width: '70%',
                      height: '40%'
                  },
                  bar: {
                      groupWidth: '15%'
                  },
                  hAxis: {
                      title: 'City',
                      textStyle: {
                          fontSize: 11
                      },
                      slantedText: true,
                      slantedTextAngle: 30
                  },
                  vAxis: {
                      title: 'Jobs Posted',
                      minValue: 0,
                      gridlines: {
                          count: 5
                      },
                      textStyle: {
                          fontSize: 11
                      },
                      format: '0'
                  },
                  colors: {!! json_encode($jobsLocationColors) !!},
                  legend: {
                      position: 'none'
                  },
                  titleTextStyle: {
                      fontSize: 14
                  }
              };

              var chart = new google.visualization.ColumnChart(
                  document.getElementById('jobsByLocationChart')
              );
              chart.draw(data, options);
          }
      </script>

      <!---Employement Rate by Employer City--->
      <div class="chart-container">
          <h3 class="chart-title">Employment Rate by Employer City</h3>
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

              var data = google.visualization.arrayToDataTable([
                  {!! implode(',', $employmentRateChartData) !!}
              ]);

              var options = {
                  title: 'Employment Rate by Employer City (2025)',
                  chartArea: {
                      width: '70%'
                  },
                  bar: {
                      groupWidth: '15%'
                  },
                  hAxis: {
                      title: 'City'
                  },
                  vAxis: {
                      title: 'Employment Rate (%)',
                      minValue: 0,
                      maxValue: 100,
                      format: '#\'%\'',
                      gridlines: {
                          count: 5
                      }
                  },
                  colors: {!! json_encode($employmentRateColors) !!},
                  legend: {
                      position: 'none'
                  }
              };

              var chart = new google.visualization.ColumnChart(
                  document.getElementById('employmentRateChart')
              );
              chart.draw(data, options);


              google.visualization.events.addListener(chart, 'select', function() {
                  var selection = chart.getSelection();
                  if (selection.length > 0) {
                      var row = selection[0].row;
                      var city = data.getValue(row, 0);
                      var approved = data.getValue(row, 2); // approved count column
                      alert('📍 ' + city + '\n Approved Applicants: ' + approved);
                  }
              });
          }
      </script>







  </section>
