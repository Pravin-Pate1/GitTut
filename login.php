<?php 
Include_once("include/functions.php");
$functions = New Functions();
//print_R($_POST);
if($loggedInUserDetailsArr = $functions->sessionExists()){
	header("location: ".BASE_URL."/my-orders.php");
	exit;
}
if(isset($_POST["c_fname"]) && !empty($_POST["c_fname"]) && isset($_POST["c_email"]) && !empty($_POST["c_email"])){
	$functions->addUser($_POST);
	header("location:login.php?successfulReg");
	exit;
}
if(isset($_POST["btnLogin"])){
	$successURL ="my-orders.php";
	$functions->userLogin($_POST, $successURL, "login.php?failed");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Pharma</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Rubik:400,700|Crimson+Text:400,400i" rel="stylesheet">
  <link rel="stylesheet" href="fonts/icomoon/style.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/style.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  <style>
  .error{
	  color:red;
  }
  </style>
</head>

<body>

  <div class="site-wrap">


    <?php include_once "include/header.php"; ?>

    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0">
            <a href="index.php">Home</a> <span class="mx-2 mb-0">/</span>
            <?php if(isset($_GET["registration"])){ ?>
					<strong class="text-black">User Registration</strong>
			<?php }else{ ?>		
					<strong class="text-black">User Login</strong>
			<?php } ?>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
			
          <div class="col-md-12">
			
			
			<?php if(isset($_GET["registration"])){ ?>
				<h2 class="h3 mb-5 text-black">User Registration</h2>
			<?php }else{ ?>		
				<h2 class="h3 mb-5 text-black">User Login</h2>
			<?php } ?>
          </div>
          <div class="col-md-12">
				<?php if(isset($_GET['successfulReg'])){ ?>
						<div class="alert alert-success" role="alert">
							<h4 class="alert-heading">Well done!</h4>
							<p>Thank you for registering with <b>PHARMA</b>.Your registration is now confirmed.</p>
							<hr>
							<p class="mb-0">Your account is in under verification.Will get back to you soon.</p>
						</div>
				<?php }if(isset($_GET["failed"]) && !isset($_GET["user-not-verified"])){ ?>
						<div class="alert alert-danger" role="alert">
							<h4 class="alert-heading">OOPS!</h4>
							<p>Something Went Wrong.Please try again</p>
							<hr>
							<p class="mb-0">Please enter valid email id and password</p>
						</div>
				<?php }if(isset($_GET["user-not-verified"])){  ?>
						<div class="alert alert-danger" role="alert">
							<h4 class="alert-heading">OOPS!</h4>
							<p>Something Went Wrong.</p>
							<hr>
							<p class="mb-0">Your account is not verified yet. Kindly contact our admin.</p>
						</div>
				<?php } ?>
				
		  
    <?php if(isset($_GET["registration"])){ ?>
            <form action="" method="post" id="registration">
              <div class="p-3 p-lg-5 border">
                <div class="form-group row">
                  <div class="col-md-6">
                    <label for="c_fname" class="text-black">First Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="c_fname" name="c_fname">
                  </div>
                  <div class="col-md-6">
                    <label for="c_lname" class="text-black">Last Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="c_lname" name="c_lname">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-5">
                    <label for="c_email" class="text-black">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="c_email" name="c_email" placeholder="">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-5">
                    <label for="dob" class="text-black">Date of Birth </label>
                    <input type="date" class="form-control" id="dob" name="dob">
                  </div>
                </div>
    
               <div class="form-group row">
                  <div class="col-md-6">
                    <label for="" class="text-black">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="password" name="password">
                  </div>
                  <div class="col-md-6">
                    <label for="" class="text-black">Re-password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="repassword" name="repassword">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-lg-3">
                    <input type="submit" class="btn btn-primary btn-lg btn-block" value="Sign up">
                  </div>
				  <div class="col-lg-12">
					<a href="login.php" style="padding:0px;color:black;"><b>Back To <u>Login</u></b></a>
				</div>
                </div>
              </div>
            </form>
	<?php }else{ ?>	
			<form action="" id="Frmlogin" method="post">
              <div class="p-3 p-lg-5 border">
               <div class="form-group row">
                  <div class="col-md-5">
                    <label for="email" class="text-black">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="">
                  </div>
               </div>
               <div class="form-group row">
                  <div class="col-md-5">
                    <label for="" class="text-black">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="password" name="password">
                  </div>
               </div>
                <div class="form-group row">
					<div class="col-lg-3">
						<input type="submit" class="btn btn-primary btn-lg btn-block" name="btnLogin" id="btnLogin" value="Login">
					</div>
					<div class="col-lg-12">
						<a href="login.php?registration=1" style="padding:0px;color:black;"><b>If New User <u>Click Here</u> to sign up</b></a>
					</div>
				</div>
            </form>
	<?php } ?>	
          </div>
        </div>
      </div>
    </div>
     <?php include_once "include/footer.php"; ?>
  </div>

	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/aos.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>/pharma-panel/js/plugins/forms/validate.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>/pharma-panel/js/additional-methods.js"></script>  
	<script src="js/main.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#Frmlogin").validate({
                ignore:[],
				rules: {
                    email: {
						required: true,
						email:true,
						//min: 1,
					},
					password: {
                        required: true,
                    }
				},
				messages:{
					email: {
						required: "Please enter an email Id",
						required: "Please enter valid email Id"
					},
					password: {
						required: "Please enter password",
					}
				}
			});
			$("#registration").validate({
                ignore:[],
				rules: {
					c_fname:{
						required:true,
					},
					c_lname: {
                        required: true,
                    },
                    c_email: {
						required: true,
						email:true,
						//min: 1,
						remote: {
							url: "ajaxEmailExistsOrNot.php",
							type: "post",
						},
					},
					dob: {
						required: true,
						minAge: 18,
					},
					password: {
                        required: true,
						minlength: 6,
                    },
					repassword: {
                        required: true,
						equalTo:"#password"
                    },
          
				},
				messages:{
					c_fname: {
						required: "Please enter first name"
					},c_lname: {
						required: "Please enter last name"
					},c_email: {
						required: "Please enter an email Id",
						email: "Please enter valid email Id",
						remote: "Email already registred with us."
					},dob: {
						 required: "Please enter date of birth",
						 minAge: "You must be at least 18 years old!"
					},password: {
						required: "Please enter password",
						minlength: "Please enter minimum 6 characters for password"
					},repassword: {
						required: "Please enter re-password",
						equalTo: "Re-password doesn't match"
					}
				}
			});
			$.validator.addMethod("minAge", function(value, element, min) {
				var today = new Date();
				var birthDate = new Date(value);
				var age = today.getFullYear() - birthDate.getFullYear();

				if (age > min + 1) {
				  return true;
				}

				var m = today.getMonth() - birthDate.getMonth();

				if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
				  age--;
				}

				return age >= min;
			 }, "You are not old enough!");
		});
	</script>
</body>

</html>