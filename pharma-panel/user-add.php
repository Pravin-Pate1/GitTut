<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	$pageName = "Users";
	$parentPageURL = 'user-master.php';
	$pageURL = 'user-add.php';
	//error_reporting(E_ALL);
	//echo phpinfo();
	//ini_set('display_errors', '1');
	
	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}
	//include_once 'csrf.class.php';
	$csrf = new csrf();
	$token_id = $csrf->get_token_id();
	$token_value = $csrf->get_token($token_id);
	
	/* if(isset($_POST['product_name']) && empty($_POST['id'])){
		//add to database
        $result = $admin->addUser($_POST,$_FILES);
        header("location:".$pageURL."?registersuccess");
		exit;
	} */
	if(isset($_GET['edit'])){
		$id = $admin->escape_string($admin->strip_all($_GET['id']));
		$data = $admin->getRegUserById($id);
	}
	if(isset($_POST['id']) && !empty($_POST['id'])) {
        $result = $admin->updateRegUser($_POST,$_FILES);
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
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
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
	<script>
	$(document).ready(function() {
			$("#updateProfile").validate({
                ignore:[],
				rules: {
					c_fname:{
						required:true,
					},
					c_lname: {
                        required: true,
                    },
                    c_email: {
						required: true,
						email:true,
						//min: 1,
						/* remote: {
							url: "ajaxEmailExistsOrNot.php",
							type: "post",
						}, */
					},
					dob: {
						required: true,
						minAge: 18,
					},
					password: {
						minlength: 6,
                    },
					repassword: {
						equalTo:"#password"
                    },
          
				},
				messages:{
					c_fname: {
						required: "Please enter first name"
					},c_lname: {
						required: "Please enter last name"
					},c_email: {
						required: "Please enter an email Id",
						email: "Please enter valid email Id",
						//remote: "Email already registred with us."
					},dob: {
						 required: "Please enter date of birth",
						 minAge: "You must be at least 18 years old!"
					},password: {
						required: "Please enter password",
						minlength: "Please enter minimum 6 characters for password"
					},repassword: {
						required: "Please enter re-password",
						equalTo: "Re-password doesn't match"
					}
				}
			});
			$.validator.addMethod("minAge", function(value, element, min) {
				var today = new Date();
				var birthDate = new Date(value);
				var age = today.getFullYear() - birthDate.getFullYear();

				if (age > min + 1) {
				  return true;
				}

				var m = today.getMonth() - birthDate.getMonth();

				if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
				  age--;
				}

				return age >= min;
			 }, "You are not old enough!");
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
			<form role="form" action="" method="post" id="updateProfile" enctype="multipart/form-data">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h6 class="panel-title"><i class="icon-library"></i>Users Details</h6>
					</div>
					<div class="panel-body">
						<div class="form-group">
                            <div class="row">
								<div class="col-sm-3">
                                    <label>First Name<span style="color:red;">*</span></label>                                
                                    <input type="text" name="c_fname" id="c_fname" class="form-control" value="<?php if(isset($_GET['edit'])){ echo $data['f_name']; } ?>" required/>
                                </div>
                                <div class="col-sm-3">
                                    <label>Last Name<span style="color:red;">*</span></label>
                                   	<input type="text" name="c_lname" id="c_lname" class="form-control" value="<?php if(isset($_GET['edit'])){ echo $data['l_name']; } ?>" required/>
								</div>
								<div class="col-sm-3">
                                    <label>Email</label>
                                    <input type="text" name="c_email" id="c_email" class="form-control" value="<?php if(isset($_GET['edit'])){ echo $data['email']; } ?>" />
                                </div>
								<div class="col-sm-3">
                                    <label>Date of Birth</label>
                                    <input type="date" name="dob" id="dob" class="form-control" value="<?php if(isset($_GET['edit'])){ echo $data['dob']; } ?>" />
                                </div>
								
                            </div>
                            <br>
                            <div class="row">
								<div class="col-sm-3">
									<label>Active</label>
									<select class="form-control" name="active">
										<option value="Yes" <?php if(isset($_GET['edit']) and $data['active']=='Yes') { echo 'selected'; } ?>>Yes</option>
										<option value="No" <?php if(isset($_GET['edit']) and $data['active']=='No') { echo 'selected'; } ?>>No</option>
									</select>
								</div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-3">
									<h5>Update Password</h5>
								</div><br><hr>
								<div class="col-sm-3">
                                    <label>Password</label>
                                    <input type="password" name="password" id="password" class="form-control" autocomplete="off" value="" />
									<small>(Leave empty if don't want to change)</small>
                                </div>
								<div class="col-sm-3">
                                    <label>Re-Password</label>
                                    <input type="password" name="repassword" id="repassword" class="form-control" autocomplete="off" value="" />
                                </div>
                            </div>
                                                       
                            </div>
                           
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
			</form>

<?php 	include "include/footer.php"; ?>
    
		</div>
	</div>
	<link href="css/crop-image/cropper.min.css" rel="stylesheet">
	<script src="js/crop-image/cropper.min.js"></script>
	<script src="js/crop-image/image-crop-app.js"></script>
</body>
</html>