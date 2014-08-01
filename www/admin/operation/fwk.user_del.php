<?php

    $delete = new CreateDelete(5, $_GET['id']);
    $delete->delete("sp_fwk_user_delete");

?>
