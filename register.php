<title>Daftar</title>
<link rel="stylesheet" href="style.css">

<div class="header">
  <p class="logo">Layanan Asesmen dan Evaluasi Pembelajaran</p>
  <b>Halaman daftar</b>
</div>

<div class="tab">
  <br>
</div>

<!--registration form-->
<div class="tabcontent">
<form method="POST">
  <table>
    <tr><td>Pilih:</td>
    <td>
      <input type="radio" id="student" name="role" value="0" checked>
      <label for="student">siswa</label>
      <input type="radio" id="teacher" name="role" value="1">
      <label for="teacher">dosen</label><br>
    </td></tr>
  
    <tr><td><label for="username">Nama:</label></td>
    <td><input type="text" id="username" name="username"></td></tr>
    <tr><td><label for="password">Sandi:</label></td>
    <td><input type="password" id="password" name="password"></td></tr>
    <tr><td><input type="submit" value="daftar"></td></tr>
  </table>
</form>

<a href="login.php">Halaman masuk</a><br>

<?php
  //database
  include("config.php");
  
  //only execute after clicking submit
  if($_SERVER["REQUEST_METHOD"] == "POST")
  { //fetch username and password
    $username = $_POST[username];
    $password = $_POST[password];
    $role     = $_POST[role];
    
    //database query
    //radio 0 for student, 1 for teacher
    if($role == 0)
    { $sql = "insert into student (username, password)
              values ('$username','$password')";
    }
    else if($role == 1)
    { $sql = "insert into teacher (username, password)
              values ('$username','$password')";
    }
    
    //insert into mysql
    mysqli_query($db,$sql);
    
    echo "<span style='color:green'>berhasil mendaftar</span><br>";
  }
?>
</div>
