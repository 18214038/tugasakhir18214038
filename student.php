<title>Beranda Siswa</title>
<link rel="stylesheet" href="style.css">

<script>
  function take(studentId,courseId)
  { var xhttp = new XMLHttpRequest();
    xhttp.open("POST","take.php",true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("studentId="+studentId+"&courseId="+courseId);
    location.reload();
  }
</script>

<?php
  include("config.php");
  session_start();

  //welcome message
  echo "Selamat datang, siswa ";
  echo "<span style='color:green'>".$_SESSION[user]."</span>.<br>";
  
  //logout
  echo "<a href='logout.php'>keluar</a><br><br>";
  
  //list of courses taken
  $sql = "select course.id, course.course
          from course join enrollment
          on course.id = enrollment.course_id
          where enrollment.student_id = '$_SESSION[id]'
          order by course.id";
  
  $result = mysqli_query($db,$sql);
  
  //array for course
  $course = array();
  while($row = mysqli_fetch_assoc($result))
  { $course[] = $row; }
  
  cetak("----------------------");
  cetak("<b>".mysqli_num_rows($result)." matkul yang diambil:</b>");
  echo "<br>";
  
  //number display
  $i = 1;
  
  echo "<table>";
  
  //listing courses
  foreach($course as $course)
  { //print course
    echo "<tr><td>".$i.". ".$course[course]."</td><td></td><td>Nilai</td></tr>";
    $i++;
    
    //list of tests in a course
    $sql = "select test.id, test.test
            from course join enrollment join test
            on course.id = enrollment.course_id
            and test.course_id = enrollment.course_id
            where enrollment.student_id = '$_SESSION[id]'
            and course.id = '$course[id]'
            order by test.id";
            
    $result = mysqli_query($db,$sql);
    
    //array for test
    $test = array();
    while($row = mysqli_fetch_assoc($result))
    { $test[] = $row; }
    
    //listing tests available
    if(empty($test))
    { echo "<tr><td><span style='color:red'>belum ada ujian</span></td></tr>";
      echo "<tr></tr>";
    }
    else
    { //print whether the test is taken or not
      //retrieve the right and wrong answers
      foreach($test as $test)
      { $sql = "select test.id, test.test, testSession.rightAnswer, testSession.wrongAnswer
                from test join testSession
                on test.id = testSession.test_id
                where testSession.test_id = '$test[id]'
                and testSession.student_id = '$_SESSION[id]'";
                
        $result = mysqli_query($db,$sql);
        $count  = mysqli_num_rows($result);
        $score  = mysqli_fetch_assoc($result);
        
        //if count == 0, the test is NOT taken yet
        if($count == 0)
        { echo "<tr><td><a href='test.php?testId=$test[id]'>";
          echo $test[test];
          echo "</a></td>";
          echo "<td><span style='color:red'>belum</span></td></tr>";
        }
        else //also print the score
        { echo "<tr><td>".$test[test]."</td>";
          echo "<td><span style='color:green'>sudah</span></td>";
          echo "<td style='text-align:right'>".nilai($score[rightAnswer],$score[wrongAnswer])."</td></tr>";
        }
      }
    }
    echo "<tr><td>&nbsp;</td></tr>";
  }
  
  echo "</table>";
  
  //untaken courses
  cetak("----------------------");
  cetak("<b>Matkul tersedia:</b>");
  echo "<br>";
  
  $sql = "select id, course
          from course
          where id not in
          ( select course_id
            from enrollment
            where student_id = '$_SESSION[id]'
          )
          order by id";
          
  $result = mysqli_query($db,$sql);
  
  //array for course
  $course = array();
  while($row = mysqli_fetch_assoc($result))
  { $course[] = $row; }
  
  echo "<table>";
  
  //listing untaken courses
  foreach($course as $course)
  { echo "<tr><td>".$course[course]."</td>";
    echo "<td><button onclick=take($_SESSION[id],$course[id])>ambil";
    echo "</button></td></tr>";
  }
  
  echo "</table>"
?>
