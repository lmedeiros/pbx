<?php
    require("fwk.config.php");
    require("fwk.database.php");
    require("fwk.function.php");

    if(isset($_GET['id']))
    {
       $image =  $GLOBALS['db']->selectRow("SELECT image, file_type, file_size FROM fwk_image WHERE fwk_image_id = {$_GET['id']}");
        //debug($image);
       
        header("Content-type: " . $image['file_type']);
        header("Content-length: " . $image['file_size']);
         
        echo $image['image'];
    }
?> 