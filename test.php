<title>Kuis</title>
<link rel="stylesheet" href="style.css">

<?php
	//database and session start
	include("config.php");
	session_start();
	
	$_SESSION[testId] = $_GET[testId];
	
	//query test name
	$sql = "select test from test where id = '$_GET[testId]'";
	$result = mysqli_query($db,$sql);
	$testName = mysqli_fetch_assoc($result);
	
	//print test name
	cetak("<span style='font-weight:bold'>".$testName[test]."</span><br>");
	
	//querying the questions of the test
	$sql = "select question.id, question.question, question.1, question.2, question.3, question.4
					from test join question
					on test.id = question.test_id
					where test.id = '$_GET[testId]'";
					
	$result = mysqli_query($db,$sql);
	
	//array for questions
	$question = array();
	while($row = mysqli_fetch_assoc($result))
	{	$question[] = $row;	}
	
	//test sheet
	echo "<form action='nilai.php' method='POST'>";
	
	//question number
	$i = 1;
	
	//listing questions and answers
	foreach($question as $question)
	{	echo $i.". ";
		cetak($question[question]);
		
		//shuffle the choices
		$choice = array($question[1],$question[2],$question[3],$question[4]);
		shuffle($choice);
		
		//listing the shuffled choices
		for($j = 0; $j <= 3; $j++)
		{	$id = "q".$i."c".$j;
			echo "<input type='radio' id = '$id' name='$i' value='$choice[$j]'>";
			echo "<label for='$id'>".$choice[$j]."</label><br>";
		}
		
		echo "<br>";
		$i++;
	}
	
	//submit button
	echo "<input type='submit' value='kumpulkan'><br>";
	echo "</form>";
?>
