<?php session_start();
error_reporting(0);

include_once('includes/config.php');
// Code for User login
if(isset($_POST['login']))
{
	$email = safe($_POST['emailid']);
	$password = password($_POST['inputuserpwd']);
	$query=mysqli_query($con,"SELECT id,name FROM users WHERE email='$email' and password='$password'");
	$num=mysqli_fetch_array($query);
	//If Login Suceesfull
	if($num>0)
	{
		$_SESSION['login']=$_POST['email'];
		$_SESSION['id']=$num['id'];
		$_SESSION['username']=$num['name'];
		echo "<script type='text/javascript'> document.location ='index.php'; </script>";
	}
	//If Login Failed
	else{
		echo "<script>alert('Invalid login details');</script>";
		echo "<script type='text/javascript'> document.location ='login.php'; </script>";
		exit();
	}
}
?>

<style type="text/css">
    input { border:solid 1px #000;

    }

</style>
    
<?php include_once('includes/header.php');?>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">


                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">User Login /Signin </h1>
                    <p class="lead fw-normal text-white-50 mb-0">Login is required to make the order</p>
                </div>

            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4  mt-5">
     

<form method="post" name="login">

       <div class="row mt-3">
         <div class="col-2">Email Id</div>
         <div class="col-6"><input type="email" name="emailid" id="emailid" class="form-control" onBlur="emailAvailability()" required>
 <span id="user-email-status" style="font-size:12px;"></span>
         </div>
          
     </div>


          <div class="row mt-3">
         <div class="col-2">Password</div>
         <div class="col-6"><input type="password" name="inputuserpwd" class="form-control" required>
         <small><a href="password-recovery.php">Forgot Password?</a></small></div>

     </div>

               <div class="row mt-3">
                 <div class="col-4">&nbsp;</div>
         <div class="col-6"><input type="submit" name="login" id="login" class="btn btn-primary" value="Login" required></div>
     </div>
 </form>
              
            </div>

 
</div>
        </section>
        <!-- Footer-->
   <?php include_once('includes/footer.php'); ?>
