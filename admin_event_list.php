<?php 

include 'database.php';

// session start
session_start();

$category = $_SESSION['category'];
$id = $_SESSION['adminID'];



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

      <div class="container-fluid g-0" >
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
                  <h3 class="f_s_25 f_w_700 dark_text mr_30" style="font-weight: bold; padding-bottom: 20px">Events</h3>
                </div>
                <div class="page_title_right">
                  <div class="page_date_button d-flex align-items-center">
                    <button class="btn_1" onclick="redirectToPage()">Add Event</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row ">

            <?php
      // Read
            try {
              $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
              $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Add WHERE condition to filter out events with dates and times that have passed
              $stmt = $conn->prepare("SELECT * FROM tbl_event WHERE CONCAT(eventDate, ' ', eventEndTime) >= NOW()");
              $stmt->execute();
              $result = $stmt->fetchAll();
            } catch (PDOException $e) {
              echo "Error: " . $e->getMessage();
            }
            foreach ($result as $readrow) {
              ?>
              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class="white_card mb_30 card_height_100">

                  <?php if ($readrow['eventPoster'] == ""): ?>
                    <button class="openBtn btn btn-link" data-toggle="modal" data-target="#posterModal" data-href="event_details.php?eventid=<?php echo $readrow['eventID']; ?>" role="button">
                      <img src="images/eventPoster/None.GIF" alt="No Poster" class="event-image img-fluid">
                    </button>
                  <?php else: ?>
                    <button class="openBtn btn btn-link" data-toggle="modal" data-target="#posterModal" data-href="event_details.php?eventid=<?php echo $readrow['eventID']; ?>" role="button">
                      <img src="images/eventPoster/<?php echo $readrow['eventPoster']; ?>" class="event-image img-fluid" alt="Event Poster">
                    </button>
                    <div>

                    </div>
                  <?php endif; ?>

                  <div class="white_card_body ">
                    <h5 class="card-title"><?php echo $readrow['eventName']; ?></h5>
                    <p class="card-text">
                      <strong>Date:</strong> <?php echo date('d/m/Y', strtotime($readrow['eventDate'])); ?><br>
                      <strong>Time:</strong> 
                      <?php 
                      $startTime = date('h:i A', strtotime($readrow['eventStartTime'])); 
                      $endTime = date('h:i A', strtotime($readrow['eventEndTime'])); 
                      echo $startTime . ' - ' . $endTime;
                      ?>
                      <br>
                      <strong>Location:</strong> <?php echo $readrow['eventLocation']; ?>
                    </p>
                  </div>
                  <center>
                    <a href="admin_event_form.php?edit=<?php echo $readrow['eventID']; ?>" class="btn btn-primary" role="button" >
                      <i class="bi bi-pencil"></i>Edit</a>
                      <a href="admin_event_list.php?delete=<?php echo $readrow['eventID']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs button-29" role="button">
                        <i class="bi bi-trash"></i>Delete</a>
                      </center>
                    </div>
                  </div>
                  <?php
                }
                $conn = null;
                ?>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>

  </section>

</div>


<!-- Modal -->
<div class="modal fade" id="posterModal" tabindex="-1" role="dialog" aria-labelledby="posterModalLabel" data-keyboard="false" data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content rounded-0 border-0">
      <div class="modal-header custom-bg-color text-white">
        <h5 class="modal-title custom-text" id="posterModalLabel">Event Details</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Show event information -->
      </div>
      <div class="modal-footer justify-content-between">
        <div>

        </div>
        <div>
         <button type="button" class="btn btn-info" data-dismiss="modal">OK</button>
       </div>
     </div>
   </div>
 </div>

 <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
 <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

 <script>
  $(document).ready(function(){
    // Modal initialization
    $('#myModal').modal({
      backdrop: 'static',
      keyboard: false
    });

    // Handling body overflow after modal is closed
    $('#myModal').on('hidden.bs.modal', function () {
      $('body').css('overflow', 'auto');
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('.openBtn').on('click', function() {
      // Clear previous content
        $('.modal-body').empty();

        var url = $(this).attr('data-href');
        $('.modal-body').load(url, function() {
          $('#posterModal').modal('show');
        });
      });
    });
  </script>

  <script>
function redirectToPage() {
  window.location.href = "admin_event_form.php";
}
</script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.1.2/chart.umd.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>



</body>
</html>