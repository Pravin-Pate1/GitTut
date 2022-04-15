<?php 	
	Include_once("include/functions.php");
	$functions = New Functions();
	if(isset($_POST["requestDonation"])){
		$functions->requestDonation($_POST);
		header("location:request-donation.php?success");
		exit;
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
		
/* booking */

.bg-light-blue {
    background-color: #e9f7fe !important;
    color: #3184ae;
    padding: 7px 18px;
    border-radius: 4px;
}

.bg-light-green {
    background-color: rgba(40, 167, 69, 0.2) !important;
    padding: 7px 18px;
    border-radius: 4px;
    color: #28a745 !important;
}

.buttons-to-right {
    position: absolute;
    right: 0;
    top: 40%;
}

.btn-gray {
    color: #666;
    background-color: #eee;
    padding: 7px 18px;
    border-radius: 4px;
}

.booking:hover .buttons-to-right .btn-gray {
    opacity: 1;
    transition: .3s;
}

.buttons-to-right .btn-gray {
    opacity: 0;
    transition: .3s;
}

.btn-gray:hover {
    background-color: #36a3f5;
    color: #fff;
}

.booking {
    margin-bottom: 30px;
    border-bottom: 1px solid #eee;
    padding-bottom: 30px;
}

.booking:last-child {
    margin-bottom: 0px;
    border-bottom: none;
    padding-bottom: 0px;
}

@media screen and (max-width: 575px) {
    .buttons-to-right {
        top: 10%;
    }
    .buttons-to-right a {
        display: block;
        margin-bottom: 20px;
    }
    .buttons-to-right a:last-child {
        margin-bottom: 0px;
    }
    .bg-light-blue,
    .bg-light-green,
    .btn-gray {
        padding: 7px;
    }
}

.card {
    margin-bottom: 20px;
    background-color: #fff;
    border-radius: 4px;
    -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
    border-radius: 4px;
    box-shadow: none;
    border: none;
    padding: 25px;
}
.mb-5, .my-5 {
    margin-bottom: 3rem!important;
}
.msg-img {
    margin-right: 20px;
}
.msg-img img {
    width: 60px;
    border-radius: 50%;
}
img {
    max-width: 100%;
    height: auto;
}
.form-control-borderless {
	border: none;
}

.form-control-borderless:hover, .form-control-borderless:active, .form-control-borderless:focus {
	border: none;
	outline: none;
	box-shadow: none;
}
.error{
	color:red;
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
          <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span><a href="donation.php">Eye Donation</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Eye & Blood Donation Form</strong></div>
        </div>
      </div>
    </div>


      <div class="container">
		<div class="row">
			<div class="col-md-9">
				<form action="" method="POST" id="updateProfile">
					<div class="p-3 py-5">
						<div class="d-flex justify-content-between align-items-center mb-3">
							<h6>Personal Information</h6>
						</div>
						<hr>
						<?php 
							if(isset($_GET["success"])){
						?>
								<div class="alert alert-success" role="alert">
									Donation requested successfully.Our team reach you shortly.
								</div>
							<?php 
							} ?>
						<div class="row mt-2">
							<div class="col-md-4"><label>Full Name</label><input name="full_name" type="text" class="form-control" placeholder="Name"></div>
							<div class="col-md-4"><label>Contact</label><input name="contact" type="text" class="form-control" placeholder="Contact"></div>
							<div class="col-md-4"><label>Email</label><input name="email" type="text" class="form-control" placeholder="Email"></div>
						</div>
						<div class="row mt-3">
							<div class="col-md-8"><label>Full Address</label>
								<textarea name="full_address" rows="3" type="text" class="form-control" placeholder="Please Enter Full Address"></textarea>
							</div>
						</div>
						<br>
						<h6 class="text-left">Donation Details</h6>
						<hr>
						<div class="row mt-3">
							<div class="col-md-5">
								<label>User Name</label>
								<select name="donation_type" class="form-control">
									<option value="">Select Donation Type</option>
									<option value="Blood Donation">Blood Donation</option>
									<option value="Eye Donation">Eye Donation</option>
								</select>
							</div>
							<div class="col-md-5">
								<label>Request Type</label>
								<select name="request_type" class="form-control">
									<option value="">Select Request Type</option>
									<option value="Receiver">Receiver</option>
									<option value="Donor">Donor</option>
								</select>
							</div>
						</div>
						
						<div class="mt-5">
							<button name="requestDonation" class="btn btn-success profile-button" type="submit">Submit</button>
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
					full_name:{
						required:true,
					},
					contact: {
                        required: true,
						number:true,
                    },
					email: {
						required: true,
						email:true,
					},
					donation_type: {
						required: true,
                    },
					request_type: {
						required: true,
                    },
					full_address: {
						required: true,
                    }
          
				},
				messages:{
					full_name: {
						required: "Please enter full name"
					},
					contact: {
						required: "Please enter contact number"
					},
					email: {
						required: "Please enter an email id",
					},
					donation_type: {
						 required: "Please select donation type",
					},
					request_type: {
						 required: "Please select request type",
					},
					full_address: {
						 required: "Please enter full address",
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