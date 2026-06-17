<?php include 'database.php'; ?>

<!DOCTYPE html>
<html>
<head>

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style1.css" rel="stylesheet">

  <style>
    body {
      background-color: #f0f0f0;
    }

    .panel-body {
      border-radius: 0;
    }

    .table {
      margin-bottom: 0;
    }

    .container-fluid {
      margin-bottom: 20px;
    }

    .card {
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Customize shadow as needed */
    }

    .small-font {
      font-size: 13px;
    }
  </style>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
</head>

<body>
  <?php
  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM tbl_consultation, tbl_student, tbl_sos WHERE consultationID = :consultationid AND tbl_consultation.studentID = tbl_student.studentID AND tbl_consultation.studentID = tbl_student.studentID AND consultationID = :consultationid");
    $stmt->bindParam(':consultationid', $consultationid, PDO::PARAM_STR);
    $consultationid = $_GET['consultationid'];
    $stmt->execute();
    $readrow = $stmt->fetch(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
  ?>

  <div class="card-body small-font">
    <div class="row">
      <div class="col-md-4">
        <strong>Consultation ID:</strong> <?php echo $readrow['consultationID'] ?>
      </div>
      <div class="col-md-4">
        <strong>Consultation Date:</strong> <?php echo $readrow['consultationDate'] ?>
      </div>
      <div class="col-md-4">
        <strong>Contact Name:</strong> <?php echo $readrow['sosName'] ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <strong>Student ID:</strong> <?php echo $readrow['studentID'] ?>
      </div>
      <div class="col-md-4">
        <strong>Consultation Time:</strong> <?php echo $readrow['consultationTime'] ?>
      </div>
      <div class="col-md-4">
        <strong>Contact Phone No.:</strong> <?php echo $readrow['sosPhone'] ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <strong>Student Name:</strong> <?php echo $readrow['studentName'] ?>
      </div>
      <div class="col-md-4">
        <strong>Issue:</strong> <?php echo $readrow['issue'] ?>
      </div>
      <div class="col-md-4">
        <strong>Contact Relationship:</strong> <?php echo $readrow['sosRelationship'] ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <strong>Email:</strong> <?php echo $readrow['studentEmail'] ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <strong>Phone Number:</strong> <?php echo $readrow['studentPhone'] ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <strong>Address:</strong> <?php echo $readrow['studentAddress'] ?>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-sm">
        <div class="card">
          <!-- Counselor Report Form -->
          <div class="card-header" style="background-color: #123456; color: white;">
            Counselor's Report
          </div>
          <div class="card-body">
            <form action="process_report.php" method="post">
              <input type="hidden" name="consultationID" value="<?php echo $readrow['consultationID']; ?>">
              <div class="form-group">
                <label for="report">Report:</label>
                <textarea class="form-control" id="report" name="report" rows="5" required></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Submit Report</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>


  <p></p>

</body>
</html>