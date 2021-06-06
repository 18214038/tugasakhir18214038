<title>Beranda admin</title>
<link rel="stylesheet" href="style.css">

<script>
  function deleteCourse(table,id)
  { var xhttp = new XMLHttpRequest();
    xhttp.open("POST","delete.php",true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("table="+table+"&id="+id);
    location.reload();
  }
</script>

<div class="header">
<?php
  include("config.php");
  session_start();
  
  //welcome message
  echo "<p class='logo'>Layanan Asesmen dan Evaluasi Pembelajaran</p>";
  echo "Halaman ";
  echo "<span style='color:red'>admin</span><br>";
  
  //logout
  echo "<a href='logout.php'>keluar</a><br>";
?>
</div>

<div class="tab">
  <div class="left"><br></div>
</div>

<div class="row tabcontent">
  <div class="column tabcontent2">
    <b>Buat mata kuliah baru</b><br><br>
    <form method="POST" action="createcourse.php">
      <table>
        <tr><td><label for="course">Nama matkul:</label></td><td><input id="course" name="course"></td></tr>
        <tr><td><label for="sks">Jumlah SKS:</label></td><td><input id="sks" name="sks" size="1"></td></tr>
        <tr><td><label for="teacher">Pilih dosen:</label></td>
        <td><select name="teacher" id="teacher">
        <?php
          $sql = "select id, username from teacher";
          $result = mysqli_query($db, $sql);
          
          $teacher = array();
          while($row = mysqli_fetch_assoc($result))
          { $teacher[] = $row; }
          
          echo "<option selected hidden disabled>pilih dosen</option>";
          
          foreach($teacher as $teacher)
          { echo "<option value='".$teacher[id]."'>".$teacher[username]."</option>";  }
        ?>
        </select></td>
        </tr>
      </table>
      <input type="submit" value="Buat matkul">
    </form>
  </div>
  
  <div class="column">
    <b>Daftar mata kuliah</b><br><br>
    <?php
      $sql = "select course.id, course.course, course.sks, teacher.username
              from course join teacher
              on course.teacher_id = teacher.id";
              
      $result = mysqli_query($db, $sql);
          
      $course = array();
      while($row = mysqli_fetch_assoc($result))
      { $course[] = $row; }
      
      echo "<table>";
      echo "<tr>";
      echo "<th>Mata Kuliah</th>";
      echo "<th>SKS</th>";
      echo "<th>Dosen</th>";
      echo "<th>Jumlah Mahasiswa</th>";
      echo "</tr>";
      
      foreach($course as $course)
      { echo "<tr><td>".$course[course]."</td>";
        echo "<td>".$course[sks]."</td>";
        echo "<td>".$course[username]."</td>";
        
        $sql = "select student.id, student.username
                from student join enrollment join course
                on student.id = enrollment.student_id
                and course.id = enrollment.course_id
                where course.id = $course[id]";
                
        $result = mysqli_query($db,$sql);
        $jumlah = mysqli_num_rows($result);
        
        echo "<td align='right'>".$jumlah."</td>";
        
        if($jumlah == 0)
        { echo "<td><button onclick=deleteCourse(course,".$course[id].")>Hapus</button></td>";  }
        
        echo "</tr>";
      }
      
      echo "</table>";
    ?>
  </div>
</div>
