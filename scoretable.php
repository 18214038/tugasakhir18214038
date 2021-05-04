<link rel="stylesheet" href="style.css">
<a href='teacher.php'>Kembali</a><br><br>

<?php
  //database and session start
  include("config.php");
  session_start();

  var_dump($_POST[testId]);

  $sql = "select student.username, testSession.rightAnswer, testSession.wrongAnswer
          from student join testSession
          on student.id = testSession.student_id
          where testSession.test_id = $_POST[testId]
          order by testSession.rightAnswer desc";
          
  $result = mysqli_query($db,$sql);
  
  //array for course
  $score = array();
  while($row = mysqli_fetch_assoc($result))
  { $score[] = $row;  }
  
  echo "<table>";
  echo "<tr>";
  echo "<th>Nama</th>";
  echo "<th>Nilai</th>";
  echo "<th>Benar</th>";
  echo "<th>Salah</th>";
  echo "</tr>";
  foreach($score as $score)
  { echo "<tr>";
    echo "<td>".$score[username]."</td>";
    echo "<td>".nilai($score[rightAnswer],$score[wrongAnswer])."</td>";
    echo "<td>".$score[rightAnswer]."</td>";
    echo "<td>".$score[wrongAnswer]."</td>";
    echo "</tr>";
  }
?>
