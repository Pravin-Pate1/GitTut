<div class="site-navbar py-2" style="box-shadow: 1px 2px 2px;">

      <?php /*<div class="search-wrap">
        <div class="container">
          <a href="#" class="search-close js-search-close"><span class="icon-close2"></span></a>
          <form action="#" method="post">
            <input type="text" class="form-control" placeholder="Search keyword and hit enter...">
          </form>
        </div>
      </div> */ 
		$currentPage = pathinfo($_SERVER['PHP_SELF'], PATHINFO_BASENAME);
		$loggedInUserDetailsArr = $functions->sessionExists();
	  ?>

      <div class="container">
        <div class="d-flex align-items-center justify-content-between">
          <div class="logo">
            <div class="site-logo">
              <a href="index.php" class="js-logo-clone">Pharma</a>
            </div>
          </div>
          <div class="main-nav d-none d-lg-block">
            <nav class="site-navigation text-right text-md-center" role="navigation">
              <ul class="site-menu js-clone-nav d-none d-lg-block">
				
                <li class="<?php if($currentPage=='index.php') { echo 'active'; }?>"><a href="index.php">Home</a></li>
                <li class="<?php if($currentPage=='shop.php' || $currentPage=="shop-single.php") { echo 'active'; }?>"><a href="shop.php">Store</a></li>
                <li class="<?php if($currentPage=='articles.php') { echo 'active'; }?>"><a href="articles.php">Articles</a></li>
                <li class="<?php if($currentPage=='labs.php') { echo 'active'; }?>"><a href="labs.php">Lab Test</a></li>
				<li class="<?php if($currentPage=='donation.php' || $currentPage=='request-donation.php') { echo 'active'; }?>"><a href="donation.php">Eye Donation</a></li>
				<?php if($loggedInUserDetailsArr){ ?>
					<li class="<?php if($currentPage=='my-orders.php' || $currentPage=='order-details.php' || $currentPage=='my-profile.php' || $currentPage=="product-demand.php") { echo 'active'; }?>"><a href="my-orders.php">My Orders</a></li>
					<li class=""><a href="logout.php" style="color:red;" title="logout"><i class="fa fa-power-off"></i></a></li>
				<?php } ?>
              </ul>
            </nav>
          </div>
          <div class="icons">
           
            <?php /*<a href="javascript:;" class="icons-btn d-inline-block bag">
              <span class="icon-shopping-bag"></span>
              <span class="number">2</span>
            </a> */ 
				
				//print_r($loggedInUserDetailsArr);
				if($loggedInUserDetailsArr){
					$notiSql = "SELECT * FROM ".PREFIX."notification WHERE user_id='".$loggedInUserDetailsArr["id"]."' and is_seen='0' order by created DESC";
					$notiResult = $functions->query($notiSql);
					$notiCount = $functions->num_rows($notiResult);
			?>
					<?php echo "Hi, ".$loggedInUserDetailsArr['f_name']; ?>
					 <ul class="nav navbar-nav navbar-right">
					 
					 <li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell"></i> (<b style="color:red;"><?php echo $notiCount; ?></b>)</a>
					  <ul class="dropdown-menu notify-drop">
						<div class="drop-content">
							<li>
								<div class="col-md-12 col-sm-12 col-xs-12 pd-l0">
									<?php
										if($notiCount>0){
											while($notiDetails=$functions->fetch($notiResult)){
												if($notiDetails["notification_type"]=="Article"){
													$notiUrl = "articles.php?notiId=".$notiDetails["id"];
												}elseif($notiDetails["notification_type"]=="Order"){
													$notiUrl = "my-orders.php?notiId=".$notiDetails["id"];
												}else{
													$notiUrl = "";
												}
										?>
											<a href="<?php echo $notiUrl; ?>"><?php echo $notiDetails["description"]; ?></a><hr>
										<?php 
											} 
										}else{ ?>
											<a href="javascript:;">No Notifications</a>
								<?php	}
									?>		
								</div>
							</li>
						</div>
						
					  </ul>
					</li>
				  </ul>
			<?php 
				}else{ ?>
					<a href="login.php" class="icons-btn d-inline-block bag">Login</a>
			<?php 
			} ?>	
          </div>
        </div>
      </div>
    </div>