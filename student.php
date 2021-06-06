<title>Beranda Siswa</title>
<link rel="stylesheet" href="style.css">

<script>
  function take(studentId,courseId,sks,sksmatkul)
  { if(sks + sksmatkul > 24)
    { alert("Anda hanya dapat mengambil maksimal 24 SKS."); }
    else
    { var xhttp = new XMLHttpRequest();
      xhttp.open("POST","take.php",true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send("studentId="+studentId+"&courseId="+courseId);
      location.reload();
    }
  }
  
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
  
  function redden()
  { document.getElementById("ujianbutton").id = "ujianred"; }
  
  function notification(i)
  { if(i > 0)
    { document.getElementById("ujianred").innerHTML = "Kuis/Ujian ("+i+")"; }
  }
</script>

<div class="header">
<?php
  include("config.php");
  session_start();
  
  $belum = 0;
  
  //welcome message
  echo "<p class='logo'>Layanan Asesmen dan Evaluasi Pembelajaran</p>";
  echo "Selamat datang, siswa ";
  echo "<span style='color:green'>".$_SESSION[user]."</span>.<br>";
  
  //logout
  echo "<a href='logout.php'>keluar</a><br>";
?>
</div>

<div id="metronome" class="tab">
  <div class="left">
    <button class="tablinks active" id="mateributton" onclick="openTab(event, 'materi')">Materi</button>
    <button class="tablinks" id="ujianbutton" onclick="openTab(event, 'ujian')">Kuis/Ujian</button>
    Catatan: Jika Anda belum mengambil mata kuliah, maka ambillah mata kuliah terlebih dahulu.
  </div>
</div>

<div id="materi" class="row tabcontent" style="display:block">
  <div class="column tabcontent2">
  <?php
    //list of courses
    $sql = "select course.id, course.course
            from course join enrollment
            on course.id = enrollment.course_id
            where enrollment.student_id = $_SESSION[id]";
            
    $result = mysqli_query($db,$sql);
    
    //array for course
    $course = array();
    while($row = mysqli_fetch_assoc($result))
    { $course[] = $row; }

    $jumlahmatkul = mysqli_num_rows($result);

    //number display
    $i = 1;
    
    cetak("<b>Materi kuliah</b>");
    cetak("<b>".$jumlahmatkul." matkul yang diambil (Total ".jumlahSKS($_SESSION[id])." SKS)</b>");
    echo "<br>";
    
    if(empty($course))
    { echo "(Belum ada mata kuliah yang diambil)";  }
    else
    { echo "<table>";
      
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
  
  <div class="column">
  <?php
    //untaken courses
    cetak("<b>Matkul tersedia:</b>");
    echo "<br>";
    
    $sql = "select id, course, sks
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
      echo "<td>(".$course[sks]." SKS)";
      
      $sksdiambil = jumlahSKS($_SESSION[id]);
      
      echo "<td><button onclick=take($_SESSION[id],$course[id],$sksdiambil,$course[sks])>ambil</button>";
      echo "</td></tr>";
    }
    
    echo "</table>"
  ?>
  </div>
</div>

<div id="ujian" class="row tabcontent" style="display:none">
  <div class="column tabcontent2">
  <?php
    $date1 = date("Y-m-d");
    $date1 = date_create($date1);
    
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
    
    cetak("<b>Kuis dan ujian</b>");
    cetak("<b>".mysqli_num_rows($result)." mata kuliah yang diambil:</b>");
    echo "<br>";
    
    //number display
    $i = 1;
    
    echo "<table>";
    
    //listing courses
    foreach($course as $course)
    { //print course
      echo "<tr><td><b>".$i.". "."</b></td>";
      echo "<td><b>".$course[course]."</b></td>";
      echo "<td style='width:80'></td><td style='width:100'>Nilai</td>";
      echo "<td>Tenggat</td></tr>";
      $i++;
      
      //list of tests in a course
      $sql = "select test.id, test.type, test.test, test.duedate
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
      { echo "<tr><td></td><td>(Belum ada ujian)</td></tr>";
        echo "<tr></tr>";
      }
      else
      { //print whether the test is taken or not
        //retrieve the right and wrong answers
        foreach($test as $test)
        { $sql = "select test.id, test.type, test.test, testSession.score
                  from test join testSession
                  on test.id = testSession.test_id
                  where testSession.test_id = '$test[id]'
                  and testSession.student_id = '$_SESSION[id]'";
                  
          $result = mysqli_query($db,$sql);
          $count  = mysqli_num_rows($result);
          $score  = mysqli_fetch_assoc($result);
          
          echo "<tr>";
          
          if($test[type] == 0)
          { echo "<td><img src='mc.png'></td>"; }
          else if($test[type] == 1)
          { echo "<td><img src='es.png'></td>"; }
          
          //if count == 0, the test is NOT taken yet
          if($count == 0)
          { $belum++;
            
            echo "<script>";
            echo "redden()";
            echo "</script>";
            
            $date2 = date_create($test[duedate]);
            $diff = date_diff($date1,$date2);
            
            echo "<td width=200>";
            
            if($date1 <= $date2)
            { echo "<a href='test.php?testId=$test[id]'>";
              echo $test[test];
              echo "</a></td>";
            }
            else
            { echo $test[test]; }
            
            echo "<td><span style='color:red'>belum</span></td>";
            echo "<td></td><td>";
            
            if($date1 <= $date2)
            { echo $test[duedate]." (".$diff->format('%a hari lagi').")"; }
            else
            { echo $test[duedate];  }
            
            echo "</td></tr>";
          }
          else //also print the score
          { echo "<td width=200>".$test[test]."</td>";          
            echo "<td><span style='color:green'>sudah</span></td>";
            echo "<td>";
            
            if($score[score] == NULL)
            { echo "<span style='color:orange'>dinilai</span>";  }
            else
            { if($score[score] >= 70)
              { echo "<span style='color:green'>";  }
              else
              { echo "<span style='color:red'>";  }
              
              echo $score[score]."</span>";
            }
            
            echo "</td></tr>";
          }
        }
        
        echo "<script>";
        echo "notification(".$belum.")";
        echo "</script>";
      }
      
      echo "<tr><td>&nbsp;</td></tr>";
    }
    
    echo "</table>";
  ?>
  </div>
  
  <div class="column">
  <?php
    cetak("<b>Indeks Prestasi sementara: ".indeksPrestasi($_SESSION[id])."</b>");
    echo "<br>";
    
    //list of courses taken
    $sql = "select course.id, course.course, course.sks
            from course join enrollment
            on course.id = enrollment.course_id
            where enrollment.student_id = '$_SESSION[id]'
            order by course.id";
    
    $result = mysqli_query($db,$sql);
    
    //array for course
    $course = array();
    while($row = mysqli_fetch_assoc($result))
    { $course[] = $row; }
    
    $i = 1;
    
    echo "<table>";
    
    echo "<tr>";
    echo "<th></th>";
    echo "<th>Mata kuliah</th>";
    echo "<th>SKS</th>";
    echo "<th>Akumulasi</th>";
    echo "<th>Jumlah ujian</th>";
    echo "<th>Rata-rata</th>";
    echo "<th>Indeks</th>";
    echo "</tr>";
    
    foreach($course as $course)
    { echo "<tr>";
      echo "<td>".$i.". "."</td>";
      echo "<td>".$course[course]."</td>";
      echo "<td>".$course[sks]."</td>";
      echo "<td>".scoreCumulation($_SESSION[id],$course[id])."</td>";
      echo "<td>".numberOfTests($_SESSION[id],$course[id])."</td>";
      echo "<td>".averageScore($_SESSION[id],$course[id])."</td>";
      echo "<td><b>".courseGrade($_SESSION[id],$course[id])."</b></td>";
      echo "</tr>";
      
      $i++;
    }
      
    echo "</table>";
  ?>
  </div>
</div>
