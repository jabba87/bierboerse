<?php
  
defined("bierbörse") or die("Kein direkter Zugriff");
if(!isset($_SESSION[getIP()]['user'])){
    header("Location: index.php?action=login");
}
?>
