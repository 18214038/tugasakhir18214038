<title>Masuk</title>
<link rel="stylesheet" href="style.css">

<div class="header">
  <p class="logo">Layanan Asesmen dan Evaluasi Pembelajaran</p>
  <b>Halaman masuk</b>
</div>

<div class="tab">
  <div class="left">
    Catatan: Jika Anda belum memiliki akun, silahkan gunakan halaman daftar.
  </div>
</div>

<!--login form-->
<div class="tabcontent">
<form method="POST">
  <table>
    <tr><td>Pilih:</td>
    <td>
      <input type="radio" id="student" name="role" value="0" checked>
      <label for="student">siswa</label>
      <input type="radio" id="teacher" name="role" value="1">
      <label for="teacher">dosen</label>
      <input type="radio" id="admin" name="role" value="2">
      <label for="admin">admin</label>
    </td></tr>
  
    <tr><td><label for="username">Nama:</label></td>
    <td><input type="text" id="username" name="username"></td></tr>
    <tr><td><label for="password">Sandi:</label></td>
    <td><input type="password" id="password" name="password"></td></tr>
    <tr><td><input type="submit" value="masuk"></td></tr>
  </table>
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
    else if($_POST[role] == 2)
    { $sql = "select id, role, username
              from admin
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
      else if($_SESSION[role] == 2)
      { header("location:admin.php"); }
    }
    else
    { echo "<span style='color:red'>salah</span><br>";  }
  }
?>
</div>
