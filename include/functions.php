<?php
	/*
	 * Functions
	 * v1.1.0
	 */
	$rootDir = dirname(dirname(__FILE__));
	include_once $rootDir.'/pharma-panel/include/config.php';
	include_once $rootDir.'/pharma-panel/include/database.php';

	class Functions extends Database {
		private $groupType = 'user'; // DEFAULT TO 'user'
		private $userType = 'customer'; // DEFAULT TO 'customer'
		private $userTypeAvailable = array("customer");
		/*===================== EXTRA FUNCTIONS BEGINS =====================*/

		/** * Function to create permalink */
		function getValidatedPermalink($permalink){ // v2.0.0
			$permalink = trim($permalink, '()');
			$replace_keywords = array("-:-", "-:", ":-", " : ", " :", ": ", ":",
				"-@-", "-@", "@-", " @ ", " @", "@ ", "@", 
				"-.-", "-.", ".-", " . ", " .", ". ", ".", 
				"-\\-", "-\\", "\\-", " \\ ", " \\", "\\ ", "\\",
				"-/-", "-/", "/-", " / ", " /", "/ ", "/", 
				"-&-", "-&", "&-", " & ", " &", "& ", "&", 
				"-,-", "-,", ",-", " , ", " ,", ", ", ",", 
				" ",
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
				"-?-", "-?", "?-", " ? ", " ?", "? ", "?",
				'-"-', '-"', '"-', ' " ', ' "', '" ', '"',
				"-!-", "-!", "!-", " ! ", " !", "! ", "!");
			$escapedPermalink = str_replace($replace_keywords, '-', $permalink); 
			return strtolower($escapedPermalink);
		}

		/** * Function to get value in yes/no */
		function getActiveLabel($isActive){
			if($isActive){
				return 'Yes';
			} else {
				return 'No';
			}
		}


		/** * Function to get image directory */
		function getImageDir($imageFor){
			switch($imageFor){
				case "banner":
					$fileDir = "images/banner/";
					break;
				case "category":
					$fileDir = "images/category/";
					break;
				case "products":
					$fileDir = "images/products/";
					break;
				case "static_banner":
					$fileDir = "images/static_banner/";
					break;
				case "occasion":
					$fileDir = "images/occasion/";
					break;
				case "testimonials":
					$fileDir = "images/testimonials/";
					break;
				case "MainBasket":
					$fileDir = "images/MainBasket/";
					break;
				case "hamper":
					$fileDir = "images/hamper/";
					break;
				case "web_banner":
					$fileDir = "images/web_banner/";
					break;
				default:
					return false;
					break;
			}
			return $fileDir;
		}
		function moneyFormate($amt){
			return number_format($amt,2);
		}
		/** * Function to get image url */
		function getImageUrl($imageFor, $fileName, $imageSuffix, $dirPrefix = ""){
			$fileDir = $this->getImageDir($imageFor, $dirPrefix);
			//echo $imageFor;
			if($fileDir === false){ // custom directory not found, error!
				
				$fileDir = "../images/"; // add / at end
				$defaultImageUrl = $fileDir."default.jpg";
				return BASE_URL."/".$defaultImageUrl;
			} else { // process custom directory
				$defaultImageUrl = $fileDir."default.jpg";
				//var_dump($fileName);
				if(empty($fileName)){
					return BASE_URL."/".$defaultImageUrl;
				} else {
					$image_name = strtolower(pathinfo($fileName, PATHINFO_FILENAME));
					$image_ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
					if(!empty($imageSuffix)){
						$imageUrl = $fileDir.$image_name."_".$imageSuffix.".".$image_ext;
					} else {
						$imageUrl = $fileDir.$image_name.".".$image_ext;
					}
					//echo $imageUrl;
					if(file_exists($imageUrl)){
						return BASE_URL."/".$imageUrl;
					} else {
						return BASE_URL."/".$defaultImageUrl;
					}
				}
			}
		}

		/** * Function to delete/unlink image file */
		function unlinkImage($imageFor, $fileName, $imageSuffix, $dirPrefix = ""){
			$fileDir = $this->getImageDir($imageFor, $dirPrefix);
			if($fileDir === false){ // custom directory not found, error!
				return false;
			} else { // process custom directory
				$defaultImageUrl = $fileDir."default.jpg";

				$imagePath = $this->getImageUrl($imageFor, $fileName, $imageSuffix, $dirPrefix);
				if($imagePath != $defaultImageUrl){
					$status = unlink($imagePath);
					return $status;
				} else {
					return false;
				}
			}
		}

		/** * Function to get remaining time/ elapsed time */
		function formatTimeRemainingInText($dateTime, $isComplete = false){
			if($isComplete){
				return "<strong>Complete!</strong>";
			} else if(!empty($dateTime)){
				$timestampDiff = strtotime($dateTime) - time();
				if($timestampDiff <=0 ){ // over due
					$then = new DateTime($dateTime);
					$now = new DateTime();
					$sinceThen = $now->diff($then);

					if($sinceThen->y > 0){
						return '<strong class="text-danger">'.$sinceThen->y." year(s) over due</strong>";
					}
					if($sinceThen->m > 0){
						return '<strong class="text-danger">'.$sinceThen->m." month(s) over due</strong>";
					}
					if($sinceThen->d > 0){
						return '<strong class="text-danger">'.$sinceThen->d." day(s) over due</strong>";
					}
					if($sinceThen->h > 0){
						return '<strong class="text-danger">'.$sinceThen->h." hour(s) over due</strong>";
					}
					if($sinceThen->i > 0){
						return '<strong class="text-danger">'.$sinceThen->i." minutes(s) over due</strong>";
					}
				} else { // time remaining
					$then = new DateTime($dateTime);
					$now = new DateTime();
					$sinceThen = $now->diff($then);

					if($sinceThen->y > 0){
						return $sinceThen->y." year(s) left";
					}
					if($sinceThen->m > 0){
						return $sinceThen->m." month(s) left";
					}
					if($sinceThen->d > 0){
						return $sinceThen->d." day(s) left";
					}
					if($sinceThen->h > 0){
						return '<strong class="text-danger">'.$sinceThen->h."</strong> hour(s) remaining";
					}
					if($sinceThen->i > 0){
						return '<strong class="text-danger">'.$sinceThen->i."</strong> minutes(s) remaining";
					}
				}

			} else {
				return "-";
			}
		}
	
		/** * Function to format date and time */
		function returnFormatTimeRemainingArray($dateTime, $isComplete = false){
			$resultArray = array();
			$resultArray['year'] = "0";
			$resultArray['month'] = "0";
			$resultArray['day'] = "0";
			$resultArray['hour'] = "0";
			$resultArray['minute'] = "0";
			$resultArray['second'] = "0";

			if($isComplete){
				$resultArray['overDue'] = false; // +
				return $resultArray;
			} else if(!empty($dateTime)){
				$then = new DateTime($dateTime);
				$now = new DateTime();
				$sinceThen = $now->diff($then);
				$resultArray['year'] = $sinceThen->y;
				$resultArray['month'] = $sinceThen->m;
				$resultArray['day'] = $sinceThen->d;
				$resultArray['hour'] = $sinceThen->h;
				$resultArray['minute'] = $sinceThen->i;
				$resultArray['second'] = $sinceThen->s;

				$timestampDiff = strtotime($dateTime) - time();
				if($timestampDiff <=0 ){ // over due
					$resultArray['overDue'] = true; // -
				} else { // time remaining
					$resultArray['overDue'] = false; // +
				}
				return $resultArray;
			} else {
				$resultArray['overDue'] = false; // +
				return $resultArray;
			}
		}
		function isCustomerEmailUnique($email) {
			$email = $this->escape_string($this->strip_all($email));
			$query = "select * from ".PREFIX."customers where email='".$email."'";
			$result = $this->query($query);
			// if($result->num_rows==1){ // exists // DEPRECATED
			if($result->num_rows>0){ // at lease one email exists 
				return false;
			} else {
				return true;
			}
		}
		function addUser($data){
			//print_R($data); exit;
			$c_fname = $this->escape_string($this->strip_all($data['c_fname']));
			$c_lname = $this->escape_string($this->strip_all($data['c_lname']));
			$email = $this->escape_string($this->strip_all($data['c_email']));
			$dob = $this->escape_string($this->strip_all(date('Y-m-d',strtotime($data['dob']))));
			
			$password = $this->escape_string($this->strip_all($data['password']));
			$passwordHASH = password_hash($password, PASSWORD_DEFAULT);

			$emailVerificationToken = md5('HYP'.time().$email);
			//$refCode = $this->GenrateReferralCode();
			$sql = "INSERT INTO ".PREFIX."user(`f_name`, `l_name`, `email`, `password`, `dob`, `active`) 
			VALUES ('".$c_fname."','".$c_lname."','".$email."','".$passwordHASH."','".$dob."','No')";	
			$this->query($sql);
			
			
		}
		/** * Function to format date and time */
		function formatDateTime($dateTime, $defaultFormat = "d M, Y h:i a T"){
			if(empty($dateTime)){
				return "-";
			} else {
				return date($defaultFormat, strtotime($dateTime));
			}
		}

		/** * Function to format date */
		function formatDate($dateTime, $defaultFormat = "d M, Y T"){
			if(empty($dateTime)){
				return "-";
			} else {
				return date($defaultFormat, strtotime($dateTime));
			}
		}

		/** * Function to format time */
		function formatTime($dateTime, $defaultFormat = "h:i a T"){
			if(empty($dateTime)){
				return "-";
			} else {
				return date($defaultFormat, strtotime($dateTime));
			}
		}

		/** * Function to limit text of description */
		function limitDescText($content, $charLength){
			if(strlen($content) > $charLength){
				return substr($content, 0, $charLength).'...';
			} else {
				return $content;
			}
		}

		/** * Function to format number in amount */
		function formatAmount($amount){
			$amount = (float) $amount;
			return number_format($amount,  2, '.', ',');
		}

		/** * Function to format number as text () */
		function formatNumberAsText($number){
			$numberLength = strlen($number);

			if($numberLength > 3){
				$number = (float) $number;
				$multiplier = 1;
				$suffix = "";
				switch($numberLength){
					case 4:
					case 5:
					case 6:
						$multiplier = 1000;
						$suffix = "K";
						break;
					case 7:
					case 8:
					case 9:
						$multiplier = 1000000;
						$suffix = "M";
						break;
					case 10:
					case 11:
					case 12:
						$multiplier = 1000000000;
						$suffix = "B";
						break;
				}
				$number = $number / $multiplier;
				$number = number_format($number,  1, '.', '');
				$number = $number.$suffix;
			}
			return $number;
		}
		function setUserEmailAsVerified($verificationToken) {
			$verificationToken = $this->escape_string($this->strip_all($verificationToken));
			$query = "update ".PREFIX."customers set is_email_verified='1', active='1', is_email_verified='1' where verification_link='".$verificationToken."'";
			$this->query($query);
			return $this->affected_rows();
		}
		/** * Function to validate numbers */
		function isNumericValue($value){

			return is_numeric($value);
		}

		/** * Function to validate percentage value */
		function isPercentValue($value){

			return ($value >=0 && $value <= 100);
		}

		/** * Function to check user's permission to access features. This function is specially used for multiusers */
		function checkUserPermissions($permission,$loggedInUserDetailsArr) {
			$userPermissionsArray = explode(',',$loggedInUserDetailsArr['permissions']);
			if(!in_array($permission,$userPermissionsArray) and $loggedInUserDetailsArr['user_role']!='super') {
				header("location: dashboard.php");
				exit;
			}
		}

		//Sequential Unique No generation for Seller/Producer/Booking/Order => Eg. prefix/yearFormat/monthFormat/1000
		function generateSequentialNo($prefix,$tablename,$columnName){
			$yearFormat 	= date("Y");
			$monthFormat	= date("m"); 

			// for financial year format
			/*if(date("n") > 3){
				$yearFormat = date("y").(date("y")+1);
			}else{
				$yearFormat = (date("y")-1).date("y");
			}*/

			$query = "select ".$columnName." from ".PREFIX.$tablename." where ".$columnName." LIKE '".$prefix.$yearFormat."/".$monthFormat."/"."%' order by id desc limit 1";
			$result = $this->query($query);
			if($this->num_rows($result) > 0){ // previous row exists, increment previous value
				$row =  $this->fetch($result);
				$prevTxnNo = intval(substr($row[$columnName], strlen($prefix.$yearFormat."/".$monthFormat."/"))); // SG1234567890
				$newTxnNo = $prevTxnNo + 1;
			} else { // no orders exist, generate new value
				$newTxnNo = 1000;
			}
			// $newTxnNo = str_pad($newTxnNo, 10, "0", STR_PAD_LEFT); // get another id
			$newTxnNo = $prefix.$yearFormat."/".$monthFormat."/".$newTxnNo;

			$isAvailQuery = "select ".$columnName." from ".PREFIX.$tablename." where ".$columnName." = '".$newTxnNo."'";
			$isAvailRS = $this->query($isAvailQuery);
			if($this->num_rows($isAvailRS) > 0){ // this id is used by another transaction, request new id
				return $this->generateSequentialNo($prefix,$tablename,$columnName);
			} else {
				return $newTxnNo;
			}
		}


		/** * Function to generate random unique number for user */
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

		/** * Function to get title of youtube video by its video id */
		function get_youtube_title($ref) {
			$json = file_get_contents('http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=' . $ref . '&format=json'); //get JSON video details
			$details = json_decode($json, true); //parse the JSON into an array
			return $details['title']; //return the video title
		}
		/*===================== EXTRA FUNCTIONS ENDS =====================*/

		function sessionExists(){
			if($this->isUserLoggedIn()){
				return $loggedInUserDetailsArr = $this->getLoggedInUserDetails();
				// return true; // DEPRECATED
			} else {
				return false;
			}
		}
		function getLoggedInUserDetails(){
			$loggedInID = $this->escape_string($this->strip_all($_SESSION[SITE_NAME][$this->groupType.'UserId']));
			$loggedInUserDetailsArr = $this->getUniqueUserById($loggedInID);
			return $loggedInUserDetailsArr;
		}
		function getUniqueUserById($id) {
			$id = $this->escape_string($this->strip_all($id));
			return $this->fetch($this->query("select * from ".PREFIX."user where id = '".$id."'"));
		}
		function isUserLoggedIn(){

			if(isset($_SESSION[SITE_NAME]) && isset($_SESSION[SITE_NAME][$this->groupType.'UserId'])  && 
				!empty($_SESSION[SITE_NAME][$this->groupType.'UserId']) ){
				return true;
			} else {
				return false;
			}
		}
		
		function userLogin($data, $successURL, $failURL = "login.php?failed"){
			$email = $this->escape_string($this->strip_all($data['email']));
			$password = $this->escape_string($this->strip_all($data['password']));

			$result = $this->query("select * from ".PREFIX."user where email='".$email."'");
			if($this->num_rows($result) == 1){
				$row = $this->fetch($result);
				if(password_verify($password, $row['password'])) {
					if($row['active']=='Yes' || $row['active']=='yes'){
						$this->loginSession($row['id'], $row['f_name'], $row['email'], $this->userTypeAvailable[0]);
						header("location: ".$successURL." ");
						exit;
					}else {
						$this->close_connection();
						header("location: ".BASE_URL."/".$failURL."&user-not-verified");
						exit;						
					}
				}else{
					$this->close_connection();
					header("location: ".BASE_URL."/".$failURL);
					exit;	
				}
				
			} else {
				$this->close_connection();
				header("location: ".BASE_URL."/".$failURL);
				exit;
			}

		}
		function loginSession($userId, $userFirstName, $userEmailName='', $userType) {
			$_SESSION[SITE_NAME][$this->groupType."UserId"] = $userId;
			$_SESSION[SITE_NAME][$this->groupType."UserFirstName"] = $userFirstName;
			$_SESSION[SITE_NAME][$this->groupType."UserEmail"] = $userEmailName;
			$_SESSION[SITE_NAME][$this->groupType."UserGroupType"] = $this->groupType;
			//$_SESSION[SITE_NAME][$this->groupType."UserType"] = $userType;
		}
		function logoutSession() {
			if(isset($_SESSION[SITE_NAME])){
				if(isset($_SESSION[SITE_NAME][$this->groupType."UserId"])){
					unset($_SESSION[SITE_NAME][$this->groupType."UserId"]);
				}
				if(isset($_SESSION[SITE_NAME][$this->groupType."UserFirstName"])){
					unset($_SESSION[SITE_NAME][$this->groupType."UserFirstName"]);
				}
				if(isset($_SESSION[SITE_NAME][$this->groupType."UserEmail"])){
					unset($_SESSION[SITE_NAME][$this->groupType."UserEmail"]);
				}
				if(isset($_SESSION[SITE_NAME][$this->groupType."UserGroupType"])){
					unset($_SESSION[SITE_NAME][$this->groupType."UserGroupType"]);
				}
				if(isset($_SESSION[SITE_NAME][$this->groupType."UserType"])){
					unset($_SESSION[SITE_NAME][$this->groupType."UserType"]);
				}
				
				unset($_SESSION[SITE_NAME]);
				return true;
			} else {
				return false;
			}
		}
		function setUserPasswordResetCode($email) {
			$email = $this->escape_string($this->strip_all($email));
			$userDetails = $this->getUniqueUserByEmail($email);

			$passwordResetToken = md5(time()."HYP".$email);

			$query = "update ".PREFIX."customers set password_reset_token='".$passwordResetToken."' where id='".$userDetails['id']."'";
			$this->query($query);

			$response = array();
			$response['updateSuccess'] = $this->affected_rows();
			$response['name'] = $userDetails['first_name'];
			$response['email'] = $userDetails['email'];
			$response['passwordResetToken'] = $passwordResetToken;
			return $response;
		}
		function getUniqueUserByEmail($email){
			$email = $this->escape_string($this->strip_all($email));
			return $this->fetch($this->query("select * from ".PREFIX."customers where email='".$email."'"));
		}
		/*=============  admin data ===============*/

		function getSuperAdminData(){
			return $this->fetch($this->query("select * from ".PREFIX."admin where user_role='super' limit 0, 1"));
		}

		/*=============  admin data ===============*/

		
		function getUniqueProductById($id) {
			$id = $this->escape_string($this->strip_all($id));
			return $this->fetch($this->query("select * from ".PREFIX."products where id='".$id."' "));
		}
		function getAddressByAddressid($addressID,$logeduser){
			$addressID = $this->escape_string($this->strip_all($addressID));
			$userId = $this->escape_string($this->strip_all($logeduser['id']));
			$sql = "SELECT * FROM ".PREFIX."customers_address WHERE `id`='".$addressID."' and customer_id='".$userId."'";
			return $this->query($sql);
		}
		function processTransaction($data){
			
			
			$payment_status = 'Payment Complete';
			$contact = $this->escape_string($this->strip_all($data["contact"]));
			$email = $this->escape_string($this->strip_all($data["email"]));
			$full_address = $this->escape_string($this->strip_all($data["full_address"]));
			$cc_name = $this->escape_string($this->strip_all($data["cc_name"]));
			
			$productDetails = $this->getProductBYid($_SESSION[SITE_NAME]["product_id"]);
			
			
			
			
			$created = date('Y-m-d G:i:s');
			$month = date('m');
			if($month <= '03' )	{
				$s_year = date('y')-1;
				$s_year1 = date('Y')-1;
				$e_year = date('y');	
				$e_year1 = date('Y');	
			} else {
				$s_year = date('y');
				$s_year1 = date('Y');
				$e_year = date('y')+1; 
				$e_year1 = date('Y')+1;  
			}	
			$invYear = $s_year.''.$e_year;
			$prevOrderRS = $this->query("select * from ".PREFIX."order where txn_id LIKE 'PHARMA-".$invYear."-%' order by id DESC LIMIT 0,1");
			if($this->num_rows($prevOrderRS)>0) {
				$prevOrder = $this->fetch($prevOrderRS);
				$prevOrderNo = $prevOrder['txn_id'];
				$prevOrderExp = explode('-',$prevOrderNo);
				//print_r($prevOrderExp);
				if(isset($prevOrderExp[0])) {
					$newOrderNo = $prevOrderExp[2] + 1;
					$newOrderNo = str_pad($newOrderNo, 8, 0, STR_PAD_LEFT);
					$txn_id = 'PHARMA-'.$invYear.'-'.$newOrderNo;
					//$invoice_id = 'INV-'.$invYear.'-'.$newOrderNo;
					$invoice_id = '';
				} else {
					$txn_id = 'PHARMA-'.$invYear.'-00000001';
					// $invoice_id = 'INV-'.$invYear.'-0001';
					$invoice_id = '';
				}
			} else {
				$txn_id = 'PHARMA-'.$invYear.'-00000001';
				// $invoice_id = 'INV-'.$invYear.'-0001';
				$invoice_id = '';
			}
			$logedInUser = $this->sessionExists();
			$date = date('Y-m-d H:i:s');
			//print_R($_SESSION);
			$sql = "INSERT INTO ".PREFIX."order(`txn_id`, `product_name`, user_id, full_address,
			`product_code`, `price`, `qty`, `payment_mode`, `user_name`, `contact`, `email`, 
			`payment_status`, `delivery_status`, `feedback`, `order_accept`) VALUES 
			('".$txn_id."','".$productDetails["product_name"]."','".$logedInUser["id"]."','".$full_address."','".$productDetails["product_code"]."','".$productDetails["price"]."','".$_SESSION[SITE_NAME]["qty"]."'
			,'CARD','".$cc_name."','".$contact."','".$email."','".$payment_status."',
			'In Process','','0')";
			
			//print_r($data);
			//print_r($productDetails);
			//exit;
			$this->query($sql);		
			$orderId = $this->last_insert_id();
			
			if(isset($_SESSION[SITE_NAME]["qty"])){
				unset($_SESSION[SITE_NAME]["qty"]);
			}
			if(isset($_SESSION[SITE_NAME]["product_id"])){
				unset($_SESSION[SITE_NAME]["product_id"]);
			}
			return array(
				"orderId" => $orderId, 
				"txnId" => $txn_id, 
				"status" => "success", 
			);
			
		}
		
		function getUniqueRegisteredUserById($id){
			$id = $this->escape_string($this->strip_all($id));
			return $this->fetch($this->query("select * from ".PREFIX."customers where id='".$id."' "));
		}
		function getProductBYid($id){
			$id = $this->escape_string($this->strip_all($id));
			return $this->fetch($this->query("select * from ".PREFIX."product_master where id='".$id."' "));
		}
		function getProductByProductCode($productCode){
			$productCode = $this->escape_string($this->strip_all($productCode));
			return $this->fetch($this->query("select * from ".PREFIX."product_master where product_code='".$productCode."' "));
		}
		function getorderDetailsBYTxnId($txnId){
			$txnId = $this->escape_string($this->strip_all($txnId));
			return $this->fetch($this->query("select * from ".PREFIX."order where txn_id='".$txnId."' "));
		}
		function orderFeedBack($data){
			$order_id = $this->escape_string($this->strip_all($data["order_id"]));
			$feedback = $this->escape_string($this->strip_all($data["feedback"]));
			
			$sql = "UPDATE ".PREFIX."order SET `feedback`='".$feedback."' WHERE id='".$order_id."'";
			$this->query($sql);
			
		}
		function updateProfile($data){
			//print_r($data); exit;
			$id = $this->escape_string($this->strip_all($data['upodateId']));
			$c_fname = $this->escape_string($this->strip_all($data['c_fname']));
			$c_lname = $this->escape_string($this->strip_all($data['c_lname']));
			$email = $this->escape_string($this->strip_all($data['c_email']));
			$dob = $this->escape_string($this->strip_all(date('Y-m-d',strtotime($data['dob']))));
			$passwordError ="";	
			if(isset($data['password']) && !empty($data['password'])){
				$old_password = $this->escape_string($this->strip_all($data['old_password']));
				$password = $this->escape_string($this->strip_all($data['password']));
				$row = $this->getUniqueUserById($id);
				if(password_verify($old_password, $row['password'])) {
					$passwordHASH = password_hash($password, PASSWORD_DEFAULT);
					$updatePswrd="UPDATE ".PREFIX."user SET password='".$passwordHASH."' WHERE id='".$id."'";
					$this->query($updatePswrd);
				}else{
					$passwordError ="1";
				}
			}
			
			$sql="UPDATE ".PREFIX."user SET `f_name`='".$c_fname."',`l_name`='".$c_lname."',
			`email`='".$email."',`dob`='".$dob."' WHERE id='".$id."'";
			$this->query($sql);
			return $passwordError;
		}
		function updateNotificationSeenStatus($notiId){
			$notiId = $this->escape_string($this->strip_all($notiId));
			$updateNoti = "UPDATE ".PREFIX."notification SET is_seen='1'  WHERE id='".$notiId."'";
			$this->query($updateNoti);
		}
		function productOnDemand($data){
			$product_name = $this->escape_string($this->strip_all($data['product_name']));
			$brand_name = $this->escape_string($this->strip_all($data['brand_name']));
			$quantity = $this->escape_string($this->strip_all($data['quantity']));
			$contact_details = $this->escape_string($this->strip_all($data['contact_details']));
			$full_address = $this->escape_string($this->strip_all($data['full_address']));
			$user_name = $this->escape_string($this->strip_all($data['user_name']));
			
			$sql = "INSERT INTO ".PREFIX."demand_product(`product_name`, `band_name`, `contact`, `address`, `status`, `qty`,user_name) 
			VALUES ('".$product_name."','".$brand_name."','".$contact_details."','".$full_address."','0','".$quantity."','".$user_name."')";
			$this->query($sql);
			
		}
		function requestDonation($data){
			$full_name = $this->escape_string($this->strip_all($data['full_name']));
			$contact = $this->escape_string($this->strip_all($data['contact']));
			$email = $this->escape_string($this->strip_all($data['email']));
			$full_address = $this->escape_string($this->strip_all($data['full_address']));
			$donation_type = $this->escape_string($this->strip_all($data['donation_type']));
			
			$sql= "INSERT INTO ".PREFIX."donation_request(`full_name`, `contact`, `email`, `full_address`, `donation_type`)
			VALUES ('".$full_name."','".$contact."','".$email."','".$full_address."','".$donation_type."')";
			$this->query($sql);
		}
	}

?>