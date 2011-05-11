<?php

defined("bierbörse") or die("Kein direkter Zugriff");

require "mysql_conf.php";

function connect(){
	global $user,$password,$database;

	mysql_connect('localhost',$user,$password);
	@mysql_select_db($database) or die( "Unable to select database");

}

function close(){
	mysql_close();
}

function getBeers($club){
	global $database,$prefix;
	$query = "SELECT * FROM `".$database."`.`".$prefix.$club."`";
	$res = mysql_query($query);
	while ($h = mysql_fetch_array($res)) {
		$row[] = $h;
	}
	return $row;
}

function getAllBeers(){
	global $database,$prefix;
	$query = "SELECT bdname, bdprice, bcname, bcprice, outname, outprice FROM (
				SELECT bd.id, bd.price as bdprice, bd.name as bdname, bc.price as bcprice, bc.name as bcname 
				FROM `".$database."`.`".$prefix."bc-club` bc, `".$database."`.`".$prefix."bd-club` bd, `".$database."`.`".$prefix."partners` partners 
				WHERE bd.id = partners.beer_id AND bc.id = partners.partner_id) AS t1 
			LEFT JOIN (
				SELECT bd.id, sw.price as outprice, sw.name as outname 
				FROM `".$database."`.`".$prefix."schankwagen` sw, `".$database."`.`".$prefix."bd-club` bd, `".$database."`.`".$prefix."partners` partners
				WHERE bd.id = partners.beer_id AND sw.id = partners.partner_id) AS t2
			ON(t1.id = t2.id)";
	$res = mysql_query($query);
	$row = array();
	while ($h = mysql_fetch_array($res)) {
		$row[] = $h;
	}
	return $row;
}

function getBeerHistory($id){
	global $database,$prefix;
	$query = "SELECT UNIX_TIMESTAMP(time) as time, cur_price FROM `".$database."`.`".$prefix."prices` WHERE clubBeers_id = ".$id;
	$res = mysql_query($query);
	while($row = mysql_fetch_array($res)) {
		$data[$row['time']] = $row['cur_price'];
	}
	return $data;
}

function getAllBeerHistory(){
	global $database,$prefix;
	$query = "SELECT DISTINCT prices.clubBeers_id AS id, beers.name AS name, clubs.name AS club FROM `".$database."`.`".$prefix."prices` as prices, `".$database."`.`".$prefix."beers` as beers, `".$database."`.`".$prefix."club_beers` as clubbeers, `".$database."`.`".$prefix."clubs` as clubs WHERE clubbeers.beer_id = beers.id AND clubbeers.id = prices.clubBeers_id AND clubs.id = clubbeers.club_id";
	$res = mysql_query($query);
	while($row = mysql_fetch_array($res)){
		$data[$row['name'].$row['club']] = getBeerHistory($row['id']);
	}
	return $data;
}



function logEvent($time,$ip,$event,$details=NULL){
	global $database,$prefix;
	$query = "INSERT INTO `".$database."`.`".$prefix."events`(time,ip,event,details) VALUES (FROM_UNIXTIME($time), '$ip', '$event', '$details')";
	$res = mysql_query($query) or die("MySQL Fehler");
}

