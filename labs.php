<?php 	
	Include_once("include/functions.php");
	$functions = New Functions();
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
          <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Labs</strong></div>
        </div>
      </div>
    </div>


      <div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="card card-white mb-5">
					<div class="card-heading clearfix border-bottom mb-4">
						<div class="col-6 col-md-8 col-lg-8">
							<form class="card card-sm" method="GET">
								<div class="card-body row no-gutters align-items-center">
									<div class="col-auto">
										<i class="fa fa-search h4 text-body"></i>
									</div>
									<!--end of col-->
									<div class="col">
										<input required value ="<?php  if(isset($_GET['search_keyword']) && !empty($_GET['search_keyword'])){ echo $_GET['search_keyword'];  } ?>" class="form-control form-control-lg form-control-borderless" name="search_keyword" type="search" placeholder="Search Near Labs By Location & Services">
									</div>
									<!--end of col-->
									<div class="col-auto">
										<button class="btn btn-success" type="submit">Search</button>
										<?php  if(isset($_GET['search_keyword']) && !empty($_GET['search_keyword'])){ ?>
											<a class="btn btn-danger" href="labs.php">Reset</a>
										<?php } ?>
									</div>
									<!--end of col-->
								</div>
							</form>
						</div>
					</div>
					<div class="card-body">
						<ul class="list-unstyled">
						<?php
							$extQuery="";
							if(isset($_GET["search_keyword"]) && !empty($_GET["search_keyword"])){
								$extQuery=" and (city like '%".$_GET["search_keyword"]."%' || address like '%".$_GET["search_keyword"]."%' || service like '%".$_GET["search_keyword"]."%') ";
							}
							$sql = "SELECT * FROM ".PREFIX."lab WHERE `active`='Yes' $extQuery order by created DESC";
							$result = $functions->query($sql);
							while($labsDetails = $functions->fetch($result)){
						?>
									<li class="position-relative booking">
										<div class="media">
											<div class="msg-img">
												<img src="images/mark.png" alt="">
											</div>
											<div class="media-body">
												<h5 class="mb-4"><?php echo UCWORDS($labsDetails['name']); ?> 
													<?php /*<span class="badge badge-primary mx-3">Pending</span><span class="badge badge-danger">Unpaid</span> */ ?>
												</h5>
												<div class="mb-3">
													<span class="mr-2 d-block d-sm-inline-block mb-2 mb-sm-0">Services</span><hr>
													<span class="bg-light-blue"><?php echo $labsDetails['service']; ?></span>
												</div>
												<div class="mb-3">
													Contact Details <hr>
												</div>
												<div class="mb-3">
													<span class="mr-2 d-block d-sm-inline-block mb-2 mb-sm-0">Contact No</span>
													<span class="badge badge-warning"><?php echo $labsDetails['contact']; ?></span>
												</div>
												<div class="mb-3">
													<span class="mr-2 d-block d-sm-inline-block mb-2 mb-sm-0">City</span>
													<span class="badge badge-warning"><?php echo UCWORDS($labsDetails['city']); ?></span>
												</div>
												<div class="mb-5">
													<span class="mr-2 d-block d-sm-inline-block mb-1 mb-sm-0">Address:</span>
													<span class="pr-2 mr-2"><?php echo nl2br($labsDetails['address']); ?></span>
													
												</div>
											</div>
										</div>
										
									</li>
							<?php 
							} ?>
							

						
						</ul>

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

  <script src="js/main.js"></script>

</body>

</html>