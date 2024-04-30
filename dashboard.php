<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['omrsaid']==0)) {
  header('location:logout.php');
  } else{


  ?>
<!DOCTYPE html>
<html lang="en">
  <head>

    <title>Digital Record Management and Reservation System for St. John the Baptist Parish Church Services</title>

    <!-- vendor css -->
    <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="lib/jquery-toggles/toggles-full.css" rel="stylesheet">
    <link href="lib/rickshaw/rickshaw.min.css" rel="stylesheet">

    <!-- Amanda CSS -->
    <link rel="stylesheet" href="css/amanda.css">
  </head>

  <body>

    <?php include_once('includes/header.php');?>

   <?php include_once('includes/sidebar.php');?>

    <div class="am-mainpanel">
      <div class="am-pagetitle">
       
      </div><!-- am-pagetitle -->

<div class="am-pagebody">
        <div class="row row-sm">
          <div class="col-lg-4">
            <?php 
$sql ="SELECT ID from tblregistration where Status is null 
UNION
SELECT ID from tblbaptism where Status is null 
UNION
SELECT ID from tblconfirm where Status is null 
UNION
SELECT ID from tblconfession where Status is null
UNION
SELECT ID from tblhouse where Status is null
UNION
SELECT ID from tblfuneral where Status is null
UNION
SELECT ID from tblcolumbarium where Status is null
UNION
SELECT ID from tblanointing where Status is null
UNION
SELECT ID from tblmass where Status is null";

$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$totalnewapp=$query->rowCount();
?>
            <div class="card">
              <div id="rs1" class="wd-100p ht-200"></div>
              <div class="overlay-body pd-x-20 pd-t-20">
                <div class="d-flex justify-content-between">
                  <div>
                    <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-5">Total</h6>
                    <p class="tx-12">New Application</p>
                  </div>
                  <a href="" class="tx-gray-600 hover-info"><i class="icon ion-more tx-16 lh-0"></i></a>
                </div><!-- d-flex -->
                <h2 class="mg-b-5 tx-inverse tx-lato"><?php echo htmlentities($totalnewapp);?></h2>
             
              </div>
            </div><!-- card -->
          </div><!-- col-4 -->
          <div class="col-lg-4 mg-t-15 mg-sm-t-20 mg-lg-t-0">
<?php
// Assume $dbh is your PDO database connection object

// Prepare the SQL query to fetch approved applications from different tables
$sql = "SELECT ID FROM (
            SELECT ID, 'tblregistration' AS TableName FROM tblregistration WHERE Status='Approved'
            UNION ALL
            SELECT ID, 'tblbaptism' FROM tblbaptism WHERE Status='Approved'
            UNION ALL
            SELECT ID, 'tblconfirm' FROM tblconfirm WHERE Status='Approved'
            UNION ALL
            SELECT ID, 'tblconfession' FROM tblconfession WHERE Status='Approved'
            UNION ALL
            SELECT ID, 'tblhouse' FROM tblhouse WHERE Status='Approved'
            UNION ALL
            SELECT ID, 'tblfuneral' FROM tblfuneral WHERE Status='Approved'
            UNION ALL
            SELECT ID, 'tblcolumbarium' FROM tblcolumbarium WHERE Status='Approved'
            UNION ALL
            SELECT ID, 'tblanointing' FROM tblanointing WHERE Status='Approved'
            UNION ALL
            SELECT ID, 'tblmass' FROM tblmass WHERE Status='Approved'
        ) AS ApprovedApplications";
$query = $dbh->prepare($sql);

if ($query->execute()) {
    // Fetch all the results as objects
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    
    // Count the total number of approved applications
    $totalverapp = count($results);

    ?>
    <div class="card">
        <div id="rs2" class="wd-100p ht-200"></div>
        <div class="overlay-body pd-x-20 pd-t-20">
            <div class="d-flex justify-content-between">
                <div>
                    <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-5">Total</h6>
                    <p class="tx-12">Approved Application</p>
                </div>
                <a href="verified-marriage-application.php" class="tx-gray-600 hover-info"><i class="icon ion-more tx-16 lh-0"></i></a>
            </div><!-- d-flex -->
            <h2 class="mg-b-5 tx-inverse tx-lato"><?php echo htmlentities($totalverapp); ?></h2>
        </div>
    </div><!-- card -->
    <?php
} else {
    // Error occurred during query execution
    echo "Error executing query: " . $query->errorInfo()[2];
}
?>
</div><!-- col-4 -->
          <div class="col-lg-4 mg-t-15 mg-sm-t-20 mg-lg-t-0">
            <?php 
$sql ="SELECT ID from tblregistration where Status='Invalid'
UNION
SELECT ID from tblbaptism where Status='Invalid'
UNION
SELECT ID from tblconfirm where Status='Invalid'
UNION
SELECT ID from tblconfession where Status='Invalid'
UNION
SELECT ID from tblhouse where Status='Invalid'
UNION
SELECT ID from tblfuneral where Status='Invalid'
UNION
SELECT ID from tblcolumbarium where Status='Invalid'
UNION
SELECT ID from tblanointing where Status='Invalid'
UNION
SELECT ID from tblmass where Status='Invalid'";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$totalrejapp=$query->rowCount();
?>
            <div class="card">
              <div id="rs3" class="wd-100p ht-200"></div>
              <div class="overlay-body pd-x-20 pd-t-20">
                <div class="d-flex justify-content-between">
                  <div>
                    <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-5">Total</h6>
                    <p class="tx-12">Invalid Application</p>
                  </div>
                  <a href="rejected-marriage-application.php" class="tx-gray-600 hover-info"><i class="icon ion-more tx-16 lh-0"></i></a>
                </div><!-- d-flex -->
                <h2 class="mg-b-5 tx-inverse tx-lato"><?php echo htmlentities($totalrejapp);?></h2>
               
              </div>
            </div><!-- card -->
          </div><!-- col-4 -->
</div>

<div class="row row-sm" style="margin-top: 1%">
<div class="col-lg-4 mg-t-15 mg-sm-t-20 mg-lg-t-0">
            <?php 
$sql ="SELECT ID from tblregistration where Status='Pending'
UNION
SELECT ID from tblbaptism where Status='Pending'
UNION
SELECT ID from tblconfirm where Status='Pending'
UNION
SELECT ID from tblconfession where Status='Pending'
UNION
SELECT ID from tblhouse where Status='Pending'
UNION
SELECT ID from tblfuneral where Status='Pending'
UNION
SELECT ID from tblcolumbarium where Status='Pending'
UNION
SELECT ID from tblanointing where Status='Pending'
UNION
SELECT ID from tblmass where Status='Pending'";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$totalinvapp=$query->rowCount();
?>
            <div class="card">
              <div id="rs4" class="wd-100p ht-200"></div>
              <div class="overlay-body pd-x-20 pd-t-20">
                <div class="d-flex justify-content-between">
                  <div>
                    <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-5">Total</h6>
                    <p class="tx-12">Pending Application</p>
                  </div>
                  <a href="invalid.php" class="tx-gray-600 hover-info"><i class="icon ion-more tx-16 lh-0"></i></a>
                </div><!-- d-flex -->
                <h2 class="mg-b-5 tx-inverse tx-lato"><?php echo htmlentities($totalinvapp);?></h2>
               
              </div>
            </div><!-- card -->
          </div><!-- col-4 -->
</div>

<div class="row row-sm" style="margin-top: 1%">
       <div class="col-lg-4 mg-t-15 mg-sm-t-20 mg-lg-t-0">
            <?php 
$sql ="SELECT ID from tblregistration 
UNION
SELECT ID from tblbaptism 
UNION
SELECT ID from tblconfirm 
UNION
SELECT ID from tblconfession
UNION
SELECT ID from tblhouse
UNION
SELECT ID from tblfuneral
UNION
SELECT ID from tblcolumbarium
UNION
SELECT ID from tblanointing
UNION
SELECT ID from tblmass";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$totalreg=$query->rowCount();
?>
            <div class="card">
              <div id="rs5" class="wd-100p ht-200"></div>
              <div class="overlay-body pd-x-20 pd-t-20">
                <div class="d-flex justify-content-between">
                  <div>
                    <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-5">Total</h6>
                    <p class="tx-12">Total Application</p>
                  </div>
                  <a href="" class="tx-gray-600 hover-info"><i class="icon ion-more tx-16 lh-0"></i></a>
                </div><!-- d-flex -->
                <h2 class="mg-b-5 tx-inverse tx-lato"><?php echo htmlentities($totalreg);?></h2>
               
              </div>
            </div><!-- card -->
          </div><!-- col-4 -->



        </div>



     <?php include_once('includes/footer.php');?>
    </div><!-- am-mainpanel -->

    <script src="lib/jquery/jquery.js"></script>
    <script src="lib/popper.js/popper.js"></script>
    <script src="lib/bootstrap/bootstrap.js"></script>
    <script src="lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
    <script src="lib/jquery-toggles/toggles.min.js"></script>
    <script src="lib/d3/d3.js"></script>
    <script src="lib/rickshaw/rickshaw.min.js"></script>
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyAEt_DBLTknLexNbTVwbXyq2HSf2UbRBU8"></script>
    <script src="lib/gmaps/gmaps.js"></script>
    <script src="lib/Flot/jquery.flot.js"></script>
    <script src="lib/Flot/jquery.flot.pie.js"></script>
    <script src="lib/Flot/jquery.flot.resize.js"></script>
    <script src="lib/flot-spline/jquery.flot.spline.js"></script>

    <script src="js/amanda.js"></script>
    <script src="js/ResizeSensor.js"></script>
    <script src="js/dashboard.js"></script>
  </body>
</html>
<?php }  ?>