<?php new CreateHome(@$_GET['operation'], array(0),109); ?>
<div style="float:left;" width="900px;">
        <table class='form'><form enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
            <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
            <tr><td>Arquivo .WAV</td><td><input name="file[]" type="file" /></td></tr>
            <tr><td></td><td class="submit"><input class='submit' type='submit' value="Gravar" /><input  class="cancel" type='button' onclick='history.go(-1)' value='Cancelar' /></td></tr>
        </form></table>
</div>
<?php

// check if a file was submitted
if (isset($_FILES['file']) && $_FILES['file']!='')  {
    try {
        upload();
    } catch (Exception $e) {
        echo $e->getMessage();
        echo 'Sorry, could not upload file';
    }
}

function upload() {

	$tmpname = $_FILES['file']['tmp_name'][0];

	$filename = asterisk_sound_patch . "/ivr-" . $_GET['id'] . ".wav";
	$gsmfile = asterisk_sound_patch . "/ivr-" . $_GET['id'] . ".gsm";

    	if (is_uploaded_file($tmpname)) {
		$allowedExts = array("wav");
		$extension = end(explode(".", $_FILES["file"]["name"][0]));
		if ((($_FILES["file"]["type"][0] == "audio/wav") || ($_FILES["file"]["type"][0] == "audio/x-wav")) && ($_FILES["file"]["size"][0] < 12048576) && in_array($extension, $allowedExts)) {

 			if ($_FILES["file"]["error"][0] > 0) {
				echo "Retorno: " . $_FILES["file"]["error"][0] . "<br />";
    			} else {
				echo "Upload: " . $_FILES["file"]["name"][0] . "<br />";
				echo "Tipo: " . $_FILES["file"]["type"][0] . "<br />";
    				echo "Tamanho: " . ($_FILES["file"]["size"][0] / 1024) . " Kb<br />";
    				echo "Arquivo temp: " . $_FILES["file"]["tmp_name"][0] . "<br />";
				move_uploaded_file($_FILES["file"]["tmp_name"][0] , $filename);
				system("/usr/bin/sox {$filename} -e gsm -c1 -r8k {$gsmfile}");
				unlink($filename);
      			}
  		} else {
			echo "Arquivo inválido";
  		}
        
    	}
}

?>
