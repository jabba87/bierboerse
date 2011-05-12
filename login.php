<?php
if(isset($_POST)&&!empty($_POST)){
    connect();
	if($_POST['club']=='admin'){
	  if(md5($_POST['kennwort'])==getAdminPassword()){
        $_SESSION[getIP()]['user'] = 'admin';
		}else{
        $content.= "Falsches Kennwort.";
      }
    }else{
      if(md5($_POST['kennwort'])==getPassword($_POST['club'])){
        $_SESSION[getIP()]['user'] = $_POST['club'];
	  }else{
        $content.= "Falsches Kennwort.";
      }
    }
    
	logLogin(getIP(),$_POST['club'],isset($_SESSION[getIP()]['user']));
	close();
}

if(!isset($_SESSION[getIP()]['user'])){
    $content.= "<form action='index.php?action=login' method='post'>";
    $content.= "<select name='club' size='1'>
      <option value='BD'>BD Club</option>
      <option value='BC'>BC Club</option>
      <option value='OUT'>Schankwagen</option>
      <option value='admin'>Adminübersicht</option>
      </select><br/>";
    $content.= "<input name='kennwort' type='password'/><br/>";
    $content.= "<input type='submit'/>";
    $content.= "</form>";
}else{
	if($_SESSION[getIP()]['user'] == 'admin'){
    header("Location: index.php?action=admin");
  }else{
    header("Location: index.php?action=input");
  }
}
?>
