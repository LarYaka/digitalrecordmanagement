<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (empty($_SESSION['omrsaid'])) {
    header('location:logout.php');
    exit();
} else {
    if (isset($_POST['submit'])) {
        $vid = $_GET['viewid'];
        $status = $_POST['status'];
        $remark = $_POST['remark'];

        $sql = "UPDATE tbluser SET Status=:status, Remark=:remark WHERE ID=:vid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':remark', $remark, PDO::PARAM_STR);
        $query->bindParam(':vid', $vid, PDO::PARAM_STR);
        $query->execute();

        echo '<script>alert("Remark has been updated")</script>';
        echo '<script>window.location.href ="useractivation.php"</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Digital Record Management and Reservation System for St. John the Baptist Parish Church Services || View Anointing of the Sick Application</title>

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
    <h5 class="am-title">User Management Status</h5>
</div><!-- am-pagetitle -->

<div class="am-mainpanel">
    <div class="am-pagebody">

        <div class="card pd-20 pd-sm-40">
            <h6 class="card-body-title">User Management Status</h6>

            <div class="table-wrapper" style="padding-top: 20px">
                <?php
                $vid = $_GET['viewid'];

                $sql = "SELECT * FROM tbluser WHERE ID=:vid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':vid', $vid, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);

                foreach ($results as $row) {
                    ?>
                    <table border="1" class="table table-bordered">
                        <tr align="center">
                            <td colspan="9" style="font-size:20px;color:blue">User Details</td>
                        </tr>
                        <tr>
                            <th scope="row">First Name</th>
                            <td><?php echo $row->FirstName; ?></td>
                            <th scope="row">Last Name</th>
                            <td><?php echo $row->LastName; ?></td>
                            <th scope="row">Mobile Number</th>
                            <td><?php echo $row->MobileNumber; ?></td>
                            <th>Email</th>
                            <td colspan="3"><?php echo $row->EmailAdd; ?></td>
                        </tr>
                        <tr>
                            <th colspan="2">Order Final Status</th>
                            <td colspan="2"><?php
                                $status = $row->Status;

                                if ($row->Status == "Activate") {
                                    echo "Your account has been activated";
                                } elseif ($row->Status == "Deactivate") {
                                    echo "Your account has been deactivated";
                                } else {
                                    echo "Pending";
                                }
                                ?>
                            </td>
                            <th colspan="2">Admin Remark</th>
                            <td colspan="4"><?php echo ($row->Status == "") ? "Your application has still pending" : htmlentities($row->Status); ?></td>
                        </tr>
                    </table>
                    <?php
                }
                ?>
            </div><!-- table-wrapper -->

            <?php if ($row->Status == "") { ?>
                <p align="center" style="padding-top: 20px">
                    <button class="btn btn-primary waves-effect waves-light w-lg" data-toggle="modal"
                            data-target="#myModal">Take Action
                    </button>
                </p>
            <?php } ?>

        </div><!-- card -->
    </div><!-- am-pagebody -->
    <?php include_once('includes/footer.php'); ?>
</div><!-- am-mainpanel -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Take Action</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" name="submit">
                    <table class="table table-bordered table-hover data-tables">
                        <tr>
                            <th>Remark :</th>
                            <td>
                                <textarea name="remark" placeholder="Remark" rows="12" cols="14" class="form-control"
                                          required></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th>Status :</th>
                            <td>
                                <select name="status" class="form-control" required>
                                    <option value="" selected="true"></option>
                                    <option value="Activate">Activate</option>
                                    <option value="Deactivate">Deactivate</option>
                                </select>
                            </td>
                        </tr>
                    </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-primary">Update</button>
            </div>
            </form>
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
    $(function () {
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
        $('.dataTables_length select').select2({minimumResultsForSearch: Infinity});

    });
</script>
</body>
</html>