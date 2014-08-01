<?php

    $delete = new CreateDelete(75, $_GET['id']);
    $delete->delete("sp_pbx_peer_free");

?>
