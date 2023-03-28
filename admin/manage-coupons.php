<?php session_start();
include_once('includes/config.php');
error_reporting(0);
if(strlen($_SESSION["aid"])==0)
{   
header('location:logout.php');
} else {
if($_GET['del']){
	$copid=$_GET['id'];
	mysqli_query($con,"delete from coupons where id ='$copid'");
	echo "<script>alert('Data Deleted');</script>";
	echo "<script>window.location.href='manage-coupons.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shopping Portal | Manage Coupons</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
 <?php include_once('includes/header.php');?>
        <div id="layoutSidenav">
       <?php include_once('includes/sidebar.php');?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Manage Coupons</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manage Coupons</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                               Coupons Details
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Discount Amount</th>
                                            <th>Creation date</th>
                                            <th>Expired</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
											<th>#</th>
                                            <th>Name</th>
                                            <th>Discount Amount</th>
                                            <th>Creation date</th>
                                            <th>Expired</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
<?php $query=mysqli_query($con,"select * from coupons");
$cnt=1;
while($row=mysqli_fetch_array($query))
{
?>  

                                <tr>
                                            <td><?php echo htmlentities($cnt);?></td>
                                            <td><?php echo htmlentities($row['value']);?></td>
                                            <td><?php echo htmlentities($row['amount']);?></td>
                                            <td><?php echo htmlentities(date('m/d/Y H:i:s', $row['start']));?></td>
                                            <td><?php echo htmlentities(date('m/d/Y H:i:s', $row['end']));?></td>
                                            <td>
                                            <a href="edit-coupon.php?id=<?php echo $row['id']?>"><i class="fas fa-edit"></i></a> | 
                                            <a href="manage-coupons.php?id=<?php echo $row['id']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                        </tr>
                                        <?php $cnt ++; } ?>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
<?php include_once('includes/footer.php');?>
                </footer>
            </div>
        </div>
        <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
<?php } ?>
