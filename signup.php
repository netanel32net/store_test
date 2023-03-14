<?php session_start();
include_once('includes/config.php');
if(isset($_SESSION['id'])){
	echo "<script type='text/javascript'> document.location ='index.php'; </script>";   
}
if(isset($_POST['submit']) && !isset($_SESSION['id'])){
	$name = safe($_POST['fullname']);
	$email = safe($_POST['emailid']);
	$contactno = safe($_POST['contactnumber']);
	$password = safe($_POST['inputuserpwd']);
	$passwordHashed = password($_POST['inputuserpwd']);
	$sql = mysqli_query($con,"select id from users where email='$email'");
	$count = mysqli_num_rows($sql);
	if($count != 0){
		echo "<script>alert('Email id already registered with another accout. Please try  with another email id.');</script>";
		echo "<script type='text/javascript'> document.location ='signup.php'; </script>";   
	}else if(!preg_match('/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$/', $email) || strlen($email) > 200){
		echo "<script>alert('You must use the Email pattern. Please try again.');</script>";
		echo "<script type='text/javascript'> document.location ='signup.php'; </script>";   
	}else if(!preg_match('/[א-תA-Za-z0-9]{2,50}/', $name)){
		echo "<script>alert('Please write you full name currectly.');</script>";
		echo "<script type='text/javascript'> document.location ='signup.php'; </script>";   
	}else if(!preg_match('/^[0-9]{10}+$/', $contactno)){
		echo "<script>alert('Please write your real phone number.');</script>";
		echo "<script type='text/javascript'> document.location ='signup.php'; </script>";   
	}else if(!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,200}/', $password)){
		echo "<script>alert('The password must be written with english letters and include one big letter and one number.');</script>";
		echo "<script type='text/javascript'> document.location ='signup.php'; </script>";   
	}else{
		$query=mysqli_query($con,"insert into users(name,email,contactno,password) values('$name','$email','$contactno','$passwordHashed')");
		if($query)
		{
			echo "<script>alert('You are successfully register');</script>";
			echo "<script type='text/javascript'> document.location ='login.php'; </script>";
		}else{
			echo "<script>alert('Not register something went worng');</script>";
			echo "<script type='text/javascript'> document.location ='signup.php'; </script>";
		}
	}
}
?>
<script>
function emailAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'email='+$("#emailid").val(),
type: "POST",
success:function(data){
$("#user-email-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>
<style type="text/css"></style>
    <body>
<?php include_once('includes/header.php');?>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">


                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">User Signup</h1>
                    <p class="lead fw-normal text-white-50 mb-0">One Time Registration is Required for Shopping</p>
                </div>

            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4  mt-5">
     

<form method="post" name="signup">
     <div class="row">
         <div class="col-2">Full Name</div>
         <div class="col-6"><input type="text" name="fullname" class="form-control" required ></div>
     </div>
       <div class="row mt-3">
         <div class="col-2">Email Id</div>
         <div class="col-6"><input type="email" name="emailid" id="emailid" class="form-control" onBlur="emailAvailability()" required>
 <span id="user-email-status" style="font-size:12px;"></span>
         </div>
          
     </div>

       <div class="row mt-3">
         <div class="col-2">Contact Number</div>
         <div class="col-6"><input type="text" name="contactnumber" pattern="[0-9]{10}" title="10 numeric characters only" class="form-control" required></div>
     </div>

          <div class="row mt-3">
         <div class="col-2">Password</div>
         <div class="col-6"><input type="password" name="inputuserpwd" class="form-control" required></div>
     </div>

               <div class="row mt-3">
                 <div class="col-4">&nbsp;</div>
         <div class="col-6"><input type="submit" name="submit" id="submit" class="btn btn-primary" required></div>
     </div>
 </form>
              
            </div>

 
</div>
        </section>
        <!-- Footer-->
   <?php include_once('includes/footer.php'); ?>
