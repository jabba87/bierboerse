<?php
defined("bierbörse") or die("Kein direkter Zugriff");

if(!isset($_SESSION[getIP()]['user'])){
	header('Location: index.php?action=login');
}else{
	if($_SESSION[getIP()]['user'] != 'admin' ){
	die("Unzureichende Befugnisse, bitte abmelden und mit Adminrechten anmelden");
	}
}

connect();
logEvent(time(),getIp(),'crash','tiefstpreise');
close();

header('Location: index.php?action=admin');
?>