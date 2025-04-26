// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
if (ctx) {
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Normal", "Mild", "Borderline", "Moderate", "Severe", "Extreme"],
            datasets: [{
                data: [normalCount, mildCount, borderlineCount, moderateCount, severeCount, extremeCount],
                backgroundColor: ['rgba(40, 167, 69, 0.8)', 'rgba(255, 193, 7, 0.8)', 'rgba(255, 127, 80, 0.8)', 'rgba(255, 99, 71, 0.8)', 'rgba(220, 53, 69, 0.8)', 'rgba(108, 117, 125, 0.8)'],
                hoverBackgroundColor: ['rgba(40, 167, 69, 1)', 'rgba(255, 193, 7, 1)', 'rgba(255, 127, 80, 1)', 'rgba(255, 99, 71, 1)', 'rgba(220, 53, 69, 1)', 'rgba(108, 117, 125, 1)'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
    });
}
