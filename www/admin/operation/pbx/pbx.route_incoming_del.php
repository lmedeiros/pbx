<?php
    $delete = new CreateDelete(86, $_GET['id']);
    $delete->delete("sp_pbx_route_incoming_delete");
?>
