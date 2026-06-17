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
                  <h3 class="f_s_25 f_w_700 dark_text mr_30" style="font-weight: bold; padding-bottom: 20px">Student</h3>
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
                      <h3 class="m-0">Student List</h3>
                    </div>
                  </div>
                </div>

                <div class="white_card_body">
                  <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper no-footer">
                        <table class="table lms_table_active3 dataTable no-footer dtr-inline" id="DataTables_Table_1" role="grid" aria-describedby="DataTables_Table_1_info" style="max-width: 100%;">
                          <thead>
                            <tr role="row">
                              <th>Student ID</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Phone</th>
                              <th>Address</th>
                              <th>Gender</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr role="row" class="odd">
                              <?php   
                              $per_page =7;
                              if (isset($_GET["page"]))
                                $page = $_GET["page"];
                              else
                                $page = 1;
                              $start_from = ($page-1) * $per_page;

                              try {
                                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $stmt = $conn->prepare("select * from tbl_student LIMIT $start_from, $per_page");
                                $stmt->execute();
                                $result = $stmt->fetchAll();
                              }
                              catch(PDOException $e){
                                echo "Error: " . $e->getMessage();
                              }
                              foreach($result as $readrow) {
                                ?>
                                <tr>
                                  <td><?php echo $readrow['studentID']; ?></td>
                                  <td><?php echo $readrow['studentName']; ?></td>
                                  <td><?php echo $readrow['studentEmail']; ?></td>
                                  <td><?php echo $readrow['studentPhone']; ?></td>
                                  <td><?php echo $readrow['studentAddress']; ?></td>
                                  <td><?php echo $readrow['studentGender']; ?></td>
                                </tr>
                              <?php }  ?>
                            </tr>
                          </tbody>
                        </table>

                        <div class="dataTables_wrapper">
                          <div class="dataTables_paginate paging_simple_numbers">
                              <ul class="pagination">
                             <?php
                             try {
                              $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                              $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                              $stmt = $conn->prepare("SELECT * FROM tbl_student");
                              $stmt->execute();
                              $result = $stmt->fetchAll();
                              $total_records = count($result);
                            }
                            catch(PDOException $e){
                              echo "Error: " . $e->getMessage();
                            }
                            $total_pages = ceil($total_records / $per_page);
                            ?>

                            <!-- Previous Page -->
                            <?php
                            if ($page == 1) { ?>

                              <li class="paginate_button previous disabled">
                                <span class="page-link" aria-hidden="true">&laquo;</span>
                              </li>

                              <?php
                            } else { ?>
                              <li class="paginate_button next">
                                <a class="page-link" href="admin_user_student.php?page=<?php echo $page - 1 ?>" aria-label="Previous">
                                  <span aria-hidden="true">&laquo;</span>
                                </a></li>
                              <?php } ?>

                              <!-- Numbered Pages -->
                              <?php

                              for ($i = 1; $i <= $total_pages; $i++) { ?>
                                <li class="paginate_button <?php echo ($i == $page) ? 'active' : ''; ?>">
                                  <a class="page-link" href="admin_user_student.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>

                                <?php } ?>

                                <!-- Next Page -->
                                <?php if ($page == $total_pages) { ?>
                                  <li class="paginate_button disabled">
                                    <span class="page-link" aria-hidden="true">&raquo;</span></li>
                                  <?php } else { ?>
                                    <li class="page-item">
                                      <a class="page-link" href="admin_user_student.php?page=<?php echo $page + 1 ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                      </a></li>
                                    <?php } ?>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>

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


      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    </body>
    </html>
