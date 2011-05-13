<?php
defined("bierbörse") or die("Kein direkter Zugriff");
require_once "functions.php";
connect();
$refresh = "<meta http-equiv=\"refresh\" content=\"10\" >";


$content .=
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
$content .= "<tr><td>".
	number2price($row['BD_cur_price']).
	"</td><td>".
	"<img src=\"images/itemicon_".$row['BD_beer_name'].".png\">".
	"</td><td>".
	number2price($row['BC_cur_price']).
	"</td><td>".
	"<img src=\"images/itemicon_".$row['BC_beer_name'].".png\">".
	"</td><td>";
	if (!$row['OUT_cur_price']=="")
		$content .= number2price($row['OUT_cur_price']);
	$content .= "</td><td>";
	if (!$row['OUT_beer_name']=="")
		$content .= "<img src=\"images/itemicon_".$row['OUT_beer_name'].".png\">";
	$content .= "</td></tr>";
}
$content .= "</table>".
	 "</td><td class=\"stdview_pictures\"><br>";

renderGraphs();

if(!isset($_SESSION[getIP()]['picture'])){

	$_SESSION[getIP()]['picture']=0;	 
}

$beer = $beers[$_SESSION[getIP()]['picture']];
$content .= "<img src=\"images/graphs/BD ".$beer['BD_beer_name'].".png\"><br>".
		        "<img src=\"images/graphs/BC ".$beer['BC_beer_name'].".png\"><br>";
if ($beer['OUT_beer_name'] != ""){
    $content .= "<img src=\"images/graphs/OUT ".$beer['OUT_beer_name'].".png\">";

}
$_SESSION[getIP()]['picture']++;
if($_SESSION[getIP()]['picture']>11){
  $_SESSION[getIP()]['picture'] =1;
}


$content .= "</td></tr></table>";

close();


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