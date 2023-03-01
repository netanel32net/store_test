						<!-- store products -->
						<div class="row">
						<?php 

if (isset($_GET['page_no']) && $_GET['page_no']!="") {
    $page_no = $_GET['page_no'];
    } else {
        $page_no = 1;
        }
 
    $total_records_per_page = 12;
    $offset = ($page_no-1) * $total_records_per_page;
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;
    $adjacents = "2"; 
 
    $result_count = mysqli_query($con,"SELECT COUNT(*) As total_records FROM products ");
    $total_records = mysqli_fetch_array($result_count);
    $total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
    $second_last = $total_no_of_pages - 1; // total page minus 1


    $query=mysqli_query($con,"select products.id as pid,products.productImage1,products.productName,products.productPriceBeforeDiscount,products.productPrice from products order by pid desc LIMIT $offset, $total_records_per_page ");
$cnt=1;
while($row=mysqli_fetch_array($query))
{
?> 
							<!-- product -->
							<div class="col-md-4 col-xs-6">
								<div class="product">
									<div class="product-img">
										<img src="admin/productimages/<?php echo htmlentities($row['productImage1']);?>" alt="<?php echo htmlentities($row['productName']);?>">
										<div class="product-label">
											<span class="sale">-30%</span>
											<span class="new">NEW</span>
										</div>
									</div>
									<div class="product-body">
										<!-- <p class="product-category">Category</p> -->
										<h3 class="product-name"><a href="product-details.php?pid=<?php echo htmlentities($row['pid']);?>"><?php echo htmlentities($row['productName']);?></a></h3>
										<h4 class="product-price"><?php echo htmlentities($row['productPrice']);?><del class="product-old-price"><?php echo htmlentities($row['productPriceBeforeDiscount']);?></del></h4>
										<div class="product-rating">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
										</div>
										<!-- <div class="product-btns">
											<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>
											<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
											<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
										</div> -->
									</div>
									<div class="add-to-cart">
										<button class="add-to-cart-btn"><a href="product-details.php?pid=<?php echo htmlentities($row['pid']);?>" class="fa fa-shopping-cart"></a> add to cart</button>
									</div>
								</div>
							</div>
							<!-- /product -->
							<div class="clearfix visible-sm visible-xs"></div>
							<?php } ?>  
						</div>
						<!-- /store products -->