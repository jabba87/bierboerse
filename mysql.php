<?php

defined("bierbörse") or die("Kein direkter Zugriff");

require "mysql_conf.php";

function connect(){
	global $ip,$user,$password,$database;

	mysql_connect($ip,$user,$password);
	@mysql_select_db($database) or die( "Unable to select database");

}

function pref($string,$as = true){
global $database,$prefix;
$out = "`".$database."`.`".$prefix.$string."`";
if($as){
  $out .= " `".$string."`";
}
return $out;
}

function close(){
	mysql_close();
}

function getSaleCount(){
	
	$query = "SELECT Count(ID) saleCount  FROM ".pref("sales");
	$res = mysql_fetch_array(query($query));
	return $res['saleCount'];
}

function sellBeer($id,$amount,$price,$club){

	$query = "INSERT INTO ".pref("sales",false)." (time, amount, cur_price, club, clubbeers_id)"; 
	$query .= "VALUES (NOW(), ".$amount.", ".$price.", '".$club."', ".$id.")";
	$res = query($query);	
}

function getBeers($club){

	$query = "SELECT ".$club."_club_beer_id AS id, ".$club."_beer_name AS name, (round((".$club."_cur_price / 10),0) * 10) AS price FROM ".pref($club);
	$res = query($query);
	while ($h = mysql_fetch_array($res)) {
		$row[] = $h;
	}
	return $row;
}

function getSaleReview($club){
  $query = "SELECT ".$club.".".$club."_club_beer_id, ".$club.".".$club."_beer_name, SUM(sales.amount) as sumamount, SUM(sales.amount*sales.cur_price) as sumprice FROM ".pref($club).", ".pref("sales")." WHERE ".$club.".".$club."_club_beer_id = sales.clubBeers_id";
  $res = query($query);
  while ($h = mysql_fetch_array($res)) {
		$row[] = $h;
	}
	return $row;

}

function getClubSaleSum($club){
  $query = "SELECT SUM(sales.amount) as sumamount, SUM(sales.amount*sales.cur_price) as sumprice FROM ".pref("sales")." WHERE sales.club = '".$club."'";
  $res = query($query);
  return mysql_fetch_array($res);

}

function getAllBeers(){
  $query = "SELECT BD_beer_name, (round((BD_cur_price/ 10),0) * 10) AS BD_cur_price, BC_beer_name, (round((BC_cur_price/ 10),0) * 10) AS BC_cur_price, OUT_beer_name, (round((OUT_cur_price/ 10),0) * 10) AS OUT_cur_price FROM ".pref("completebeers");
  $res = query($query);
	while ($h = mysql_fetch_array($res)) {
		$row[] = $h;
	}
	return $row;
}

function getAdminBeerList(){

	$query = "Select * FROM  ".pref("completebeers");
	$res = query($query);
	while ($h = mysql_fetch_array($res)) {
		$row[] = $h;
	}
	return $row;
}


function getBeerHistory($id){

	$query = "SELECT UNIX_TIMESTAMP(time) as time, cur_price FROM ".pref("prices")." WHERE clubBeers_id = ".$id;
	$res = query($query);
	while($row = mysql_fetch_array($res)) {
		$data[$row['time']] = $row['cur_price'];
	}
	return $data;
}

function getAllBeerHistory(){

	$query = "SELECT DISTINCT prices.clubBeers_id AS id, beers.name AS name, clubs.name AS club FROM ".pref("prices").", ".pref("beers").",".pref("club_beers").", ".pref("clubs")." WHERE club_beers.beer_id = beers.id AND club_beers.id = prices.clubBeers_id AND clubs.name = club_beers.club";
	$res = query($query);
	while($row = mysql_fetch_array($res)){
		$data[$row['club']." ".$row['name']] = getBeerHistory($row['id']);
	}
	return $data;
}

function getPassword($name){

  $query = "SELECT password FROM ".pref("clubs")." WHERE name = '$name'";
  $res = mysql_fetch_array(query($query));
  return $res['password'];
}

function getAdminPassword(){

  $query = "SELECT password FROM ".pref("settings");
  $res = mysql_fetch_array(query($query));
  return $res['password'];
}

function getSettings(){

	$query = "SELECT max_price, beer_incr, beer_decr, club_incr, club_decr FROM ".pref("settings");
	$res = query($query);
	while($row = mysql_fetch_array($res)){
		$out[] = $row;
	}
	return $out;
}

function setSettings($settings){
	$values="";
	foreach($settings as $setting => $val){
		if(!empty($values)){
			$values .= ", ";
		}
		$values .= $setting." = ".$val;
	}
	$query = "UPDATE ".pref("settings",false)." SET $values WHERE id = 1;";
	$res = query($query);
	
}

function logEvent($time,$ip,$event,$details=NULL){
	$query = "INSERT INTO ".pref("events",false)." (time,ip,event,details) VALUES (FROM_UNIXTIME(".$time."), '".$ip."', '".$event."', '".$details."')";
	$res = query($query);
}

function query($query){
  return mysql_query($query);
}
?>
