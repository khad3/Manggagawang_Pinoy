  <div class="page-section" id="analytics-section" style="display: flex; justify-content: center; width: 90%;">
      <div class="content-section"
          style="max-width: 1200px; width: 100%; padding: 30px; background: #fff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">

          <!-- 🪄 Chart Title -->
          <div class="text-center" style="margin-bottom: 20px;">
              <i class="fas fa-chart-bar fa-3x mb-2" style="color: #4CAF50;"></i>
              <h2 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 8px;">Applicant Status Analytics</h2>
              <p style="color: #666; font-size: 1rem;">Approved vs Rejected Applicants per Job Post & Employer</p>
          </div>

          <!-- 🪄 Chart Container -->
          <div class="chart-container" style="width: 100%; height: 300px; display: flex; justify-content: center;">
              <!-- ⬅️ height reduced -->
              <div id="approvedApplicantsChart" style="width: 90%; height: 100%;"></div>
          </div>
      </div>
  </div>

  <!-- 📊 Google Charts Script -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
      google.charts.load('current', {
          packages: ['corechart']
      });
      google.charts.setOnLoadCallback(drawApprovedApplicantsChart);

      function drawApprovedApplicantsChart() {
          var data = google.visualization.arrayToDataTable([
              ['Job Post (Employer)', 'Approved', 'Rejected'],
              @foreach ($jobPosts as $job)
                  ['{{ $job->title }} ({{ $job->companyName->company_name ?? 'No Employer' }})',
                      {{ $job->approved_count }}, {{ $job->rejected_count }}
                  ],
              @endforeach
          ]);

          var options = {
              title: 'Approved vs Rejected Applicants',
              titleTextStyle: {
                  fontSize: 20,
                  bold: true
              },
              chartArea: {
                  left: '10%',
                  right: '10%',
                  top: 60,
                  bottom: 80,
                  width: '80%',
                  height: '60%'
              },
              hAxis: {
                  title: 'Job Post & Employer',
                  titleTextStyle: {
                      fontSize: 14,
                      bold: true
                  },
                  textStyle: {
                      fontSize: 12
                  },
                  slantedText: true,
                  slantedTextAngle: 25
              },
              vAxis: {
                  title: 'Number of Applicants',
                  titleTextStyle: {
                      fontSize: 14,
                      bold: true
                  },
                  minValue: 0,
                  viewWindow: {
                      min: 0,
                      max: 10 // ✅ set a fixed max to make bar shorter
                  },
                  format: '0',
                  gridlines: {
                      count: -1
                  }
              },
              legend: {
                  position: 'top',
                  alignment: 'center',
                  textStyle: {
                      fontSize: 12
                  }
              },
              colors: ['#4CAF50', '#F44336'],
              bar: {
                  groupWidth: '40%'
              },
              animation: {
                  startup: true,
                  duration: 1000,
                  easing: 'out'
              }
          };

          var chart = new google.visualization.ColumnChart(document.getElementById('approvedApplicantsChart'));
          chart.draw(data, options);

          window.addEventListener('resize', () => chart.draw(data, options));
      }
  </script>
