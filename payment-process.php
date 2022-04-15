<?php 
	Include_once("include/functions.php");
	$functions = New Functions();
	//print_r($_POST);
	if(isset($_POST["buy_now"])){
		if(isset($_POST["qty"]) && !empty($_POST["qty"])){
			$_SESSION[SITE_NAME]["qty"] = $_POST["qty"];
		}
		if(isset($_POST["product_id"]) && !empty($_POST["product_id"])){
			$_SESSION[SITE_NAME]["product_id"] = $_POST["product_id"];
		}
		
	}
	$productDetails = $functions->getProductBYid($_SESSION[SITE_NAME]["product_id"]);
	$price = $productDetails["price"] * $_SESSION[SITE_NAME]["qty"];
	//print_R($_SESSION);
	if(isset($_POST["processPayment"])){
		$process = $functions->processTransaction($_POST);
		//print_r($process); exit;
		header("location:thank-you.php?txnid=".$process["txnId"]);
		exit;
	}
	//print_r($_POST);
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


    <div class="site-navbar py-2">
      <?php include_once "include/header.php"; ?>
    </div>

    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Store</strong></div>
        </div>
      </div>
    </div>

    <div class="site-section">
		<div class="container">
			<div class="row">
				 <div class="col-md-6 offset-md-3">
					
					
					<div class="card card-outline-secondary">
						<div class="card-body">
							<form class="form" method="POST" action="" id="processPymentFrm" role="form" autocomplete="off">
								<div class="form-group row">
									<label class="col-md-12">Delivery Address</label>
									<div class="col-md-6">
										<input type="number" class="form-control" autocomplete="off"  required="" name="contact" placeholder="Billing Contact">
									</div>
									<div class="col-md-6">
										<input type="text" class="form-control" autocomplete="off" required="" name="email" placeholder="Billing Email">
									</div>
									<div class="col-md-12"><br>
										<textarea class="form-control" rows="3" autocomplete="off"  required="" name="full_address" placeholder="Billing Full Address"></textarea>
									</div>
								 </div>
							<h3 class="text-center">Credit Card Payment</h3>
							<hr>
							
							
								<div class="form-group">
									<label for="cc_name">Card Holder's Name</label>
									<input type="text" class="form-control" id="cc_name" pattern="\w+ \w+.*" title="First and last name" name="cc_name" required="required">
								</div>
								<div class="form-group">
									<label>Card Number</label>
									<input type="text" class="form-control" autocomplete="off" maxlength="20" pattern="\d{16}" title="Credit card number" required="">
								</div>
								<div class="form-group row">
									<label class="col-md-12">Card Exp. Date</label>
									<div class="col-md-4">
										<select class="form-control" name="cc_exp_mo" size="0">
											<option value="01">01</option>
											<option value="02">02</option>
											<option value="03">03</option>
											<option value="04">04</option>
											<option value="05">05</option>
											<option value="06">06</option>
											<option value="07">07</option>
											<option value="08">08</option>
											<option value="09">09</option>
											<option value="10">10</option>
											<option value="11">11</option>
											<option value="12">12</option>
										</select>
									</div>
									<div class="col-md-4">
										<select class="form-control" name="cc_exp_yr" size="0">
											<option>2018</option>
											<option>2019</option>
											<option>2020</option>
											<option>2021</option>
											<option>2022</option>
										</select>
									</div>
									<div class="col-md-4">
										<input type="password" class="form-control" autocomplete="off" maxlength="3" pattern="\d{3}" title="Three digits at back of your card" required="" placeholder="CVC">
									</div>
								 </div>
								<div class="row">
									<label class="col-md-12">Amount</label>
								</div>
								<div class="form-inline">
									<div class="input-group">
										<div class="input-group-prepend"><span class="input-group-text">Rs</span></div>
										<input type="text" readonly class="form-control text-right" id="exampleInputAmount" value="<?php echo $price; ?>">
										<div class="input-group-append"><span class="input-group-text">.00</span></div>
									</div>
								</div>
								<hr>
								<div class="form-group row">
									<div class="col-md-6">
										<a href="shop-single.php?id=<?php echo $_SESSION[SITE_NAME]["product_id"]; ?>" class="btn btn-danger btn-lg btn-block" style="color:white">Cancel</a>
									</div>
									<div class="col-md-6">
										<button type="submit" name="processPayment" class="btn btn-success btn-lg btn-block">Proceed Payment</button>
									</div>
								</div>
							</form>
						</div>
					</div>
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
			$("#processPymentFrm").validate({
                ignore:[],
				rules: {
					contact:{
						required:true,
					},
					email: {
                        required: true,
						email:true,
                    },
                    full_address: {
						required: true,
						
					}
          
				},
				messages:{
					contact: {
						required: "Please enter contact number"
					},
					email: {
						required: "Please enter an email Id",
						email: "Please enter valid email Id",
						
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