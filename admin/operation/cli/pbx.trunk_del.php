<?php

    function load_values() {
        if (isset($_GET['id']) && $_GET['id'] != "") {
            $query = "SELECT * FROM pbx_peer_sip WHERE id = {$_GET['id']}";
            $record = $GLOBALS['db']->selectAll($query);
            if(isset($record[0])) {
                return $record[0];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    $record = load_values();

    if($record) {
 	system("rm -rf /etc/asterisk/sip.registrations/".$record['name'].".conf");
    }

    $back_operation_id = 41;

    $delete = new CreateDelete(41, $_GET['id']);
    $delete->delete("sp_pbx_trunk_delete");

?>
