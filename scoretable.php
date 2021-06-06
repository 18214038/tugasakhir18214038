<link rel="stylesheet" href="style.css">

<?php
  //database and session start
  include("config.php");
  session_start();

  $sql = "select test from test where id = $_GET[testId]";
  $result = mysqli_query($db,$sql);
  $testname = mysqli_fetch_assoc($result);
  
  cetak("<b>Nilai untuk ".$testname[test]."</b>");
  echo "<br>";

  $sql = "select student.username, testSession.score
          from student join testSession
          on student.id = testSession.student_id
          where testSession.test_id = $_GET[testId]
          order by student.id";
          
  $result = mysqli_query($db,$sql);
  
  //array for course
  $score = array();
  while($row = mysqli_fetch_assoc($result))
  { $score[] = $row;  }
  
  echo "<table>";
  echo "<tr>";
  echo "<th>Nama</th>";
  echo "<th>Nilai</th>";
  echo "</tr>";
  
  foreach($score as $score)
  { echo "<tr>";
    echo "<td>".$score[username]."</td>";
    
    echo "<td>";

    if($score[score] >= 70)
    { echo "<span style='color:green'>";  }
    else
    { echo "<span style='color:red'>";  }
    
    echo $score[score];
    echo "</span>";
    
    echo "</td></tr>";
  }
?>
