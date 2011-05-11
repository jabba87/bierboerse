<?php
defined("bierbörse") or die("Kein direkter Zugriff");

if(!isset($_SESSION[getIP()]['user'])){
    header("Location: index.php?action=login");
}else{
	if($_SESSION[getIP()]['user']=="admin"){
		header("Location: index.php?action=admin");
	}else{
		echo "<form id=\"sale\" action=\"index.php?action=input\" method=\"post\">".
			 "<table>";
				$club = "";
				switch($_SESSION[getIP()]['user']){
					case "bd": 	$club = "`bd-club`";
								break;
					case "bc": 	$club = "`bc-club`";
								break;
					case "out": $club = "`schankwagen`";
								break;
					default:	$club = "`bc-club`";
				}
		
				connect();
				$beers = getBeers($club);
				$i = 1;
				echo "<tr>\n";
				foreach($beers as $beer){
					echo "  <td>F".$i++."</td>\n".
						 "  <td>".$beer['name']."</td>\n".
						 "  <td class=\"cost\">".($beer['price']/100)."<input name=\"price_".$beer['id']."\" type=\"hidden\" value=\"".$beer['price']."\" >"."</td>\n".
						 "  <td>€</td>\n".
						 "  <td><input class=\"beers\" id=\"".$beer['id']."\" name=\"amount_".$beer['id']."\" type=\"text\" value=\"0\"></input></td>\n";
					echo "</tr><tr>";
				}
				echo "</tr>\n".
					 "<tr>".
						"td></td>".
						"<td>Summe</td>".
						"<td class=\"sum\">0</td>".
						"<td>€</td>".
						"<td><input id=\"sub\" type=\"submit\" value=\"Senden\"></input></td>".
					"</tr>".
			"</table>".
			"</form>";
	}
}
?>