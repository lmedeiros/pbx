<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    <head><title>File Upload To Database</title></head>
    <body>
        <h3>Please Choose a File and click Submit</h3>

        <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
            <input type="text" name='title' id="title" />
            <input name="userfile[]" type="file" />
            <input type="submit" value="Submit" />
        </form>
    </body>
</html>

<?php
require("fwk.config.php");
require("fwk.database.php");
require("fwk.function.php");

// check if a file was submitted
if (!isset($_FILES['userfile'])) {
    echo '<p>Please select a file</p>';
} else {
    try {
        upload();
        // give praise and thanks to the php gods
        echo '<p>Thank you for submitting</p>';
    } catch (Exception $e) {
        echo $e->getMessage();
        echo 'Sorry, could not upload file';
    }
}

function upload() {

    $tmpname = $_FILES['userfile']['tmp_name'][0];

    if (is_uploaded_file($tmpname)) {


        $imgData = addslashes(file_get_contents($tmpname));
        // $imgData = addslashes($_FILES['userfile']);
        // get the image info..
        $imgDetails = getimagesize($tmpname);
        $size = filesize($tmpname);
        
        
        debug($size);


        $GLOBALS['db']->command("INSERT INTO fwk_image(image, title, file_type, file_size) VALUES('{$imgData}', '{$_POST['title']}','{$imgDetails['mime']}','{$size}')");

    }
}
?>