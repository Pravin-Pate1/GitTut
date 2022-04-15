<?php 
	Include_once("include/functions.php");
	$functions = New Functions();
	if(!$loggedInUserDetailsArr = $functions->sessionExists()){
		header("location: ".BASE_URL."/login.php");
      	exit;
	}
	//print_R($loggedInUserDetailsArr);
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
				<div class="col-md-9"><br><br>
					<div class="row">
						<div class="col-md-8">
							<input class="form-control" id="myInput" type="text" placeholder="Search..">
						</div>	
						<div class="col-md-3">
							<a class="btn btn-warning" style="color:white;" href="product-demand.php">Request For Products On Demand</a><br>
						</div>	
					</div>	
					  <br>
					  <table class="table table-bordered table-striped">
						<thead>
						  <tr>
							<th>Product Name</th>
							<th>Qty</th>
							<th>Brand Name</th>
							<th>Name</th>
							<th>Contact / Email</th>
							<th>Requested Date</th>
							<th>Status</th>
						  </tr>
						</thead>
						<tbody id="myTable">
						<?php 
							$sql = "SELECT * FROM ".PREFIX."demand_product order by created DESC";
							$result = $functions->query($sql);
							if($functions->num_rows($result)>0){
								while($row = $functions->fetch($result)){
							?>
									  <tr>
										<td><?php echo $row["product_name"]; ?></td>
										<td><?php echo $row["qty"]; ?></td>
										<td><?php echo $row["band_name"]; ?></td>
										<td><?php echo $row["user_name"]; ?></td>
										<td><?php echo $row["contact"]; ?></td>
										<td><?php echo date("d-m-Y",strtotime($row["created"])); ?></td>
										<td>
											<?php if($row["status"]==1){ ?>
												<span class="badge badge-success">Accepted</span>
											<?php }elseif($row["status"]==2){ ?>	
												<span class="badge badge-danger">Rejected</span>
											<?php }else{ ?>
												<span class="badge badge-info">Requested</span>		
											<?php 
													} ?>
										</td>
										
									  </tr>
								<?php 
								}
							}else{ ?>
								 <tr>
									<td colspan="7">Request Not Found</td>
								</tr>		
							<?php 
							} ?>
						  
						</tbody>
					  </table>
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
	<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
</body>

</html>