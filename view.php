<?php

defined("bierbörse") or die("Kein direkter Zugriff");
connect();
$beers = getAllBeers();

echo "<table><tr><th colspan='2' >BD Club</th><th colspan='2'>BC Club</th><th colspan='2'>Schankwagen</th></tr>";
foreach($beers as $row){
echo "<tr><td>".$row['bdprice']."</td><td>".$row['bdname']."</td><td>".$row['bcprice']."</td><td>".$row['bcname']."</td><td>".$row['outprice']."</td><td>".$row['outname']."</td></tr>";
}
echo "</table>";

$data = getAllBeerHistory();
var_dump($data);

close();
?>