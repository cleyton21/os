// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    // labels: ["Direct", "Referral", "Social"],
    labels: user,
    datasets: [{
      data: qtdUser,
      backgroundColor: ["#0275d8", "#5cb85c", "#5bc0de", "#f0ad4e", "#d9534f", "#292b2c", "#FFC107", "#1976D2", "#1976D2", "#1976D2", "#1976D2", "#1976D2", "#1976D2", "#1976D2", "#1976D2", "#1976D2", "#1976D2", "#1976D2", "#1976D2", "#1976D2"],
      hoverBackgroundColor: ['#ccc','#ccc','#ccc','#ccc','#ccc','#ccc','#ccc','#ccc','#ccc','#ccc','#ccc','#ccc','#ccc','#ccc','#ccc','#ccc','#ccc','#ccc','#ccc','#ccc'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#000",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 30,
    },
    legend: {
      display: true
    },
    cutoutPercentage: 80,
  },
});
