<?php 

defined("bierbörse") or die("Kein direkter Zugriff");
require_once "mysql.php";

function getIP(){
if ( isset($_SERVER["REMOTE_ADDR"]) )    { 
	$ip=$_SERVER["REMOTE_ADDR"] . ' '; 
} else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) )    { 
	$ip=$_SERVER["HTTP_X_FORWARDED_FOR"] . ' '; 
} else if ( isset($_SERVER["HTTP_CLIENT_IP"]) )    { 
	$ip=$_SERVER["HTTP_CLIENT_IP"] . ' '; 
} 
return $ip;
}

function logActions($ip){
  if(!isset($_SESSION[$ip])){
	
	 $_SESSION[$ip]['calls'] =1;	
	 $_SESSION[$ip]['firstvisit'] = time();
	 $_SESSION[$ip]['lastpage'] = http_build_query($_GET);
	 connect();
	 logEvent(time(),$ip,"newClient",NULL);
	 logEvent(time(),$ip,"pageCall",$_SESSION[$ip]['lastpage']);
	 close();
	
  }else{
  	$_SESSION[$ip]['lastvisit'] = time();
	  if($_SESSION[$ip]['lastpage'] != http_build_query($_GET)){
	   	$_SESSION[$ip]['lastpage'] = http_build_query($_GET);
		  connect();
		  logEvent(time(),$ip,"pageCall",$_SESSION[$ip]['lastpage']);
		  close();
	 }
  }	
}



	
	



?>
