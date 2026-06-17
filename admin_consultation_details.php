<?php 

include 'database.php';
include 'admin_consultation_details_crud.php';

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
                  <h3 class="f_s_25 f_w_700 dark_text mr_30" style="font-weight: bold; padding-bottom: 20px">Consultation</h3>
                </div>
              </div>
            </div>
          </div>

          <div class="row ">

            <div class="col-lg-12">
              <div class="white_card card_height_100 mb_30">

                <div class="white_card_header">
                  <div class="box_header m-0">
                    <div class="main-title">
                      <h3 class="m-0">Consultation List</h3>
                    </div>
                  </div>
                </div>

                <div class="white_card_body">
                  <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper no-footer">
                    <form action="admin_consultation_details.php" method="post">
                      <table border="1" >

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
                          <div class="consultationDetails">
                            <table class="table custom-table">
                              <tr>
                                <td class="header-cell"><strong>Consultation ID</strong></td>
                                <td><?php echo $readrow['consultationID'] ?></td>
                              </tr>
                              <tr>
                                <td class="header-cell"><strong>Consultation Date</strong></td>
                                <td><?php echo $readrow['consultationDate'] ?></td>
                              </tr>
                              <tr>
                                <td class="header-cell"><strong>Consultation Time</strong></td>
                                <td><?php echo $readrow['consultationTime'] ?></td>
                              </tr>
                              <tr>
                                <td class="header-cell"><strong>Student ID</strong></td>
                                <td><?php echo $readrow['studentID'] ?></td>
                              </tr>
                              <tr>
                                <td class="header-cell"><strong>Counselor ID</strong></td>
                                <td><?php echo $readrow['counselorID'] ?></td>
                              </tr>
                              <tr>
                                <td class="header-cell"><strong>Issue</strong></td>
                                <td><?php echo $readrow['issueOption'] ?></td>
                              </tr>
                              <tr>
                                <td class="header-cell"><strong>Issue Description</strong></td>
                                <td><?php echo $readrow['issueDescription'] ?></td>
                              </tr>
                              <tr>
                                <td class="header-cell"><strong>Status Approval</strong></td>
                                <td>
                                  <select name="status" class="statusApproval" required>
                                    <option hidden value="">Please select</option>
                                    <option value="Pending" <?php echo ($readrow['statusApproval'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Approved" <?php echo ($readrow['statusApproval'] == 'Approved') ? 'selected' : ''; ?>>Approved</option>
                                    <option value="Rejected" <?php echo ($readrow['statusApproval'] == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                                  </select></td>

                                </tr>
                                <tr>
                                  <td class="header-cell"><strong>Status Completion</strong></td>
                                  <td><?php echo $readrow['statusCompletion'] ?></td>
                                </tr>
                                <tr>
                                  <td class="header-cell"><strong>Status Report</strong></td>
                                  <td><?php echo $readrow['statusReport'] ?></td>
                                </tr>
                              </table>

                              <input name="cid" type="hidden" value="<?php echo $readrow['consultationID'] ?>">
                              <button class="btn" type="submit" name="update">Update</button>
                            </div>
                          </div>
                        </table>
                      </form>



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


      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    </body>
    </html>
