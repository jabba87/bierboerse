<?php
session_start();
error_reporting(E_ALL);
define("bierbörse",true);

require_once "mysql.php";
require "logging.php";

require "header.html";

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
		default:require "view.php";
	}
}

require "footer.html";
?>