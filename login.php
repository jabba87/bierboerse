<?php
if(isset($_POST)){
    
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
