<?php
defined("bierbörse") or die("Kein direkter Zugriff");
connect();
$beers = getAllBeers();

echo "<div><table class=\"stdview\"><tr><th colspan='2' >".
	 "<img src=\"images/icon_BD.png\">".
	 "</th><th colspan='2'>".
	 "<img src=\"images/icon_BC.png\">".
	 "</th>"."<th colspan='2'>".
	 "<img src=\"images/icon_OUT.png\">".
	 "</th></tr>";
foreach($beers as $row){
echo "<tr><td>".
	number_format($row['bdprice']/100,2)." €".
	"</td><td>".
	"<img src=\"images/itemicon_".$row['bdname'].".png\" width=\"100\">".
	"</td><td>".
	number_format($row['bcprice']/100,2)." €".
	"</td><td>".
	"<img src=\"images/itemicon_".$row['bcname'].".png\" width=\"100\">".
	"</td><td>";
	if (!$row['outprice']=="")
		echo number_format($row['outprice']/100,2)." €";
	echo "</td><td>";
	if (!$row['outname']=="")
		echo "<img src=\"images/itemicon_".$row['outname'].".png\" width=\"100\">";
	echo "</td></tr>";
}
echo "</table></div>";

close();
?>