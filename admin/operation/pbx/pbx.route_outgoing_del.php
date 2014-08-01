<?php
    $delete = new CreateDelete(69, $_GET['id']);
    $delete->delete("sp_pbx_route_outgoing_delete");
?>
