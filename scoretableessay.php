<link rel="stylesheet" href="style.css">

<script>
  function essayScoring(studentId,testId,i)
  { var nilai = document.getElementById("nilai"+i).value;
    
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST","essayscoring.php",true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("studentId="+studentId+"&testId="+testId+"&nilai="+nilai);
    
    if(nilai >= 70)
    { var x = "<span style='color:green'>";  }
    else
    { var x = "<span style='color:red'>";  }
    
    document.getElementById(i).innerHTML = x+nilai+"</span>";
  }
</script>

<?php
  //database and session start
  include("config.php");
  session_start();
  
  $sql = "select test from test where id = $_GET[testId]";
  $result = mysqli_query($db,$sql);
  $testname = mysqli_fetch_assoc($result);
  
  cetak("<b>Nilai untuk ".$testname[test]."</b>");
  echo "<br>";
  
  $sql = "select student.id, student.username, testSession.file, testSession.score
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
  echo "<th>Berkas</th>";
  echo "<th>Nilai</th>";
  echo "<th></th>";
  echo "<th></th>";
  echo "</tr>";
  
  $i = 0;
  
  foreach($score as $score)
  { echo "<tr>";
    echo "<td>".$score[username]."</td>";
    echo "<td><a href='uploads/".$score[file]."'>".$score[file]."</a></td>";
    
    if($score[score] == NULL)
    { echo "<td id='".$i."'><span style='color:orange'>belum</span></td>";  }
    else
    { echo "<td id='".$i."'>";
      
      if($score[score] >= 70)
      { echo "<span style='color:green'>";  }
      else
      { echo "<span style='color:red'>";  }
      
      echo $score[score]."</span></td>";
    }
    
    echo "<td>";
    //echo "<form method='POST' action='essayscoring.php' id='".$score[id]."'>";
    //echo "<input type='hidden' id='studentId' name='studentId' value='".$score[id]."'>";
    //echo "<input type='hidden' id='testId' name='testId' value='".$_GET[testId]."'>";
    echo "<input size='3' id='nilai".$i."' name='nilai'></td>";
    echo "<td><button onclick=essayScoring(".$score[id].",".$_GET[testId].",".$i.")>Beri nilai</button></td></tr>";
    
    $i++;
  }
  
  echo "</table>";
  
  $i = 0;
?>
