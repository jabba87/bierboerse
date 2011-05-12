<?php

defined("bierbörse") or die("Kein direkter Zugriff");

include "phpgraphlib.php";
include_once "mysql.php";

function loadPage($url,$time){
	echo "<html><head><meta http-equiv=\"refresh\" content=\"$time;URL=$url\"></head></html>";
}

function renderGraphs(){
  date_default_timezone_set('Europe/Berlin');
  $beershistory = getAllBeerHistory();
  foreach($beershistory as $name => $data){
	 $val = end($data);
	 $data[time()] = $val;
	 
	 $newdata = array();
	 foreach($data as $time => $value)
		$newdata[date("G:i",$time)] = $value/100;
	 
	 renderBeerGraph($name,$newdata);
	} 
}

function renderBeerGraph($name,$data){
	
  $graph = new PHPGraphLib(800,240,"images/graphs/".$name.".png");
  $graph->addData($data);
  $graph->setTitle($name);
  $graph->setRange(1.30,3.00);
  $graph->setBars(false);
  $graph->setLine(true);
  $graph->setBackgroundColor('221,221,221');
  $graph->setupXAxis(22, 'black');  
  $graph->createGraph();
  
}

function renderCorrelatedBeerGraph($name,$datas){

  $graph = new PHPGraphLib(500,200,"images/graphs/".$name.".png");
  foreach($datas as $data){
	 $graph->addData($data);
	}
  $graph->setTitle($name);
  $graph->setRange(0,400);
  $graph->setBars(false);
  $graph->setLine(true);
  $graph->createGraph();

}

