<title>Masuk</title>
<link rel="stylesheet" href="style.css">

<!--login form-->
<span style="font-weight:bold">Masuk</span>
<form method="POST">
  Pilih:  <input type="radio" id="student" name="role" value="0" checked>
          <label for="student">siswa</label>
          <input type="radio" id="teacher" name="role" value="1">
          <label for="teacher">dosen</label><br>
  <label for="username">Nama : </label>
  <input type="text" id="username" name="username"><br>
  <label for="password">Sandi: </label>
  <input type="password" id="password" name="password"><br>
  <input type="submit" value="masuk"><br>
</form>
<a href="register.php">Halaman daftar</a><br>

<?php
  //database
  include("config.php");
  
  //only execute after clicking submit
  if($_SERVER["REQUEST_METHOD"] == "POST")
  { //database query
    //radio 0 for student, 1 for teacher
    if($_POST[role] == 0)
    { $sql = "select id, role, username
              from student
              where username = '$_POST[username]'
              and password = '$_POST[password]'";
    }
    else if($_POST[role] == 1)
    { $sql = "select id, role, username
              from teacher
              where username = '$_POST[username]'
              and password = '$_POST[password]'";
    }
    
    //fetching database into array
    $result = mysqli_query($db,$sql);
    $count  = mysqli_num_rows($result);
    $result = mysqli_fetch_assoc($result);
    
    //if result match, table row must be 1
    if($count == 1)
    { echo "<span style='color:green'>berhasil</span><br>";
      
      //start new session
      session_start();
      $_SESSION[id]   = $result[id];
      $_SESSION[role] = $result[role];
      $_SESSION[user] = $result[username];
      
      //redirect
      if($_SESSION[role] == 0)
      { header("location:student.php"); }
      else if($_SESSION[role] == 1)
      { header("location:teacher.php"); }
    }
    else
    { echo "<span style='color:red'>salah</span><br>";  }
  }
?>
