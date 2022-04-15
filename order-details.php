<?php 	
	Include_once("include/functions.php");
	$functions = New Functions();
	if(!$loggedInUserDetailsArr = $functions->sessionExists()){
		header("location: ".BASE_URL."/login.php");
      	exit;
	}
	if(isset($_GET["txnId"]) && !empty($_GET['txnId'])){
		$txnId = $_GET["txnId"];
		$orderDetails = $functions->getorderDetailsBYTxnId($txnId);
		$productDetails = $functions->getProductByProductCode($orderDetails["product_code"]);
	}else{
		header("location:shop.php?InvalidTXN");
		exit;
	}
	if(isset($_POST["feedback"]) && !empty($_POST["feedback"]) && isset($_POST["feedbackBtn"])){
		$functions->orderFeedBack($_POST);
		header("location:order-details.php?sucess&txnId=".$_POST["txnId"]);
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
		
.invoice {
    padding: 30px;
}

.invoice h2 {
	margin-top: 0px;
	line-height: 0.8em;
}

.invoice .small {
	font-weight: 300;
}

.invoice hr {
	margin-top: 10px;
	border-color: #ddd;
}

.invoice .table tr.line {
	border-bottom: 1px solid #ccc;
}

.invoice .table td {
	border: none;
}

.invoice .identity {
	margin-top: 10px;
	font-size: 1.1em;
	font-weight: 300;
}

.invoice .identity strong {
	font-weight: 600;
}


.grid {
    position: relative;
	width: 100%;
	background: #fff;
	color: #666666;
	border-radius: 2px;
	margin-bottom: 25px;
	box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.1);
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
          <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <a href="my-orders.php">My Orders</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Order Details</strong></div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
		<div class="row">
							<!-- BEGIN INVOICE -->
				<div class="col-xs-12">
					<div class="grid invoice">
						<div class="grid-body">
							<div class="invoice-title">
								<br>
								<div class="row">
									<div class="col-xs-12">
										<h2>Order Details</h2><br>
										<span class="small">Order #<?php echo $orderDetails["txn_id"];  ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<span class="small">Order Date : <?php echo date("l, M d, h:i A",strtotime($orderDetails["created"])); ?></span>
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-xs-6">
									<address>
										<strong>Billed To:</strong><br>
										<?php echo $orderDetails["user_name"]; ?><br>
										<?php echo $orderDetails["full_address"]; ?><br>
										<span>Contact No. <b><?php echo $orderDetails["contact"]; ?></span></b><br>
										<span>Email Id: <b><?php echo $orderDetails["email"]; ?></b></span>
									</address>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6">
										<strong>Payment Method : </strong><?php echo $orderDetails["payment_mode"]; ?><br>
										<strong>Order Status : </strong><b>
																<?php if($orderDetails["order_accept"]==1){ ?>
																	<span class="badge badge-success">Accepted</span>
																<?php }elseif($orderDetails["order_accept"]==2){	?>
																	<span class="badge badge-danger">Rejected</span>
																<?php }else{ ?>	
																	<span class="badge badge-info">Under Review</span>
																<?php } ?>
															</b><br>
										<strong>Delivery Status : </strong><b>
																<?php if($orderDetails["delivery_status"]=="Completed"){ ?>
																	<span class="badge badge-dark">Completed</span>
																<?php }elseif($orderDetails["delivery_status"]=="Shipped"){	?>
																	<span class="badge badge-warning">Shipped</span>
																<?php }else{ ?>	
																	<span class="badge badge-primary">In Process</span>
																<?php } ?>
															</b><br>
								</div>
								
							</div>
							<div class="row">
								<div class="col-md-12"><br><br>
									<h3>ORDER SUMMARY</h3>
									<table class="table table-striped">
										<thead>
											<tr class="line">
												<td><strong>#</strong></td>
												<td class="text-center"><strong>Product Name</strong></td>
												<td class="text-center"><strong>Qty</strong></td>
												<td class="text-right"><strong>price</strong></td>
												<td class="text-right"><strong>SUBTOTAL</strong></td>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td class="text-center"><?php echo $productDetails["product_name"]; ?></td>
												<td class="text-center"><?php echo $orderDetails["qty"]; ?></td>
												<td class="text-right"><?php echo $orderDetails["price"]; ?></td>
												<td class="text-right"><?php echo $orderDetails["price"]*$orderDetails["qty"]; ?></td>
											</tr>
											<?php /*<tr>
												<td colspan="3"></td>
												 <td class="text-right"><strong>Taxes</strong></td>
												<td class="text-right"><strong>N/A</strong></td>
											</tr>*/ ?>
											<tr>
												<td colspan="3">
												</td><td class="text-right"><strong>Total</strong></td>
												<td class="text-right"><strong><?php echo $orderDetails["price"]*$orderDetails["qty"]; ?></strong></td>
											</tr>
										</tbody>
									</table>
								</div>									
							</div>
							
						</div>
					</div>
				</div>
				<!-- END INVOICE -->
				<div class="col-xs-6" style="margin-left: 10px;">
						<?php if(isset($_GET["sucess"])){ ?>
							<div class="alert alert-success" role="alert">
							 Thank you for your valuable feedback.
							</div>
						<?php } ?>
					<form action="" method="POST">
						<label>Feedback</label>
						<textarea required class="form-control" rows="10" autocomplete="off"  required="" name="feedback" placeholder="Write Your Feedback">
							<?php if(isset($orderDetails["feedback"])){ echo $orderDetails["feedback"]; }  ?>
						</textarea><br>
						<input type="hidden" name="order_id" value="<?php echo $orderDetails["id"]; ?>">
						<input type="hidden" name="txnId" value="<?php echo $orderDetails["txn_id"]; ?>">
						<button type="submit" name="feedbackBtn" class="btn btn-success">Submit</button>
					</form>
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