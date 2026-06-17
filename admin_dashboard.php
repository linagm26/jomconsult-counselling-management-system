<?php 

include 'database.php';

// session start
session_start();

$category = $_SESSION['category'];
$id = $_SESSION['adminID'];

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.18.0/font/bootstrap-icons.css" rel="stylesheet">


    <!-- Template Main CSS File -->
    <link href="assets/css/style2.css" rel="stylesheet">

    <style>


    </style>

  </head>

  <body class="crm_body_bg">

    <div class="d-flex">

      <?php include_once 'admin_sidebar.html'; ?>

      <section class="main_content dashboard_part large_header_bg">

        <div class="container-fluid g-0">
          <div class="row">
            <div class="col-lg-12 p-0 ">
              <div class="header_iner d-flex justify-content-between align-items-center">
                <div class="line_icon open_miniSide d-none d-lg-block">
                  <img src="images/icon/sidebar_line.png"  style="height: 25px;" alt="">
                </div>
                <!-- Add the logout button here -->
                <a href="login.php" class="logout-btn">Logout</a>
              </div>
            </div>
          </div>
        </div>

        <div class="main_content_iner overly_inner ">
          <div class="container-fluid">

            <div class="row">
              <div class="col-12">
                <div class="page_title_box d-flex flex-wrap align-items-center justify-content-between">
                  <div class="page_title_left d-flex align-items-center">
                    <h3 class="f_s_25 f_w_700 dark_text mr_30" style="font-weight: bold; padding-bottom: 20px">Dashboard</h3>
                  </div>
                </div>
              </div>
            </div>

            <div class="row ">

              <div class="col-xl-8 ">

                <div class="white_card mb_30 card_height_100">
                  <div class="white_card_header">
                    <div class="row align-items-center justify-content-between flex-wrap">
                      <div class="col-lg-4">                <div class="main-title">
                        <h5 class="m-0">Counseling Issues</h5>
                      </div>
                    </div>
                  </div>
                  <canvas id="myBarChart" width="100%" height="50"></canvas>
                </div>
              </div>
            </div>

            <?php

            try {
              $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
              $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $stmt = $conn->prepare("SELECT COUNT(*) AS count, statusCompletion FROM tbl_consultation WHERE statusApproval = 'Approved' GROUP BY statusCompletion");
              $stmt->execute();
              $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

              $upcomingCount = 0;
              $completeCount = 0;
              $incompleteCount = 0;

              foreach ($result as $row) {
                switch ($row['statusCompletion']) {
                  case 'Upcoming':
                  $upcomingCount = $row['count'];
                  break;
                  case 'Complete':
                  $completeCount = $row['count'];
                  break;
                  case 'Incomplete':
                  $incompleteCount = $row['count'];
                  break;
                }
              }

              $sql = "SELECT studentGender, COUNT(*) as count FROM tbl_student, tbl_consultation WHERE tbl_student.studentID = tbl_consultation.studentID GROUP BY studentGender";
              $result = $conn->query($sql);

              $genderData = $result->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
              echo "Error: " . $e->getMessage();
            }
            ?>

        <div class="col-xl-4 ">

            <div class="white_card card_height_100 mb_30">
              <div class="white_card_header">
                <div class="row align-items-center">
                  <div>
                    <div class="main-title">
                      <h5 class="m-0">Consultation Status</h5>
                    </div>
                  </div>
                </div>
              </div>
              <div class="white_card_body ">
                <canvas id="pieChart" width="100%" height="300"></canvas>
              </div>
            </div>
          </div>



        <div class="col-xl-12 ">

          <div class=" card_height_100 mb_30 user_crm_wrapper">
            <div class="row">

              <div class="col-lg-3">
                <div class="single_crm">
                  <div class="crm_head d-flex align-items-center justify-content-between" style="background-color: #DBCDF0">
                    <div>
                      <i class='bx bx-grid'></i>
                    </div>
                  </div>
                  <div class="crm_body">
                    <h4>26</h4>
                    <p>Total Consultations</p>
                  </div>
                </div>
              </div>

              <div class="col-lg-3">
                <div class="single_crm ">
                  <div class="crm_head crm_bg_1 d-flex align-items-center justify-content-between"  style="background-color: #FAEDCB">
                    <div class="thumb">
                      <i class='bx bx-run'></i>
                    </div>
                  </div>
                  <div class="crm_body">
                    <h4>10</h4>
                    <p>Total Counselors</p>
                  </div>
                </div>
              </div>

              <div class="col-lg-3">
                <div class="single_crm">
                  <div class="crm_head crm_bg_2 d-flex align-items-center justify-content-between"  style="background-color: #C6DEF1">
                    <div class="thumb">
                      <i class='bx bx-run'></i>
                    </div>
                  </div>
                  <div class="crm_body">
                    <h4>30</h4>
                    <p>Total Students</p>
                  </div>
                </div>
              </div>

              <div class="col-lg-3">
                <div class="single_crm">
                  <div class="crm_head crm_bg_3 d-flex align-items-center justify-content-between"  style="background-color: #F7D9C4">
                    <div class="thumb">
                      <i class='bx bx-x'></i>
                    </div>
                  </div>
                  <div class="crm_body">
                    <h4>18</h4>
                    <p>Total Events</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php

        $analyticsResult = array();

        try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                  // Query to get the count of events for each quarter
          $analyticsQuery = "
          SELECT 
          YEAR(eventDate) AS year,
          QUARTER(eventDate) AS quarter,
          SUM(CASE WHEN MONTH(eventDate) BETWEEN 1 AND 3 THEN 1 ELSE 0 END) AS jan_mar_count,
          SUM(CASE WHEN MONTH(eventDate) BETWEEN 4 AND 6 THEN 1 ELSE 0 END) AS apr_jun_count,
          SUM(CASE WHEN MONTH(eventDate) BETWEEN 7 AND 9 THEN 1 ELSE 0 END) AS jul_sep_count,
          SUM(CASE WHEN MONTH(eventDate) BETWEEN 10 AND 12 THEN 1 ELSE 0 END) AS oct_dec_count
          FROM 
          tbl_event
          GROUP BY 
          year, quarter
          ORDER BY 
          year, quarter;
          ";

          $analyticsStmt = $conn->prepare($analyticsQuery);
          $analyticsStmt->execute();
          $analyticsResult = $analyticsStmt->fetchAll();

        } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
                   // If an error occurs, set $analyticsResult to an empty array or handle it as needed.
          $analyticsResult = array();
        }

        $conn = null;

                  // Prepare data for Chart.js
        $chartData = array(
          'datasets' => array()
        );

        foreach ($analyticsResult as $row) {
          $year = $row['year'];

                  // Create a dataset for each year
          if (!isset($chartData['datasets'][$year])) {
            $chartData['datasets'][$year] = array(
              'labels' => array(),
              'datasets' => array(
                array('label' => 'Jan-Mar', 'data' => array()),
                array('label' => 'Apr-Jun', 'data' => array()),
                array('label' => 'Jul-Sep', 'data' => array()),
                array('label' => 'Oct-Dec', 'data' => array())
              )
            );
          }

                   // Add data for each quarter in the current year
          $chartData['datasets'][$year]['labels'][] = 'Q' . $row['quarter'];
          $chartData['datasets'][$year]['datasets'][0]['data'][] = $row['jan_mar_count'];
          $chartData['datasets'][$year]['datasets'][1]['data'][] = $row['apr_jun_count'];
          $chartData['datasets'][$year]['datasets'][2]['data'][] = $row['jul_sep_count'];
          $chartData['datasets'][$year]['datasets'][3]['data'][] = $row['oct_dec_count'];
        }
        ?>

        <?php foreach ($chartData['datasets'] as $year => $yearData): ?>

          <div class="col-xl-6">
            <div class="white_card card_height_100 mb_30">
              <div class="white_card_header">
                <div class="row align-items-center">
                  <div>
                    <div class="main-title">
                      <h5 class="m-0">Quarterly Event Analysis <?php echo $year; ?></h5>
                    </div>
                  </div>
                </div>
              </div>
              <div class="white_card_body ">
                <canvas id="analyticsChart_<?php echo $year; ?>" width="800" height="400"></canvas>
              </div>
            </div>
          </div>
          <script>
            document.addEventListener('DOMContentLoaded', function () {
              var ctx = document.getElementById('analyticsChart_<?php echo $year; ?>').getContext('2d');
              var myChart = new Chart(ctx, {
                type: 'bar',
                data: <?php echo json_encode($yearData); ?>,
                options: {
                  responsive: true,
                  scales: {
                    x: { stacked: true },
                    y: { stacked: true }
                  }
                }
              });
            });
          </script>
        <?php endforeach; ?>

        <div class="col-xl-4 ">

            <div class="white_card card_height_100 mb_30">
              <div class="white_card_header">
                <div class="row align-items-center">
                  <div>
                    <div class="main-title">
                      <h5 class="m-0">Total Student by Gender</h5>
                    </div>
                  </div>
                </div>
              </div>
              <div class="white_card_body ">
                <canvas id="chartTotal" width="100%" height="300"></canvas>
              </div>
            </div>
          </div>

      </div>
    </div>
  </div>

</div>

</section>

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
        backgroundColor: ['#FFADAD', '#FFECD9', '#CAFFBF', '#A0C4FF', '#CCCCFF'],
      }],
    },
    options: {
      responsive:true,
      scales: {
        xAxes: [{
          ticks: {
            beginAtZero: true
          }
        }],
        yAxes: [{
          ticks: {
        display: false, // Hide y-axis labels
      },
    }],
      }
    }
  });
</script>

<script>
    // Use the counts obtained from the database
  var upcomingCount = <?php echo $upcomingCount; ?>;
  var completeCount = <?php echo $completeCount; ?>;
  var incompleteCount = <?php echo $incompleteCount; ?>;

      // Chart.js configuration
  var ctx = document.getElementById('pieChart').getContext('2d');
  var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Upcoming', 'Complete', 'Incomplete'],
      datasets: [{
        data: [upcomingCount, completeCount, incompleteCount],
        backgroundColor: [
              'rgba(255, 99, 132, 0.8)', // Red for Upcoming
              'rgba(75, 192, 192, 0.8)', // Green for Complete
              'rgba(255, 205, 86, 0.8)'  // Yellow for Incomplete
              ],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
    }
  });
</script>

<script>

      // Chart.js configuration
      var ctx = document.getElementById('chartTotal').getContext('2d');
      var myPieChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: ["Male", "Female"],
    datasets: [{
      data: <?php echo json_encode(array_column($genderData, 'count')); ?>,
      backgroundColor: ['#A0C4FF', 'rgba(255, 99, 132, 0.8)'],
    }],
  },
  options: {
          responsive: true,
          maintainAspectRatio: false,
        }
});
    </script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>

<?php
} catch(PDOException $e) {
  echo "Error: ".$e->getMessage();
}
$conn = null;
?>
