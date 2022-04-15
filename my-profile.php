<?php 	
	Include_once("include/functions.php");
	$functions = New Functions();
	if(!$loggedInUserDetailsArr = $functions->sessionExists()){
		header("location: ".BASE_URL."/login.php");
      	exit;
	}
	if(isset($_POST["c_fname"]) && !empty($_POST["c_fname"]) && isset($_POST["c_email"]) && !empty($_POST["c_email"])){
		$response = $functions->updateProfile($_POST);
		//print_r($response); exit;
		if(empty($response)){
			header("location:my-profile.php?success");
		}else{
			header("location:my-profile.php?failed");
		}
		exit;
	}
	//print_r($loggedInUserDetailsArr);
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
	
.form-control:focus {
    box-shadow: none;
    border-color: #BA68C8
}

.profile-button {
    background: #BA68C8;
    box-shadow: none;
    border: none
}

.profile-button:hover {
    background: #682773
}

.profile-button:focus {
    background: #682773;
    box-shadow: none
}

.profile-button:active {
    background: #682773;
    box-shadow: none
}

.back:hover {
    color: #682773;
    cursor: pointer
}
  </style>
</head>
<body>

  <div class="site-wrap">


    <div class="site-navbar py-2">
      <?php include_once "include/header.php"; ?>
    </div>

    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span><a href="my-orders.php">My Orders</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">My Profile</strong></div>
        </div>
      </div>
    </div>


      <div class="container rounded bg-white mt-5">
			
			<div class="row">
				<div class="col-md-4 border-right">
					<div class="d-flex flex-column align-items-center text-center p-3 py-5">
						<img class="rounded-circle mt-5" src="images/default-avatar.png" width="90">
						<span class="font-weight-bold"><?php echo ucwords($loggedInUserDetailsArr["f_name"])." ".ucwords($loggedInUserDetailsArr["l_name"]); ?></span>
						<span class="text-black-50"><?php echo $loggedInUserDetailsArr["email"]; ?></span>
						</div>
				</div>
				<div class="col-md-8">
					<?php 
						if(isset($_GET["success"])){
					?>
							<div class="alert alert-success" role="alert">
								Profile Updated Successfully.
							</div>
					<?php } if(isset($_GET["failed"])){ ?>
							<div class="alert alert-danger" role="alert">
								Old Password Doesn't Matched.
							</div>
					<?php } ?>		
					<form action="" method="POST" id="updateProfile">
						<div class="p-3 py-5">
							<div class="d-flex justify-content-between align-items-center mb-3">
								<div class="d-flex flex-row align-items-center back"><i class="fa fa-long-arrow-left mr-1 mb-1"></i>
									<h6><a href="my-orders.php">Back to My Orders</a></h6>
								</div>
								<h6 class="text-right">Edit Profile</h6>
							</div>
							<div class="row mt-2">
								<div class="col-md-6"><label>First Name</label><input name="c_fname" type="text" class="form-control" placeholder="first name" value="<?php echo $loggedInUserDetailsArr["f_name"]; ?>"></div>
								<div class="col-md-6"><label>Last Name</label><input name="c_lname" type="text" class="form-control" value="<?php echo $loggedInUserDetailsArr["l_name"]; ?>" placeholder="Last Name"></div>
							</div>
							<div class="row mt-3">
								<div class="col-md-6"><label>Email Id</label><input name="c_email" type="text" class="form-control" placeholder="Email" value="<?php echo $loggedInUserDetailsArr["email"]; ?>"></div>
								<div class="col-md-6"><label>Date Of Birth</label><input name="dob" type="date" class="form-control" value="<?php echo $loggedInUserDetailsArr["dob"]; ?>" placeholder="Phone number"></div>
							</div>
							<br>
							<h6 class="text-left">Change Password</h6>
							<hr>
							<div class="row mt-3">
								<div class="col-md-6"><label>Old Password</label>
									<input type="password" name="old_password" class="form-control" placeholder="Old Password" value="">
									<small>(Leave empty if don't want to change)</small>
								</div>
							</div>
							<div class="row mt-3">
								<div class="col-md-6"><label>New Password</label><input type="password" name="password" id="password" class="form-control" placeholder="New Password" value=""></div>
								<div class="col-md-6"><label>Re Password</label><input type="password" name="repassword" class="form-control" value="" placeholder="Re-enter New Password"></div>
							</div>
							<div class="mt-5 text-right">
								<input type="hidden" name="upodateId" value="<?php echo $loggedInUserDetailsArr["id"]; ?>" >
								<button name="updateProfile" class="btn btn-primary profile-button" type="submit">Save Profile</button>
							</div>
						</div>
					</form>
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
  <script src="js/main.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>/pharma-panel/js/plugins/forms/validate.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>/pharma-panel/js/additional-methods.js"></script>  
	<script type="text/javascript">
		$(document).ready(function() {

			$("#updateProfile").validate({
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
						/* remote: {
							url: "ajaxEmailExistsOrNot.php",
							type: "post",
						}, */
					},
					dob: {
						required: true,
						minAge: 18,
					},
					password: {
						minlength: 6,
                    },
					repassword: {
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
						//remote: "Email already registred with us."
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