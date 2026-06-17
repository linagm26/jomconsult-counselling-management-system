<?php 

include 'database.php';
include 'event_crud.php';

// session start
session_start();

$category = $_SESSION['category'];
$id = $_SESSION['adminID'];

?>

<?php
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmtE = $conn->prepare("SELECT * FROM tbl_event");
    $stmtE->execute();

    $event = $stmtE->fetchAll();

}
catch(PDOException $e)
{
    echo "Error: " . $e->getMessage();
}

$conn = null;
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

    .btn_2 {
        background-color: #FAA0A0;
        border: 1px solid #FAA0A0;
        color: #fff;
        display: inline-block;
        padding: 9px 10px;
        text-transform: capitalize;
        font-size: 14px;
        font-weight: 400;
        border-radius: 5px;
        white-space: nowrap;
        -webkit-transition: .5s;
        transition: .5s;
    }

    .btn_2:hover {
        color: #fff;
        background-color: #FF6961;
        box-shadow: 0 3px 11px rgba(136,79,251,.4)
    }

    label {
        color: black;
    }

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
            <div class="white_card card_height_100 mb_30">
                <div class="white_card_header">
                    <div class="box_header m-0">
                        <div class="main-title">
                            <h3 class="m-0">Add New Event </h3>
                        </div>
                    </div>
                </div>

                <div class="white_card_body">

                    <form action=event_crud.php method="POST" enctype="multipart/form-data">
                        <div class="row">

                            <?php
                            try {
                                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                $stmt = $conn->prepare("SELECT MAX(eventID) AS maxID FROM tbl_event");
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Extract the numeric part of the latest ID and increment it
                                $numericPart = (int) ltrim($result['maxID'], 'E');
                                $newNumericPart = $numericPart + 1;

                    // Format the new event ID with leading zeros
                                $newEventID = 'E' . str_pad($newNumericPart, 4, '0', STR_PAD_LEFT);

                                $_SESSION['eventID'] = $newEventID;
                            } catch (PDOException $e) {
                              echo "Error: " . $e->getMessage();
                          }
                          $conn = null;
                          ?>

                          <input type="hidden" name="eid" value="<?php echo $newEventID ?>" required>

                          <!-- ======= NAME ======= -->
                          <div class="col-lg-6">
                            <div class="common_input mb-3">
                                <label class="form-label" for="title">Title</label>
                                <input type="text" id="title" placeholder="Event Title" name="name" value="<?php if(isset($_GET['edit'])) echo $editrow['eventName']; ?>" required>
                            </div>
                        </div>

                        <!-- ======= DESCRIPTION ======= -->
                        <?php if (isset($_GET['edit'])) { ?>
                            <div class="col-lg-6">
                                <label class="form-label" for="description">Description</label>
                                <div class="common_input mb_15">
                                    <input type="text" id="description" name="description" placeholder="Description" rows="4" value="<?php if(isset($_GET['edit'])) echo $editrow['eventDescription']; ?>" required>
                                </div>
                            </div>
                        <?php } 
                        else { ?>
                            <div class="col-lg-6">
                                <div class="common_input mb_15">
                                    <label class="form-label" for="description">Description</label>
                                    <input type="text" id="description" name="description" placeholder="Description" rows="4" value="<?php if(isset($_GET['edit'])) echo $editrow['eventDescription']; ?>" required>
                                </div>
                            </div>
                        <?php } ?>

                        <!-- ======= START TIME ======= -->
                        <div class="col-lg-3">
                            <div class="common_input mb_15">
                                <label class="form-label" for="starttime">Start Time</label>
                                <input type="time" id="starttime" placeholder="Start Time" name= "stime" value="<?php if(isset($_GET['edit'])) echo $editrow['eventStartTime']; ?>" required>
                            </div>
                        </div>

                        <!-- ======= END TIME ======= -->
                        <div class="col-lg-3">
                            <div class="common_input mb_15">
                                <label class="form-label" for="endtime">End Time</label>
                                <input type="time" id="endtime" placeholder="End Time" name= "etime" value="<?php if(isset($_GET['edit'])) echo $editrow['eventEndTime']; ?>" required>
                            </div>
                        </div>

                        <!-- ======= LOCATION ======= -->
                        <div class="col-lg-6">
                            <div class="common_input mb_15">
                                <label class="form-label" for="location">Location</label>
                                <input type="text" placeholder="Location" id="location" name="location" value="<?php if(isset($_GET['edit'])) echo $editrow['eventLocation'];?>" required>
                            </div>
                        </div>

                        <!-- ======= DATE ======= -->
                        <div class="col-lg-6">
                            <div class="common_input mb_15">
                                <label class="form-label" for="title">Date</label>
                                <input type="date" placeholder="Date" id="date" name="edate" value="<?php if(isset($_GET['edit'])) echo $editrow['eventDate']; ?>" required>
                            </div>
                        </div>

                        <!-- ======= FEES ======= -->
                        <div class="col-lg-6">
                            <div class="common_input mb_15">
                                <label class="form-label" for="title">Fees</label>
                                <input type="text" placeholder="Fees"  id="fees" name="fees" value="<?php if(isset($_GET['edit'])) echo $editrow['eventFees']; ?>" required>
                            </div>
                        </div>

                        <?php if (isset($_GET['edit'])) { ?>

                        <?php } 
                        else { ?>
                            <div class="col-lg-6">
                                <label for="poster" class="form-label">Poster</label><br>
                                <input type="file" name="poster" value="<?php echo $newEventID ?>" id="poster">
                            </div>
                        <?php } ?>

                        <?php if (isset($_GET['edit'])) { ?>
                            <input type="hidden" name="oldeid" value="<?php echo $editrow['eventID']; ?>">
                            <button class="btn_1 buttoned" type="submit
                            " name="update"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>Update</button>
                        <?php } 
                        else { ?>
                            <button class="btn_1 buttoned" type="submit" name="create"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Create</button>
                        <?php } ?>

                        <button class="btn_2" onclick="confirmReset()" style="margin-top: 10px;" type="reset"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span>Clear</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</section>

</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script>
    function confirmReset() {
        if (confirm("Are you sure you want clear all?")) {
            document.getElementById("eventForm").reset();
        }
    }
</script>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
  })();
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
