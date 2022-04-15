<?php 	
	Include_once("include/functions.php");
	$functions = New Functions();
	if(isset($_GET["txnid"]) && !empty($_GET['txnid'])){
		$txnid = $_GET["txnid"];
	}else{
		header("location:shop.php?InvalidTXN");
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
		/*--thank you pop starts here--*/
		.thank-you-pop{
			width:100%;
			padding:20px;
			text-align:center;
		}
		.thank-you-pop img{
			width:76px;
			height:auto;
			margin:0 auto;
			display:block;
			margin-bottom:25px;
		}

		.thank-you-pop h1{
			font-size: 42px;
			margin-bottom: 25px;
			color:#5C5C5C;
		}
		.thank-you-pop p{
			font-size: 20px;
			margin-bottom: 27px;
			color:#5C5C5C;
		}
		.thank-you-pop h3.cupon-pop{
			font-size: 25px;
			margin-bottom: 40px;
			color:#222;
			display:inline-block;
			text-align:center;
			padding:10px 20px;
			border:2px dashed #222;
			clear:both;
			font-weight:normal;
		}
		.thank-you-pop h3.cupon-pop span{
			color:#03A9F4;
		}
		.thank-you-pop a{
			display: inline-block;
			margin: 0 auto;
			padding: 9px 20px;
			color: #fff;
			text-transform: uppercase;
			font-size: 14px;
			background-color: #8BC34A;
			border-radius: 17px;
		}
		.thank-you-pop a i{
			margin-right:5px;
			color:#fff;
		}
		#ignismyModal .modal-header{
			border:0px;
		}
		/*--thank you pop ends here--*/

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
          <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Thank you</strong></div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
			<div class="thank-you-pop">
				<img src="<?php echo BASE_URL."/images/Tick.png"; ?>" alt="">
				<h1>Thank You!</h1>
				<p>Your Order Successfully Placed.</p>
				<h3 class="cupon-pop">Order Id: <span><?php echo $txnid; ?></span></h3>
			</div>
			<div class="col-md-12 text-center">
				<p><a href="shop.php" class="btn btn-md height-auto px-4 py-3 btn-primary">Back to store</a></p>
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

</body>

</html>