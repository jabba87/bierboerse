<?php

defined("bierbörse") or die("Kein direkter Zugriff");

include "phpgraphlib.php";
include_once "mysql.php";

function renderGraphs(){
  $beershistory = getAllBeerHistory();
  foreach($beershistory as $name => $data){
	 $val = end($data);
	 $time = time();
	 $data[time()] = $val;
	 renderBeerGraph($name,$data);
	} 
}

function renderBeerGraph($name,$data){
	
	$graph = new PHPGraphLib(500,200,"images/graphs/".$name.".png");
	$graph->addData($data);
  $graph->setTitle($name);
  $graph->setRange(0,400);
  $graph->setBars(false);
  $graph->setLine(true);
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

