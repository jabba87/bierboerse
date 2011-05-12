<?php
defined("bierbörse") or die("Kein direkter Zugriff");

include "functions.php";
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

include_once "functions.php";

echo "<div class=\"admin\"><form action='index.php?action=admin' method='post'>";
echo "<table>";
foreach($settings[0] as $id => $value){

	if(!is_numeric($id)){
		echo option($id,$value);
	}
}
echo "<tr><td colspan='2'><input type='submit'></input></td>".
 "<td><a href='index.php?action=crash'><input type=\"button\" value=\"Börsencrash\"></a></td>".
 "<td><a href='index.php?action=reset'><input type=\"button\" value=\"Datenbankreset\"></a></td>".
 "<td><a href='index.php?action=logout'><input type=\"button\" value=\"Logout\"></a><br><br></td></tr>".
 "</table></form>";

$beersBD = getBeerList('BD');
$beersBC = getBeerList('BC');
$beersOUT = getBeerList('OUT');

$content.= "<table class=\"admin_icons\"><tr><th><img src=\"images/icon_BD.png\"></th><th><img src=\"images/icon_BC.png\"></th><th><img src=\"images/icon_OUT.png\"></th></tr>";
$content.= "<tr><td><table><tr><th>Name</th><th>Mindest-<br>preis</th><th>Standard-<br>preis</th><th>Aktueller<br>Preis</th></tr>";
foreach($beersBD as $beer){
$content.= "<tr><td>".$beer['name']."</td><td>".number_format($beer['min_price']/100,2)." € </td><td>".number_format($beer['std_price']/100,2)." € </td><td>".number_format($beer['cur_price']/100,2)." € </td></tr>";
}
$content.= "</table></td><td><table><tr><th>Name</th><th>Mindest-<br>preis</th><th>Standard-<br>preis</th><th>Aktueller<br>Preis</th></tr>";
foreach($beersBC as $beer){
$content.= "<tr><td>".$beer['name']."</td><td>".number_format($beer['min_price']/100,2)." € </td><td>".number_format($beer['std_price']/100,2)." € </td><td>".number_format($beer['cur_price']/100,2)." € </td></tr>";
}
$content.= "</table></td><td><table><tr><th>Name</th><th>Mindest-<br>preis</th><th>Standard-<br>preis</th><th>Aktueller<br>Preis</th></tr>";
foreach($beersOUT as $beer){
$content.= "<tr><td>".$beer['name']."</td><td>".number_format($beer['min_price']/100,2)." € </td><td>".number_format($beer['std_price']/100,2)." € </td><td>".number_format($beer['cur_price']/100,2)." € </td></tr>";
}
$content.= "</table></td></tr>";
$content.= "</table></div>";

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
