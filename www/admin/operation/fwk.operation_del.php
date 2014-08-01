<?php

    $back_operation_id = 7;

    $delete = new CreateDelete(7, $_GET['id']);
    $delete->delete("sp_fwk_operation_delete");

?>
