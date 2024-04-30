<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['omrsaid'] == 0)) {
  header('location:logout.php');
} else {


?>
  <!DOCTYPE html>
  <html lang="en">

  <head>


    <title>Digital Record Managgement and Reservation System for St. John the Baptist Parish Church Services || View Marriage Application</title>

    <!-- vendor css -->
    <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="lib/jquery-toggles/toggles-full.css" rel="stylesheet">
    <link href="lib/highlightjs/github.css" rel="stylesheet">
    <link href="lib/datatables/jquery.dataTables.css" rel="stylesheet">
    <link href="lib/select2/css/select2.min.css" rel="stylesheet">

    <!-- Amanda CSS -->
    <link rel="stylesheet" href="css/amanda.css">
  </head>

  <body>

    <?php include_once('includes/header.php');
    include_once('includes/sidebar.php');

    ?>


    <div class="am-pagetitle">
      <h5 class="am-title">View Reservation Application</h5>

    </div><!-- am-pagetitle -->

    <div class="am-mainpanel">
      <div class="am-pagebody">

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">View Reservation Application</h6>


          <div class="table-wrapper" style="padding-top: 20px">
            <?php
            $fdate = $_POST['fromdate'];
            $tdate = $_POST['todate'];
            $reservation = $_POST['reservation'];
            $tables = [
              "Anointing" => "tblanointing",
              "Baptism" => "tblbaptism",
              "Columnbarium" => "tblcolumbarium",
              "Confession" => "tblconfession",
              "Confirm" => "tblconfirm",
              "Funeral" => "tblfuneral",
              "House" => "tblhouse",
              "Mass" => "tblmass",
              "Wedding" => "tblregistration",
            ];
            $tableName = $tables[$reservation];



            ?>
            <h4 align="center" style="color:blue">Report from <?php echo $fdate ?> to <?php echo $tdate ?></h4>
            <table id="datatable1" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-15p">S.No</th>

                  <th class="wd-15p">Reg Number</th>
                  <th class="wd-15p">RegDate</th>
                  <th class="wd-10p">Date</th>
                  <th class="wd-10p">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = "SELECT * FROM $tableName  WHERE date(RegDate) BETWEEN '$fdate' and '$tdate'";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);

                $cnt = 1;
                if ($query->rowCount() > 0) {
                  foreach ($results as $row) {               ?>
                    <tr>
                      <td><?php echo htmlentities($cnt); ?></td>
                      <td><?php echo htmlentities($row->RegistrationNumber); ?></td>
                      <td><?php echo htmlentities($row->RegDate); ?></td>
                      <td><?php echo htmlentities($row->Date); ?></td>
                      <?php if ($row->Status == "") { ?>

                        <td><?php echo "Still Pending"; ?></td>
                      <?php } else { ?> <td><?php echo htmlentities($row->Status); ?>
                        </td>
                      <?php } ?>
                      <td><a href="view-marriage-application-detail.php?viewid=<?php echo htmlentities($row->ID); ?>"></a></td>
                      <td><a href="view-columbarium-res-detail.php?viewid=<?php echo htmlentities($row->ID); ?>"></a></td>
                    </tr>

                  <?php
                    $cnt = $cnt + 1;
                  }
                } else { ?>
                  <tr>
                    <td colspan="8"> No record found against this date</td>

                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div><!-- table-wrapper -->
        </div><!-- card -->


      </div><!-- am-pagebody -->
      <?php include_once('includes/footer.php'); ?>
    </div><!-- am-mainpanel -->

    <script src="lib/jquery/jquery.js"></script>
    <script src="lib/popper.js/popper.js"></script>
    <script src="lib/bootstrap/bootstrap.js"></script>
    <script src="lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
    <script src="lib/jquery-toggles/toggles.min.js"></script>
    <script src="lib/highlightjs/highlight.pack.js"></script>
    <script src="lib/datatables/jquery.dataTables.js"></script>
    <script src="lib/datatables-responsive/dataTables.responsive.js"></script>
    <script src="lib/select2/js/select2.min.js"></script>

    <script src="js/amanda.js"></script>
    <script>
      $(function() {
        'use strict';

        $('#datatable1').DataTable({
          responsive: true,
          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
          }
        });

        $('#datatable2').DataTable({
          bLengthChange: false,
          searching: false,
          responsive: true
        });

        // Select2
        $('.dataTables_length select').select2({
          minimumResultsForSearch: Infinity
        });

      });
    </script>
  </body>

  </html>
<?php }  ?>