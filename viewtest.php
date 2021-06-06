<title>Lihat Ujian</title>
<link rel="stylesheet" href="style.css">

<div class="header">
<?php
  //database and session start
  include("config.php");
  session_start();
  
  $_SESSION[testId] = $_GET[testId];
  
  //welcome message
  echo "<p class='logo'>Layanan Asesmen dan Evaluasi Pembelajaran</p>";
  echo "Selamat datang, Dosen ";
  echo "<span style='color:blue'>".$_SESSION[user]."</span>.<br>";
  
  //logout
  echo "<a href='logout.php'>keluar</a><br>";
?>
</div>

<div class="tab">
  <div class="left"></div>
</div>

<div class="tabcontent">
<?php  
  //query test name
  $sql = "select test, type from test where id = '$_GET[testId]'";
  $result = mysqli_query($db,$sql);
  $test = mysqli_fetch_assoc($result);
  
  //print test name
  cetak("<span style='font-weight:bold'>".$test[test]."</span>");
  echo "<a href='teacher.php'>Kembali</a><br><br>";
  
  if($test[type] == 0)
  { //querying the questions of the test
    $sql = "select question.id, question.question, question.choice1, question.choice2, question.choice3, question.choice4, question.choice5
            from test join question
            on test.id = question.test_id
            where test.id = '$_GET[testId]'";
            
    $result = mysqli_query($db,$sql);
    
    //array for questions
    $question = array();
    while($row = mysqli_fetch_assoc($result))
    { $question[] = $row; }
    
    //question number
    $i = 1;
    
    //listing questions and answers
    foreach($question as $question)
    { echo $i.". ";
      cetak($question[question]);
      cetak("☑ ".$question[choice1]);
      cetak("☐ ".$question[choice2]);
      cetak("☐ ".$question[choice3]);
      cetak("☐ ".$question[choice4]);
      cetak("☐ ".$question[choice5]);
      
      echo "<br>";
      $i++;
    }
  }
  else if($test[type] == 1)
  { $sql = "select question.id, question.question
            from test join question
            on test.id = question.test_id
            where test.id = '$_GET[testId]'";
            
    $result = mysqli_query($db,$sql);
    $question = mysqli_fetch_assoc($result);
    
    echo "<div class='tab'>";
    echo $question[question];
    echo "</div>";
    echo "<br>";
  }
?>
</div>
