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
</head>

<body>

  <div class="site-wrap">

	<?php include_once "include/header.php"; ?>

    <div class="site-blocks-cover" style="background-image: url('images/hero_1.jpg');">
      <div class="container">
        <div class="row">
          <div class="col-lg-7 mx-auto order-lg-2 align-self-center">
            <div class="site-block-cover-content text-center">
              <h2 class="sub-title">Effective Medicine, New Medicine Everyday</h2>
              <h1>Welcome To Pharma</h1>
              <p>
                <a href="shop.php" class="btn btn-primary px-5 py-3">Shop Now</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row align-items-stretch section-overlap">
          <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
            <div class="banner-wrap bg-primary h-100">
              <a href="#" class="h-100">
                <h5>Reliable</h5>
                <p>
                  <strong>All products displayed on Pharma are procured from verified and licensed pharmacies. All labs listed on the platform are accredited</strong>
                </p>
              </a>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
            <div class="banner-wrap h-100">
              <a href="#" class="h-100">
                <h5>Secure</h5>
                <p>
                  <strong>Pharma uses Secure Sockets Layer (SSL) 128-bit encryption and is Payment Card Industry Data Security Standard (PCI DSS) compliant</strong>
                </p>
              </a>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
            <div class="banner-wrap bg-warning h-100">
              <a href="#" class="h-100">
                <h5>Affordable</h5>
                <p>
                 
                  <strong>Find affordable medicine substitutes, save up to 50% on health products, up to 80% off on lab tests and free doctor consultations.</strong>
                </p>
              </a>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="title-section text-center col-12">
            <h2 class="text-uppercase">Popular Products</h2>
          </div>
        </div>
        <div class="row">
			<?php 
				$sql ="SELECT * FROM ".PREFIX."product_master WHERE `feature_product`='Yes' and `active`='Yes' order by created DESC LIMIT 6";
				$result = $functions->query($sql);
				while($productDetails = $functions->fetch($result)){
					$file_name = str_replace('', '-', strtolower( pathinfo($productDetails['main_image'], PATHINFO_FILENAME)));
					$ext = pathinfo($productDetails['main_image'], PATHINFO_EXTENSION);
					if(!empty($productDetails['main_image'])){
						$url =  BASE_URL."/images/products/".$file_name.'_crop.'.$ext;
					}else{
						$url = BASE_URL.'/images/default.jpg';
					}
			?>
				  
				  <div class="col-sm-6 col-lg-4 text-center item mb-4">
					<a href="<?php echo "shop-single.php?id=".$productDetails["id"]; ?>"> <img style="width: 50%;" src="<?php echo $url; ?>" alt="Image"></a>
					<h4 class="text-dark"><a style="color:black;" href="<?php echo "shop-single.php?id=".$productDetails["id"]; ?>"><?php  echo ucwords($productDetails["product_name"]); ?></a></h4>
					<p class="price">Rs.<?php echo $productDetails["price"]; ?></p>
				  </div>
				  
				<?php 
				} ?>
        </div>
        <div class="row mt-5">
          <div class="col-12 text-center">
            <a href="shop.php" class="btn btn-primary px-4 py-3">View All Products</a>
          </div>
        </div>
      </div>
    </div>

    
    <div class="site-section bg-light">
      <div class="container">
        <div class="row">
          <div class="title-section text-center col-12">
            <h2 class="text-uppercase">New Products</h2>
          </div>
        </div>
        <div class="row">
			<div class="col-md-12 block-3 products-wrap">
				<div class="nonloop-block-3 owl-carousel">
				<?php 
					$sql ="SELECT * FROM ".PREFIX."product_master WHERE `upcoming_product`='Yes' and `active`='Yes' order by created DESC LIMIT 9";
					$result = $functions->query($sql);
					while($productDetails = $functions->fetch($result)){
						$file_name = str_replace('', '-', strtolower( pathinfo($productDetails['main_image'], PATHINFO_FILENAME)));
						$ext = pathinfo($productDetails['main_image'], PATHINFO_EXTENSION);
						if(!empty($productDetails['main_image'])){
							$url =  BASE_URL."/images/products/".$file_name.'_crop.'.$ext;
						}else{
							$url = BASE_URL.'/images/default.jpg';
						}
				?>
						  <div class="text-center item mb-4">
							<a href="<?php echo "shop-single.php?id=".$productDetails["id"]; ?>"> <img src="<?php echo $url; ?>"  style="width:60%;margin-left: 17%;" alt="Image"></a>
							<h4 class="text-dark"><a style="color:black;" href="<?php echo "shop-single.php?id=".$productDetails["id"]; ?>"><?php  echo ucwords($productDetails["product_name"]); ?></a></h4>
							<p class="price">Rs.<?php echo $productDetails["price"]; ?></p>
						  </div>
					<?php 
					} ?>
				</div>
			</div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="title-section text-center col-12">
            <h2 class="text-uppercase">Testimonials</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 block-3 products-wrap">
            <div class="nonloop-block-3 no-direction owl-carousel">
        
              <div class="testimony">
                <blockquote>
                  <img src="images/default-avatar.png" alt="Image" class="img-fluid w-25 mb-4 rounded-circle">
                  <p>&ldquo;Pharma service during COVID 19 is magnificent. It gives good discounts than medical shops. The App is very simple to choose and the service is very much proficient and prompt. Pretty satisfied with the service. Good Part is you need not spend huge bucks on Doctor's prescribed medical shops which is other big relief. Way to GO.&rdquo;</p>
                </blockquote>

                <p>&mdash; Narendra Nekkanti</p>
              </div>
        
            
        
              <div class="testimony">
                <blockquote>
                  <img src="images/default-avatar.png" alt="Image" class="img-fluid w-25 mb-4 rounded-circle">
                  <p>&ldquo;Thank You Pharma team for your wonderful support during the nationwide LOCKDOWN because of COVID19. Despite the odds you guys made it to deliver medicine. It can be understood you incurred heavy price by shipping one order in parts from different location. You will be repaid for your wonderful Human touch to OUR buisness. Keep walking. God Bless U.&rdquo;</p>
                </blockquote>
              
                <p>&mdash; Vipan Puri</p>
              </div>
			  <div class="testimony">
				<blockquote>
				  <img src="images/default-avatar.png" alt="Image" class="img-fluid w-25 mb-4 rounded-circle">
				  <p>&ldquo;Your customer support staff are really verry good. And the hear us, help us with verry much polite manner, which is very impressive.&rdquo;</p>
				</blockquote>
			  
				<p>&mdash; Santanu</p>
			  </div>
              <div class="testimony">
                <blockquote>
                  <img src="images/default-avatar.png" alt="Image" class="img-fluid w-25 mb-4 rounded-circle">
                  <p>&ldquo;One of the good customer service and also easy payment with great offers..&rdquo;</p>
                </blockquote>
              
                <p>&mdash; Manish</p>
              </div>
			  <div class="testimony">
                <blockquote>
                  <img src="images/default-avatar.png" alt="Image" class="img-fluid w-25 mb-4 rounded-circle">
                  <p>&ldquo;I would like to thanks Pharma for their brilliant Customer Service. I ordered medicines from Pharma and they delivered my medicines within 3 days. Keep it up the good work. Pharma is the best medicine app. I recommend everyone to use Pharma App..&rdquo;</p>
                </blockquote>
              
                <p>&mdash; Himanshu Bhardwaj</p>
              </div>
			  <div class="testimony">
                <blockquote>
                  <img src="images/default-avatar.png" alt="Image" class="img-fluid w-25 mb-4 rounded-circle">
                  <p>&ldquo;Pharma IS ONE OF THE BEST MEDICINE WEBSITE INDIA BECAUSE THE DELIVERY AND CUSTOMER SUPPORT WAS VERY APPRECIABLE AND ALSO THEY GIVE MANY DISCOUNT AND OFFERS AND ALSO PROVIDE FREE MEDICAL CONSTULATION.&rdquo;</p>
                </blockquote>
              
                <p>&mdash; Harsh Agrawal</p>
              </div>
			  <div class="testimony">
                <blockquote>
                  <img src="images/default-avatar.png" alt="Image" class="img-fluid w-25 mb-4 rounded-circle">
                  <p>&ldquo;I am regular customer of Pharma since long. I order medicine for my family from Pharma and I Happy with their services. I continue using this platform for my medical needs. Thanks.&rdquo;</p>
                </blockquote>
              
                <p>&mdash; Ramesh Kumar</p>
              </div>
        
            </div>
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
                <p>Pharmaceutical products are essential to save one’s life in the world when it gets delivered to the right place with right time.
                </p>
              </div>
            </a>
          </div>
          <div class="col-lg-6 mb-5 mb-lg-0">
            <a href="#" class="banner-1 h-100 d-flex" style="background-image: url('images/bg_2.jpg');">
              <div class="banner-1-inner ml-auto  align-self-center">
                <h2>Rated by Experts</h2>
                <p>Pharmaceutical companies and doctors are today embracing the digital transformation and are aggressively taking steps to adapt.
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

</body>

</html>