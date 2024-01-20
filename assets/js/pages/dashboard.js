"use strict";

$(document).ready(function() {
  var domain_traffic_overview_chart = document.getElementById("last_seven_days_domain_traffic").getContext("2d");
  var domain_traffic_chart_color = domain_traffic_overview_chart.createLinearGradient(0, 0, 0, 230);
  domain_traffic_chart_color.addColorStop(0, 'rgba(31, 8, 255, 0.8)');
  domain_traffic_chart_color.addColorStop(1, 'rgba(31, 8, 255, 0.3)');
  var domain_traffic_overview_bar = new Chart(domain_traffic_overview_chart, {
      data: {
          labels: last_seven_days_domains_labels,
          datasets: [{
              type: 'line',
              label: numberof_search,
              data: last_seven_days_domains_values,
              borderColor: 'transparent',
              backgroundColor: domain_traffic_chart_color,
              pointBackgroundColor: '#7224ff',
              borderWidth:0,
              pointRadius: 4,
              pointHoverRadius: 2
          }]
      },
      options: {
          responsive: true,
          title: {
            display: true,
            text: seven_days_text,
            fontSize:14,
            lineHeight: 2,
              
          },
          maintainAspectRatio: true,
          scales: {
            yAxes: [{
                gridLines: {
                  display: false,
                  color: '#f2f2f2',
                },
                ticks: {
                    beginAtZero: true,
                    //suggestedMax: 5,        
                    fontColor: "#686868",
                    stepSize: domain_traffic_chart_step_size,
                    maxTicksLimit: 15
                },
            }],
            xAxes: [{
                gridLines: {
                  display: false,
                  tickMarkLength: 15
                },
            }]
          },
          legend: {
            display: false,
            position: 'top'
          },
      }
  });


  var email_chart = document.getElementById("last_30_days_emails").getContext('2d');

  var email_chart_bgcolor = email_chart.createLinearGradient(0, 0, 0, 70);
  email_chart_bgcolor.addColorStop(0, 'rgba(21, 233, 255, .3)');
  email_chart_bgcolor.addColorStop(1, 'rgba(21, 151, 229, 0)');

  var gradient_primary = email_chart.createLinearGradient(0, 0, 0, 600);
  gradient_primary.addColorStop(0, 'rgba(13, 139, 241)');
  gradient_primary.addColorStop(1, 'rgba(7, 65, 204)'); 

  var gradient_warning = email_chart.createLinearGradient(0, 0, 0, 600);
  gradient_warning.addColorStop(0, 'rgba(252, 74, 26)');
  gradient_warning.addColorStop(1, 'rgba(247, 183, 51)'); 


  var subscribers_myChart = new Chart(email_chart, {
    type: 'bar',
    data: {
      labels: last_30_days_emails_labels,
      datasets: [{
       label: total_download_text,
       type:'line',
       backgroundColor: 'transparent',
       borderColor: gradient_warning,
       data: last_30_days_download_values,
       pointBorderWidth: 0,
       pointRadius: 0,
       pointBackgroundColor: 'transparent',
       pointHoverRadius: 0
     },{
       label: total_email_text,
       backgroundColor: gradient_primary,
       borderColor: 'transparent',
       data: last_30_days_emails_values,
       pointHoverRadius: 0
     }
     ]
    },
    options: {
      title: {
          display: true,
          text: thirty_days_text,
          fontSize:14,
          lineHeight: 2,
          position: 'bottom'
      },
      responsive: true,
      legend: {
        display: true
      },
      plugins: {
        datalabels: {
            display: false,
        }
      },
      scales: {
        yAxes: [{
          gridLines: {
            display: false,
            color: '#f2f2f2',
          },
          ticks: {
            beginAtZero: true,
            stepSize: domain_traffic_chart_step_size,
            maxTicksLimit: 15
          }
        }],
        xAxes: [{
          gridLines: {
            display: false,
            tickMarkLength: 15
          },
          ticks: {
            maxTicksLimit: 15
          }
        }]
      },
    }
  });
});