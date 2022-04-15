<?php
    include_once 'include/functions.php';
    $functions = new Functions();
    $response = 'false';
	if(isset($_POST['c_email']) && !empty($_POST['c_email'])){
		$email = $functions->escape_string($functions->strip_all($_POST['c_email']));
		$checkUserExistSQL = $functions->query("select * from ".PREFIX."user where email='".$email."' ");
		//echo $checkUserExistSQL;
		if($functions->num_rows($checkUserExistSQL)>0){
			$response="false";
		} else{
			$response="true";
		}
	}
	echo $response;
?>