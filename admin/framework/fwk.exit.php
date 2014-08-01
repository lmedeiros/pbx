<?php

    require("fwk.config.php");
    require("fwk.session.php");
    $session = new Session(2);
    $session->end_session();
    Header ("Location: ../" . login_page);

?>
