<title>Pembuatan Soal</title>
<link rel="stylesheet" href="style.css">

<script>
  function formSoal(i)
  { return "<div id="+i+"><label for='soal["+i+"]'>Soal "+i+": </label><input type='text' size='50' id='soal["+i+"]' name='soal["+i+"]'><br><label for='pil1["+i+"]'>Pil1: </label><input type='text' size='20' id='pil1["+i+"]' name='pil1["+i+"]'><br><label for='pil2["+i+"]'>Pil2: </label><input type='text' size='20' id='pil2["+i+"]' name='pil2["+i+"]'><br><label for='pil3["+i+"]'>Pil3: </label><input type='text' size='20' id='pil3["+i+"]' name='pil3["+i+"]'><br><label for='pil4["+i+"]'>Pil4: </label><input type='text' size='20' id='pil4["+i+"]' name='pil4["+i+"]'><br><br></div>"; }

  var i = 0;

  function addElement()
  { i++;
    var soal = document.createElement("div");
    soal.innerHTML = formSoal(i);
    document.getElementById("form").appendChild(soal);
  }
  
  function rmvElement()
  { document.getElementById(i).remove();
    i--;
  }
</script>

<?php
  include("config.php");
  session_start();
  
  $sql = "select id, course
          from course
          where teacher_id = $_SESSION[id]";
          
  $result = mysqli_query($db,$sql);
  
  $course = array();
  while($row = mysqli_fetch_assoc($result))
  { $course[] = $row; }
  
  echo "<form id='form' method='POST'>";
  echo "<label for='course'>Pilih mata kuliah: </label>";
  echo "<select name='course' id='course'>";
  foreach($course as $course)
  { echo "<option value='".$course[id]."'>".$course[course]."</option>";  }
  echo "</select><br>";
  
  echo "<label for='test'>Nama ujian/kuis: </label>";
  echo "<input name='test' id='test'><br>";
  
  echo "<label for='date'>Batas waktu pengumpulan: </label>";
  echo "<input type='date' name='date' id='date'><br><br></form>";

  echo "<button onclick=addElement()>tambah soal</button>";
  echo "<button onclick=rmvElement()>hapus soal</button>";
  echo "<button onclick=document.getElementById('form').submit()>kumpulkan</button>";
  
  if($_SERVER["REQUEST_METHOD"] == "POST")
  { $i = count($_POST[soal]);
    
    $sql = "insert into test (course_id, test, duedate)
            values ($_POST[course], $_POST[test], $_POST[date])";
            
    mysqli_query($db,$sql);
    
    for($j=1;$j<=$i;$j++)
    { $sql = "insert into question (question, 1, 2, 3, 4)
              values ($_POST[soal][$j], $_POST[pil1][$j], $_POST[pil2][$j], $_POST[pil3][$j], $_POST[pil4][$j])";
              
      mysqli_query($db,$sql);
    }
    
    var_dump($_POST);
  }
?>
