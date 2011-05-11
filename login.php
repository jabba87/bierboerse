<?php
if(isset($_POST['club'])){
    connect();
	$login = false;
    if($_POST['club']=='admin'){
      if($_POST['kennwort']==getAdminPassword()){
        $_SESSION[getIP()]['user'] = 'admin';
		$login = true;
		echo "Login erfolgreich";
      }else{
        echo "Falsches Kennwort.";
      }
    }else{
      if($_POST['kennwort']==getPassword($_POST['club'])){
        $_SESSION[getIP()]['user'] = $_POST['club'];
	
		switch($_POST['club']){
			case "BD": 	$clubID = 1;
						break;
			case "BC": 	$clubID = 2;
						break;
			case "OUT": $clubID = 3;
		}
		$_SESSION[getIP()]['clubID'] = $clubID;

		$login = true;
		echo "Login erfolgreich";
      }else{
        echo "Falsches Kennwort.";
      }
    }
    close();
	if ($login) exit;
}
    echo "<form action='index.php?action=login' method='post'>";
    echo "<select name='club' size='1'>
      <option value='BD'>BD Club</option>
      <option value='BC'>BC Club</option>
      <option value='OUT'>Schankwagen</option>
      <option value='admin'>Adminübersicht</option>
      </select><br/>";
    echo "<input name='kennwort' type='password'/><br/>";
    echo "<input type='submit'/>";
    echo "</form>";
?>
