<?php
    $delete = new CreateDelete(128, $_GET['id']);
    $delete->delete("sp_pbx_route_incoming_delete");
?>
