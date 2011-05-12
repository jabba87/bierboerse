<?php
session_start();
error_reporting(E_ALL);
define("bierbörse",true);

require_once "mysql.php";
require "logging.php";
global $content;


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
      connect();
      crash(getIP());  
		  close();
		  header('Location: index.php?action=admin');
		  break;
		default:require "view.php";
	}
}else{
  header("Location: index.php?action=view");
}
require "header.html";
echo $content;
require "footer.html";
?>