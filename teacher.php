<title>Beranda Dosen</title>
<link rel="stylesheet" href="style.css">

<?php
  //database and session start
  include("config.php");
  session_start();
  
  //welcome message
  echo "Selamat datang, Dosen ";
  echo "<span style='color:blue'>".$_SESSION[user]."</span>.<br>";

  //logout
  echo "<a href='logout.php'>keluar</a><br><br>";
  
  //list of courses
  $sql = "select course.id, course.course
          from course
          where course.teacher_id = $_SESSION[id]
          order by course.id";
          
  $result = mysqli_query($db,$sql);
  
  //array for course
  $course = array();
  while($row = mysqli_fetch_assoc($result))
  { $course[] = $row; }

  echo "<b>".mysqli_num_rows($result)."</b>";
  cetak(" matkul yang diampu:");
  echo "<br>";

  //number display
  $i = 1;
  
  //listing courses
  foreach($course as $course)
  { //print number display
    echo $i.". ";
    $i++;
    
    //print course
    cetak($course[course]);
    
    //list of tests in a course
    $sql = "select test.id, test.test
            from course join test
            on course.id = test.course_id
            where course.id = '$course[id]'
            order by test.id";
            
    $result = mysqli_query($db,$sql);
    
    //array for test
    $test = array();
    while($row = mysqli_fetch_assoc($result))
    { $test[] = $row; }
    
    //listing tests available
    if(empty($test))
    { cetak("<span style='color:red'>belum ada ujian</span>");
      echo "<br>";
    }
    else
    { foreach($test as $test)
      { echo "<span class='cell0'>";
        echo "<form action='score.php' method='POST'>";
        echo "<button type='submit' name='testId' value='$test[id]' class='btn-link'>";
        echo $test[test];
        echo "</button></form></span><br>";
      }
    }
  }
?>
