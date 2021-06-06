<title>Beranda Dosen</title>
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
  
  function viewScore(testId)
  { var xhttp = new XMLHttpRequest();
    xhttp.open("POST","scoretable.php",true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("testId="+testId);
    location.href = "scoretable.php?testId="+testId;
  }
  
  function viewScoreEssay(testId)
  { location.href = "scoretableessay.php?testId="+testId; }
  
  function openTab(evt, section)
  { var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    
    for (i = 0; i < tabcontent.length; i++)
    { tabcontent[i].style.display = "none"; }
    
    tablinks = document.getElementsByClassName("tablinks");
  
    for (i = 0; i < tablinks.length; i++)
    { tablinks[i].className = tablinks[i].className.replace(" active", ""); }
    
    document.getElementById(section).style.display = "block";
    evt.currentTarget.className += " active";
  }
  
  function scoreTable(type, testId)
  { var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function()
    { document.getElementById("scoretable").innerHTML = this.responseText;  }
    
    if(type == 0)
    { xhttp.open("GET", "scoretable.php?testId="+testId, true); }
    else if(type == 1)
    { xhttp.open("GET", "scoretableessay.php?testId="+testId, true); }
    else
    { alert();  }
    
    xhttp.send();
  }
</script>

<div class="header">
<?php
  //database and session start
  include("config.php");
  session_start();
  
  //welcome message
  echo "<p class='logo'>Layanan Asesmen dan Evaluasi Pembelajaran</p>";
  echo "Selamat datang, Dosen ";
  echo "<span style='color:blue'>".$_SESSION[user]."</span>.<br>";
  
  //logout
  echo "<a href='logout.php'>keluar</a><br>";
?>
</div>

<div class="tab">
  <div class="left">
    <button class="tablinks active" onclick="openTab(event, 'materi')">Materi</button>
    <button class="tablinks" onclick="openTab(event, 'ujian')">Kuis/ujian</button>
    Catatan: Jika Anda belum memiliki mata kuliah, hubungi admin.
  </div>
</div>

<div id="materi" class="tabcontent" style="display:block">
<?php
  //list of courses
  $sql = "select course.id, course.course
          from course
          where course.teacher_id = $_SESSION[id]";
          
  $result = mysqli_query($db,$sql);
  
  //array for course
  $course = array();
  while($row = mysqli_fetch_assoc($result))
  { $course[] = $row; }

  //number display
  $i = 1;
  
  if(empty($course))
  { echo "(Belum ada mata kuliah)";  }
  else
  { echo "<b>Unggah materi baru</b><br><br>";
    
    echo "<form action='uploadfile.php' method='POST' enctype='multipart/form-data'>";
    echo "<label for='course'>Pilih mata kuliah: </label>";
    echo "<select name='course' id='course' name='course'>";
    
    foreach($course as $y)
    { echo "<option value='".$y[id]."'>".$y[course]."</option>";  }
    
    echo "<select><br>";
    
    echo "<label for='file'>Unggah materi: </label>";
    echo "<input type='file' id='file' name='file'><br>";
    echo "<input type='submit' value='unggah'>";
    echo "</form>";
    
    echo "<table>";
    
    //listing courses
    foreach($course as $course)
    { //print course
      echo "<tr><td><b>".$i.". "."</b></td>";
      echo "<td><b>".$course[course]."</b></td></tr>";
      
      $sql = "select id, file from teachingFile where course_id = $course[id]";
      $result = mysqli_query($db,$sql);
    
      //array for course
      $file = array();
      while($row = mysqli_fetch_assoc($result))
      { $file[] = $row; }
      
      if(empty($file))
      { echo "<tr><td></td><td>(Belum ada materi)</td></tr>"; }
      else
      { foreach($file as $file)
        { echo "<tr><td><img src='se.png'></td>";
          echo "<td><a href='material/".$file[file]."'>".$file[file]."</a></td></tr>";
        }
      }
      
      echo "<tr><td>&nbsp;</td></tr>";
      $i++;
    }
    
    echo "</table>";
  }
?>
</div>

<div id="ujian" class="row tabcontent" style="display:none">
  <div class="column tabcontent2">
  <?php
    if(empty($course))
    {}
    else
    { //make new test
      echo "<table><tr><td>";
      echo "<img src='docplus.png'></td>";
      echo "<td><a href='maketest.php'>Buat ujian baru</a></td></tr></table><br>";
    }
    
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

    //number display
    $i = 1;
    
    echo "<table>";
    
    //listing courses
    foreach($course as $course)
    { //print course
      echo "<tr><td><b>".$i.". "."</b></td>";
      echo "<td><b>".$course[course]."</b></td></tr>";
      $i++;
      
      //list of tests in a course
      $sql = "select test.id, test.type, test.test
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
      { echo "<tr><td></td><td>(Belum ada ujian)</td></tr>";
        echo "<tr></tr>";
      }
      else
      { foreach($test as $test)
        { echo "<tr>";
          
          if($test[type] == 0)
          { echo "<td><img src='mc.png'></td>"; }
          else if($test[type] == 1)
          { echo "<td><img src='es.png'></td>"; }
          
          echo "<td><a href='viewtest.php?testId=".$test[id]."'>".$test[test]."</a></td>";
          
          echo "<td>";
          echo "<button onclick=scoreTable(".$test[type].",".$test[id].")>Lihat/beri nilai</button>";
          echo "</td></tr>";
        }
      }
      echo "<tr><td>&nbsp;</td></tr>";
    }
    
    echo "</table>";
  ?>
  </div>
  
  <div id="scoretable" class="column"></div>
</div>
