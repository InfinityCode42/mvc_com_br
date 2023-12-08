<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-
  fit=no">
  <!-- <link rel="apple-touch-icon" sizes="76x76" href="backoffice\src\public\assets/img/apple-icon.png"> -->
  <link rel="icon" type="image/png" href="backoffice\src\config\public\assets\img\illustrations\icon-documentation.svg">
  <title>
    Novastack | Soluções em TI
  </title>
  <!--     Fonts and icons     -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

  <!-- Nucleo Icons -->
  <link href="backoffice\src\config/public\assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="backoffice\src\config/public\assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="backoffice\src\public\assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="backoffice\src\config\public\assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <link rel="stylesheet" href="backoffice\src\config\public/assets/css/style.css"/>
  <!-- JavaScript -->
  <script src="backoffice\src\config/public/vendor/jquery/jquery.min.js"></script>

  <script src="backoffice\src\config/public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="backoffice\src\config/public/vendor/jquery-easing/jquery.easing.min.js"></script>

  <script src="backoffice\src\config/public/assets/js/core/popper.min.js"></script>

  <script src="backoffice\src\config/public/assets/js/core/bootstrap.min.js"></script>

  <script src="backoffice\src\config/public/assets/js/plugins/perfect-scrollbar.min.js"></script>

  <script src="backoffice\src\config/public/assets/js/plugins/smooth-scrollbar.min.js"></script>

  <script src="backoffice\src\config/public/assets/js/plugins/chartjs.min.js"></script>
  

  
  

  <!-- SWEET ALERT -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<script>
  
  var ctx1 = document.getElementById("chart-line").getContext("2d");

  var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

  gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
  gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
  gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
  new Chart(ctx1, {
    type: "line",
    data: {
      labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      datasets: [{
        label: "Mobile apps",
        tension: 0.4,
        borderWidth: 0,
        pointRadius: 0,
        borderColor: "#5e72e4",
        backgroundColor: gradientStroke1,
        borderWidth: 3,
        fill: true,
        data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
        maxBarThickness: 6

      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        }
      },
      interaction: {
        intersect: false,
        mode: 'index',
      },
      scales: {
        y: {
          grid: {
            drawBorder: false,
            display: true,
            drawOnChartArea: true,
            drawTicks: false,
            borderDash: [5, 5]
          },
          ticks: {
            display: true,
            padding: 10,
            color: '#fbfbfb',
            font: {
              size: 11,
              family: "Open Sans",
              style: 'normal',
              lineHeight: 2
            },
          }
        },
        x: {
          grid: {
            drawBorder: false,
            display: false,
            drawOnChartArea: false,
            drawTicks: false,
            borderDash: [5, 5]
          },
          ticks: {
            display: true,
            color: '#ccc',
            padding: 20,
            font: {
              size: 11,
              family: "Open Sans",
              style: 'normal',
              lineHeight: 2
            },
          }
        },
      },
    },
  });

  var win = navigator.platform.indexOf('Win') > -1;
  if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = {
      damping: '0.5'
    }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
  }

</script>

<?php include(__DIR__.'/../includes/modal_logout.php'); ?>