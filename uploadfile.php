<?php
  //database and session start
  include("config.php");
  session_start();
  
  var_dump($_POST);
  var_dump($_FILES);
  
  $filename = $_FILES['file']['name'];
  $destination = "material/".$filename;
  $file = $_FILES['file']['tmp_name'];
      
  if(move_uploaded_file($file, $destination))
  { $sql = "insert into teachingFile (course_id, file)
            values ('$_POST[course]', '$filename')";
                
    if(mysqli_query($db, $sql))
    { cetak("Berhasil mengumpulkan");  }
    else
    { cetak("Gagal"); }
        
    cetak(mysqli_error($db));
  }
  
  header("location:teacher.php");
?>
