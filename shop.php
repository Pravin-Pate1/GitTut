<?php 	
	Include_once("include/functions.php");
	$functions = New Functions();
	$filterExt = "";
	
	if(isset($_GET["search_keyword"]) && !empty($_GET["search_keyword"])){
		$filterExt = "&search_keyword=".$_GET["search_keyword"];
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
          <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Store</strong></div>
        </div>
      </div>
    </div>
<br>
      <div class="container">
        
        <div class="row">
			<div class="col-lg-6">
				<h3 class="mb-3 h6 text-uppercase text-black d-block">Filter by Reference</h3>
				<button type="button" class="btn btn-secondary btn-md dropdown-toggle px-4" id="dropdownMenuReference" data-toggle="dropdown">Reference</button>
				<div class="dropdown-menu pull-right" aria-labelledby="dropdownMenuReference">
					<a class="dropdown-item" href="shop.php?tx<?php echo $filterExt; ?>">Relevance</a>
					<a class="dropdown-item" href="shop.php?nameAsc=1<?php echo $filterExt; ?>">Name, A to Z</a>
					<a class="dropdown-item" href="shop.php?nameDesc=1<?php echo $filterExt; ?>">Name, Z to A</a>
					<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="shop.php?priceAsc=1<?php echo $filterExt; ?>">Price, low to high</a>
						<a class="dropdown-item" href="shop.php?priceDesc=1<?php echo $filterExt; ?>">Price, high to low</a>
					</div>
			</div>
			<div class="col-6 col-md-6 col-lg-6">
				<form class="card card-sm" method="GET">
					<div class="card-body row no-gutters align-items-center">
						<div class="col-auto">
							<i class="fa fa-search h4 text-body"></i>
						</div>
						<!--end of col-->
						<div class="col">
							<input type="hidden" value="<?php if(isset($_GET["nameAsc"]) && !empty($_GET["nameAsc"])){ echo $_GET["nameAsc"]; } ?>" name="nameAsc">
							<input type="hidden" value="<?php if(isset($_GET["nameDesc"]) && !empty($_GET["nameDesc"])){ echo $_GET["nameDesc"]; } ?>" name="nameDesc">
							<input type="hidden" value="<?php if(isset($_GET["priceAsc"]) && !empty($_GET["priceAsc"])){ echo $_GET["priceAsc"]; } ?>" name="priceAsc">
							<input type="hidden" value="<?php if(isset($_GET["priceDesc"]) && !empty($_GET["priceDesc"])){ echo $_GET["priceDesc"]; } ?>" name="priceDesc">
							<input value ="<?php  if(isset($_GET['search_keyword']) && !empty($_GET['search_keyword'])){ echo $_GET['search_keyword'];  } ?>" class="form-control form-control-lg form-control-borderless" name="search_keyword" type="search" placeholder="Search products">
						</div>
						<!--end of col-->
						<div class="col-auto">
							<button class="btn btn-success" type="submit">Search</button>
							<?php  if(isset($_GET['search_keyword']) && !empty($_GET['search_keyword'])){ ?>
								<a class="btn btn-danger" href="shop.php">Reset</a>
							<?php } ?>
						</div>
						<!--end of col-->
					</div>
				</form>
			</div>
		</div><br>
        <div class="row">
          <?php /* <div class="col-sm-6 col-lg-4 text-center item mb-4">
            <span class="tag">Sale</span>
            <a href="shop-single.html"> <img src="images/product_01.png" alt="Image"></a>
            <h3 class="text-dark"><a href="shop-single.html">Bioderma</a></h3>
            <p class="price"><del>95.00</del> &mdash; $55.00</p>
          </div> */ 
		  $orderByExt = "";
		  if(isset($_GET['nameAsc']) && $_GET['nameAsc']==1){
			   $orderByExt = " order by product_name ASC";
		  }elseif(isset($_GET['nameDesc']) && $_GET['nameDesc']==1){
			   $orderByExt = " order by product_name DESC";
		  }elseif(isset($_GET['priceAsc']) && $_GET['priceAsc']==1){
			   $orderByExt = " order by price ASC";
		  }elseif(isset($_GET['priceDesc']) && $_GET['priceDesc']==1){
			   $orderByExt = " order by price DESC";
		  }else{
			  $orderByExt = " order by created DESC";
		  }
		  
		  $queryExt="";
		  if(isset($_GET['search_keyword']) && !empty($_GET['search_keyword'])){
			  $queryExt = " and product_name like '%".$_GET['search_keyword']."%' ";
		  }
		  $sql = "SELECT * FROM ".PREFIX."product_master WHERE `active`='Yes' $queryExt $orderByExt";
		  $result = $functions->query($sql);
		  while($productDetails=$functions->fetch($result)){
				$file_name = str_replace('', '-', strtolower( pathinfo($productDetails['main_image'], PATHINFO_FILENAME)));
				$ext = pathinfo($productDetails['main_image'], PATHINFO_EXTENSION);
				if(!empty($productDetails['main_image'])){
					$url =  BASE_URL."/images/products/".$file_name.'_crop.'.$ext;
				}else{
					$url = BASE_URL.'/images/default.jpg';
				}
			  
		  ?>
				<div class="col-sm-6 col-lg-4 text-center item mb-4">
					<a href="shop-single.php?id=<?php echo $productDetails['id']; ?>"> <img style="width: 60%;" src="<?php echo $url; ?>" alt="Image"></a>
					<h3 class="text-dark"><a href="shop-single.php?id=<?php echo $productDetails['id']; ?>"><?php echo Ucwords($productDetails['product_name']); ?></a></h3>
					<p class="price"><?php echo "Rs.".$productDetails['price']; ?></p>
				</div>
          <?php 
		  } ?>
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