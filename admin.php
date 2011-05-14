<?php
defined("bierbörse") or die("Kein direkter Zugriff");


require_once "functions.php";
if(!isset($_SESSION[getIP()]['user'])){
	header('Location: index.php?action=login');
}else{
	if($_SESSION[getIP()]['user'] != 'admin' ){
	die("Unzureichende Befugnisse, bitte abmelden und mit Adminrechten anmelden");
	}
}
connect();

if(isset($_POST)){
	setSettings($_POST);
}

$settings = getSettings();
$out;


$content .= "<div class=\"admin\"><form action='index.php?action=admin' method='post'>";
$content .= "<table>";
foreach($settings[0] as $id => $value){

	if(!is_numeric($id)){
		$content .= option($id,$value);
	}
}
$content .= "<tr><td colspan='2'><input type='submit'></input></td>".
 "<td><a href='index.php?action=crash'><input type=\"button\" value=\"Börsencrash\"></a></td>".
 "<td><a href='index.php?action=reset'><input type=\"button\" value=\"Datenbankreset\"></a></td>".
 "<td><a href='index.php?action=logout'><input type=\"button\" value=\"Logout\"></a><br><br></td></tr>".
 "</table></form>";

$beers = getAdminBeerList();


$content.= "<table class=\"admin_icons\"><tr><th colspan = '4'><img src=\"images/icon_BD.png\"></th><th colspan='4'><img src=\"images/icon_BC.png\"></th><th colspan='4'><img src=\"images/icon_OUT.png\"></th></tr>";
$content.= "<tr><th>Name</th><th>Mindest-<br>preis</th><th>Standard-<br>preis</th><th>Aktueller<br>Preis</th><th>Name</th><th>Mindest-<br>preis</th><th>Standard-<br>preis</th><th>Aktueller<br>Preis</th><th>Name</th><th>Mindest-<br>preis</th><th>Standard-<br>preis</th><th>Aktueller<br>Preis</th></tr>";
foreach($beers as $beer){
$content.= "<tr><td>".$beer['BD_beer_name']."</td><td>".number2price($beer['BD_min_price'])."</td><td>".number2price($beer['BD_std_price'])." </td><td>".number2price($beer['BD_cur_price'])." </td>
                <td>".$beer['BC_beer_name']."</td><td>".number2price($beer['BC_min_price'])."</td><td>".number2price($beer['BC_std_price'])." </td><td>".number2price($beer['BC_cur_price'])." </td>
                <td>".$beer['OUT_beer_name']."</td><td>".number2price($beer['OUT_min_price'])." </td><td>".number2price($beer['OUT_std_price'])." </td><td>".number2price($beer['OUT_cur_price'])." </td>
                     </tr>";

}

$row = getSaleReview('BC');

getSaleReview('OUT');

$content.= "</table></td></tr>
</table></div>
<h2>Umsatz</h2>
<table><tr><th>BD Club</th><th>BC Club</th><th>Schankwagen</th></tr>
<tr><td>";
$sales = getSaleReview('BD');
if(!empty($sales)){
$content .="<table><tr><th>Bier</th><th>Verkäufe</th><th>Umsatz</th><th>Durschnittlicher Preis</th></tr>";
foreach($sales as $sale){
if($sale['BD_beer_name'] != NULL){
$content.= "<tr><td>".$sale['BD_beer_name']."</td><td>".$sale['sumamount']."</td><td>".number2price($sale['sumprice'])."</td><td>".number2price($sale['sumprice']/$sale['sumamount'])."</td></tr>";
}
}
$sum = getClubSaleSum('BD');
$content .= "<tr><td>Gesamtsumme</td><td>".$sum['sumamount']."</td><td>".number2price($sum['sumprice'])."</td></tr>";
$content.= "</table>";
}
$content.= "</td><td>";
$sales = getSaleReview('BC');
if(!empty($sales)){
$content .= "<table><tr><th>Bier</th><th>Verkäufe</th><th>Umsatz</th><th>Durschnittlicher Preis</th></tr>";
foreach($sales as $sale){
if($sale['BC_beer_name'] != NULL){
  $content.= "<tr><td>".$sale['BC_beer_name']."</td><td>".$sale['sumamount']."</td><td>".number2price($sale['sumprice'])."</td><td>".number2price($sale['sumprice']/$sale['sumamount'])."</td></tr>";
}

}
$sum = getClubSaleSum('BC');
$content .= "<tr><td>Gesamtsumme</td><td>".$sum['sumamount']."</td><td>".number2price($sum['sumprice'])."</td></tr>";
$content.= "</table>";
}
$content.="</td><td>";
$sales = getSaleReview('OUT');
if(!empty($sales)){
$content .= "<table><tr><th>Bier</th><th>Verkäufe</th><th>Umsatz</th><th>Durschnittlicher Preis</th></tr>";
foreach($sales as $sale){
if($sale['OUT_beer_name'] != NULL){
$content.= "<tr><td>".$sale['OUT_beer_name']."</td><td>".$sale['sumamount']."</td><td>".number2price($sale['sumprice'])."</td><td>".number2price($sale['sumprice']/$sale['sumamount'])."</td></tr>";
}
}
$sum = getClubSaleSum('OUT');
$content .= "<tr><td>Gesamtsumme</td><td>".$sum['sumamount']."</td><td>".number2price($sum['sumprice'])."</td></tr>";
$content.= "</table>";
}
echo "</td></tr></table>";






close();


function option($id,$value){
	return "<tr><td><label for='$id'>".getDescr($id).": </label></td><td><input type=text size='6' name='$id' id='$id' value='$value'></input></td></tr>";
}

function getDescr($id){
	switch($id){
		case "beer_incr": return "Preiserhöhung";
		case "beer_decr": return "Preissenkung";
		case "club_incr": return "Preiserhöhung clubübergreifend";
		case "club_decr": return "Preissenkung clubübergreifend";
		case "max_price": return "Maximalpreis";
		case "equalize_decr": return "Preissenkung angleichen";
	}
}
?>
