<?php

    $back_operation_id = 89;

    $delete = new CreateDelete($back_operation_id, $_SESSION[session_key]);
    $delete->delete("sp_pbx_post_payment");

?>

