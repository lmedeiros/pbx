<?php
    require("fwk.config.php");
    require("fwk.database.php");
    require("fwk.function.php");

    if(isset($_GET['id']))
    {
        $image =  $GLOBALS['db']->selectRow("SELECT DISTINCT B.image, B.file_type, B.title, B.file_size FROM fwk_operation A, fwk_image B WHERE A.is_visible=1 AND A.fwk_image_id = B.fwk_image_id AND A.fwk_operation_id=" . $_GET['id']);

        header("Content-type: " . $image['file_type']);
        header("Content-length: " . $image['file_size']);
            
        echo $image['image'];
    }
?> 