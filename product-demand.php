<?php 
	Include_once("include/functions.php");
	$functions = New Functions();
	if(!$loggedInUserDetailsArr = $functions->sessionExists()){
		header("location: ".BASE_URL."/login.php");
      	exit;
	}
	//print_R($loggedInUserDetailsArr);
	if(isset($_POST["addProductDemand"])){
		$functions->productOnDemand($_POST);
		header("location:product-demand.php?success");
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
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  <style>
	
/* My Account */
.payments-item img.mr-3 {
    width: 47px;
}
.order-list .btn {
    border-radius: 2px;
    min-width: 121px;
    font-size: 13px;
    padding: 7px 0 7px 0;
}
.osahan-account-page-left .nav-link {
    padding: 18px 0px;
    border: none;
    font-weight: 600;
    color: #535665;
}
.osahan-account-page-left .nav-link i {
    width: 28px;
    height: 28px;
    background: #535665;
    display: inline-block;
    text-align: center;
    line-height: 29px;
    font-size: 15px;
    border-radius: 50px;
    margin: 0 7px -7px 0px;
    color: #fff;
}
.osahan-account-page-left .nav-link.active {
    background: #f3f7f8;
    color: #282c3f !important;
}
.osahan-account-page-left .nav-link.active i {
    background: #282c3f !important;
}
.osahan-user-media img {
    width: 90px;
}
.card offer-card h5.card-title {
    border: 2px dotted #000;
}
.card.offer-card h5 {
    border: 1px dotted #daceb7;
    display: inline-table;
    color: #17a2b8;
    margin: 0 0 19px 0;
    font-size: 15px;
    padding: 6px 10px 6px 6px;
    border-radius: 2px;
    background: #fffae6;
    position: relative;
}
.card.offer-card h5 img {
    height: 22px;
    object-fit: cover;
    width: 22px;
    margin: 0 8px 0 0;
    border-radius: 2px;
}
.card.offer-card h5:after {
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    border-bottom: 4px solid #daceb7;
    content: "";
    left: 30px;
    position: absolute;
    bottom: 0;
}
.card.offer-card h5:before {
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    border-top: 4px solid #daceb7;
    content: "";
    left: 30px;
    position: absolute;
    top: 0;
}
.payments-item .media {
    align-items: center;
}
.payments-item .media img {
    margin: 0 40px 0 11px !important;
}
.reviews-members .media .mr-3 {
    width: 56px;
    height: 56px;
    object-fit: cover;
}
.order-list img.mr-4 {
    width: 70px;
    height: 70px;
    object-fit: cover;
    box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075)!important;
    border-radius: 2px;
}
.osahan-cart-item p.text-gray.float-right {
    margin: 3px 0 0 0;
    font-size: 12px;
}
.osahan-cart-item .food-item {
    vertical-align: bottom;
}

.h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
    color: #000000;
}

.shadow-sm {
    box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;
}

.rounded-pill {
    border-radius: 50rem!important;
}
a:hover{
    text-decoration:none;
}
.error{
	color:red;
}
  </style>
</head>

<body>

  <div class="site-wrap">
	<?php include_once "include/header.php"; ?>
			
		
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<div class="osahan-account-page-left shadow-sm bg-white h-100">
						<div class="border-bottom p-4">
							<div class="osahan-user text-center">
								<div class="osahan-user-media">
									<img class="mb-3 rounded-pill shadow-sm mt-1" src="<?php echo BASE_URL; ?>/images/default-avatar.png" alt="gurdeep singh osahan">
									<div class="osahan-user-media-body">
										<h6 class="mb-2"><?php echo UCWORDS($loggedInUserDetailsArr['f_name']." ".$loggedInUserDetailsArr['l_name']); ?></h6>
										<p class="mb-2"><?php echo $loggedInUserDetailsArr['email']; ?></p>
										<p class="mb-0 text-black font-weight-bold"><a class="text-primary mr-3"  href="my-profile.php"><i class="icofont-ui-edit"></i> EDIT</a></p>
										
									</div>
								</div>
							</div>
						</div>
						<ul class="nav nav-tabs flex-column border-0 pt-4 pl-4 pb-4" id="myTab" role="tablist">
							<li class="nav-item">
								<a class="nav-link" id="orders-tab" href="my-orders.php"><i class="icofont-food-cart"></i> <span>Orders</span></a>
								<a class="nav-link"  href="product-demand-master.php" role="tab"><i class="icofont-food-cart"></i> <span>Products On Demand</span></a>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-md-9">
					<form action="" method="POST" id="updateProfile">
						<div class="p-3 py-5">
							<div class="d-flex justify-content-between align-items-center mb-3">
								<div class="d-flex flex-row align-items-center back"><i class="fa fa-long-arrow-left mr-1 mb-1"></i>
									<h6><a href="product-demand-master.php">Back to Products On Demand List</a></h6>
								</div>
								<h6 class="text-right">Products Details</h6>
							</div>
							<hr>
							<?php 
								if(isset($_GET["success"])){
							?>
									<div class="alert alert-success" role="alert">
										Product requested successfully.Our team reach you shortly.
									</div>
								<?php 
								} ?>
							<div class="row mt-2">
								<div class="col-md-5"><label>Product Name</label><input name="product_name" type="text" class="form-control" placeholder="Product name"></div>
								<div class="col-md-5"><label>Brand Name</label><input name="brand_name" type="text" class="form-control" placeholder="Brand Name"></div>
								<div class="col-md-2"><label>Quantity</label><input name="quantity" type="text" class="form-control" placeholder="Quantity"></div>
							</div>
							<br>
							<h6 class="text-left">Users Contact Details</h6>
							<hr>
							
							<div class="row mt-3">
								<div class="col-md-5"><label>User Name</label><input name="user_name" type="text" class="form-control" placeholder="Full Name"></div>
								<div class="col-md-5"><label>Contact / Email</label><input name="contact_details" type="text" class="form-control" placeholder="Email or Contact"></div>
							</div>
							<div class="row mt-3">
								<div class="col-md-8"><label>Full Address</label>
									<textarea name="full_address" rows="3" type="text" class="form-control" placeholder="Please Enter Full Address"></textarea>
								</div>
							</div>
							<div class="mt-5 text-right">
								<button name="addProductDemand" class="btn btn-success profile-button" type="submit">Submit</button>
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
					product_name:{
						required:true,
					},
					brand_name: {
                        required: true,
                    },
					quantity: {
						required: true,
						number:true,
					},
					user_name: {
						required: true,
                    },
					contact_details: {
						required: true,
                    },
					full_address: {
						required: true,
                    }
          
				},
				messages:{
					product_name: {
						required: "Please enter product name"
					},
					brand_name: {
						required: "Please enter brand name"
					},
					quantity: {
						required: "Please enter quantity",
					},
					user_name: {
						 required: "Please enter full name",
					},
					contact_details: {
						required: "Please enter mobile or email id.",
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