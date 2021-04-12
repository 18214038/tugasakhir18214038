<link rel="stylesheet" href="style.css">

<script>
var formSoal = "<form method='POST'><label for='soal'>Soal: </label><input type='text' size='50' id='soal' name='soal'><br><label for='pil1'>Pil1: </label><input type='text' size='20' id='pil1' name='pil1'><br><label for='pil2'>Pil2: </label><input type='text' size='20' id='pil2' name='pil2'><br><label for='pil3'>Pil3: </label><input type='text' size='20' id='pil3' name='pil3'><br><label for='pil4'>Pil4: </label><input type='text' size='20' id='pil4' name='pil4'><br></form>";

function addElement()
{ document.getElementById("form").innerHTML += formSoal;  }

function rmvElement()
{ document.getElementById("form").innerHTML -= formSoal;  }
</script>

<p id="form"></p>

<button onclick=addElement()>tambah soal</button>
<button onclick=rmvElement()>hapus soal</button>
