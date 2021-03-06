<title>Ujian</title>
<link rel="stylesheet" href="style.css">

<div class="header">
<?php
  //database and session start
  include("config.php");
  session_start();
  
  $_SESSION[testId] = $_GET[testId];
  
  //welcome message
  echo "<p class='logo'>Layanan Asesmen dan Evaluasi Pembelajaran</p>";
  echo "Selamat datang, siswa ";
  echo "<span style='color:green'>".$_SESSION[user]."</span>.<br>";
  
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
  echo "<a href='student.php'>Kembali</a><br><br>";
  
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
    
    //test sheet
    echo "<form action='score.php' method='POST'>";
    
    //question number
    $i = 1;
    
    //listing questions and answers
    foreach($question as $question)
    { echo $i.". ";
      cetak($question[question]);
      
      //shuffle the choices
      $choice = array($question[choice1],$question[choice2],$question[choice3],$question[choice4],$question[choice5]);
      shuffle($choice);
      
      //listing the shuffled choices
      for($j=0;$j<=4;$j++)
      { $id = "q".$i."c".$j;
        echo "<input type='radio' id = '$id' name='$i' value='$choice[$j]'>";
        echo "<label for='$id'>".$choice[$j]."</label><br>";
      }
      
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
    
    echo "<form action='score.php' method='POST' enctype='multipart/form-data'>";
    echo "<input type='file' id='file' name='file'><br>";
  }
  
  //submit button
  echo "<input type='submit' value='kumpulkan'><br>";
  echo "</form>";
?>
</div>
