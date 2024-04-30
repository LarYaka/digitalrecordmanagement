<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if(isset($_POST['submit']))
  {
    $aname=$_POST['aname'];
    $uname=$_POST['uname'];
    $mobno=$_POST['mobno'];
    $email=$_POST['email'];
    $password=md5($_POST['password']);
    $ret="select MobileNumber from tbladmin where MobileNumber=:mobno";
    $query= $dbh -> prepare($ret);
    $query-> bindParam(':mobno', $mobno, PDO::PARAM_STR);
    $query-> execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() == 0)
{
$sql="Insert Into tbladmin(AdminName,UserName,MobileNumber,Email,Password)Values(:aname,:uname,:mobno,:email,:password)";
$query = $dbh->prepare($sql);
$query->bindParam(':aname',$aname,PDO::PARAM_STR);
$query->bindParam(':uname',$uname,PDO::PARAM_STR);
$query->bindParam(':mobno',$mobno,PDO::PARAM_INT);
$query->bindParam(':email',$email,PDO::PARAM_STR);

$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{

echo "<script>alert('You have signup  Succesfully');</script>";
}
else
{

echo "<script>alert('Something went wrong.Please try again');</script>";
}
}
 else
{

echo "<script>alert('This Email already exist. Please try again');</script>";
}
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
   

    <title>Digital Record Management and Reservation System for St. John the Baptist Parish Church Services||Sign Up page</title>

    <!-- vendor css -->
    <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">

    <!-- Amanda CSS -->
    <link rel="stylesheet" href="css/amanda.css">
  </head>

  <body>

    <div class="am-signin-wrapper">
      <div class="am-signin-box">
        <div class="row no-gutters">
          <div class="col-lg-5">
            <div>
              <h2>Admin Registration Page</h2>
              <p>Welcome to St. John the Baptist Parish Church</p>
              <img src="../images/SJBP Logo.jpg" width="200" height="200">

              <hr>
              <p><br> <a href="../index.php">Back Home</a></p>
            </div>
          </div>
          <div class="col-lg-7">
            <h5 class="tx-gray-800 mg-b-25">Admin Registration Form</h5>
 <form class="form-auth-small" action="" method="post">
            <div class="form-group">
              <label class="form-control-label">Admin Name:</label>
              <input type="text" class="form-control" placeholder="Admin Name" required="true" name="aname" value="" >
            </div><!-- form-group -->
<div class="form-group">
              <label class="form-control-label">User Name:</label>
              <input type="text" class="form-control" placeholder="User Name" required="true" name="uname" value="" >
            </div>
            <div class="form-group">
              <label class="form-control-label">Mobile Number:</label>
              <input type="text" class="form-control" placeholder="Mobile Number" required="true" name="mobno"  maxlength="10" pattern="[0-9]+" value="" >
            </div>
            <div class="form-group">
              <label class="form-control-label">Email:</label>
              <input type="text" class="form-control" placeholder="Email" required="true" name="email" value="" >
            </div>
            <div class="form-group">
              <label class="form-control-label">Password:</label>
              <input type="password" class="form-control" placeholder="Password" name="password" required="true" value="">
            </div><!-- form-group -->

           

            <button type="submit" class="btn btn-block" name="submit">Sign Up</button>
             <div class="form-group mg-b-20" style="padding-top: 20px"><a href="login.php">Do you have an account ? || signin</a></div>
          </div>
         </form>
        </div><!-- row -->
        <p class="tx-center tx-white-5 tx-12 mg-t-15">Copyright &copy; 2023. All Rights Reserved. Regina A. Caraan, John Reniel Ybañez and John Genesi Mamore</p>
      </div><!-- signin-box -->
    </div><!-- am-signin-wrapper -->

    <script src="lib/jquery/jquery.js"></script>
    <script src="lib/popper.js/popper.js"></script>
    <script src="lib/bootstrap/bootstrap.js"></script>
    <script src="lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>

    <script src="js/amanda.js"></script>
  </body>
</html>
