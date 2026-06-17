<?php 
include_once 'database.php';

 try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "SELECT issueOption, COUNT(*) as count FROM tbl_consultation GROUP BY issueOption";
  $result = $conn->query($sql);
  $issueData = $result->fetchAll(PDO::FETCH_ASSOC);

  $issueLabels = array_column($issueData, 'issueOption');
  $issueCounts = array_column($issueData, 'count');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Jom Consult</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

  <!-- Icon picture -->
  <link rel="shortcut icon" type="images/jpg" href="images/icon.png" />

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/style.css" rel="stylesheet">
  <style>

    body{
      background-image: url("images/background.jpg");
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center center;
    }

  </style>
</head>

<body>
  
    <?php include_once 'admin_navbar.html'; ?>

<div>

    <!-- ======= Image ======= -->
    <div class="container">
      <img src="images/menuboard.png" alt="Menu Board" class="img-fluid custom-mt mx-auto d-block">
    </div>

    <br><br><hr>

<!-- Chart for consultation status -->
<div class="col-lg-12">
  <div class="card mb-6">
      <div class="card-header">
        <i class="fas fa-chart-pie me-1"></i>
          Status
      </div>
      <div class="card-body">
        <canvas id="myBarChart" width="100%" height="50"></canvas>
      </div>
        </div>
  </div><br><br>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.1.2/chart.umd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
     <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>


    <script type="text/javascript">
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#292b2c';

        // Bar Chart Example
        var ctx = document.getElementById("myBarChart").getContext('2d');
        var myBarChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: <?php echo json_encode($issueLabels); ?>,
                datasets: [{
                    label: 'Number of Issues',
                    data: <?php echo json_encode($issueCounts); ?>,
                    backgroundColor: ['#007bff', '#dc3545', '#43A047', '#FF9800', '#8D6E63'],
                }],
            },
           options: {
            responsive:true,
              scales: {
                xAxes: [{
                  ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
        });
    </script>

</script>

</body>
</html>

<?php
} catch(PDOException $e) {
  echo "Error: ".$e->getMessage();
}
$conn = null;
?>
