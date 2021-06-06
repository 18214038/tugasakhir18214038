<?php
  include("config.php");
  session_start();
  
  $sql = "delete from course where id = $_POST[id]";
  mysqli_query($db,$sql);
  
  unset($_POST);
  
  cetak(mysqli_error($db));
?>
