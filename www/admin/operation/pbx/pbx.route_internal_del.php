<?php
    $delete = new CreateDelete(70, $_GET['id']);
    $delete->delete("sp_pbx_route_outgoing_delete");
?>
