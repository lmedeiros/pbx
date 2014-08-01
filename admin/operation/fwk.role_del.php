<?php

    $back_operation_id = 6;

    $delete = new CreateDelete($back_operation_id, $_GET['id']);
    $delete->delete("sp_fwk_role_delete");

?>
