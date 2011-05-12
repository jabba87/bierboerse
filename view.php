<?php
defined("bierbörse") or die("Kein direkter Zugriff");
connect();

echo
//	"<script src=\"http://code.jquery.com/jquery-latest.js\"></script>".
//	"<script src=\"view.js\"></script>".
	"<table><tr><td>".
	"<table class=\"stdview\"><tr><th colspan='2' >".
	"<img src=\"images/icon_BD.png\">".
	"</th><th colspan='2'>".
	"<img src=\"images/icon_BC.png\">".
	"</th>"."<th colspan='2'>".
	"<img src=\"images/icon_OUT.png\">".
	"</th></tr>";

$beers = getAllBeers();
foreach($beers as $row){
echo "<tr><td>".
	number_format($row['bdprice']/100,2)."&nbsp;€".
	"</td><td>".
	"<img src=\"images/itemicon_".$row['bdname'].".png\">".
	"</td><td>".
	number_format($row['bcprice']/100,2)."&nbsp;€".
	"</td><td>".
	"<img src=\"images/itemicon_".$row['bcname'].".png\">".
	"</td><td>";
	if (!$row['outprice']=="")
		echo number_format($row['outprice']/100,2)."&nbsp;€";
	echo "</td><td>";
	if (!$row['outname']=="")
		echo "<img src=\"images/itemicon_".$row['outname'].".png\">";
	echo "</td></tr>";
}
echo "</table>".
	 "</td><td class=\"stdview_pictures\"><br>";

require "functions.php";
renderGraphs();

$beer = $beers[$_GET['picture']];

echo "<img src=\"images/graphs/BD ".$beer['bdname'].".png\"><br>".
	 "<img src=\"images/graphs/BC ".$beer['bcname'].".png\"><br>";
	 if ($beer['outname'] != "")
	 echo "<img src=\"images/graphs/OUT ".$beer['outname'].".png\">";


echo "</td></tr></table>";

close();

if (!isset($_GET['picture'])){
	loadPage("index.php?action=view&picture=1",5);
}else{
	loadPage("index.php?action=view&picture=".((($_GET['picture']+1)%12)),5);
}


/* versuch der sleep-funtion, 
--> nicht möglich, da während sleep der gesamte server lahm gelegt ist....

require "functions.php";
$saleCount = getSaleCount();*/
//close();

/*if(!isset($_GET['reload'])){
	loadPage("index.php?action=view&reload=$saleCount");
}else{
	connect();
	$time = time();
	sleep(1);
//	while(getSaleCount()==$_GET['reload'] and (time()<$time+1000)){
//		sleep(1);
	//}
	$saleCount = getSaleCount();
	close();
	loadPage("index.php?action=view&reload=$saleCount");
}*/
?>