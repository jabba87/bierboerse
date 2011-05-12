<?php
connect();
if(isset($_SESSION[getIP()])){
	unset($_SESSION[getIP()]);
}
header("Location: index.php?action=login");
close();
?>