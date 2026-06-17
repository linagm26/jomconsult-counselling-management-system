<?php 
include 'database.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Events</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

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
  <link href="assets/css/style1.css" rel="stylesheet">

  <style>
   body {
   }

   .event-container {
    display: flex;
    justify-content: space-around;
    align-items: flex-start;
    flex-wrap: wrap;
  }

  .event-card {
    margin: 8px;
    margin-bottom: 20px;
    padding: 6px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease-in-out;
  }

  .event-card:hover {
    transform: scale(1.05);
  }

  .event-image {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
  }

  .card-title {
    color: #007bff;
    font-weight: bold;
    font-size: 1.3em;
    text-align: center;
    margin-bottom: 0.5em;
  }

  .card-text {
    font-size: 0.9em;
    color: #333;
    margin-bottom: 0.5em;
  }

  .custom-bg-color {
    background-color: #6380FF;
  }

  .title-font {
    font-family: Fantasy;
    font-size: 28px;
    color: #5bc0de;
  }

  .custom-text {
    font-family:  helvetica, sans-serif;
    font-size: 16px;
  }

  .title {
    font-family: 'Fantasy';
    font-weight: bold;
    font-size: 26px;
  }
</style>
</head>

<body>

  <?php include_once 'student_navbar.php'; ?>


  <div class="container mt-5">

    <section id="schedule" class="section-bg">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <p>Events</p>
        </div>
      </div>
    </section>

    <div class="event-container">

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

        <div class="col-xs-12 col-sm-6 col-md-4">
          <div class="event-card">
            <?php if ($readrow['eventPoster'] == ""): ?>
              <button class="openBtn btn btn-link" data-toggle="modal" data-target="#posterModal" data-href="event_details.php?eventid=<?php echo $readrow['eventID']; ?>" role="button">
                <img src="images/eventPoster/None.GIF" alt="No Poster" class="event-image img-fluid">
              </button>
            <?php else: ?>
              <button class="openBtn btn btn-link" data-toggle="modal" data-target="#posterModal" data-href="event_details.php?eventid=<?php echo $readrow['eventID']; ?>" role="button">
                <img src="images/eventPoster/<?php echo $readrow['eventPoster']; ?>" class="event-image img-fluid" alt="Event Poster">
              </button>
            <?php endif; ?>

            <div class="card-body">
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
          </div>
        </div>
        <?php
      }
      $conn = null;
      ?>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="posterModal" tabindex="-1" role="dialog" aria-labelledby="posterModalLabel" data-keyboard="false" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content rounded-0 border-0">
        <div class="modal-header custom-bg-color text-white">
          <h5 class="modal-title custom-text" id="posterModalLabel">Event Details</h5>
          <button type="button" class="close text-white" data-dismiss="modal"  aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Show event information -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info" data-dismiss="modal" >OK</button>
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


  </body>

  </html>
