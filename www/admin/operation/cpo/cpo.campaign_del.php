<?php

    $back_operation_id = 95;

    $delete = new CreateDelete($back_operation_id, $_GET['id']);
    $delete->delete("sp_pbx_campaign_delete");

?>
