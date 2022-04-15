<?php 
	Include_once("include/functions.php");
	$functions = New Functions();
	if(isset($_GET["notiId"]) && !empty($_GET["notiId"])){
		$functions->updateNotificationSeenStatus($_GET["notiId"]);
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
</head>

<body>

  <div class="site-wrap">
    <div class="site-navbar py-2">
		<?php include_once "include/header.php"; ?>
    </div>
		<?php 
			$sql = "SELECT * FROM ".PREFIX."article order by created DESC";
			$result = $functions->query($sql);
			$evenOdd = 1;
			while($articlesDetails = $functions->fetch($result)){
				//print_r($articlesDetails);
				$file_name = str_replace('', '-', strtolower( pathinfo($articlesDetails['atricle_image'], PATHINFO_FILENAME)));
				$ext = pathinfo($articlesDetails['atricle_image'], PATHINFO_EXTENSION);
				if(!empty($articlesDetails['atricle_image'])){
					$url =  BASE_URL."/images/article/".$file_name.'_crop.'.$ext;
				}else{
					$url = BASE_URL.'/images/default.jpg';
				}
				if ($evenOdd % 2 == 0) {
				
		?>
				<div class="site-section bg-light custom-border-bottom" data-aos="fade">
					<div class="container">
						<div class="row mb-5">
							<div class="col-md-6">
								<div class="block-16">
									<figure>
										<img src="<?php echo $url; ?>" alt="Image placeholder" class="img-fluid rounded">
										<?php /*<a href="https://vimeo.com/channels/staffpicks/93951774" class="play-button popup-vimeo">
										<span class="icon-play"></span></a> */ ?>
			
									</figure>
								</div>
							</div>
							<div class="col-md-1"></div>
							<div class="col-md-5">
								<div class="site-section-heading pt-3 mb-4">
									<h2 class="text-black"><?php echo ucwords($articlesDetails["title"]); ?></h2>
								</div>
								<br>
								<?php echo $articlesDetails["description"]; ?>
							</div>
						</div>
					</div>
				</div>
		<?php }else{ ?>
				<div class="site-section bg-light custom-border-bottom" data-aos="fade">
					<div class="container">
						<div class="row mb-5">
							<div class="col-md-6 order-md-2">
								<div class="block-16">
									<figure>
										<img src="<?php echo $url; ?>" alt="Image placeholder" class="img-fluid rounded">
										<?php /* <a href="https://vimeo.com/channels/staffpicks/93951774" class="play-button popup-vimeo">
										<span class="icon-play"></span></a>    */?>
									</figure>
								</div>
							</div>
							<div class="col-md-5 mr-auto">
			   
								<div class="site-section-heading pt-3 mb-4">
									<h2 class="text-black"><?php echo ucwords($articlesDetails["title"]); ?></h2>
								</div>
								<br>
								<?php echo $articlesDetails["description"]; ?>  
							</div>
						</div>
					</div>
				</div>
			<?php 
			}
			$evenOdd++;
		} ?>
		<div class="site-section site-section-sm site-blocks-1 border-0" data-aos="fade">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="">
						<div class="icon mr-4 align-self-start">
							<span class="icon-truck text-primary"></span>
						</div>
						<div class="text">
							<h2>Safe Delivery </h2>
							<p>Absolutely! All the medicines/products sold through our platform are inspected thoroughly for their authenticity and quality. Also, while delivering the medicines, our team follows strict safety protocols to ensure only the top-notch products get delivered to you.</p>
						</div>
					</div>
					<div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="100">
						<div class="icon mr-4 align-self-start">
							<span class="icon-refresh2 text-primary"></span>
						</div>
						<div class="text">
							<h2>Pharma First</h2>
							<p>Pharma First is our loyalty programme which puts you and your health First! First members can get an extra 2.5% NMS Cashback (up to INR 100 per order) on prescription medication ordered using the membership.</p>
						</div>
					</div>
					<div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="200">
						<div class="icon mr-4 align-self-start">
							<span class="icon-help text-primary"></span>
						</div>
						<div class="text">
							<h2>Customer Support</h2>
							<p>You can email us at onlinehelpdesk@Pharma.com for any issues you face with the payment.Our support team available 24/7 Monday through Friday.</p>
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