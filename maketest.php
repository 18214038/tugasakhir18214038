<title>Pembuatan Soal</title>
<link rel="stylesheet" href="style.css">

<script>
  function formSoal(i)
  { return "<div id="+i+"><label for='soal["+i+"]'>Soal "+i+": </label><textarea required rows='4' cols='80' id='soal["+i+"]' name='soal["+i+"]'></textarea><br><label for='pil1["+i+"]'>☑ Pil1: </label><input required type='text' size='50' id='pil1["+i+"]' name='pil1["+i+"]'><br><label for='pil2["+i+"]'>☐ Pil2: </label><input required type='text' size='50' id='pil2["+i+"]' name='pil2["+i+"]'><br><label for='pil3["+i+"]'>☐ Pil3: </label><input required type='text' size='50' id='pil3["+i+"]' name='pil3["+i+"]'><br><label for='pil4["+i+"]'>☐ Pil4: </label><input required type='text' size='50' id='pil4["+i+"]' name='pil4["+i+"]'><br><label for='pil5["+i+"]'>☐ Pil5: </label><input required type='text' size='50' id='pil5["+i+"]' name='pil5["+i+"]'><br><br></div>"; }

  var i = 0;

  var innerbuttons = "<button onclick=addElement()>tambah soal</button><button onclick=rmvElement()>hapus soal</button>";
  var inneressay = "<label for='task'>Berilah soal atau tema dalam esai yang akan dikumpulkan: </label><br><textarea required id='task' name='task' rows='10' cols='100'></textarea>";
  
  function addElement()
  { i++;
    var soal = document.createElement("div");
    soal.innerHTML = formSoal(i);
    document.getElementById("isi").appendChild(soal);
  }
  
  function rmvElement()
  { document.getElementById(i).remove();
    i--;
  }
  
  function toggle()
  { i = 0;
    
    var x = document.getElementById("type").value;
    
    if(x == 0)
    { if(document.getElementById("essay"))
      { document.getElementById("essay").remove();  }
  
      var buttons = document.createElement("div");
      buttons.id = "buttons";
      buttons.innerHTML = innerbuttons;
      
      document.getElementById("placeholder").appendChild(buttons);
      
      addElement();
    }
    else if(x == 1)
    { document.getElementById("isi").innerHTML = "";
      
      if(document.getElementById("buttons"))
      { document.getElementById("buttons").remove();  }
      
      var essay = document.createElement("div");
      essay.id = "essay";
      essay.innerHTML = inneressay;
      
      document.getElementById("form").appendChild(essay);
    }
  }
</script>

<div class="header">
<?php
  //database and session start
  include("config.php");
  session_start();
  
  //welcome message
  echo "<p class='logo'>Layanan Asesmen dan Evaluasi Pembelajaran</p>";
  echo "Selamat datang, Dosen ";
  echo "<span style='color:blue'>".$_SESSION[user]."</span>.<br>";
  
  //logout
  echo "<a href='logout.php'>keluar</a><br>";
?>
</div>

<div class="tab">
  <div class="left">
    Catatan: Jawaban yang benar ditandai dengan ☑.
  </div>
</div>

<div class="tabcontent">
<b>Pembuatan ujian</b><br>
<a href='teacher.php'>Kembali</a><br><br>

<?php  
  $sql = "select id, course
          from course
          where teacher_id = $_SESSION[id]";
          
  $result = mysqli_query($db,$sql);
  
  $course = array();
  while($row = mysqli_fetch_assoc($result))
  { $course[] = $row; }
?>

<table>
<form id='form' method='POST'>

<tr>
<td><label for='type'>Jenis ujian/kuis:</label></td>
<td>
<select required id='type' name='type' onchange=toggle()>
  <option value='0' selected>Pilihan ganda</option>
  <option value='1'>Esai/dokumen</option>
</select></td></tr>

<tr>
<td><label for='course'>Pilih mata kuliah:</label></td>
<td><select name='course' id='course'>

<?php  
  foreach($course as $course)
  { echo "<option value='".$course[id]."'>".$course[course]."</option>";  }
?>
  
</select></td></tr>

<tr>
<td><label for='test'>Nama ujian/kuis:</label></td>
<td><input required name='test' id='test'></td></tr>

<tr>  
<td><label for='date'>Batas pengumpulan:</label></td>
<td><input required type='date' name='date' id='date'></td></tr>

</table><br>

<div id='isi'></div>
</form>

<div id='placeholder'></div>
<button onclick=document.getElementById('form').submit()>kumpulkan</button>

<?php  
  if($_SERVER["REQUEST_METHOD"] == "POST")
  { //var_dump($_POST);
    
    $sql = "insert into test (course_id, type, test, duedate)
            values ('$_POST[course]', '$_POST[type]', '$_POST[test]', '$_POST[date]')";
            
    mysqli_query($db,$sql);
    //cetak("<br>".mysqli_error($db));
    $last_id = mysqli_insert_id($db);

    if($_POST[type] == 0)
    { $i = count($_POST[soal]);
      
      for($j=1;$j<=$i;$j++)
      { $array = array($_POST[soal][$j], $_POST[pil1][$j], $_POST[pil2][$j], $_POST[pil3][$j], $_POST[pil4][$j], $_POST[pil5][$j]);
        
        $array[0] = nl2br(htmlentities($array[0], ENT_QUOTES, 'UTF-8'));
        
        $sql = "insert into question (test_id, question, choice1, choice2, choice3, choice4, choice5)
                values ('$last_id', '$array[0]', '$array[1]', '$array[2]', '$array[3]', '$array[4]', '$array[5]')";
                
        mysqli_query($db,$sql);
        //cetak("<br>".mysqli_error($db));
      }
    }
    else if($_POST[type] == 1)
    { $textToStore = nl2br(htmlentities($_POST[task], ENT_QUOTES, 'UTF-8'));
      
      $sql = "insert into question (test_id, question)
              values ('$last_id', '$textToStore')";
      mysqli_query($db,$sql);
      //cetak("<br>".mysqli_error($db));
    }
    
    header("location:teacher.php");
  }
?>
</div>

<script>
  toggle();
</script>
