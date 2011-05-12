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
				sellBeer ($ID,$amount,$prices[$ID],$_SESSION[getIP()]['user']);
			}
			close();
		}
	
		$content.= "<script src=\"http://code.jquery.com/jquery-latest.js\"></script>";
		$content.= "<script src=\"input.js\"></script>";
		$content.= "<div><form id=\"sale\" action=\"index.php?action=input\" method=\"post\">".
			 "<table class=\"input\">".
				"<th colspan=\"5\"><img src=\"images/icon_".$_SESSION[getIP()]['user'].".png\"</th>";
				connect();
				$beers = getBeers($_SESSION[getIP()]['user']);
				close();
				$i = 1;
				$content.= "<tr>\n";
				foreach($beers as $beer){
					$content.= "  <td>F".$i++."</td>\n".
						 "  <td><img src=\"images/itemicon_".$beer['name'].".png\"></td>\n".
						 "  <td class=\"cost\">".number_format($beer['price']/100,2)."<input name=\"price_".$beer['id']."\" type=\"hidden\" value=\"".$beer['price']."\" >"."</td>\n".
						 "  <td>€</td>\n".
						 "  <td><input class=\"beers\" id=\"".$beer['id']."\" name=\"amount_".$beer['id']."\" type=\"text\" value=\"0\"></td>\n";
					$content.= "</tr><tr>";
				}
				$content.= "</tr>\n".
					 "<tr><td>&nbsp;</td></tr>".
					 "<tr>".
						"<td><a href='index.php?action=logout'><input type=\"button\" value=\"Logout\"></a></td>".
						"<td class=\"summe\">Summe</td>".
						"<td class=\"summe\" id=\"sum\">0</td>".
						"<td class=\"summe\">€</td>".
						"<td><input id=\"sub\" type=\"submit\" value=\"Senden\"></td>".
					"</tr>".
			"</table>".
			"</form></div>";
	}
}
?>