<?php
session_start();
error_reporting(E_ALL);
define("bierbörse",true);

require_once "mysql.php";
require "logging.php";

logActions(getIP()); 

if(isset($_GET['action'])){
	switch($_GET['action']){
		case 'view':
			require "view.php";
			break;
		case 'input':
			require "input.php";
			break;
		case 'admin':
			require "admin.php";
			break;
		case 'login':
		  require "login.php";
		  break;
		default:require "view.php";
	}
}else{
  header("Location: index.php?action=view");
}





?>