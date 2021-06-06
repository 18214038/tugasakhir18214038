<?php
  include("config.php");
  session_start();
  
  $sql = "insert into course (teacher_id, sks, course)
          values ('$_POST[teacher]', '$_POST[sks]', '$_POST[course]')";
  
  mysqli_query($db,$sql);
  unset($_POST);
  
  header("location:admin.php");
?>
