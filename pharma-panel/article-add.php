<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	$pageName = "Articles";
	$parentPageURL = 'article-master.php';
	$pageURL = 'article-add.php';
	error_reporting(E_ALL);
	//echo phpinfo();
	ini_set('display_errors', '1');
	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}
	
	//include_once 'csrf.class.php';
	$csrf = new csrf();
	$token_id = $csrf->get_token_id();
	$token_value = $csrf->get_token($token_id);
	
	if(isset($_POST['title']) && empty($_POST['id'])){
		//add to database
        $result = $admin->addArticle($_POST,$_FILES);
        header("location:".$pageURL."?registersuccess");
		
	}
	if(isset($_GET['edit'])){
		$id = $admin->escape_string($admin->strip_all($_GET['id']));
		$data = $admin->getUniqueArticleById($id);
	}
	if(isset($_POST['id']) && !empty($_POST['id'])) {
        //update to database
        $result = $admin->updateArticle($_POST,$_FILES);
        header("location:".$pageURL."?updatesuccess&edit&id=".$id);
        exit();
	}
	
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
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
	
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/nanoscroller.css" rel="stylesheet">
	<link href="css/emoji.css" rel="stylesheet">
	<link href="css/cover.css" rel="stylesheet">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
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
			$("#form").validate({
                ignore:[],
				rules: {
					
					title: {
                        required: true,
                    },
					atricle_image: {
						extension: 'jpg|jpeg|png'
					}
          
				},
				messages:{
					title: {
						remote: "Product enter article title"
					}
				}
			});
			jQuery.validator.addMethod("letterswithspaceonly", function(value, element) {
			return this.optional(element) || /^[^-\s][a-zA-Z\s-]+$/i.test(value);
			}, "Please enter valid value");
			$.validator.addMethod("lessthan",
			function (value, element, param) {
			  var $min = $(param);
			  if (this.settings.onfocusout) {
				$min.off(".validate-greaterThan").on("blur.validate-greaterThan", function () {
				  $(element).valid();
				});
			  }
			  return parseInt(value) < parseInt($min.val());
			}, "Discount price must be less than product standard price");
		});
	</script>
</head>
<body class="sidebar-wide">
	<?php include 'include/navbar.php' ?>

	<div class="page-container">

		<?php include 'include/sidebar.php' ?>

		<div class="page-content">

		<div class="breadcrumb-line">
			<div class="page-ttle hidden-xs" style="float:left;">
<?php
				if(isset($_GET['edit'])){ ?>
					<?php echo 'Edit '.$pageName; ?>
<?php			} else { ?>
					<?php echo 'Add New '.$pageName; ?>
<?php			} ?>
			</div>
			<ul class="breadcrumb">
				<li><a href="banner-master.php">Home</a></li>
				<li><a href="<?php echo $parentPageURL; ?>"><?php echo $pageName; ?></a></li>
				<li class="active">
<?php
				if(isset($_GET['edit'])){ ?>
					<?php echo 'Edit '.$pageName; ?>
<?php			} else { ?>
					<?php echo 'Add New '.$pageName; ?>
<?php			} ?>
				</li>
			</ul>
		</div>

		<a href="<?php echo $parentPageURL; ?>" class="label label-primary">Back to <?php echo $pageName; ?></a><br/><br/>
<?php
		if(isset($_GET['registersuccess'])){ ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="icon-checkmark3"></i> <?php echo $pageName; ?> successfully added.
			</div><br/>
<?php	} ?>
	
<?php
		if(isset($_GET['registerfail'])){ ?>
			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="icon-close"></i> <strong><?php echo $pageName; ?> not added.</strong> <?php echo $admin->escape_string($admin->strip_all($_GET['msg'])); ?>.
			</div><br/>
<?php	} ?>

<?php
		if(isset($_GET['updatesuccess'])){ ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="icon-checkmark3"></i> <?php echo $pageName; ?> successfully updated.
			</div><br/>
<?php	} ?>
	
<?php
		if(isset($_GET['updatefail'])){ ?>
			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="icon-close"></i> <strong><?php echo $pageName; ?> not updated.</strong> <?php echo $admin->escape_string($admin->strip_all($_GET['msg'])); ?>.
			</div><br/>
<?php	} ?>
			<form role="form" action="" method="post" id="form" enctype="multipart/form-data">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h6 class="panel-title"><i class="icon-library"></i>Article Details</h6>
					</div>
					<div class="panel-body">
						<div class="form-group">
                            <div class="row">
								<div class="col-sm-4">
                                    <label>Article Title<span style="color:red;">*</span></label>                                
                                    <input type="text" name="title" id="title" class="form-control" value="<?php if(isset($_GET['edit'])){ echo $data['title']; } ?>" required/>
                                </div>
								<div class="col-sm-3">
                                    <label>Main Image<span style="color:red;">*</span></label>
                                    <input type="file" class="form-control" name="atricle_image" id="atricle_image" accept="image/jpg,image/png,image/jpeg" id="" data-image-index="0" <?php if(isset($data['atricle_image']) && !empty($data['atricle_image'])){ }else{ echo "required"; } ?> value="<?php if(isset($data['atricle_image'])){ echo $data['atricle_image'] ;} ?>" />
									<span class="help-text">
										Files must be less than <strong>2 MB</strong>.<br>
										Allowed file types: <strong>png jpg jpeg</strong>.<br>
										Images must be exactly <strong>1000x667</strong> pixels.
									</span>
									<br>
									<?php if(isset($_GET['edit'])){
										$file_name = str_replace('', '-', strtolower( pathinfo($data['atricle_image'], PATHINFO_FILENAME)));
										$ext = pathinfo($data['atricle_image'], PATHINFO_EXTENSION);
										if(!empty($data['atricle_image'])){
									?>
											<img src="../images/article/<?php echo $file_name.'_crop.'.$ext ?>" width="100"  />
                                    <?php }else{ ?>
                                    		<img src="<?php echo BASE_URL.'/images/default.jpg'; ?>" width="100">
                                    <?php } 
                                    	}
                                    ?>
                                </div>
                            </div>
                            </div>
                            <br>
                         
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>Description</label>
                                    <textarea col="5" rows="4"  class="form-control" name="description" id="description" ><?php if(isset($_GET['edit'])){ echo $data['description']; }  ?></textarea>
                                </div>
                            </div>

						</div>	
						
						<div class="form-actions text-right">
						<input type="hidden" name="<?php echo $token_id; ?>" value="<?php echo $token_value; ?>" />
		<?php
					if(isset($_GET['edit'])){ ?>
							<input type="hidden" class="form-control" name="id" id="id" required="required" value="<?php echo $id ?>"/>
							<button type="submit" name="update" class="btn btn-warning"><i class="icon-pencil"></i>Update <?php echo $pageName; ?></button>
		<?php		} else { ?>
							<button type="submit" name="register" class="btn btn-danger"><i class="icon-signup"></i>Add <?php echo $pageName; ?></button>
		<?php		} ?>
						</div>
						
					</div>
				</div>
			</form>

<?php 	include "include/footer.php"; ?>
    
		</div>
	</div>
	
	<link href="css/crop-image/cropper.min.css" rel="stylesheet">
	<script src="js/crop-image/cropper.min.js"></script>
	<script src="js/crop-image/image-crop-app.js"></script>
	<script>
	$(document).ready(function() {
		//subcategory();
		$('input[type="file"]').change(function(){
			loadImagePreview(this, (1000 / 667));
		});
	});
	</script>
	<script type="text/javascript" src="js/editor/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="js/editor/ckfinder/ckfinder.js"></script>
	<script>
	var editor = CKEDITOR.replace( 'description', {
			height: 300,
			filebrowserImageBrowseUrl : 'js/editor/ckfinder/ckfinder.html?type=Images',
			filebrowserImageUploadUrl : 'js/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
			toolbarGroups: [
				
				{"name":"document","groups":["mode"]},
				{"name":"clipboard","groups":["undo"]},
				{"name":"basicstyles","groups":["basicstyles"]},
				{"name":"links","groups":["links"]},
				{"name":"paragraph","groups":["list"]},
				{"name":"insert","groups":["insert"]},
				{"name":"insert","groups":["insert"]},
				{"name":"styles","groups":["styles"]},
				{"name":"paragraph","groups":["align"]},
				{"name":"about","groups":["about"]},
				{"name":"colors","tems": [ 'TextColor', 'BGColor' ] },
			],
			removeButtons: 'Iframe,Flash,Strike,Smiley,Subscript,Superscript,Anchor,Specialchar'
		} );
	CKFinder.setupCKEditor( editor, '../' );

	</script>
	
</body>
</html>