<?php
	$userPermissionsArray = explode(',',$loggedInUserDetailsArr['permissions']);
	$basename = basename($_SERVER['REQUEST_URI']);
	$currentPage = pathinfo($_SERVER['PHP_SELF'], PATHINFO_BASENAME);
?>
<div class="sidebar collapse">
    <div class="sidebar-content">
		<!-- Main navigation -->
		<ul class="navigation">
			
			
			<li <?php if($currentPage=='product-master.php' || $currentPage=='prdouct-add.php') { echo 'class="active"'; }?>>
				<a href="product-master.php"><span>Product Master</span> <i class="icon-diamond"></i></a>
			</li>
			<li <?php if($currentPage=='user-master.php' || $currentPage=='user-add.php') { echo 'class="active"'; }?>>
				<a href="user-master.php"><span>User Master</span> <i class="icon-diamond"></i></a>
			</li>
			<li <?php if($currentPage=='order-master.php' || $currentPage=='order-add.php') { echo 'class="active"'; }?>>
				<a href="order-master.php"><span>User Order</span> <i class="icon-diamond"></i></a>
			</li>
			<li <?php if($currentPage=='article-master.php' || $currentPage=='article-add.php') { echo 'class="active"'; }?>>
				<a href="article-master.php"><span>Article Master</span> <i class="icon-diamond"></i></a>
			</li>
			<li <?php if($currentPage=='lab-master.php' || $currentPage=='lab-add.php') { echo 'class="active"'; }?>>
				<a href="lab-master.php"><span>Lab Test Master</span> <i class="icon-diamond"></i></a>
			</li>
			<li <?php if($currentPage=='donation-master.php' || $currentPage=='donation-add.php') { echo 'class="active"'; }?>>
				<a href="donation-master.php"><span>Eye Donation Master</span> <i class="icon-diamond"></i></a>
			</li>
			<li <?php if($currentPage=='donation-request-master.php' || $currentPage=='donation-request-add.php') { echo 'class="active"'; }?>>
				<a href="donation-request-master.php"><span>Donation Request Master</span> <i class="icon-diamond"></i></a>
			</li>
			<li <?php if($currentPage=='product-demand-master.php' || $currentPage=='product-demand-add.php') { echo 'class="active"'; }?>>
				<a href="product-demand-master.php"><span>Custom Product Orders</span> <i class="icon-diamond"></i></a>
			</li>
		</ul>
      <!-- /main navigation -->
	</div>
</div>
 
<!-- /sidebar -->
