<?php

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

echo "<form action='index.php?action=admin' method='post'>";
echo "<table>";
foreach($settings[0] as $id => $value){

	if(!is_numeric($id)){
		echo option($id,$value);
	}
}
echo "<tr><td colspan='2'><input type='submit'></input></td></tr>";
echo "</table></form>";
echo "<a href='index.php?action=crash'> <button>Börsencrash</button></input></a>";

$beersBD = getBeerList(1);
$beersBC = getBeerList(2);
$beersOUT = getBeerList(3);

$content.= "<table><tr><th>BD Club</th><th>BC Club</th><th>Schankwagen</th></tr>";
$content.= "<tr><td><table><tr><th>Name</th><th>Mindestpreis</th><th>Standardpreis</th><th>Aktueller Preis</th></tr>";
foreach($beersBD as $beer){
$content.= "<tr><td>".$beer['name']."</td><td>".$beer['min_price']."</td><td>".$beer['std_price']."</td><td>".$beer['cur_price']."</td></tr>";
}
$content.= "</table></td><td><table><tr><th>Name</th><th>Mindestpreis</th><th>Standardpreis</th><th>Aktueller Preis</th></tr>";
foreach($beersBC as $beer){
$content.= "<tr><td>".$beer['name']."</td><td>".$beer['min_price']."</td><td>".$beer['std_price']."</td><td>".$beer['cur_price']."</td></tr>";
}
$content.= "</table></td><td><table><tr><th>Name</th><th>Mindestpreis</th><th>Standardpreis</th><th>Aktueller Preis</th></tr>";
foreach($beersOUT as $beer){
$content.= "<tr><td>".$beer['name']."</td><td>".$beer['min_price']."</td><td>".$beer['std_price']."</td><td>".$beer['cur_price']."</td></tr>";
}
$content.= "</table></td></tr>";
$content.= "</table>";

close();


function option($id,$value){
	return "<tr><td><label for='$id'>".getDescr($id)."</label></td><td><input type=text size='6' name='$id' id='$id' value='$value'></input></td></tr>";
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
