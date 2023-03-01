<?php session_start();
include_once('includes/config.php');
error_reporting(0);
?>
<?php include_once('includes/header.php');?>
<?php include_once('includes/topBar.php');?>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Shop Categories</h1>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
<?php $query=mysqli_query($con,"select category.id as catid,category.categoryName from category ");
$cnt=1;
while($row=mysqli_fetch_array($query))
{
?> 

                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img src="assets/category.png"  alt="<?php echo htmlentities($row['categoryName']);?>" width="150" style="display: block;margin-left: auto; margin-right: auto; width: 40%;" />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder"><?php echo htmlentities($row['categoryName']);?></h5>
                                    <!-- Product price-->
               
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="categorywise-products.php?cid=<?php echo htmlentities($row['catid']);?>">View options</a></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
     
    

                </div>
            </div>

 
</div>
        </section>
        <!-- Footer-->
   <?php include_once('includes/footer.php'); ?>

