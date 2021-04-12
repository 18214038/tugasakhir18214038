<?php
	//print but with auto append <br>
	function cetak($var)
	{	echo $var."<br>";	}
	
	//function to test variable outcomes
	//automatically append <br>
	function cetakvar($var)
	{	echo var_dump($var)."<br>";	}
	
	//function to calculate score
	function nilai($a, $b)
	{	return (($a / ($a + $b)) * 100);	}
	
	//establish MySQL connection
	define("dbhost", "localhost");
	define("dbuser", "root");
	define("dbpass", "");
	define("dbname", "tugasakhir");
	$db = mysqli_connect(dbhost,dbuser,dbpass,dbname);
?>
