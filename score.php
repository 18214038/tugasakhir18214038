<title>Nilai</title>
<link rel="stylesheet" href="style.css">

<div class="header">
<?php
  include("config.php");
  session_start();
  
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
  $date1 = date("Y-m-d");
  $date1 = date_create($date1);
  
  $sql = "select duedate from test where id = $_SESSION[testId]";
  $result = mysqli_query($db,$sql);
  $date2 = mysqli_fetch_assoc($result);
  $date2 = date_create($date2[duedate]); 
  
  $sql = "select type from test where id = $_SESSION[testId]";
  $result = mysqli_query($db,$sql);
  $type = mysqli_fetch_assoc($result);
  
  if($date1 <= $date2)
  { if($type[type] == 0)
    { //querying the questions of the test
      //the first choice (question.1) is the true answer
      //all others are wrong
      $sql = "select question.id, question.choice1
              from test join question
              on test.id = question.test_id
              where test.id = '$_SESSION[testId]'";
            
      $result = mysqli_query($db,$sql);
    
      $question = array();
      while($row = mysqli_fetch_assoc($result))
      { $question[] = $row; }
    
      $i = 1; //index for question
      $right = 0;
      $wrong = mysqli_num_rows($result);
    
      //checking right and wrong answers
      foreach($question as $question)
      { if($_POST[$i] == $question[choice1])
        { $right++;
          $wrong--;
        }
      
        $i++;
      }
    
      $nilai = nilai($right,$wrong);
    
      //submitting the right and wrong answers to database
      $sql = "insert into testSession (student_id, test_id, score)
              values ($_SESSION[id], $_SESSION[testId], $nilai)";
            
      mysqli_query($db,$sql);
    
      //show final score
      cetak("Berhasil mengumpulkan");
      echo "Nilai Anda: ";
    
      if($nilai >= 70)
      { echo "<span style='color:green'>";  }
      else
      { echo "<span style='color:red'>";  }
    
      echo nilai($right,$wrong);
      cetak("</span>");
    }
    else if($type[type] == 1)
    { $filename = $_FILES['file']['name'];
      $destination = "uploads/".$filename;
      $file = $_FILES['file']['tmp_name'];
      
      if(move_uploaded_file($file, $destination))
      { $sql = "insert into testSession (student_id, test_id, file)
                values ($_SESSION[id], $_SESSION[testId], '$filename')";
                
        if(mysqli_query($db, $sql))
        { cetak("Berhasil mengumpulkan");  }
        else
        { cetak("Gagal"); }
      }
    }
  }
  else
  { cetak("Waktu Anda habis."); }
  
  unset($_SESSION[testId]);
?>

<a href="student.php">Kembali ke beranda</a><br>
</div>
