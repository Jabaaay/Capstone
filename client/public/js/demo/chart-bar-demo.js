// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

// Function to get color based on depression level
function getDepressionLevelColor(score) {
    if (score <= 9) {
        return 'rgba(40, 167, 69, 0.8)'; // Green for Normal
    } else if (score <= 16) {
        return 'rgba(255, 193, 7, 0.8)'; // Yellow for Mild
    } else if (score <= 20) {
        return 'rgba(255, 127, 80, 0.8)'; // Orange for Borderline
    } else if (score <= 29) {
        return 'rgba(255, 99, 71, 0.8)'; // Red for Moderate
    } else if (score <= 40) {
        return 'rgba(220, 53, 69, 0.8)'; // Dark Red for Severe
    } else {
        return 'rgba(108, 117, 125, 0.8)'; // Gray for Extreme
    }
}

// Bar Chart Example
var ctx = document.getElementById("myBarChart");
if (ctx) {
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: testDates,
            datasets: [{
                label: "Test Scores",
                backgroundColor: testScores.map(score => getDepressionLevelColor(score)),
                borderColor: testScores.map(score => getDepressionLevelColor(score).replace('0.8', '1')),
                borderWidth: 1,
                data: testScores,
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    },
                    maxBarThickness: 50,
                }],
                yAxes: [{
                    ticks: {
                        min: 0,
                        max: 40,
                        maxTicksLimit: 5,
                        padding: 10,
                        callback: function(value, index, values) {
                            return number_format(value);
                        }
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    generateLabels: function(chart) {
                        return [
                            {
                                text: 'Normal',
                                fillStyle: 'rgba(40, 167, 69, 0.8)',
                                strokeStyle: 'rgba(40, 167, 69, 1)',
                                lineWidth: 1
                            },
                            {
                                text: 'Mild',
                                fillStyle: 'rgba(255, 193, 7, 0.8)',
                                strokeStyle: 'rgba(255, 193, 7, 1)',
                                lineWidth: 1
                            },
                            {
                                text: 'Borderline',
                                fillStyle: 'rgba(255, 127, 80, 0.8)',
                                strokeStyle: 'rgba(255, 127, 80, 1)',
                                lineWidth: 1
                            },
                            {
                                text: 'Moderate',
                                fillStyle: 'rgba(255, 99, 71, 0.8)',
                                strokeStyle: 'rgba(255, 99, 71, 1)',
                                lineWidth: 1
                            },
                            {
                                text: 'Severe',
                                fillStyle: 'rgba(220, 53, 69, 0.8)',
                                strokeStyle: 'rgba(220, 53, 69, 1)',
                                lineWidth: 1
                            },
                            {
                                text: 'Extreme',
                                fillStyle: 'rgba(108, 117, 125, 0.8)',
                                strokeStyle: 'rgba(108, 117, 125, 1)',
                                lineWidth: 1
                            }
                        ];
                    }
                }
            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        var value = tooltipItem.yLabel;
                        var level = '';
                        if (value <= 9) {
                            level = ' (Normal)';
                        } else if (value <= 16) {
                            level = ' (Mild)';
                        } else if (value <= 20) {
                            level = ' (Borderline)';
                        } else if (value <= 29) {
                            level = ' (Moderate)';
                        } else if (value <= 40) {
                            level = ' (Severe)';
                        } else {
                            level = ' (Extreme)';
                        }
                        return datasetLabel + ': ' + number_format(value) + level;
                    }
                }
            }
        }
    });
}
