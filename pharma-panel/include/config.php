<?php

//DELUXORA DB CRED.
/* incinson_deluxus	USER
incinson_deluxora	DB
auBTfWqxccQM		PASS */

	/*
	 * CONFIG
	 * - v1 - 
	 * - v2 - updated BASE CONFIG, error_reporting based on PROJECTSTATUS
	 * - v3 - added staging option
	 * - v3.1 - BUGFIX in staging option
	 */

	/* DEVELOPMENT CONFIG */
		// DEFINE('PROJECTSTATUS','LIVE');
		// DEFINE('PROJECTSTATUS','STAGING');
		DEFINE('PROJECTSTATUS','DEV');
	/* DEVELOPMENT CONFIG */

	/* TIMEZONE CONFIG */
	$timezone = "Asia/Calcutta";
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
	/* TIMEZONE CONFIG */

	if(PROJECTSTATUS=="LIVE"){
		error_reporting(0);
		DEFINE('BASE_URL','');
		DEFINE('ADMIN_EMAIL','info@gmail.in');
		
		

	} else if(PROJECTSTATUS=="STAGING"){
		error_reporting(E_ALL);
		DEFINE('BASE_URL','http://localhost/pharma-master');
		DEFINE('ADMIN_EMAIL','anil@gmail.com');

		

	} else { // DEFAULT TO DEV
		error_reporting(E_ALL);
		DEFINE('BASE_URL','http://localhost/pharma-master');
		DEFINE('ADMIN_EMAIL','info@gmail.com');
	}

	/* BASE CONFIG */
		DEFINE('SITE_NAME','PHARMA');
		DEFINE('SITE_NAME_IN_EMAIL','PHARMA');
		DEFINE('TITLE','Administrator Panel | '.SITE_NAME);
		DEFINE('PREFIX','pharma_');
		DEFINE('COPYRIGHT','2022');
		DEFINE('currentdate',date('Y-m-d H:i:s'));
		DEFINE('current_date',date('Y-m-d H:i:s'));
		DEFINE('LOGO', BASE_URL.'/images/logo.png');
		DEFINE('FAVICON', BASE_URL.'/images/favicon.png');		error_reporting(E_ALL);		ini_set('display_errors', '1');
	/* BASE CONFIG */
?>