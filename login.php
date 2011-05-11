<?php
if(isset($_POST)&&!empty($_POST)){
    connect();
	if($_POST['club']=='admin'){
	  if(md5($_POST['kennwort'])==getAdminPassword()){
        $_SESSION[getIP()]['user'] = 'admin';
		}else{
        echo "Falsches Kennwort.";
      }
    }else{
      if(md5($_POST['kennwort'])==getPassword($_POST['club'])){
        $_SESSION[getIP()]['user'] = $_POST['club'];
	}else{
        echo "Falsches Kennwort.";
      }
    }
    close();
	logLogin(getIP(),$_POST['club'],isset($_SESSION[getIP()]['user']));
}

if(!isset($_SESSION[getIP()]['user'])){
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
}else{
	echo "<p>Du bist eingeloggt als ".$_SESSION[getIP()]['user']."</p>";
}
?>
