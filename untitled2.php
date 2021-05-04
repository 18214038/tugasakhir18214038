<title>Pembuatan Soal</title>
<link rel="stylesheet" href="style.css">

<script>
  //function formSoal(i)
  //{ return "<div id=".$i."><label for='soal".$i."'>Soal ".$i.": </label><input type='text' size='50' id='soal".$i."' name='soal".$i."'><br><label for='soal".$i."pil1'>Pil1: </label><input type='text' size='20' id='soal".$i."pil1' name='soal".$i."pil1'><br><label for='soal".$i."pil2'>Pil2: </label><input type='text' size='20' id='soal".$i."pil2' name='soal".$i."pil2'><br><label for='soal".$i."pil3'>Pil3: </label><input type='text' size='20' id='soal".$i."pil3' name='soal".$i."pil3'><br><label for='soal".$i."pil4'>Pil4: </label><input type='text' size='20' id='soal".$i."pil4' name='soal".$i."pil4'><br><br></div>"; }

  var i = 0;

  function addElement()
  { i++;
    document.getElementById(i).style.display = "block";
  }
  
  function rmvElement()
  { document.getElementById(i).style.display = "none";
    i--;
  }
</script>

<form id="form" method="POST">
<?php
  for($i=1;$i<=5;$i++)
  { echo "<div id='".$i."' style='display:none'>
          <label for='soal".$i."'>Soal ".$i.": </label>
          <input type='text' size='50' id='soal".$i."' name='soal".$i."'><br>
          <label for='soal".$i."pil1'>Pil1: </label>
          <input type='text' size='20' id='soal".$i."pil1' name='soal".$i."pil1'><br>
          <label for='soal".$i."pil2'>Pil2: </label>
          <input type='text' size='20' id='soal".$i."pil2' name='soal".$i."pil2'><br>
          <label for='soal".$i."pil3'>Pil3: </label>
          <input type='text' size='20' id='soal".$i."pil3' name='soal".$i."pil3'><br>
          <label for='soal".$i."pil4'>Pil4: </label>
          <input type='text' size='20' id='soal".$i."pil4' name='soal".$i."pil4'><br><br></div>";
  }
?>
</form>

<button onclick=addElement()>tambah soal</button>
<button onclick=rmvElement()>hapus soal</button>
<button onclick=document.getElementById("form").submit()>kumpulkan</button>

<?php
  if($_SERVER["REQUEST_METHOD"] == "POST")
  { var_dump($_POST); }
?>
