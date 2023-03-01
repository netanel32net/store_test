<?php session_start();
include_once('includes/config.php');
error_reporting(0);

//Code for Wish List
$pid=intval($_GET['pid']);
if(isset($_POST['wishlist'])){
if(strlen($_SESSION['id'])==0)
{   
echo "<script>alert('Login is required to wishlist a product');</script>";
} else{
$userid=$_SESSION['id'];    
$query=mysqli_query($con,"select id from wishlist where userId='$userid' and productId='$pid'");
$count=mysqli_num_rows($query);
if($count==0){
mysqli_query($con,"insert into wishlist(userId,productId) values('$userid','$pid')");
echo "<script>alert('Product aaded in wishlist');</script>";
  echo "<script type='text/javascript'> document.location ='my-wishlist.php'; </script>";
} else { 
echo "<script>alert('This product is already added in your wishlist.');</script>";
}
}}

//Code for Adding Product in to Cart
if(isset($_POST['addtocart'])){
if(strlen($_SESSION['id'])==0)
{   
echo "<script>alert('Login is required to add a product in to the cart');</script>";
} else{
$userid=$_SESSION['id']; 
$pqty=$_POST['inputQuantity'];  
$query=mysqli_query($con,"select id,productQty from cart where userId='$userid' and productId='$pid'");
$count=mysqli_num_rows($query);
if($count==0){
mysqli_query($con,"insert into cart(userId,productId,productQty) values('$userid','$pid','$pqty')");
echo "<script>alert('Product aaded in cart');</script>";
  echo "<script type='text/javascript'> document.location ='my-cart.php'; </script>";
} else { 
$row=mysqli_fetch_array($query);
$currentpqty=$row['productQty'];
$productqty=$pqty+$currentpqty;
mysqli_query($con,"update cart set productQty='$productqty' where userId='$userid' and productId='$pid'");
echo "<script>alert('Product aaded in cart');</script>";
  echo "<script type='text/javascript'> document.location ='my-cart.php'; </script>";
}
}}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shopping Portal  | Product Details</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Navigation-->
<?php include_once('includes/header.php');?>
<?php include_once('includes/topBar.php');?>
        <!-- Product section-->

		<?php 
$pid=intval($_GET['pid']);
$query=mysqli_query($con,"select products.id as pid,products.productImage1,products.productImage2,products.productImage3,products.productName,category.categoryName,subcategory.subcategoryName as subcatname,products.postingDate,products.updationDate,subcategory.id as subid,tbladmin.username,category.id as catid,products.productCompany,products.productPrice,products.productPriceBeforeDiscount,products.productAvailability,products.productDescription,products.shippingCharge from products join subcategory on products.subCategory=subCategory.id join category on products.category=category.id join tbladmin on tbladmin.id=products.addedBy where  products.id='$pid'");
while($row=mysqli_fetch_array($query))
{
$catid=$row['catid'];
?>
<form method="post">
<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<ul class="breadcrumb-tree">
							<li><a href="index.php">Home</a></li>
							<li><a href="shop-categories.php">All Categories</a></li>
							<li><a href="categorywise-products.php?cid=<?php echo htmlentities($row['catid']);?>"><?php echo htmlentities($row['categoryName']);?></a></li>		
							<li class="active"><?php echo htmlentities($row['subcatname']);?></li>
							<li class="active"><?php echo htmlentities($row['productName']);?></li>
						</ul>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /BREADCRUMB -->


		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- Product main img -->
					<div class="col-md-5 col-md-push-2">
						<div id="product-main-img">
							<div class="product-preview">
								<img src="admin/productimages/<?php echo htmlentities($row['productImage1']);?>" alt="<?php echo htmlentities($row['productName']);?>">
							</div>

							<div class="product-preview">
								<img src="admin/productimages/<?php echo htmlentities($row['productImage2']);?>" alt="<?php echo htmlentities($row['productName']);?>">
							</div>

							<div class="product-preview">
								<img src="admin/productimages/<?php echo htmlentities($row['productImage3']);?>" alt="<?php echo htmlentities($row['productName']);?>">
							</div>

						</div>
					</div>
					<!-- /Product main img -->

					<!-- Product thumb imgs -->
					<div class="col-md-2  col-md-pull-5">
						<div id="product-imgs">
							<div class="product-preview">
								<img src="admin/productimages/<?php echo htmlentities($row['productImage1']);?>" alt="<?php echo htmlentities($row['productName']);?>">
							</div>

							<div class="product-preview">
								<img src="admin/productimages/<?php echo htmlentities($row['productImage2']);?>" alt="<?php echo htmlentities($row['productName']);?>">
							</div>

							<div class="product-preview">
								<img src="admin/productimages/<?php echo htmlentities($row['productImage3']);?>" alt="<?php echo htmlentities($row['productName']);?>">
							</div>

						</div>
					</div>
					<!-- /Product thumb imgs -->

					<!-- Product details -->
					<div class="col-md-5">
						<div class="product-details">
							<h2 class="product-name"><?php echo htmlentities($row['productName']);?></h2>
							<div>
								<div class="product-rating">
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star-o"></i>
								</div>
								<a class="review-link" href="#">10 Review(s) | Add your review</a>
							</div>
							<div>
								<h3 class="product-price"><?php echo htmlentities($row['productPrice']);?><del class="product-old-price"><?php echo htmlentities($row['productPriceBeforeDiscount']);?></del></h3>
								<!-- <span class="product-available">In Stock</span> -->
							</div>
							<p><?php echo $row['productDescription'];?></p>

							<!-- <div class="product-options">
								<label>
									Size
									<select class="input-select">
										<option value="0">X</option>
									</select>
								</label>
								<label>
									Color
									<select class="input-select">
										<option value="0">Red</option>
									</select>
								</label>
							</div> -->
							<?php if($row['productAvailability']=='In Stock'):?>
								<div class="d-flex">
								<input class="form-control text-center me-3" id="inputQuantity" name="inputQuantity" type="num" value="1" style="max-width: 3rem" />
							<div class="add-to-cart">

								<button class="add-to-cart-btn" type="submit" name="addtocart">
									<i class="fa fa-shopping-cart"></i> 
									add to cart
								</button>
							</div>

							<ul class="product-btns">
								<li><button type="submit" name="wishlist"><i class="fa fa-heart-o"></i> add to wishlist</button></li>
								
							</ul>
							</div>
							<?php else: ?>
								<div class="add-to-cart">

								<button class="add-to-cart-btn" type="submit" >
									<i class="fa fa-shopping-cart"></i> Out of Stock
								</button>
							</div>
							
							<?php endif;?>  

							<ul class="product-links">
								<li>Category:</li>
								<li><a href="#"><?php echo htmlentities($row['categoryName']);?></a></li>
								<li>Sub Category:</li>
								<li><a href="#"><?php echo htmlentities($row['subcatname']);?></a></li>
							</ul>

							<ul class="product-links">
								<li>Share:</li>
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
								<li><a href="#"><i class="fa fa-envelope"></i></a></li>
							</ul>

						</div>
					</div>
					<!-- /Product details -->

					<!-- Product tab -->
					<div class="col-md-12">
						<div id="product-tab">
							<!-- product tab nav -->
							<ul class="tab-nav">
								<li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
								<li><a data-toggle="tab" href="#tab2">Details</a></li>
								<li><a data-toggle="tab" href="#tab3">Reviews (3)</a></li>
							</ul>
							<!-- /product tab nav -->

							<!-- product tab content -->
							<div class="tab-content">
								<!-- tab1  -->
								<div id="tab1" class="tab-pane fade in active">
									<div class="row">
										<div class="col-md-12">
											<p><?php echo $row['productDescription'];?></p>
										</div>
									</div>
								</div>
								<!-- /tab1  -->

								<!-- tab2  -->
								<div id="tab2" class="tab-pane fade in">
									<div class="row">
										<div class="col-md-12">
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
										</div>
									</div>
								</div>
								<!-- /tab2  -->

								<!-- tab3  -->
								<div id="tab3" class="tab-pane fade in">
									<div class="row">
										<!-- Rating -->
										<div class="col-md-3">
											<div id="rating">
												<div class="rating-avg">
													<span>4.5</span>
													<div class="rating-stars">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star-o"></i>
													</div>
												</div>
												<ul class="rating">
													<li>
														<div class="rating-stars">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
														</div>
														<div class="rating-progress">
															<div style="width: 80%;"></div>
														</div>
														<span class="sum">3</span>
													</li>
													<li>
														<div class="rating-stars">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o"></i>
														</div>
														<div class="rating-progress">
															<div style="width: 60%;"></div>
														</div>
														<span class="sum">2</span>
													</li>
													<li>
														<div class="rating-stars">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
														</div>
														<div class="rating-progress">
															<div></div>
														</div>
														<span class="sum">0</span>
													</li>
													<li>
														<div class="rating-stars">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
														</div>
														<div class="rating-progress">
															<div></div>
														</div>
														<span class="sum">0</span>
													</li>
													<li>
														<div class="rating-stars">
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
														</div>
														<div class="rating-progress">
															<div></div>
														</div>
														<span class="sum">0</span>
													</li>
												</ul>
											</div>
										</div>
										<!-- /Rating -->

										<!-- Reviews -->
										<div class="col-md-6">
											<div id="reviews">
												<ul class="reviews">
													<li>
														<div class="review-heading">
															<h5 class="name">John</h5>
															<p class="date">27 DEC 2018, 8:0 PM</p>
															<div class="review-rating">
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star-o empty"></i>
															</div>
														</div>
														<div class="review-body">
															<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
														</div>
													</li>
													<li>
														<div class="review-heading">
															<h5 class="name">John</h5>
															<p class="date">27 DEC 2018, 8:0 PM</p>
															<div class="review-rating">
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star-o empty"></i>
															</div>
														</div>
														<div class="review-body">
															<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
														</div>
													</li>
													<li>
														<div class="review-heading">
															<h5 class="name">John</h5>
															<p class="date">27 DEC 2018, 8:0 PM</p>
															<div class="review-rating">
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star-o empty"></i>
															</div>
														</div>
														<div class="review-body">
															<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
														</div>
													</li>
												</ul>
												<ul class="reviews-pagination">
													<li class="active">1</li>
													<li><a href="#">2</a></li>
													<li><a href="#">3</a></li>
													<li><a href="#">4</a></li>
													<li><a href="#"><i class="fa fa-angle-right"></i></a></li>
												</ul>
											</div>
										</div>
										<!-- /Reviews -->

										<!-- Review Form -->
										<div class="col-md-3">
											<div id="review-form">
												<form class="review-form">
													<input class="input" type="text" placeholder="Your Name">
													<input class="input" type="email" placeholder="Your Email">
													<textarea class="input" placeholder="Your Review"></textarea>
													<div class="input-rating">
														<span>Your Rating: </span>
														<div class="stars">
															<input id="star5" name="rating" value="5" type="radio"><label for="star5"></label>
															<input id="star4" name="rating" value="4" type="radio"><label for="star4"></label>
															<input id="star3" name="rating" value="3" type="radio"><label for="star3"></label>
															<input id="star2" name="rating" value="2" type="radio"><label for="star2"></label>
															<input id="star1" name="rating" value="1" type="radio"><label for="star1"></label>
														</div>
													</div>
													<button class="primary-btn">Submit</button>
												</form>
											</div>
										</div>
										<!-- /Review Form -->
									</div>
								</div>
								<!-- /tab3  -->
							</div>
							<!-- /product tab content  -->
						</div>
					</div>
					<!-- /product tab -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

</form>
<?php } ?>
        <!-- Footer-->
		<?php include_once('includes/footer.php'); ?>
