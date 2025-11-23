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



       </div>
   </section>
