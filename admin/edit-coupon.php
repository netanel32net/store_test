<?php session_start();
include_once('includes/config.php');
error_reporting(0);
if(strlen( $_SESSION["aid"])==0)
{   
header('location:logout.php');
} else {

//For Adding categories
if(isset($_POST['submit']))
{
$id=intval($_GET['id']);
$value=$_POST['value'];
$amount=$_POST['amount'];
$end= strtotime($_POST['end']);;
$sql=mysqli_query($con,"update coupons set value='$value',amount='$amount',end='$end' where id='$id'");
echo "<script>alert('Coupons Details updated');</script>";
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
        <title>Shopping Portal | Edit Coupon</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body>
   <?php include_once('includes/header.php');?>
        <div id="layoutSidenav">
   <?php include_once('includes/sidebar.php');?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Edit Coupon</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Coupon</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
<?php
$id=intval($_GET['id']);
$query=mysqli_query($con,"select * from coupons where id='$id'");
while($row=mysqli_fetch_array($query))
{
?>	                            	
<form  method="post">                                
<div class="row">
<div class="col-2">Coupon Name</div>
<div class="col-4"><input type="text" value="<?php echo htmlentities($row['value']);?>"  name="value" class="form-control" required></div>
</div><br />
<div class="row">
<div class="col-2">Coupon Discount Amount</div>
<div class="col-4"><input type="text" value="<?php echo htmlentities($row['amount']);?>"  name="amount" class="form-control" required></div>
</div>
<div class="row" style="margin-top:1%;">
<div class="col-2">Created Date</div>
<div class="col-4"><?php echo htmlentities(date('m/d/Y H:i:s', $row['start']));?></div>
</div>
<div class="row" style="margin-top:1%;">
<div class="col-2">Expired Date</div>
<div class="col-4"><input type="date" name="end" value="<?php echo htmlentities(date('Y-m-d', $row['end']));?>" /></div>
</div>
<div class="row">
<div class="col-2"><button type="submit" name="submit" class="btn btn-primary">Update</button></div>
</div>

</form>
<?php } ?>
                            </div>
                        </div>
                    </div>
                </main>
          <?php include_once('includes/footer.php');?>
            </div>
        </div>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
<?php } ?>
