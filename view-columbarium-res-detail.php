<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['omrsaid']==0)) {
  header('location:logout.php');
  } else{
if(isset($_POST['submit']))
  {


$vid=$_GET['viewid'];
    $status=$_POST['status'];
   $remark=$_POST['remark'];
  

$sql= "update tblcolumbarium set Status=:status,Remark=:remark where ID=:vid";
$query=$dbh->prepare($sql);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':remark',$remark,PDO::PARAM_STR);
$query->bindParam(':vid',$vid,PDO::PARAM_STR);

 $query->execute();

  echo '<script>alert("Remark has been updated")</script>';
 echo "<script>window.location.href ='all-mass-app.php'</script>";
}


  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
   

    <title>Digital Record Management and Reservation System for St. John the Baptist Parish Church Services || View Columbarium Application</title>

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
      <h5 class="am-title">Columbarium Appointment Status</h5>
     
    </div><!-- am-pagetitle -->

    <div class="am-mainpanel">
      <div class="am-pagebody">

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">View Status</h6>
        

          <div class="table-wrapper" style="padding-top: 20px">
            <?php
                               $vid=$_GET['viewid'];

$sql="SELECT tblcolumbarium.*,tbluser.FirstName,tbluser.LastName,tbluser.MobileNumber,tbluser.Address from  tblcolumbarium join  tbluser on tblcolumbarium.UserID=tbluser.ID where tblcolumbarium.ID=:vid";
$query = $dbh -> prepare($sql);
$query-> bindParam(':vid', $vid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
 <table border="1" class="table table-bordered">
 
<tr align="center">
<td colspan="8" style="font-size:20px;color:red">
 Registration Number:   <?php  echo $row->RegistrationNumber;?></td></tr>
 <tr align="center">
<td colspan="9" style="font-size:20px;color:blue">
 User Details</td></tr>
    <tr>
    <th scope>First Name</th>
    <td><?php  echo $row->FirstName;?></td>
    <th scope>Last Name</th>
    <td><?php  echo $row->LastName;?></td>
    <th scope>Mobile Number</th>
    <td><?php  echo $row->MobileNumber;?></td>
    <th>Address</th>
    <td colspan="9"><?php  echo $row->Address;?></td>

  </tr>
  
<tr align="center">
<td colspan="9" style="font-size:20px;color:blue">
 Application Details</td></tr>
 <tr>
   <th colspan="5">Date of Reservation</th>
   <td colspan="5"><?php echo $row->DateofReservation;?></td>
 </tr>

 <tr>
  <td colspan="8" style="font-size:20px;color:red">
  Buyer Details</td></tr>
  <tr>
    <th colspan="5">Fullname</th>
    <td colspan="5"><?php echo $row->Fullname;?></td>
  </tr>
  <tr>
    <th colspan="5">Date of Birth</th>
    <td colspan="5"><?php echo $row->DateofBirth;?></td>
  </tr>
  <tr>
    <th colspan="5">Age</th>
    <td colspan="5"><?php echo $row->Age;?></td>
  </tr>
  <tr>
    <th colspan="5">Payment Method</th>
    <td colspan="5"><?php echo $row->PaymentMethod;?></td>
  </tr>
  <tr>
    <th colspan="5">Price</th>
    <td colspan="5"><?php echo $row->Price;?></td>
  </tr>
  <tr>
    <th colspan="5">Slot Available</th>
    <td colspan="5"><?php echo $row->SlotAvailable;?></td>
  </tr>
 
 <tr>
  <td colspan="8" style="font-size:20px;color:red">
  Contact Information Details</td></tr>
  <tr>
    <th colspan="5">Home Address</th>
    <td colspan="5"><?php echo $row->Address;?></td>
  </tr>
  <tr>
    <th colspan="5">Phone Number</th>
    <td colspan="5"><?php echo $row->Phone;?></td>
  </tr>
  <tr>
    <th colspan="5">Email Address</th>
    <td colspan="5"><?php echo $row->Emailadd;?></td>
  </tr>


  <tr>
    
     <th colspan="2">Order Final Status</th>

    <td colspan="2"> <?php  $status=$row->Status;
    
if($row->Status=="Approved")
{
  echo "Your reservation has been approved";
}

if($row->Status=="Invalid")
{
 echo "Your reservation is invalid";
}

if($row->Status=="Pending")
{
 echo "Your reservation is still pending";
}


if($row->Status=="")
{
  echo "Pending";
}
 

     ;?></td>
     <th colspan="2">Admin Remark</th>
    <?php if($row->Status==""){ ?>

                     <td colspan="4"><?php echo "Your application has still pending"; ?></td>
<?php } else { ?>                  <td colspan="4"><?php  echo htmlentities($row->Status);?>
                  </td>
                  <?php } ?>
  </tr>
 
  <?php $cnt=$cnt+1;}} ?>
</table>
<?php 

if ($status==""){
?> 
<p align="center"  style="padding-top: 20px">                            
 <button class="btn btn-primary waves-effect waves-light w-lg" data-toggle="modal" data-target="#myModal">Take Action</button></p>  

<?php } ?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
     <div class="modal-content">
      <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Take Action</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                <table class="table table-bordered table-hover data-tables">

                                <form method="post" name="submit">

                                
                               
     <tr>
    <th>Remark :</th>
    <td>
    <textarea name="remark" placeholder="Remark" rows="12" cols="14" class="form-control" required="true"></textarea></td>
  </tr> 
   
  <tr>
    <th>Status :</th>
    <td>

   <select name="status" class="form-control" required="true" >
     <option value="Approved" selected="true">Approved</option>
     <option value="Invalid">Invalid</option>
   </select></td>
  </tr>
</table>
</div>
<div class="modal-footer">
 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
 <button type="submit" name="submit" class="btn btn-primary">Update</button>
  
  </form>
          </div><!-- table-wrapper -->
        </div><!-- card -->

</div>
      </div><!-- am-pagebody -->
     <?php include_once('includes/footer.php');?>
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
      $(function(){
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
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

      });
    </script>
  </body>
</html>
<?php }  ?>
