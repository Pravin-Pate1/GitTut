<?php

	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();
	//error_reporting(0);

	$pageName = "Articles";
	$pageURL = 'article-master.php';
	$addURL = 'article-add.php';
	$deleteURL = 'article-master.php';
	$tableName = 'article';

	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}


	if(isset($_GET['delid']) && !empty($_GET['delid'])){
		$delid = trim($admin->strip_all($_GET['delid']));
		$sql = "SELECT * FROM ".PREFIX.$tableName." WHERE id='".$delid."'";
		$result = $admin->query($sql);
		if($admin->num_rows($result)>0){
			$certi = $admin->fetch($result);
			$certimage = str_replace('', '-', strtolower( pathinfo($certi['main_image'], PATHINFO_FILENAME)));
			$certimage_ext = pathinfo($certi['main_image'], PATHINFO_EXTENSION);
			if(file_exists("../images/products/".$certimage.'_crop.'.$certimage_ext)){
				unlink("../images/products/".$certimage.'_crop.'.$certimage_ext);
				unlink("../images/products/".$certimage.'_large.'.$certimage_ext);
			}
			$Upsql = "DELETE FROM ".PREFIX.$tableName." WHERE `id`='".$delid."'";
			$admin->query($Upsql);
			header('Location:'.$pageURL.'?deletesuccess');
			exit;	
		}
	}

	if(isset($_GET['page']) && !empty($_GET['page'])) {
		$pageNo = trim($admin->strip_all($_GET['page']));
	}else{
		$pageNo=1;
	}

	$linkParam = "";
	if(isset($_GET['search']) && !empty($_GET['search_product'])){
		$search_product = trim($admin->escape_string($admin->strip_all($_GET['search_product'])));
		$searchP = " where product_name like '%".$search_product."%' or product_code like '%".$search_product."%' ";
	}else{
		$searchP='';
	}



	$query = "SELECT COUNT(*) as num FROM ".PREFIX.$tableName.$searchP;
	$total_pages = $admin->fetch($admin->query($query));
	$total_pages = $total_pages['num'];

	if(isset($_GET['search']) && !empty($_GET['search_product'])){
		$search_product = trim($admin->escape_string($admin->strip_all($_GET['search_product'])));
		$linkParam = 'search=&search_product='.$search_product;
	}

	include_once "include/pagination.php";
	$pagination = new Pagination();
	$paginationArr = $pagination->generatePagination($pageURL, $pageNo, $total_pages, $linkParam);
	$OrderBy = '';
	

	if(isset($_GET['EntryProductnameASC'])){
		$OrderBy = ' order by product_name ASC';
	}elseif(isset($_GET['EntryProductnameDESC'])){
		$OrderBy = ' order by product_name DESC';
	}elseif(isset($_GET['ProductSortASC'])){
		$OrderBy = ' order by product_code ASC';
	}elseif(isset($_GET['ProductSortDESC'])){
		$OrderBy = ' order by product_code DESC';
	}elseif(isset($_GET['EntryDateSortcreatedASC'])){
		$OrderBy = ' order by created ASC';
	}elseif(isset($_GET['EntryDateSortcreatedDESC'])){
		$OrderBy = ' order by created DESC';
	}else{
		$OrderBy = ' order by created DESC';
	}

	// $sql = "SELECT * FROM ".PREFIX.$tableName." order by created DESC LIMIT ".$paginationArr['start'].", ".$paginationArr['limit']."";

	if(isset($_GET['search']) && !empty($_GET['search_product'])){
		$search_product = trim($admin->escape_string($admin->strip_all($_GET['search_product'])));
		$sql = "SELECT * FROM ".PREFIX.$tableName." where product_name like '%".$search_product."%' or product_code like '%".$search_product."%' $OrderBy LIMIT ".$paginationArr['start'].", ".$paginationArr['limit']."";
	}else{
		$sql = "SELECT * FROM ".PREFIX.$tableName.$OrderBy;
	}
	$results = $admin->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo TITLE ?></title>
	<link rel="shortcut icon" href="<?php echo BASE_URL; ?>/images/logo.png" type="image/png" />
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="css/londinium-theme.min.css" rel="stylesheet" type="text/css">
	<link href="css/styles.min.css" rel="stylesheet" type="text/css">
	<link href="css/icons.min.css" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/fixedHeader.dataTables.min.css" rel="stylesheet">
	<link href="css/cover.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="js/jquery.1.10.1.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.1.10.2.min.js"></script>
	<script type="text/javascript" src="js/plugins/charts/sparkline.min.js"></script>
	<script type="text/javascript" src="js/plugins/forms/uniform.min.js"></script>
	<script type="text/javascript" src="js/plugins/forms/select2.min.js"></script>
	<script type="text/javascript" src="js/plugins/forms/inputmask.js"></script>
	<script type="text/javascript" src="js/plugins/forms/autosize.js"></script>
	<script type="text/javascript" src="js/plugins/forms/inputlimit.min.js"></script>
	<script type="text/javascript" src="js/plugins/forms/listbox.js"></script>
	<script type="text/javascript" src="js/plugins/forms/multiselect.js"></script>
	<script type="text/javascript" src="js/plugins/forms/validate.min.js"></script>
	<script type="text/javascript" src="js/plugins/forms/tags.min.js"></script>
	<script type="text/javascript" src="js/plugins/forms/switch.min.js"></script>
	<script type="text/javascript" src="js/plugins/forms/uploader/plupload.full.min.js"></script>
	<script type="text/javascript" src="js/plugins/forms/uploader/plupload.queue.min.js"></script>
	<script type="text/javascript" src="js/plugins/forms/wysihtml5/wysihtml5.min.js"></script>
	<script type="text/javascript" src="js/plugins/forms/wysihtml5/toolbar.js"></script>
	<script type="text/javascript" src="js/plugins/interface/daterangepicker.js"></script>
	<script type="text/javascript" src="js/plugins/interface/fancybox.min.js"></script>
	<script type="text/javascript" src="js/plugins/interface/moment.js"></script>
	<script type="text/javascript" src="js/plugins/interface/jgrowl.min.js"></script>
	<script type="text/javascript" src="js/plugins/interface/datatables.min.js"></script>
	<script type="text/javascript" src="js/plugins/interface/colorpicker.js"></script>
	<script type="text/javascript" src="js/plugins/interface/fullcalendar.min.js"></script>
	<script type="text/javascript" src="js/plugins/interface/timepicker.min.js"></script>
	<script type="text/javascript" src="js/plugins/interface/collapsible.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/application.js"></script>
	<script type="text/javascript" src="js/additional-methods.js"></script>
	<script type="text/javascript">

		$(document).ready(function() {
			$("#product-form").validate({
				ignore: [],
				rules: {
					csv_upload: {
						required: true,
						extension: 'csv',
					},
				},
				messages: {
					csv_upload: {
						extension: 'Please upload csv file',
					},
				}
			});
		});
	</script>
	<style>
	.totalsize{
		font-size: 15px;
	}
	</style>
</head>
<body class="sidebar-wide">
	<?php include 'include/navbar.php' ?>
	<div class="page-container">
		<?php include 'include/sidebar.php' ?>
 		<div class="page-content">
			<div class="breadcrumb-line">
				<div class="page-ttle hidden-xs" style="float:left;"><?php echo $pageName; ?></div>
				<ul class="breadcrumb">
					<li><a href="index.php">Home</a></li>
					<li class="active"><?php echo $pageName; ?></li>
				</ul>
			</div>

			<a href="<?php echo $addURL; ?>" class="label label-primary"  id="#" >Add <?php echo $pageName; ?></a><br/><br/>
	<?php
		if(isset($_GET['deletesuccess'])){ ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="icon-checkmark"></i> <?php echo $pageName; ?> successfully deleted.
			</div><br/>
	<?php	} 
		if(isset($_GET['deletefail'])){ ?>
			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="icon-close"></i> <strong><?php echo $pageName; ?> not deleted.</strong> Invalid Details.
			</div><br/>
	<?php	} 
		if(isset($_GET['StatusUpdateSucess'])){ ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="icon-close"></i> <strong>Status updated.</strong> successfully.
			</div><br/>
	<?php	} ?>
			<br/>
			<div class="panel panel-default">
				<div class="datatable-selectable-data">
					<table class="table">
						<thead>
							<tr>
								<th>#</th>
								<th>Article Image</th>
								<th>Article Title</th>
								<th>Created</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
<?php
						//$x = 1;
						$x = (100*$pageNo)-99;
						while($row = $admin->fetch($results)){
							$file_name = str_replace('', '-', strtolower( pathinfo($row['atricle_image'], PATHINFO_FILENAME)));
							$ext = pathinfo($row['atricle_image'], PATHINFO_EXTENSION);
							if(!empty($row['atricle_image'])){
								$url =  BASE_URL."/images/article/".$file_name.'_crop.'.$ext;
							}else{
								$url = BASE_URL.'/images/default.jpg';
							}
?>
							<tr>
								<td><?php echo $x++; ?></td>
								<td><img style="height: 100px;" src="<?php echo $url; ?>"  /></td>
								<td><?php echo $row['title']; ?></td>
								<td><?php echo date('d-m-Y', strtotime($row['created'])); ?></td>
								<td>
									<a href="<?php echo $addURL; ?>?edit&id=<?php echo $row['id'] ?>" name="edit" class="" title="Click to edit this row"><i class="icon-pencil"></i></a>
									<a class="" href="<?php echo $deleteURL; ?>?delid=<?php echo $row['id']; ?>&page=<?php echo $_GET['page']; ?>&editedby=<?php echo $loggedInUserDetailsArr['id']; ?>&search_product=<?php if(isset($_GET['search_product'])){ echo $_GET['search_product']; } ?>" onclick="return confirm('Are you sure you want to delete?');" title="Click to delete this row, this action cannot be undone."><i class="icon-remove3"></i></a>
								</td>
							</tr>

<?php
						}
?>
						</tbody>
				  </table>
				</div>
			</div>
			<input type="hidden" name="search_text" id="search_text" value="<?php if(isset($_GET['search_product']) && !empty($_GET['search_product'])){ echo $_GET['search_product']; } ?>" >
			<?php 	include "include/footer.php"; ?>
		</div>
	</div>
	<link href="css/jquery.dataTables.min.css" rel="stylesheet">
	<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="js/plugins/interface/dataTables.fixedHeader.min.js"></script>
	<link href="css/crop-image/cropper.min.css" rel="stylesheet">
	<script src="js/crop-image/cropper.min.js"></script>
	<script src="js/crop-image/image-crop-app.js"></script>

	<script>

		$(document).ready(function() {
			$("#export").on("click",function(){
				//var fromDate = $("#fromDate").val();
				//var toDate = $("#toDate").val();
				/* var values = $("input[name='products[]']").map(function(){return $(this).val();}).get();
				console.log(values); */
				  var searchIDs = $('input:checked').map(function(){
				  return $(this).val();
				});
				//console.log(searchIDs.get());
				window.open("export-products.php?success&ids="+searchIDs.get()+"&search_text=<?php if(isset($_GET['search_product']) && !empty($_GET['search_product'])){ echo $_GET['search_product']; } ?>");
			});
		});

	</script>

	<script>
	 $("#selectall").click(function () {
		 $('input:checkbox').not(this).prop('checked', this.checked);
	 });
	</script>

</body>

</html>