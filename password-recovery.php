<?php session_start();
include_once('includes/config.php');
// Code for User login
if(isset($_POST['submit']))
{
$email=safe($_POST['emailid']);
$ret=mysqli_query($con,"SELECT * FROM users WHERE email='$email'");
$num=mysqli_num_rows($ret);
if($num>0)
{
$user = $ret->fetch_assoc();
$randAuth = rand(10000,99999);
$query=mysqli_query($con,"INSERT INTO `passwords`(`userId`, `code`, `createDate`) VALUES ('".$user['id']."','".$randAuth."','".time()."')");
$subject = "GoShop: Password Recovery";
$body = "Click here to reset your password: https://gogo-shop.co.il/password-recovery.php?res=$randAuth";
$header = "From: Gogo2014@gmail.com";
$header .= "Reply-To: Gogo2014@gmail.com";	
if(!mail($user['email'], $subject, $body, $header))
  http_response_code(500);

echo "<script>alert('A recovery mail had been sent to your email.');</script>";
echo "<script type='text/javascript'> document.location ='index.php'; </script>";
}else{
echo "<script>alert('Invalid Email or Reg Contact Number');</script>";
echo "<script type='text/javascript'> document.location ='password-recovery.php'; </script>";
}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shopping | User Sign up</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <script src="js/jquery.min.js"></script>
       <!--  <link href="css/bootstrap.min.css" rel="stylesheet" /> -->
             <script type="text/javascript">
function valid()
{
 if(document.passwordrecovery.inputPassword.value!= document.passwordrecovery.cinputPassword.value)
{
alert("Password and Confirm Password Field do not match  !!");
document.passwordrecovery.cinputPassword.focus();
return false;
}
return true;
}
</script>
    </head>
<style type="text/css">
    input { border:solid 1px #000;

    }

</style>
    <body>
<?php include_once('includes/header.php');?>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">


                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">User Password Recovery </h1>
                   <!--  <p class="lead fw-normal text-white-50 mb-0">Login is required to make the order</p> -->
                </div>

            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4  mt-5">
<?php 
if(isset($_GET['res'])){
	$code = safe($_GET['res']);
	$checkRes = $con->query("SELECT * FROM `passwords` WHERE `code`='".$code."'");
	if($checkRes->num_rows == 0){
		echo "<script>alert('Invalid Code');</script>";
		echo "<script type='text/javascript'> document.location ='password-recovery.php'; </script>";
	}else{
		$resetFetch = $checkRes->fetch_assoc();
		$userQuery=mysqli_query($con,"SELECT * FROM `users` WHERE `id`='".$resetFetch['userId']."'");
		if((($resetFetch['createDate'] + 86400) < time()) || $userQuery->num_rows == 0){
			mysqli_query($con,"DELETE FROM `passwords` WHERE `id`='".$resetFetch['id']."'");
			echo "<script>alert('Outdated code, please try again');</script>";
			echo "<script type='text/javascript'> document.location ='password-recovery.php'; </script>";
		}else{
			$userFetch = $userQuery->fetch_assoc();
			if(isset($_POST['updatePassword'])){
				$p1NotHashed = safe($_POST['inputPassword']);
				$p1 = password($_POST['inputPassword']);
				$p2 = password($_POST['cinputPassword']);
				if(!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,200}/', $p1NotHashed)){
					echo "<script>alert('The password must be written with english letters and include one big letter and one number.');</script>";
					echo "<script type='text/javascript'> document.location ='password-recovery.php?res=".$resetFetch['code']."'; </script>";   
				}else if($p1 != $p2){
					echo "<script>alert('The passwords are not the same!');</script>";
					echo "<script type='text/javascript'> document.location ='password-recovery.php?res=".$resetFetch['code']."'; </script>"; 
				}else{
					$sql=mysqli_query($con,"UPDATE `users` SET `password`='".$p1."' WHERE `id`='".$userFetch['id']."'");
					$sql2=mysqli_query($con,"delete from passwords where id ='".$resetFetch['id']."'");
					echo "<script>alert('The passwords has been changed!');</script>";
					echo "<script type='text/javascript'> document.location ='login.php'; </script>"; 
				}
			}
			?>
			<form method="post" onSubmit="return valid();">
				   <div class="row mt-3">
					 <div class="col-2">Email Id</div>
					 <div class="col-6"><?php echo $userFetch['email']; ?></div>
				 </div>
				 
				 <div class="row mt-3">
					 <div class="col-2">New Password</div>
					 <div class="col-6"><input type="password" name="inputPassword" id="inputPassword" class="form-control" required></div>
				 </div>

						   <div class="row mt-3">
					 <div class="col-2">Password Recovery</div>
					 <div class="col-6"><input type="password" name="cinputPassword" id="cinputPassword" class="form-control" required></div>
				 </div>
				 <div class="row mt-3">
							 <div class="col-4">&nbsp;</div>
					 <div class="col-6"><input type="submit" name="updatePassword" id="submit" class="btn btn-primary" value="Submit" required></div>
				 </div>
			</form>
			<?php
		}
	}
}else{
	?>
	<form method="post" onSubmit="return valid();">

       <div class="row mt-3">
         <div class="col-2">Email Id</div>
         <div class="col-6"><input type="email" name="emailid" id="emailid" class="form-control"  required>
         </div>
                         <div class="row mt-3">
                 <div class="col-4">&nbsp;</div>
         <div class="col-6"><input type="submit" name="submit" id="submit" class="btn btn-primary" value="Submit" required></div>
     </div>
     </div>
 </form>
	<?php
}
?>
            
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
