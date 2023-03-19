<?php session_start();
include_once('includes/config.php');
if(strlen($_SESSION['id'])==0)
{   header('location:logout.php');
}else{
if($_SESSION['address']==0):
    echo "<script type='text/javascript'> document.location ='checkout.php'; </script>";
endif;    

$grantotal = 0;

//Order details
if(isset($_POST['proceedpayment'])){
	$uid=$_SESSION['id'];
	$ret=mysqli_query($con,"select products.productName as pname,products.productName as proid,products.productImage1 as pimage,products.productPrice as pprice,cart.productId as pid,cart.id as cartid,products.productPriceBeforeDiscount,cart.productQty from cart join products on products.id=cart.productId where cart.userId='$uid'");
	$num=mysqli_num_rows($ret);
	if($num>0)
	{
		while ($row=mysqli_fetch_array($ret)) {
			$totalamount = $row['productQty'] * $row['pprice'];
			$grantotal+=$totalamount;
		}
		if(isset($_SESSION['coupon'])){
			$query=mysqli_query($con,"SELECT * FROM `coupons` WHERE value='".$_SESSION['coupon']."'");
			if($query->num_rows == 0){
				$_SESSION['coupon'] = 0;
				echo "<script>alert('The coupon is not exists.');</script>";
				echo "<script type='text/javascript'> document.location ='checkout.php'; </script>";
			}else{
				$fetch = $query->fetch_assoc();
				if($fetch['active'] == 0){
					$_SESSION['coupon'] = 0;
					echo "<script>alert('The coupon is not valid anymore.');</script>";
					echo "<script type='text/javascript'> document.location ='checkout.php'; </script>";
				}else if($fetch['start'] != 0 && $fetch['end'] < time()){
					$_SESSION['coupon'] = 0;
					echo "<script>alert('The coupon is not valid anymore.');</script>";
					echo "<script type='text/javascript'> document.location ='checkout.php'; </script>";
				}else{
					$grantotal = $grantotal-($grantotal*$fetch['amount'])/100;
				}
			}
		}
	}else{
		echo "<script type='text/javascript'> document.location ='index.php'; </script>";	
	}
}else{
	echo "<script type='text/javascript'> document.location ='index.php'; </script>";
	exit;
}
if(isset($_POST['submit']))
{
$orderno= mt_rand(100000000,999999999);
$userid=$_SESSION['id'];
$address=$_SESSION['address'];
$txntype=$_POST['paymenttype'];
$txnno=$_POST['txnnumber'];
$query=mysqli_query($con,"insert into orders(orderNumber,userId,addressId,totalAmount,txnType,txnNumber) values('$orderno','$userid','$address','$totalamount','$txntype','$txnno')");
if($query)
{

$sql="insert into ordersdetails (userId,productId,quantity) select userID,productId,productQty from cart where userID='$userid';";
$sql.="update ordersdetails set orderNumber='$orderno' where userId='$userid' and orderNumber is null;";
$sql.="delete from  cart where userID='$userid'";
$result = mysqli_multi_query($con, $sql);
if ($query) {
unset($_SESSION['address']);
unset($_SESSION['gtotal']);    
echo '<script>alert("Your order successfully placed. Order number is "+"'.$orderno.'")</script>';
    echo "<script type='text/javascript'> document.location ='my-orders.php'; </script>";
} } else{
echo "<script>alert('Something went wrong. Please try again');</script>";
    echo "<script type='text/javascript'> document.location ='payment.php'; </script>";
} }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shopping | Payment</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <script src="js/jquery.min.js"></script>
       <!--  <link href="css/bootstrap.min.css" rel="stylesheet" /> -->
    </head>
<style type="text/css"></style>
    <body>
<?php include_once('includes/header.php');?>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">


                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Payment</h1>
                </div>

            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4  mt-5">
     

<form method="post" name="signup">
     <div class="row">
         <div class="col-2">Total Payment</div>
         <div class="col-6"><input type="text" name="totalamount" value="<?php echo $grantotal;?>" class="form-control" readonly ></div>
     </div>
       <div class="row mt-3">
         <div class="col-2">Payment Type</div>
         <div class="col-6">

            <select class="form-control" name="paymenttype" id="paymenttype" required>
                <option value="">Select</option>
                <option value="e-Wallet">E-Wallet</option>
                <option value="Internet Banking">Internet Banking</option>
                <option value="Debit/Credit Card">Debit/Credit Card</option>
                <option value="Cash on Delivery">Cash on Delivery (COD)</option>
            </select>
         </div>
          
     </div>

       <div class="row mt-3" id="txnno">
         <div class="col-2">Transaction Number</div>
         <div class="col-6"><input type="text" name="txnnumber" id="txnnumber" class="form-control" maxlength="50"></div>
     </div>


               <div class="row mt-3">
                 <div class="col-4">&nbsp;</div>
         <div class="col-6"><input type="submit" name="submit" id="submit" class="btn btn-primary" required></div>
     </div>
 </form>
              
            </div>

 
</div>
        </section>
        <!-- Footer-->
   <?php include_once('includes/footer.php'); ?>
        <!-- Bootstrap core JS-->
        <script src="js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
<script type="text/javascript">

  //For report file
  $('#txnno').hide();
  $(document).ready(function(){
  $('#paymenttype').change(function(){
  if($('#paymenttype').val()=='Cash on Delivery')
  {
  $('#txnno').hide();
  } else if($('#paymenttype').val()==''){
      $('#txnno').hide();
  } else{
    $('#txnno').show();
  jQuery("#txnnumber").prop('required',true);  
  }
})}) 
</script>
<?php } ?>
