<!-- NAVIGATION -->               
                        <nav id="navigation">
                        <!-- <nav class="navbar navbar-expand-lg"> -->
			<!-- container -->
			<div class="container navbar navbar-expand-lg">

				<!-- responsive-nav -->
				<div id="responsive-nav">
					<!-- NAV -->
					<ul class="main-nav nav navbar-nav">
						<li class="active"><a href="index.php">Home</a></li>
						<?php 
    $query=mysqli_query($con,"SELECT * FROM `category`");
	$cnt=1;
	while($row=mysqli_fetch_array($query))
	{ ?>


		
						<li><a href="categorywise-products.php?cid=<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['categoryName']);?></a></li>
						<!-- <li><a href="#">Categories</a></li>
						<li><a href="#">Laptops</a></li>
						<li><a href="#">Smartphones</a></li>
						<li><a href="#">Cameras</a></li>
						<li><a href="#">Accessories</a></li> -->
						<?php }?>
                    </ul>
					
					<!-- /NAV -->
				</div>
		
				<!-- /responsive-nav -->
            </div>
			<!-- /container -->
		</nav>
		<!-- /NAVIGATION -->
	