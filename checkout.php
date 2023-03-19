<?php session_start();
include_once('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['id'])==0)
{   header('location:logout.php');
}else{
// Code for Product deletion from  cart
if(isset($_SESSION['coupon']) && !isset($_GET['coupon'])){
	if($_SESSION['coupon'] != 0){
		echo "<script type='text/javascript'> document.location ='checkout.php?coupon=".$_SESSION['coupon']."'; </script>";
	}
}
if(isset($_GET['del']))
{
$wid=intval($_GET['del']);
$query=mysqli_query($con,"delete from cart where id='$wid'");
 echo "<script>alert('Product deleted from cart.');</script>";
echo "<script type='text/javascript'> document.location ='checkout.php'; </script>";
}
if(isset($_POST['cpSubmit'])){
	$cp = safe($_POST['cp']);
	echo "<script type='text/javascript'> document.location ='checkout.php?coupon=".$cp."'; </script>";
}
// For Address Insertion
if(isset($_POST['submit'])){
	$uid=$_SESSION['id'];    
	//Getting Post Values
	$address = safe($_POST['address']);
	$city = safe($_POST['city']);
	$state = safe($_POST['state']);
	$pincode = safe($_POST['pincode']);
	$country = safe($_POST['country']);
	if(!preg_match('/[א-תA-Za-z0-9.,\'\`\"_+-]{2,250}/', $address)){
		echo "<script>alert('Please enter a valid address.');</script>";
		echo "<script type='text/javascript'> document.location ='checkout.php'; </script>";
	}else if(!preg_match('/[א-תA-Za-z0-9.,\'\`\"_+-]{2,250}/', $city)){
		echo "<script>alert('Please enter a valid city.');</script>";
		echo "<script type='text/javascript'> document.location ='checkout.php'; </script>";
	}else if(!preg_match('/[א-תA-Za-z0-9.,\'\`\"_+-]{0,250}/', $state)){
		echo "<script>alert('Please enter a valid state.');</script>";
		echo "<script type='text/javascript'> document.location ='checkout.php'; </script>";
	}else if(!preg_match('/[0-9]{2,7}/', $pincode)){
		echo "<script>alert('Please enter a valid pin code.');</script>";
		echo "<script type='text/javascript'> document.location ='checkout.php'; </script>";
	}else if(!preg_match('/[א-תA-Za-z0-9.,\'\`\"_+-]{2,250}/', $country)){
		echo "<script>alert('Please enter a valid country.');</script>";
		echo "<script type='text/javascript'> document.location ='checkout.php'; </script>";		
	}else{	
		$sql=mysqli_query($con,"insert into addresses(userId,billingAddress,biilingCity,billingState,billingPincode,billingCountry,shippingAddress,shippingCity,shippingState,shippingPincode,shippingCountry) values('$uid','$address','$city','$state','$pincode','$country','$address','$city','$state','$pincode','$country')");
		if($sql)
		{
			echo "<script>alert('You Address added successfully');</script>";
			echo "<script type='text/javascript'> document.location ='checkout.php'; </script>";
		}
		else{
			echo "<script>alert('Something went wrong. Please try again.');</script>";
			echo "<script type='text/javascript'> document.location ='checkout.php'; </script>";
		}
	}
}
//For Proceeding Payment
if(isset($_POST['proceedpayment'])){
 $address=$_POST['selectedaddress'];  
 $gtotal=$_POST['grandtotal']; 
 $_SESSION['address']=$address;
 $_SESSION['gtotal']=$gtotal;
   echo "<script type='text/javascript'> document.location ='payment.php'; </script>";   
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shopping Portal | Checkout</title>
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
                    <h1 class="display-4 fw-bolder">Checkout</h1>
                </div>

            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4  mt-5">
     


        <table class="table">
            <thead>
                <tr>
                    <th colspan="4"><h4>My Cart</h4></th>
                </tr>
            </thead>
            <tr>
                <thead>
                    <th>Product</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Quantity</th>
                    <th>Total Amount</th>
                    <th>Action</th>
                </thead>
            </tr>
            <tbody>
<?php
$uid=$_SESSION['id'];
$ret=mysqli_query($con,"select products.productName as pname,products.productName as proid,products.productImage1 as pimage,products.productPrice as pprice,cart.productId as pid,cart.id as cartid,products.productPriceBeforeDiscount,cart.productQty from cart join products on products.id=cart.productId where cart.userId='$uid'");
$num=mysqli_num_rows($ret);
    if($num>0)
    {
while ($row=mysqli_fetch_array($ret)) {

?>

                <tr>
                    <td class="col-md-2"><a href="product-details.php?pid=<?php echo htmlentities($pd=$row['pid']);?>"><img src="admin/productimages/<?php echo htmlentities($row['pimage']);?>" alt="<?php echo htmlentities($row['pname']);?>" width="100" height="100"></a></td>
                    <td>
                       <a href="product-details.php?pid=<?php echo htmlentities($pd=$row['pid']);?>"><?php echo htmlentities($row['pname']);?></a>
        </td>
<td>
                           <span class="text-decoration-line-through">$<?php echo htmlentities($row['productPriceBeforeDiscount']);?></span>
                            <span>$<?php echo htmlentities($row['pprice']);?></span>
                    </td>
                    <td><?php echo htmlentities($row['productQty']);?></td>
                     <td><?php echo htmlentities($totalamount=$row['productQty']*$row['pprice']);?></td>
                    <td>
                        <a href="my-cart.php?del=<?php echo htmlentities($row['cartid']);?>" onClick="return confirm('Are you sure you want to delete?')" class="btn-upper btn btn-danger">Delete</a>
                    </td>
                </tr>
                <?php $grantotal+=$totalamount;
            }
			$discount = $grantotal;
			if(isset($_GET['coupon'])){
				$cp = safe($_GET['coupon']);
				$query=mysqli_query($con,"SELECT * FROM `coupons` WHERE value='$cp'");
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
						$discount = ($discount*$fetch['amount'])/100;
						if(!isset($_SESSION['coupon'])){
							$_SESSION['coupon'] = $cp;
						}else{
							if($_SESSION['coupon'] != $cp){
								$_SESSION['coupon'] = $cp;
							}
						}
					}
				}
			}
?>
<tr>
    <th colspan="4">Grand Total</th>
    <th colspan="2"><?php
	if($grantotal == $discount){
		echo $grantotal;
	}else{
		echo "<p class=\"text-decoration-line-through\">".$grantotal."</p>".($grantotal-$discount);
	}
	?></th>
</tr>
<tr>
	<td colspan="6">
	<?php
	if(isset($_SESSION['coupon'])){
		if($_SESSION['coupon'] != 0){
			echo "<center><h3><i><ins>\"".$fetch['value']."\"<ins></i> - ".$fetch['amount']."% OFF!</h3></center>";
		}
	}
	?>
		<center><form method="POST" action="checkout.php">
			<label>Coupon</label>
			<input type="text" style="border-radius: 25px; padding: 5px 5px;" name="cp" />
			<button type="submit" name="cpSubmit" class="btn-upper btn btn-primary">Update Discount</button>
		</form></center>
	</td>
</tr>
            <?php } else{  
    echo "<script type='text/javascript'> document.location ='my-cart.php'; </script>"; } ?>   
            </tbody>
        </table>
<h5>Already Listed Addresses</h5>
<?php 
$uid=$_SESSION['id'];
$query=mysqli_query($con,"select * from addresses where userId='$uid'");
$count=mysqli_num_rows($query);
if($count==0):
echo "<font color='red'>No addresses Found.</font>";
else:
 ?>
 <form method="post" action="payment.php">
<div class="row">
	<div class="col-12">
		  <table class="table">
				<thead>
					<tr>
						<th colspan="4"><h5>Shipping Address</h5></th>
					</tr>
				</thead>
				<tr>
					<thead>
						<th>#</th>
						<th width="250">Adresss</th>
						<th>City</th>
						<th>State</th>
						<th>Pincode</th>
						<th>Country</th>
				
					</thead>
				</tr>
				</table>  

	</div>
</div>
<!-- Fecthing Values-->
<?php while ($result=mysqli_fetch_array($query)) { ?>
<div class="row">
	<div class="col-12">
		  <table class="table">
				<tbody> 
					<tr>
						<td><input type="radio" name="selectedaddress" value="<?php echo $result['id'];?>" required></td>
						<td width="250"><?php echo $result['shippingAddress'];?></td>
						<td><?php echo $result['shippingCity'];?></td>
						<td><?php echo $result['shippingState'];?></td>
						<td><?php echo $result['shippingPincode'];?></td>
						<td><?php echo $result['shippingCountry'];?></td>
					</tr>
				</tbody>
				</table>  

	</div>
</div>


<?php } endif;?>
	<div align="right">
	 <button class="btn-upper btn btn-primary" type="submit" name="proceedpayment">Procced for Payment</button>
	</div>
</form>

<hr />
<form method="post" name="address">

     <div class="row">
        <!--Shipping Addresss --->
        <div class="col-12">
               <div class="row">
         <div class="col-9" align="center"><h5>New Shipping Address</h5></div>
         <hr />
     </div>
     <div class="row">
         <div class="col-3">Address</div>
         <div class="col-6"><input type="text" name="address"  id="saddress" class="form-control" required ></div>
     </div>
       <div class="row mt-3">
         <div class="col-3">City</div>
         <div class="col-6"><input type="text" name="city" id="scity" class="form-control" required>
         </div>
          
     </div>

       <div class="row mt-3">
         <div class="col-3">State</div>
         <div class="col-6"><input type="text" name="state" id="sstate" class="form-control" required></div>
     </div>

          <div class="row mt-3">
         <div class="col-3">Pincode</div>
         <div class="col-6"><input type="text" name="pincode" id="spincode" pattern="[0-9]+" title="only numbers" maxlength="6" class="form-control" required></div>
     </div>

           <div class="row mt-3">
         <div class="col-3">Country</div>
         <div class="col-6"><input type="text" name="country" id="scountry" class="form-control" required></div>
     </div>

      
 </div>
         <div class="row mt-3">
                 <div class="col-5">&nbsp;</div>
         <div class="col-6"><input type="submit" name="submit" id="submit" class="btn btn-primary" value="Add" required></div>
     </div>

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
        <script type="text/javascript">
    $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
                $('#saddress').val($('#baddress').val() );
                $('#scity').val($('#bcity').val());
                $('#sstate').val($('#bstate').val());
                $('#spincode').val( $('#bpincode').val());
                  $('#scountry').val($('#bcountry').val() );
            } 
            
        });
    });
</script>
    </body>
</html>
<?php } ?>
