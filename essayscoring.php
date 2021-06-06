<?php
  include("config.php"); //Just database initialization
  session_start();
  
  //var_dump($_POST);
  
  $sql = "update testSession
          set score = '$_POST[nilai]'
          where student_id = '$_POST[studentId]'
          and test_id = '$_POST[testId]'";
  
  mysqli_query($db,$sql);
  cetak(mysqli_error($db));
  
  //header("location:teacher.php");
?>
