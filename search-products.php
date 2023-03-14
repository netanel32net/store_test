<?php session_start();
error_reporting(0);

include_once('includes/config.php');
?>
<?php include_once('includes/header.php');?>
<?php include_once('includes/topBar.php');?>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
<?php 
if(isset($_POST['searchPro'])){
?>

                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Search</h1>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
<?php
$searchVal = safe($_POST['searchVal']);
$query = mysqli_query($con, "SELECT * FROM `products` WHERE `productName` LIKE '%".$searchVal."%'");
$count = mysqli_num_rows($query);
echo "<script>console.log('".$count."')</script>";
if($count>0){
while($row=mysqli_fetch_array($query))
{
?> 

                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="admin/productimages/<?php echo htmlentities($row['productImage1']);?>" width="350" height="300" alt="<?php echo htmlentities($row['productName']);?>" />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder"><?php echo htmlentities($row['productName']);?></h5>
                                    <!-- Product price-->
                                    <span class="text-decoration-line-through">$<?php echo htmlentities($row['productPriceBeforeDiscount']);?></span> - $<?php echo htmlentities($row['productPrice']);?>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="product-details.php?pid=<?php echo htmlentities($row['pid']);?>">View options</a></div>
                            </div>
                        </div>
                    </div>
                <?php } }  else{ ?>
     <h4 style="color:red">No Record found</h4>
<?php } ?>
                </div>
            </div>
		</div>
        </section>
        <!-- Footer-->
   <?php
}else{
	echo "<script type='text/javascript'> document.location ='index.php'; </script>";   
}
include_once('includes/footer.php'); ?>
