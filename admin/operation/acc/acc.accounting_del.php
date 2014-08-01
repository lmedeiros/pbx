<?php

    $back_operation_id = 53;

    $delete = new CreateDelete($back_operation_id, $_GET['id']);
    $delete->delete("sp_pbx_account_delete");

?>
