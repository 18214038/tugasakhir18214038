<?php
  include("config.php"); //Just database initialization
  session_start();
  
  $sql = "insert into enrollment
          values ($_POST[studentId],$_POST[courseId])";
          
  mysqli_query($db,$sql);
?>
