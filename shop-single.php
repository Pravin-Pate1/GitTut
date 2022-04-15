<?php 
	Include_once("include/functions.php");
	$functions = New Functions();
	if(isset($_GET["id"]) && !empty($_GET["id"])){
		$productDetails = $functions->getProductByid($_GET["id"]);
		if(!isset($productDetails["id"]) || empty($productDetails["id"])){
			header("location:shop.php?INVPRODUCT");
			exit;
		}
	}else{
		header("location:shop.php?INVPRODUCT");
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
          <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <a
              href="shop.php">Store</a> <span class="mx-2 mb-0">/</span> <strong class="text-black"><?php echo ucwords($productDetails["product_name"]); ?></strong></div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-5 mr-auto">
            <div class="border text-center">
				<?php 
					$file_name = str_replace('', '-', strtolower( pathinfo($productDetails['main_image'], PATHINFO_FILENAME)));
					$ext = pathinfo($productDetails['main_image'], PATHINFO_EXTENSION);
					if(!empty($productDetails['main_image'])){
						$url =  BASE_URL."/images/products/".$file_name.'_crop.'.$ext;
					}else{
						$url = BASE_URL.'/images/default.jpg';
					}
				?>
				<img src="<?php echo $url; ?>" alt="Image" class="img-fluid p-5">
            </div>
          </div>
          <div class="col-md-6">
			<form action="payment-process.php" id="processBtn" method="POST">
            <h2 class="text-black"><?php echo ucwords($productDetails["product_name"]); ?></h2>
            <p><strong class="text-primary h4"><?php echo "Rs.".$productDetails["price"]; ?>/-</strong></p>
            <div class="mb-5">
              <div class="input-group mb-3" style="max-width: 220px;">
                <div class="input-group-prepend">
                  <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                </div>
                <input type="text" required class="form-control text-center" min="1" readonly value="1" placeholder=""
                  aria-label="Example text with button addon" aria-describedby="button-addon1" name="qty" >
                <div class="input-group-append">
                  <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                </div>
				<label for="qty" class="error"></label>
				<input type="hidden" name="product_id" value="<?php echo $productDetails["id"]; ?>">
              </div>
            </div>
            <?php
					if(!$loggedInUserDetailsArr = $functions->sessionExists()){ ?>
						<p><a href="login.php" class="buy-now btn btn-sm height-auto px-4 py-3 btn-primary">BUY NOW</a></p>
			<?php 	}else{ ?>	
						<p><button type="submit" name="buy_now" class="buy-now btn btn-sm height-auto px-4 py-3 btn-primary">BUY NOW</button></p>
			<?php 	} ?>			
            <div class="mt-5">
				<?php echo  $productDetails["description"]; ?>
            </div>
			</form>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section bg-secondary bg-image" style="background-image: url('images/bg_2.jpg');">
      <div class="container">
        <div class="row align-items-stretch">
          <div class="col-lg-6 mb-5 mb-lg-0">
            <a href="#" class="banner-1 h-100 d-flex" style="background-image: url('images/bg_1.jpg');">
              <div class="banner-1-inner align-self-center">
                <h2>Pharma Products</h2>
                <p>Pharmaceutical products are essential to save one’s life in the world when it gets delivered to the right place with right time. </p>
              </div>
            </a>
          </div>
          <div class="col-lg-6 mb-5 mb-lg-0">
            <a href="#" class="banner-1 h-100 d-flex" style="background-image: url('images/bg_2.jpg');">
              <div class="banner-1-inner ml-auto  align-self-center">
                <h2>Rated by Experts</h2>
                <p>Pharmaceutical companies and doctors are today embracing the digital transformation and are aggressively taking steps to adapt.</p>
                </p>
              </div>
            </a>
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

  <script src="js/main.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>/pharma-panel/js/plugins/forms/validate.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>/pharma-panel/js/additional-methods.js"></script> 
	<script type="text/javascript">
		$(document).ready(function() {
			
			$("#processBtn").validate({
                ignore:[],
				rules: {
					qty:{
						required:true,
						min:1
					},
					
          
				},
				messages:{
					qty: {
						min: "Minimum 1 qty is required."
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