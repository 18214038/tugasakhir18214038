<title>Daftar</title>
<link rel="stylesheet" href="style.css">

<!--registration form-->
<span style='font-weight:bold'>Daftar</span>
<form method="POST">
	Pilih:	<input type="radio" id="student" name="role" value="0" checked>
					<label for="student">siswa</label>
					<input type="radio" id="teacher" name="role" value="1">
					<label for="teacher">dosen</label><br>
	<label for="username">Nama : </label>
	<input type="text" id="username" name="username"><br>
	<label for="password">Sandi: </label>
	<input type="password" id="password" name="password"><br>
	<input type="submit" value="daftar"><br>
</form>
<a href='login.php'>Halaman masuk</a><br>

<?php
	//database
	include("config.php");
	
	//only execute after clicking submit
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{	//fetch username and password
		$username = $_POST[username];
		$password = $_POST[password];
		$role			= $_POST[role];
		
		//database query
		//radio 0 for student, 1 for teacher
		if($role == 0)
		{	$sql = "insert into student (username, password)
							values ('$username','$password')";
		}
		else if($role == 1)
		{	$sql = "insert into teacher (username, password)
							values ('$username','$password')";
		}
		
		//insert into mysql
		mysqli_query($db,$sql);
		
		echo "<span style='color:green'>berhasil mendaftar</span><br>";
	}
?>
