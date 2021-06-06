<?php
  //establish MySQL connection
  $dbhost = "localhost";
  $dbuser = "root";
  $dbpass = "";
  $dbname = "tugasakhir";
  $db = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
  
  //print but with auto append <br>
  function cetak($var)
  { echo $var."<br>"; }
  
  //function to test variable outcomes
  //automatically append <br>
  function cetakvar($var)
  { echo var_dump($var)."<br>"; }
  
  //function to calculate score
  function nilai($a,$b)
  { return (($a / ($a + $b)) * 100);  }
  
  //function to calculate the amount of credits of a course
  function sksmatkul($courseId)
  { global $db;
    
    $sql = "select sks from course where id = $courseId";
    $result = mysqli_query($db,$sql);
    $sksmatkul = mysqli_fetch_assoc($result);
    
    return $sksmatkul[sks];
  }
  
  //function to calculate the amount of credits taken by a student
  function jumlahSKS($studentId)
  { global $db;
    
    $sql = "select sum(sks) as sks
            from student join enrollment join course
            on student.id = enrollment.student_id
            and course.id = enrollment.course_id
            where student.id = $studentId";
            
    $result = mysqli_query($db,$sql);
    $sks = mysqli_fetch_assoc($result);
    
    if($sks[sks] == 0)
    { return 0; }
    else
    { return $sks[sks]; }
  }
  
  function scoreCumulation($studentId,$courseId)
  { global $db;
    
    $sql = "select sum(testSession.score) as sum, course.course
            from testSession join test join course
            on testSession.test_id = test.id
            and test.course_id = course.id
            where testSession.student_id = $studentId
            and course.id = $courseId";
            
    $result = mysqli_query($db,$sql);
    $scores = mysqli_fetch_assoc($result);
    
    return $scores[sum];
  }
  
  function numberOfTests($studentId,$courseId)
  { global $db;
    
    $sql = "select test.test
            from enrollment join test
            on enrollment.course_id = test.course_id
            where enrollment.student_id = $studentId
            and enrollment.course_id = $courseId";
            
    $result = mysqli_query($db,$sql);
    
    return mysqli_num_rows($result);
  }
  
  //function to calculate current course grade
  function averageScore($studentId,$courseId)
  { return scoreCumulation($studentId,$courseId) / numberOfTests($studentId,$courseId); }
  
  function courseGrade($studentId,$courseId)
  { if(numberOfTests($studentId,$courseId) == 0)
    { return 4; }
    else if(averageScore($studentId,$courseId) >= 90)
    { return 4; }
    else if(averageScore($studentId,$courseId) >= 80)
    { return 3.5; }
    else if(averageScore($studentId,$courseId) >= 70)
    { return 3; }
    else if(averageScore($studentId,$courseId) >= 60)
    { return 2; }
    else if(averageScore($studentId,$courseId) >= 50)
    { return 1; }
    else
    { return 0; }
  }
  
  //function to calculate GPA
  function indeksPrestasi($studentId)
  { global $db;
    
    $sql = "select course.id, course.sks
            from student join enrollment join course
            on student.id = enrollment.student_id
            and course.id = enrollment.course_id
            where student.id = $studentId";
    
    $result = mysqli_query($db,$sql);
    
    $course = array();
    while($row = mysqli_fetch_assoc($result))
    { $course[] = $row; }
    
    $grade = 0;
    
    foreach($course as $course)
    { $grade += (coursegrade($studentId,$course[id]) * $course[sks]);  }
    
    return $grade / jumlahSKS($studentId);
  }
?>
