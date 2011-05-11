<?php
defined("bierbörse") or die("Kein direkter Zugriff");

if(!isset($_SESSION[getIP()]['user'])){
    header("Location: index.php?action=login");
}else{
	if($_SESSION[getIP()]['user']=="admin"){
		header("Location: index.php?action=admin");
	}else{
		if(isset($_POST) && sizeof($_POST) > 0){
			$prices = array();
			$amounts = array();
			foreach($_POST as $type => $value){
				list($type, $ID) = explode("_", $type);
				if ($type=="price")
					$prices[$ID] = $value;
				if (($type=="amount") && ($value>0))
					$amounts[$ID] = $value;
			}
      connect();
			
			foreach($amounts as $ID => $amount){
				sellBeer ($ID,$amount,$prices[$ID],$_SESSION[getIP()]['clubID']);
			}

		
			
			close();
		}
	
		$content.= "<script src=\"http://code.jquery.com/jquery-latest.js\"></script>";
		$content.= "<script src=\"input.js\"></script>";
		$content.= "<form id=\"sale\" action=\"index.php?action=input\" method=\"post\">".
			 "<table>";
				$club = "";
				switch($_SESSION[getIP()]['user']){
					case "BD": 	$club = "bd-club";
								break;
					case "BC": 	$club = "bc-club";
								break;
					case "OUT": $club = "schankwagen";
								break;
					default:	die("Undefinierter Club");
				}
		
				connect();
				$beers = getBeers($club);
				close();
				$i = 1;
				$content.= "<tr>\n";
				foreach($beers as $beer){
					$content.= "  <td>F".$i++."</td>\n".
						 "  <td>".$beer['name']."</td>\n".
						 "  <td class=\"cost\">".($beer['price']/100)."<input name=\"price_".$beer['id']."\" type=\"hidden\" value=\"".$beer['price']."\" >"."</td>\n".
						 "  <td>€</td>\n".
						 "  <td><input class=\"beers\" id=\"".$beer['id']."\" name=\"amount_".$beer['id']."\" type=\"text\" value=\"0\"></input></td>\n";
					$content.= "</tr><tr>";
				}
				$content.= "</tr>\n".
					 "<tr>".
						"<td></td>".
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