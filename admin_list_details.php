

<?php
  include 'list_crud.php';
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consultation Application Details</title>

    <style>
      
      table, th, td {
        border: 1px solid white;
        border-collapse: collapse;
        border-radius: 5px;
      }

      th, td {
        background-color: #96D4D4;
      }

    </style>

</head>
<body>

  <?php include_once 'admin_navbar.html'; ?>

 <?php
    try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM tbl_consultation WHERE tbl_consultation.consultationID = :cid");
    $cid = isset($_GET['listD']) ? $_GET['listD'] : '';
    $stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
    $stmt->execute();
    $readrow = $stmt->fetch(PDO::FETCH_ASSOC);

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    ?>

 
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-sm-5">
        <div class="updateStatus">
          <div class="page-header">
            <br><h6>Consultation Status</h6>
          </div>
          <form action="admin_list_details.php" method="post" class="form-horizontal">
          <div class="form-group">
          <label for="prd" class="col-sm-5 control-label">Status Approval</label>
          <div class="col-sm-5">
            <select name="status" class="form-control" required>
            <option hidden value="">Please select</option>
            <option value="Pending">Pending</option>
            <option value="Approved">Approved</option>
            <option value="Rejected">Rejected</option>

          </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
          <input name="cid" type="hidden" value="<?php echo $readrow['consultationID'] ?>">
        <button class="btn btn-default" type="submit" name="update">Update</button>
        <button class="btn btn-default" type="reset">Clear</button>
          </div>
        </div>
        </form>
      </div>
    </div>

      <div class="col-xs-12 col-sm-6">
        <div class="consultationDetails">
          <div class="panel panel-default">
            <div class="page-header">
              <br><h4>Consultation Details</h4></div><hr>
            <div class="panel-body">
              Below are details of the consultation.
            </div>
            <table class="table" border="2">
              <tr>
            <td class="col-xs-4 col-sm-4 col-md-4"><strong>Consultation ID</strong></td>
            <td><?php echo $readrow['consultationID'] ?></td>
          </tr>
          <tr>
            <td><strong>Consultation Date</strong></td>
            <td><?php echo $readrow['consultationDate'] ?></td>
          </tr>
          <tr>
            <td><strong>Consultation Time</strong></td>
            <td><?php echo $readrow['consultationTime'] ?></td>
          </tr>
          <tr>
            <td><strong>Student ID</strong></td>
            <td><?php echo $readrow['studentID'] ?></td>
          </tr>
          <tr>
            <td><strong>Counselor ID</strong></td>
            <td><?php echo $readrow['counselorID'] ?></td>
          </tr>
          <tr>
            <td><strong>Issue</strong></td>
            <td><?php echo $readrow['issue'] ?></td>
          </tr>
          <tr>
            <td><strong>Status Approval</strong></td>
            <td><?php echo $readrow['statusApproval'] ?></td>
          </tr>
          <tr>
            <td><strong>Status Completion</strong></td>
            <td><?php echo $readrow['statusCompletion'] ?></td>
          </tr>
          <tr>
            <td><strong>Status Report</strong></td>
            <td><?php echo $readrow['statusReport'] ?></td>
          </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
 
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
 
</body>
</html>