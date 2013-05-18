<?php 
  require_once("includes/common.php"); 
  nav_start_outer("Home");
  nav_start_inner();
?>
<b>Balance:</b> 
<?php 
  $sql = "SELECT Zoobars FROM Person WHERE PersonID=$user->id";
  $rs = $db->executeQuery($sql);
  $balance = $rs->getValueByNr(0,0);
  echo $balance > 0 ? $balance : 0;
?> zoobars<br/>
<b>Your profile:</b>
<form method="POST" name=profileform
  action="<?php echo $_SERVER['PHP_SELF']?>">
<textarea name="profile_update">
<?php
  $hiddentoken = $_POST['hiddentoken'];
  $sql = "SELECT Token FROM Person WHERE PersonID=$user->id";
  $rs = $db->executeQuery($sql);
  $token = $rs->getValueByNr(0,0);
  if($_POST['profile_submit'] && $hiddentoken == $token) {  // Check for profile submission
    $db_connect = mysqli_connect('localhost', 'webserver', 'webserver', 'zoobar');
    if(!$db_connect) {
      die ('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    }
    $profile = mysqli_real_escape_string($link, $_POST['profile_update']);
    $sql = "UPDATE Person SET Profile='$profile' ".
           "WHERE PersonID=$user->id";
    $db->executeQuery($sql);  // Overwrite profile in database
  }
  $sql = "SELECT Profile FROM Person WHERE PersonID=$user->id";
  $rs = $db->executeQuery($sql);
  echo $rs->getValueByNr(0,0);  // Output the current profile
?>
</textarea><br/>
<input name=hiddentoken type=hidden value="<?php
  echo $token;
?>">
<input type=submit name="profile_submit" value="Save"></form>
<?php 
  nav_end_inner();
  nav_end_outer(); 
?>
