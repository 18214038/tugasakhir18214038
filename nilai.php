<title>Nilai</title>
<link rel="stylesheet" href="style.css">

<?php
	//database and session start
	include("config.php");
	session_start();
	
	//querying the questions of the test
	//the first choice (question.1) is the true answer
	//all others are wrong
	$sql = "select question.id, question.1
          from test join question
					on test.id = question.test_id
					where test.id = '$_SESSION[testId]'";
					
	$result = mysqli_query($db,$sql);
	
	$question = array();
	while($row = mysqli_fetch_assoc($result))
	{	$question[] = $row;	}
	
	$i = 1; //index for question
	$right = 0;
	$wrong = mysqli_num_rows($result);
	
	//checking right and wrong answers
	foreach($question as $question)
	{	if($_POST[$i] == $question[1])
		{	$right++;
			$wrong--;
		}
		
		$i++;
	}
	
	//submitting the right and wrong answers to database
	$sql = "insert into testSession
					values ($_SESSION[id],$_SESSION[testId],$right,$wrong)";
					
	mysqli_query($db,$sql);
	
	//show final score
	cetak("Berhasil mengumpulkan");
	echo "Nilai Anda: ";
	
	if(nilai($right,$wrong) >= 70)
	{	echo "<span style='color:green'>";	}
	else
	{	echo "<span style='color:red'>";	}
	
	echo nilai($right,$wrong);
	cetak("</span>");
	
	unset($_SESSION[testId]);
?>

<a href="student.php">Kembali ke beranda</a><br>
