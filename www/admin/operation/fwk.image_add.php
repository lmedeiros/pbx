<?php new CreateHome(@$_GET['operation'], array(0),19); ?>
<div style="float:left;" width="900px;">
        <table><form enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
            <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
            <tr><td>Description</td><td><input type="text" name='title' id="title" /></td></tr>
            <tr><td>Image File</td><td><input name="userfile[]" type="file" /></td></tr>
            <tr><td></td><td class="submit"><input class='submit' type='submit' value="Upload" /><input  class="cancel" type='button' onclick='history.go(-1)' value='Cancel' /></td></tr>
        </form></table>
</div>
<?php

// check if a file was submitted
if (isset($_FILES['userfile']) && isset($_POST['title']) && $_POST['title']!='' && $_FILES['userfile']!='')  {
    try {
        upload();
        // give praise and thanks to the php gods
        echo '<p>Thank you for submitting</p>';
        Header("Location: ?operation=19");
    } catch (Exception $e) {
        echo $e->getMessage();
        echo 'Sorry, could not upload file';
    }
} else {
    echo 'Sorry, could not upload file';
}

function upload() {

    $tmpname = $_FILES['userfile']['tmp_name'][0];

    if (is_uploaded_file($tmpname)) {

        $imgData = addslashes(file_get_contents($tmpname));
        // $imgData = addslashes($_FILES['userfile']);
        // get the image info..
        $imgDetails = getimagesize($tmpname);
        $size = filesize($tmpname);
        
        //debug($size);

        $GLOBALS['db']->command("INSERT INTO fwk_image(image, title, file_type, file_size) VALUES('{$imgData}', '{$_POST['title']}','{$imgDetails['mime']}','{$size}')");
        
    }
}
?>