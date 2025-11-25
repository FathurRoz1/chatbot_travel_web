'use strict';
document.addEventListener('DOMContentLoaded', function () {
  setTimeout(function () {
    floatchart();
  }, 500);
});

function floatchart() {
  (function () {
    var options = {
      chart: {
        type: 'line',
        height: 90,
        sparkline: {
          enabled: true
        }
      },
      dataLabels: {
        enabled: false
      },
      colors: ['#FFF'],
      stroke: {
        curve: 'smooth',
        width: 3
      },
      series: [
        {
          name: 'series1',
          data: [45, 66, 41, 89, 25, 44, 9, 54]
        }
      ],
      yaxis: {
        min: 5,
        max: 95
      },
      tooltip: {
        theme: 'dark',
        fixed: {
          enabled: false
        },
        x: {
          show: false
        },
        y: {
          title: {
            formatter: function (seriesName) {
              return 'Chatbot Usage';
            }
          }
        },
        marker: {
          show: false
        }
      }
    };
    var chart = new ApexCharts(document.querySelector('#tab-chart-1'), options);
    chart.render();
  })();
  (function () {
    var options = {
      chart: {
        type: 'line',
        height: 90,
        sparkline: {
          enabled: true
        }
      },
      dataLabels: {
        enabled: false
      },
      colors: ['#FFF'],
      stroke: {
        curve: 'smooth',
        width: 3
      },
      series: [
        {
          name: 'series1',
          data: [75, 80, 78, 85, 82, 88, 90, 92]
        }
      ],
      yaxis: {
        min: 60,
        max: 100
      },
      tooltip: {
        theme: 'dark',
        fixed: {
          enabled: false
        },
        x: {
          show: false
        },
        y: {
          title: {
            formatter: function (seriesName) {
              return 'Accuracy Rate';
            }
          },
          formatter: function (val) {
            return val + '%';
          }
        },
        marker: {
          show: false
        }
      }
    };
    var chart = new ApexCharts(document.querySelector('#tab-chart-2'), options);
    chart.render();
  })();
  (function () {
    var options = {
      chart: {
        type: 'bar',
        height: 480,
        stacked: true,
        toolbar: {
          show: false
        }
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '50%'
        }
      },
      dataLabels: {
        enabled: false
      },
      colors: ['#2196f3', '#4caf50', '#ff9800', '#f44336'],
      series: [
        {
          name: 'Successful Chats',
          data: [120, 145, 135, 165, 155, 180, 175, 190, 185, 195, 205, 220]
        },
        {
          name: 'Failed Responses',
          data: [15, 12, 18, 10, 14, 8, 12, 9, 11, 7, 10, 8]
        },
        {
          name: 'Unanswered Queries',
          data: [10, 8, 12, 7, 9, 5, 8, 6, 7, 4, 6, 5]
        },
        {
          name: 'Feedback Received',
          data: [25, 30, 28, 35, 32, 40, 38, 42, 40, 45, 48, 50]
        }
      ],
      responsive: [
        {
          breakpoint: 480,
          options: {
            legend: {
              position: 'bottom',
              offsetX: -10,
              offsetY: 0
            }
          }
        }
      ],
      xaxis: {
        type: 'category',
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
      },
      grid: {
        strokeDashArray: 4
      },
      tooltip: {
        theme: 'dark',
        y: {
          formatter: function (val) {
            return val + ' interactions';
          }
        }
      }
    };
    var chart = new ApexCharts(document.querySelector('#growthchart'), options);
    chart.render();
  })();
  (function () {
    var options = {
      chart: {
        type: 'area',
        height: 95,
        stacked: true,
        sparkline: {
          enabled: true
        }
      },
      colors: ['#4caf50'],
      stroke: {
        curve: 'smooth',
        width: 1
      },
      series: [
        {
          data: [85, 88, 86, 90, 89, 92, 91]
        }
      ],
      tooltip: {
        theme: 'dark',
        y: {
          formatter: function (val) {
            return val + '% Accuracy';
          }
        }
      }
    };
    var chart = new ApexCharts(document.querySelector('#bajajchart'), options);
    chart.render();
  })();
}
