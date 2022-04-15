<?php
	include('database.php');
	include('SaveImage.class.php');
	include('include/classes/CSRF.class.php');
	error_reporting(0);
	/*
	 * AdminFunctions
	 * v1 - updated loginSession(), logoutSession(), adminLogin()
	 */
	class AdminFunctions extends Database {
		private $userType = 'admin';

		// === LOGIN BEGINS ===
		function loginSession($userId, $userFirstName, $userLastName, $userType,$role) {
			/* DEPRECATED $_SESSION[SITE_NAME] = array(
				$this->userType."UserId" => $userId,
				$this->userType."UserFirstName" => $userFirstName,
				$this->userType."UserLastName" => $userLastName,
				$this->userType."UserType" => $this->userType
			); DEPRECATED */
			$_SESSION[SITE_NAME][$this->userType."UserId"] = $userId;
			$_SESSION[SITE_NAME][$this->userType."UserFirstName"] = $userFirstName;
			$_SESSION[SITE_NAME][$this->userType."UserLastName"] = $userLastName;
			$_SESSION[SITE_NAME][$this->userType."UserType"] = $this->userType;
			$_SESSION[SITE_NAME][$this->userType."role"] = $role;

			/*switch($userType){
				case:'admin'{
					break;
				}
				case:'supplier'{
					break;
				}
				case:'warehouse'{
					break;
				}
				
			}*/
		}
		
		
		function logoutSession() {
			if(isset($_SESSION[SITE_NAME])){
				if(isset($_SESSION[SITE_NAME][$this->userType."UserId"])){
					unset($_SESSION[SITE_NAME][$this->userType."UserId"]);
				}
				if(isset($_SESSION[SITE_NAME][$this->userType."UserFirstName"])){
					unset($_SESSION[SITE_NAME][$this->userType."UserFirstName"]);
				}
				if(isset($_SESSION[SITE_NAME][$this->userType."UserLastName"])){
					unset($_SESSION[SITE_NAME][$this->userType."UserLastName"]);
				}
				if(isset($_SESSION[SITE_NAME][$this->userType."UserType"])){
					unset($_SESSION[SITE_NAME][$this->userType."UserType"]);
				}
				return true;
			} else {
				return false;
			}
		}
		function adminLogin($data, $successURL, $failURL = "admin-login.php?failed") {
			$username = $this->escape_string($this->strip_all($data['username']));
			$password = $this->escape_string($this->strip_all($data['password']));
			$query = "select * from ".PREFIX."admin where username='".$username."'";
			$result = $this->query($query);

			if($this->num_rows($result) == 1) { // only one unique user should be present in the system
				$row = $this->fetch($result);
				if(password_verify($password, $row['password'])) {
					$this->loginSession($row['id'], $row['fname'], $row['lname'], $this->userType,$row['role']);
					$this->close_connection();
					header("location: ".$successURL);
					exit;
				} else {
					$this->close_connection();
					header("location: ".$failURL);
					exit;
				}
			} else {
				$this->close_connection();
				header("location: ".$failURL);
				exit;
			}
		}
		/* function sessionExists(){
			if( isset($_SESSION[SITE_NAME]) && 
				isset($_SESSION[SITE_NAME][$this->userType.'UserId']) && 
				isset($_SESSION[SITE_NAME][$this->userType.'UserType']) && 
				!empty($_SESSION[SITE_NAME][$this->userType.'UserId']) &&
				$_SESSION[SITE_NAME][$this->userType.'UserType']==$this->userType){

				return $loggedInUserDetailsArr = $this->getLoggedInUserDetails();
				// return true; // DEPRECATED
			} else {
				return false;
			}
		} */
		function sessionExists(){
			if($this->isUserLoggedIn()){
				return $loggedInUserDetailsArr = $this->getLoggedInUserDetails();
				// return true; // DEPRECATED
			} else {
				return false;
			}
		}
		function isUserLoggedIn(){
			if( isset($_SESSION[SITE_NAME]) && 
				isset($_SESSION[SITE_NAME][$this->userType.'UserId']) && 
				isset($_SESSION[SITE_NAME][$this->userType.'UserType']) && 
				!empty($_SESSION[SITE_NAME][$this->userType.'UserId']) &&
				$_SESSION[SITE_NAME][$this->userType.'UserType']==$this->userType){
				return true;
			} else {
				return false;
			}
		}
		function getSystemUserType() {
			return $this->userType;
		}
		function getLoggedInUserDetails(){
			$loggedInID = $this->escape_string($this->strip_all($_SESSION[SITE_NAME][$this->userType.'UserId']));
			$loggedInUserDetailsArr = $this->getUniqueUserById($loggedInID);
			return $loggedInUserDetailsArr;
		}
		
		function getUniqueUserById($userId) {
			$id = $this->escape_string($this->strip_all($userId));
			$query = "select * from ".PREFIX."admin where id='".$id."'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		// === LOGIN ENDS ====

		// == EXTRA FUNCTIONS STARTS ==
		function getValidatedPermalink($permalink){ // v2
			$permalink = trim($permalink, '()');
			$replace_keywords = array("-:-", "-:", ":-", " : ", " :", ": ", ":",
				"-@-", "-@", "@-", " @ ", " @", "@ ", "@", 
				"-.-", "-.", ".-", " . ", " .", ". ", ".", 
				"-\\-", "-\\", "\\-", " \\ ", " \\", "\\ ", "\\",
				"-/-", "-/", "/-", " / ", " /", "/ ", "/", 
				"-&-", "-&", "&-", " & ", " &", "& ", "&", 
				"-,-", "-,", ",-", " , ", " ,", ", ", ",", 
				" ", "\r", "\n", 
				"---", "--", " - ", " -", "- ",
				"-#-", "-#", "#-", " # ", " #", "# ", "#",
				"-$-", "-$", "$-", " $ ", " $", "$ ", "$",
				"-%-", "-%", "%-", " % ", " %", "% ", "%",
				"-^-", "-^", "^-", " ^ ", " ^", "^ ", "^",
				"-*-", "-*", "*-", " * ", " *", "* ", "*",
				"-(-", "-(", "(-", " ( ", " (", "( ", "(",
				"-)-", "-)", ")-", " ) ", " )", ") ", ")",
				"-;-", "-;", ";-", " ; ", " ;", "; ", ";",
				"-'-", "-'", "'-", " ' ", " '", "' ", "'",
				'-"-', '-"', '"-', ' " ', ' "', '" ', '"',
				"-?-", "-?", "?-", " ? ", " ?", "? ", "?",
				"-+-", "-+", "+-", " + ", " +", "+ ", "+",
				"-!-", "-!", "!-", " ! ", " !", "! ", "!");
			$escapedPermalink = str_replace($replace_keywords, '-', $permalink); 
			return strtolower($escapedPermalink);
		}
		function getUniquePermalink($permalink,$tableName,$main_menu,$newPermalink='',$num=1) {
			if($newPermalink=='') {
				$checkPerma = $permalink;
			} else {
				$checkPerma = $newPermalink;
			}
			$sql = $this->query("select * from ".PREFIX.$tableName." where permalink='$checkPerma' and main_menu='$main_menu'");
			if($this->num_rows($sql)>0) {
				$count = $num+1;
				$newPermalink = $permalink.$count;
				return $this->getUniquePermalink($permalink,$tableName,$main_menu,$newPermalink,$count);
			} else {
				return $checkPerma;
			}
		}
		function getActiveLabel($isActive){
			if($isActive){
				return 'Yes';
			} else {
				return 'No';
			}
		}
		function getImageUrl($imageFor, $fileName, $imageSuffix){
			$image_name = strtolower(pathinfo($fileName, PATHINFO_FILENAME));
			$image_ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
			switch($imageFor){
				case "banner":
					$fileDir = "../images/banner/";
					break;
				case "category":
					$fileDir = "../images/category/";
					break;
				case "products":
					$fileDir = "../images/products/";
					break;
				case "static_banner":
					$fileDir = "../images/static_banner/";
					break;
				case "occasion":
					$fileDir = "../images/occasion/";
					break;
				case "testimonials":
					$fileDir = "../images/testimonials/";
					break;
				case "MainBasket":
					$fileDir = "../images/MainBasket/";
					break;
				case "hamper":
					$fileDir = "../images/hamper/";
					break;
				case "web_banner":
					$fileDir = "../images/web_banner/";
					break;
				default:
					return false;
					break;
			}

			$imageUrl = $fileDir.$image_name."_".$imageSuffix.".".$image_ext;
			if(file_exists($imageUrl)){
				return $imageUrl;
				// $imageUrl = BASE_URL.'/'.$imageUrl;
			} else {
				return false;
				// $imageUrl = BASE_URL."/images/no_img.jpg";
			}
		}
		function unlinkImage($imageFor, $fileName, $imageSuffix){
			$imagePath = $this->getImageUrl($imageFor, $fileName, $imageSuffix);
			$status = false;
			if($imagePath!==false){
				$status = unlink($imagePath);
			}
			return $status;
		}
		function checkUserPermissions($permission,$loggedInUserDetailsArr) {
			$userPermissionsArray = explode(',',$loggedInUserDetailsArr['permissions']);
			if(!in_array($permission,$userPermissionsArray) and $loggedInUserDetailsArr['user_role']!='super') {
				header("location: dashboard.php");
				exit;
			}
		}
		
		
	
		/******************************USER*************************************/
		function getUserById($userId) {
			$id = $this->escape_string($this->strip_all($userId));
			$query = "select * from ".PREFIX."user_master where id='".$id."'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addUser($data){
			$fname = $this->escape_string($this->strip_all($data['fname']));
			$lname = $this->escape_string($this->strip_all($data['lname']));
			$email = $this->escape_string($this->strip_all($data['email']));
			$password = password_hash($data['password'], PASSWORD_DEFAULT);
			$mobile = $this->escape_string($this->strip_all($data['mobile']));
			$points = $this->escape_string($this->strip_all($data['points']));
			$active = $this->escape_string($this->strip_all($data['active']));

			$query = "insert into ".PREFIX."user_master (fname, lname, email, mobile, password, active, points) values('".$fname."', '".$lname."', '".$email."', '".$mobile."', '".$password."', '".$active."', '".$points."') ";

			return $this->query($query);
		}

		function updateUser($data){
			$id = $this->escape_string($this->strip_all($data['id']));
			$fname = $this->escape_string($this->strip_all($data['fname']));
			$lname = $this->escape_string($this->strip_all($data['lname']));
			$email = $this->escape_string($this->strip_all($data['email']));
			$password = password_hash($data['password'], PASSWORD_DEFAULT);
			$mobile = $this->escape_string($this->strip_all($data['mobile']));
			$active = $this->escape_string($this->strip_all($data['active']));
			$points = $this->escape_string($this->strip_all($data['points']));
			$last_modified = date("Y-m-d h:i:s");

			$query =  "update ".PREFIX."user_master set fname = '".$fname."', lname = '".$lname."', email = '".$email."', password = '".$password."', mobile = '".$mobile."', active = '".$active."', last_modified = '".$last_modified."', points = '".$points."' where id = '".$id."'";

			return $this->query($query);

		}
		//Add User functions ends

		

		
		//Product Master Functions

		function getUniqueProductById($id){
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."product_master where id = '".$id."' ";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function generate_id($prefix, $randomNo, $tableName, $columnName){
			$chkprofile=$this->query("select ".$columnName." from ".PREFIX.$tableName." where ".$columnName." = '".$prefix.$randomNo."'");
			if($this->num_rows($chkprofile)>0){
				$randomNo = str_shuffle('1234567890123456789012345678901234567890');
				$randomNo = substr($randomNo,0,8);
				$this->generate_id($prefix, $randomNo, $tableName, $columnName);
			}else{
				return  $prefix.$randomNo;
			}
		}

		function addProduct($data, $file){
		
			
			$product_name = $this->escape_string($this->strip_all($data['product_name']));
			$product_code = $this->escape_string($this->strip_all($data['product_code']));
			$availability = $this->escape_string($this->strip_all($data['availability']));
			
			$date = date('Ymdhis');
			
			$price = $this->escape_string($this->strip_all($data['price']));
			$discount_price = $this->escape_string($this->strip_all($data['discount_price']));
			if(empty($discount_price)){
				$discount_price = 0;
			}
			
			$description =	$data['description'];
			$active = $this->escape_string($this->strip_all($data['active']));
		
			$feature_product = $this->escape_string($this->strip_all($data['feature_product']));
			$best_product = $this->escape_string($this->strip_all($data['best_product']));
			$upcoming_product = $this->escape_string($this->strip_all($data['upcoming_product']));

			$SaveImage = new SaveImage();
			$imgDir = '../images/products/';
			if(isset($file['main_image']['name']) && !empty($file['main_image']['name'])){
				$file_name = strtolower( pathinfo($file['main_image']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$main_image = $SaveImage->uploadCroppedImageFileFromForm($file['main_image'], 380, $cropData, $imgDir, time().'-1');
			} else {
				$main_image = '';
			}
			//print_r($data); 
			//$sql = "INSERT INTO ".PREFIX."product_master(`product_name`, `product_code`, `availability`, `main_image`, `image_one`, `image_two`, `image_three`, `image_four`, `image_five`, `price`, `discount_price`, `tax`, `description`, `active`, `meta_title`, `meta_keyword`, `meta_description`, permalink ,time, feature_product, best_product, upcoming_product, minimum_inventory) VALUES ('".$product_name."','".$product_code."','".$availability."','".$main_image."','".$image_one."','".$image_two."','".$image_three."','".$image_four."','".$image_five."','".$price."','".$discount_price."','".$tax."','".$description."','".$active."','".$meta_title."','".$meta_keyword."','".$meta_description."','".$permalink."', '".$date."', '".$feature_product."', '".$best_product."', '".$upcoming_product."', '".$minimum_inventory."')";
			$sql ="INSERT INTO ".PREFIX."product_master( `product_name`, `product_code`, `availability`, `price`, `discount_price`, `description`, `active`, `feature_product`, `best_product`, `upcoming_product`, `main_image`) 
			VALUES ('".$product_name."','".$product_code."','0','".$price."','0','".$description."','".$active."','".$feature_product."','".$best_product."','".$upcoming_product."','".$main_image."')";
			$this->query($sql);
			$product_id = $this->last_insert_id();


		}

		function updateProduct($data, $file){

			$id = $this->escape_string($this->strip_all($data['id']));
			$product_name = $this->escape_string($this->strip_all($data['product_name']));
			$product_code = $this->escape_string($this->strip_all($data['product_code']));
			$availability = $this->escape_string($this->strip_all($data['availability']));
			
			$price = $this->escape_string($this->strip_all($data['price']));
			$discount_price = $this->escape_string($this->strip_all($data['discount_price']));
			if(empty($discount_price)){
				$discount_price = 0;
			}
			
			$description =	$data['description'];
			$active = $this->escape_string($this->strip_all($data['active']));
		
			$feature_product = $this->escape_string($this->strip_all($data['feature_product']));
			$best_product = $this->escape_string($this->strip_all($data['best_product']));
			$upcoming_product = $this->escape_string($this->strip_all($data['upcoming_product']));

			$SaveImage = new SaveImage();
			$imgDir = '../images/products/';
			
			$image_five ='';
			$Detail = $this->getUniqueProductById($id);
			//print_r($Detail);
			$updatetime = ''; 
			/* $permalink = $this->getValidatedPermalink($product_name);
			if(!empty($Detail['time'])){
				$time = $Detail['time'];
			}else{
				$time = date('Ymdhis');
				$updatetime =", time='".$time."'";
			}
			$permalink = "corporate/".$permalink."/".$time; */

			if(isset($file['main_image']['name']) && !empty($file['main_image']['name'])) {
				$cropData = $this->strip_all($data['cropData1']);
				$file_name = strtolower( pathinfo($file['main_image']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$this->unlinkImage("products", $Detail['main_image'], "large");
				$this->unlinkImage("products", $Detail['main_image'], "crop");
				$main_image = $SaveImage->uploadCroppedImageFileFromForm($file['main_image'], 380, $cropData, $imgDir, time().'-1');
				$this->query("update ".PREFIX."product_master set main_image='$main_image' where id='$id'");
			}
			
			$sql = "UPDATE ".PREFIX."product_master SET `product_name`='".$product_name."',`product_code`='".$product_code."',`availability`='".$availability."',`price`='".$price."',
			`discount_price`='".$discount_price."',`description`='".$description."',`active`='".$active."',`feature_product`='".$feature_product."',`best_product`='".$best_product."',`upcoming_product`='".$upcoming_product."' WHERE id='".$id."'";
			$this->query($sql);
			
			

		}
		
		function deleteProduct($id){
			$id = $this->escape_string($this->strip_all($id));
			$Detail = $this->getUniqueProductById($id);
			$this->unlinkImage("images", $Detail['image'], "large");
			$this->unlinkImage("images", $Detail['image'], "crop");
			$query = "delete from ".PREFIX."product_master where id = '".$id."' "; 
			return $this->query($query);
		}



		function getAllProducts(){
			$sql = "SELECT * FROM ".PREFIX."product_master WHERE `active`='Yes'";
			return $this->query($sql);
		}

		
		function isProductCodeIsUnique($product_code,$id=''){
			$product_code = $this->escape_string($this->strip_all($product_code));
			$id = $this->escape_string($this->strip_all($id));
			if(!empty($id)){
				$id = " and id<>'".$id."'";
			}
			$sql = "SELECT * FROM ".PREFIX."product_master WHERE `product_code`='".$product_code."' $id";
			//echo $sql;
			$result = $this->query($sql);
			if($result->num_rows>0){ // at lease one email exists 
				return false;
			} else {
				return true;
			}
		}
		
		function getListOfCities(){
			$query = "select name as districtname from ".PREFIX."cities order by name asc";
			return $this->query($query);
		}
		function getListOfStates(){
			$query = "select name as statename from ".PREFIX."states order by name asc";
			return $this->query($query);
		}
		function getUniqueCustomersById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."customers where id='$id'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}
		//ARTICLES
		function getUniqueArticleById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."article where id='$id'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addArticle($data,$file) {
			
			
			$title = $this->escape_string($this->strip_all($data['title']));
			
			$description = $data["description"];
			
			$date = date("Y-m-d H:i:s");
			$SaveImage = new SaveImage();
			$imgDir = '../images/article/';
			if(isset($file['atricle_image']['name']) && !empty($file['atricle_image']['name'])){
				$atricle_image = str_replace( " ", "-", $file['atricle_image']['name'] );
				$file_name = strtolower( pathinfo($atricle_image, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$atricle_image = $SaveImage->uploadCroppedImageFileFromForm($file['atricle_image'], 667, $cropData, $imgDir, $file_name.'-'.time().'-1');
			} else {
				$atricle_image = '';
			}
			
			$query= "INSERT INTO ".PREFIX."article(`title`, `atricle_image`, `description`) VALUES ('".$title."','".$atricle_image."','".$description."')";
			$this->query($query);
			$articleId = $this->last_insert_id();
			
			$sql = "SELECT * FROM ".PREFIX."user WHERE active='Yes'";
			$userSql = $this->query($sql);
			if($this->num_rows($userSql)>0){
				while($UserDetails = $this->fetch($userSql)){
						$notidesc = "New Article Is Added";
						$this->genrateNotification("Article",$notidesc,$UserDetails["id"]);
				}
			}
			//exit;			
			
		}
		
		function updateArticle($data,$file) {
			
			$id = $this->escape_string($this->strip_all($data['id']));
			$title = $this->escape_string($this->strip_all($data['title']));
			$description = $data["description"];

			$SaveImage = new SaveImage();
			$imgDir = '../images/article/';
			
			$Detail = $this->getUniqueArticleById($id);

			
			if(isset($file['atricle_image']['name']) && !empty($file['atricle_image']['name'])) {
				$atricle_image = str_replace( " ", "-", $file['atricle_image']['name'] );
				$file_name = strtolower( pathinfo($atricle_image, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				
				$cropData = $this->strip_all($data['cropData1']);
				$this->unlinkImage("banner", $Detail['image_name'], "large");
				$this->unlinkImage("banner", $Detail['image_name'], "crop");
				$atricle_image = $SaveImage->uploadCroppedImageFileFromForm($file['atricle_image'], 667, $cropData, $imgDir, $file_name.'-'.time().'-1');
				$this->query("update ".PREFIX."article set atricle_image='".$atricle_image."' where id='$id'");
			}
			$query = "update ".PREFIX."article set title='".$title."', description='".$description."' where id='$id'";
			return $this->query($query);
		}

		function deleteArticle($id) {
			$id = $this->escape_string($this->strip_all($id));
			$Detail = $this->getUniqueArticleById($id);
			$this->unlinkImage("banner", $Detail['image_name'], "large");
			$this->unlinkImage("banner", $Detail['image_name'], "crop");
			$query = "delete from ".PREFIX."banner_master where id='$id'";
			$this->query($query);
			return true;
		}
		
		function getUniquelabById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."lab where id='$id'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addlab($data,$file) {
			$name = $this->escape_string($this->strip_all($data['name']));
			$contact = $this->escape_string($this->strip_all($data['contact']));
			$city = $this->escape_string($this->strip_all($data['city']));
			$address = $this->escape_string($this->strip_all($data['address']));
			$active = $this->escape_string($this->strip_all($data['active']));
			$service = $this->escape_string($this->strip_all(implode(", ",$data['service'])));
			$date = date("Y-m-d H:i:s");
			
			$query= "INSERT INTO ".PREFIX."lab(`name`, `contact`, `city`, `address`, `active`, service) VALUES ('".$name."','".$contact."','".$city."','".$address."','".$active."','".$service."')";
			return $this->query($query);
		}
		
		function updatelab($data,$file) {
			
			$id = $this->escape_string($this->strip_all($data['id']));
			$name = $this->escape_string($this->strip_all($data['name']));
			$contact = $this->escape_string($this->strip_all($data['contact']));
			$city = $this->escape_string($this->strip_all($data['city']));
			$address = $this->escape_string($this->strip_all($data['address']));
			$active = $this->escape_string($this->strip_all($data['active']));
			$service = $this->escape_string($this->strip_all(implode(", ",$data['service'])));
			
			$query = "UPDATE ".PREFIX."lab SET service='".$service."',`name`='".$name."',`contact`='".$contact."',`city`='".$city."',`address`='".$address."',`active`='".$active."' WHERE id='".$id."'";
			return $this->query($query);
		}
		
		function getUniqueDonationById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."donation where id='$id'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addDonation($data,$file) {
			$name = $this->escape_string($this->strip_all($data['name']));
			$contact = $this->escape_string($this->strip_all($data['contact']));
			$city = $this->escape_string($this->strip_all($data['city']));
			$address = $this->escape_string($this->strip_all($data['address']));
			
			$date = date("Y-m-d H:i:s");
			
			$query= "INSERT INTO ".PREFIX."donation(`hospital_name`, `city`, `contact`, `address`) 
			VALUES ('".$name."','".$city."','".$contact."','".$address."')";
			return $this->query($query);
		}
		
		function updateDonation($data,$file) {
			
			$id = $this->escape_string($this->strip_all($data['id']));
			$name = $this->escape_string($this->strip_all($data['name']));
			$contact = $this->escape_string($this->strip_all($data['contact']));
			$city = $this->escape_string($this->strip_all($data['city']));
			$address = $this->escape_string($this->strip_all($data['address']));
			
			
			$query = "UPDATE ".PREFIX."donation SET `hospital_name`='".$name."',
			`city`='".$city."',`contact`='".$contact."',`address`='".$address."' WHERE id='".$id."'";
			return $this->query($query);
		}
		function getRegUserById($id){
			$id = $this->escape_string($this->strip_all($id));
			$sql = "SELECT * FROM ".PREFIX."user WHERE `id`='".$id."'";
			$result = $this->query($sql);
			return $this->fetch($result);
		}
		function updateRegUser($data){
			$id = $this->escape_string($this->strip_all($data['id']));
			$c_fname = $this->escape_string($this->strip_all($data['c_fname']));
			$c_lname = $this->escape_string($this->strip_all($data['c_lname']));
			$c_email = $this->escape_string($this->strip_all($data['c_email']));
			$dob = $this->escape_string($this->strip_all($data['dob']));
			$active = $this->escape_string($this->strip_all($data['active']));
			if(isset($data["password"]) && !empty($data["password"])){
				$password = $this->escape_string($this->strip_all($data['password']));
				$passwordHASH = password_hash($password, PASSWORD_DEFAULT);
				$sql ="UPDATE ".PREFIX."user SET password='".$passwordHASH."' WHERE id='".$id."'";
				$this->query($sql);
			}
			
			$sql = "UPDATE ".PREFIX."user SET `f_name`='".$c_fname."',
			`l_name`='".$c_lname."',`email`='".$c_email."',`dob`='".$dob."',`active`='".$active."'
			WHERE id='".$id."'";
			$this->query($sql);
		}
		function getOrderById($id){
			$id = $this->escape_string($this->strip_all($id));
			$sql = "SELECT * FROM ".PREFIX."order WHERE `id`='".$id."'";
			$result = $this->query($sql);
			return $this->fetch($result);
		}
		function updateOrderStatus($data){
			$delivery_status = $this->escape_string($this->strip_all($data['delivery_status']));
			$order_accept = $this->escape_string($this->strip_all($data['order_accept']));
			$old_delivery_status = $this->escape_string($this->strip_all($data['old_delivery_status']));
			$old_order_status = $this->escape_string($this->strip_all($data['old_order_status']));
			$user_id = $this->escape_string($this->strip_all($data['user_id']));
			$id = $this->escape_string($this->strip_all($data['id']));
			$txn_id = $this->escape_string($this->strip_all($data['txn_id']));
	
			$sql = "UPDATE ".PREFIX."order SET delivery_status='".$delivery_status."',order_accept='".$order_accept."' WHERE id='".$id."'";
			$this->query($sql);
			
			
			if($delivery_status != $old_delivery_status){
				$notidesc ="Order Id ".$txn_id." Delivery Status is Updated";
				$this->genrateNotification("Order", $notidesc, $user_id);
			}
			if($order_accept != $old_order_status){
				$notidesc ="Order Id ".$txn_id." Order Status is Updated";
				$this->genrateNotification("Order", $notidesc, $user_id);
			}
			
		}
		
		function genrateNotification($notiType,$notidesc,$userId){
			$notiType = $this->escape_string($this->strip_all($notiType));
			$notidesc = $this->escape_string($this->strip_all($notidesc));
			$userId = $this->escape_string($this->strip_all($userId));
			
			$sql = "INSERT INTO ".PREFIX."notification(`notification_type`, `description`, `user_id`, `is_seen`)
			VALUES ('".$notiType."','".$notidesc."','".$userId."','0')";
			$this->query($sql);
		}
		
		function getUniqueDonationRequestById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."demand_product where id='$id'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		
		function updateProductDemandOrder($data,$file) {
			$id = $this->escape_string($this->strip_all($data['id']));
			$status = $this->escape_string($this->strip_all($data['status']));
			
			$query = "UPDATE ".PREFIX."demand_product SET `status`='".$status."' WHERE id='".$id."'";
			return $this->query($query);
		}
		
	} 
?>