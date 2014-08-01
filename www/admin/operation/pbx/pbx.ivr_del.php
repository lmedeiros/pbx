<?php

    $back_operation_id = 109;

    $delete = new CreateDelete($back_operation_id, $_GET['id']);
    $delete->delete("sp_pbx_ivr_delete");

?>
