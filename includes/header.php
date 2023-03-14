<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Homepage </title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
         <script src="js/jquery.min.js"></script>
        <!-- tamplte -->
		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

		<!-- Slick -->
		<link type="text/css" rel="stylesheet" href="css/slick.css"/>
		<link type="text/css" rel="stylesheet" href="css/slick-theme.css"/>

		<!-- nouislider -->
		<link type="text/css" rel="stylesheet" href="css/nouislider.min.css"/>

		<!-- Font Awesome Icon -->
		<link rel="stylesheet" href="css/font-awesome.min.css">

		<!-- Custom stlylesheet -->
		<link type="text/css" rel="stylesheet" href="css/style.css"/>
        <!-- tamplte and -->
        <!-- icons fontawesome(user: tomer) -->
        <script src="https://kit.fontawesome.com/a6a9cf6622.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <!-- HEADER -->
		<header>
			<!-- TOP HEADER -->
			<div id="top-header">
				<div class="container">
					<ul class="header-links pull-left">
						<li><a href="#"><i class="fa fa-phone"></i> +021-95-51-84</a></li>
						<li><a href="#"><i class="fa fa-envelope-o"></i> email@email.com</a></li>
						<li><a href="#"><i class="fa fa-map-marker"></i> 1734 Stonecoal Road</a></li>
                        <li><a href="contact-us.php"><i class="fa-solid fa-earth-asia"></i>page contact</a></li>
					</ul>
					<ul class="header-links pull-right">
                    <?php 
					if(isset($_SESSION['id'])){
						
						if($_SESSION['id']==0){
					?>
                        <li class="nav-item dropdown">
						<li><a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-user"></i>Users</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item, text-danger" href="login.php"><i class="fa fa-user-o"></i>login</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item, text-danger" href="signup.php"><i class="fa fa-sign up"></i>Sign Up</a></li>
                        </ul>
                        </li>
                        </li>
					</ul>
                   
				</div>
			
				<?php } else {?> 
					<?php if($_SESSION['id']!=0):?>
						<strong class="text-white">Welcome:&nbsp;</strong> <l class="text-danger"> <?php echo $_SESSION['username'];?> </l>
					<?php endif;
					
				}?>

                        <!-- <li class="nav-item"><a class="nav-link" href="my-wishlist.php">My Wishlist</a></li> -->
                                <li class="nav-item dropdown">
                                <li><a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-user"></i>My Account</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item, text-danger" href="my-orders.php"><i class="fa fa-user-o"></i>Orders</a></li>
                                <li><a class="dropdown-item, text-danger" href="my-profile.php"><i class="fa fa-user-o"></i>Profile</a></li>
                                <li><a class="dropdown-item, text-danger" href="change-password.php"><i class="fa fa-user-o"></i>Change Password</a></li>
                                <li><a class="dropdown-item, text-danger" href="manage-addresses.php"><i class="fa fa-user-o"></i>Adresses</a></li>
                                <li><a class="dropdown-item, text-danger" href="logout.php"><i class="fa fa-user-o"></i>Logout</a></li>
                                </ul>
                                </li>
                        </li>
                     <?php } ?>  
                     </div>
			<!-- /TOP HEADER -->

			<!-- MAIN HEADER -->
			<div id="header">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<!-- LOGO -->
						<div class="col-md-3">
							<div class="header-logo">
								<a href="index.php" class="logo">
									<img src="./img/logo.png" alt="">
								</a>
							</div>
						</div>
						<!-- /LOGO -->

						<!-- SEARCH BAR -->
						<div class="col-md-6">
							<div class="header-search">
								<form method="POST" action="search-products.php">
									<input name="searchVal" class="input" placeholder="Search here">
									<button type="submit" name="searchPro" class="search-btn">Search</button>
								</form>
							</div>
						</div>
						<!-- /SEARCH BAR -->

						<!-- ACCOUNT -->
						<div class="col-md-3 clearfix">
							<div class="header-ctn">
								<!-- Wishlist -->
								<div>
                                <?php if(isset($_SESSION['id'])){
										if($_SESSION['id']==0){?>
                                    <?php } else {?>
									<a href="my-wishlist.php">
										<i class="fa fa-heart-o"></i>
										<span>Your Wishlist</span>
										<!-- <div class="qty">2</div> -->
									</a>
                                    <?php }
									}?>
								</div>
								<!-- /Wishlist -->
									<!-- Cart -->
									<?php
									if(isset($_SESSION['id'])){
										$uid=$_SESSION['id'];
										$ret=mysqli_query($con,"select products.productName as pname,products.productName as proid,products.productImage1 as pimage,products.productPrice as pprice,cart.productId as pid,cart.id as cartid,products.productPriceBeforeDiscount,cart.productQty from cart join products on products.id=cart.productId where cart.userId='$uid'");
										$num=mysqli_num_rows($ret);
										if($num>0)
										{
											while ($row=mysqli_fetch_array($ret)) {
												$uid=$_SESSION['id'];
												$ret=mysqli_query($con,"select sum(productQty) as qtyy from cart where userId='$uid'");
												$result=mysqli_fetch_array($ret);
												$cartcount=$result['qtyy'];
											?>
										<div class="">
										<a href="checkout.php" aria-expanded="true">
											<i class="fa fa-shopping-cart"></i>
											<span>Your Cart</span>
											<?php if($cartcount==0):?>
											<div class="qty">0</div>
											<?php else: ?>
												<div class="qty"><?php echo $cartcount; ?></div>
												<?php endif;?>
										</a>
										<div class="cart-dropdown">
												<div class="cart-list">
												<?php } ?>
												<div class="cart-btns">
													<a href="shop-categories.php">View Cart</a>
													<a href="checkout.php">Checkout  <i class="fa fa-arrow-circle-right"></i></a>
												</div>
											</div>
										</div>
									<?php 
								} else{ ?>
									<div class="cart-btns">
											<a href="shop-categories.php">עגלת קניות</a>
											<a href="checkout.php"><i class="fa fa-arrow-circle-right"></i></a>
										</div>
										<?php }
									}
									?>
								<!-- /Cart -->

								<!-- Menu Toogle -->
								<!-- <div class="menu-toggle">
									<a href="#">
										<i class="fa fa-bars"></i>
										<span>Menu</span>
									</a>
								</div> -->
								<!-- /Menu Toogle -->
							</div>
						</div>
						<!-- /ACCOUNT -->
					</div>
					<!-- row -->
				</div>
				<!-- container -->
			</div>
			<!-- /MAIN HEADER -->
		</header>
		<!-- /HEADER -->


		

