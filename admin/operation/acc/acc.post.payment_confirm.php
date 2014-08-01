<?php

    $back_operation_id = 89;

    $delete = new CreateDelete($back_operation_id, $_GET['id']);
    $delete->delete("sp_pbx_post_payment_confirm");

?>
