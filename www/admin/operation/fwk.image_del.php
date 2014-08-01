<?php

    $back_operation_id = 19;

    $delete = new CreateDelete($back_operation_id, $_GET['id']);
    $delete->delete("sp_fwk_image_delete");

?>
