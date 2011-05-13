<?php
session_start();
error_reporting(E_ALL);
define("bierbörse",true);

require_once "mysql.php";
include_once "functions.php";
require_once "logging.php";
global $content;
global $refresh;


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
		case 'logout':
		  require "logout.php";
		  break;
		case 'crash':
		  require "crash.php";
		  break;
		case 'reset':
		  require "reset.php";
		  break;
		default:require "view.php";
	}
}else{
  header("Location: index.php?action=view");
}
require "template.php";
?>