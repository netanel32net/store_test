		<!-- HEADER -->
		<header>
			<!-- TOP HEADER -->
			<div id="top-header">
				<div class="container">
					<ul class="header-links pull-left">
						<li><a href="#"><i class="fa fa-phone"></i> +021-95-51-84</a></li>
						<li><a href="#"><i class="fa fa-envelope-o"></i> email@email.com</a></li>
						<li><a href="#"><i class="fa fa-map-marker"></i> 1734 Stonecoal Road</a></li>
					</ul>
					<ul class="header-links pull-right">
                    <?php if($_SESSION['id']==0){?>
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
			
            <!-- שיניתי את הסוגר בשביל הבדיקה -->
            <?php } else {?>
                <?php if($_SESSION['id']!=0):?>
<strong class="text-white">Welcome:&nbsp;</strong> <l class="text-danger"> <?php echo $_SESSION['username'];?> </l>
<?php endif;?>

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
								<a href="#" class="logo">
									<img src="./img/logo.png" alt="">
								</a>
							</div>
						</div>
						<!-- /LOGO -->

						<!-- SEARCH BAR -->
						<div class="col-md-6">
							<div class="header-search">
								<form>
									<select class="input-select">
										<option value="0">All Categories</option>
										<option value="1">Category 01</option>
										<option value="1">Category 02</option>
									</select>
									<input class="input" placeholder="Search here">
									<button class="search-btn">Search</button>
								</form>
							</div>
						</div>
						<!-- /SEARCH BAR -->

						<!-- ACCOUNT -->
						<div class="col-md-3 clearfix">
							<div class="header-ctn">
								<!-- Wishlist -->
								<div>
                                <?php if($_SESSION['id']==0){?>
                                    <?php } else {?>
									<a href="my-wishlist.php">
										<i class="fa fa-heart-o"></i>
										<span>Your Wishlist</span>
										<!-- <div class="qty">2</div> -->
									</a>
                                    <?php }?>
								</div>
								<!-- /Wishlist -->

								<!-- Cart -->
								<div class="dropdown">
                                <?php 
$uid=$_SESSION['id'];
                        $ret=mysqli_query($con,"select sum(productQty) as qtyy from cart where userId='$uid'");
$result=mysqli_fetch_array($ret);
$cartcount=$result['qtyy'];
                        ?>
									<a href="my-cart.php" aria-expanded="true">
										<i class="fa fa-shopping-cart"></i>
										<span>Your Cart</span>
                                        <?php if($cartcount==0):?>
										<div class="qty">0</div>
                                        <?php else: ?>
                                            <div class="qty"><?php echo $cartcount; ?></div>
                                            <?php endif;?>
									</a>
									
							
								</div>
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