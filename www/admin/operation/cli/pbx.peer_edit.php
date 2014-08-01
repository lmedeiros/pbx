<?php

    $back_operation_id = 53;

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
    if(!$record){
        Header("Location: ?operation={$back_operation_id}");
    } else {
    $fields = array(
    new Field("text", "Caller ID", "callerid", $record['callerid'], "", "Peer Caller ID", 20, true),
    new Field("password", "Peer Password", "secret", $record['secret'], "", "VoIP Account password", 30, true),
    new Field("combo", "Transport Type", "transport", $record['transport'], "SELECT * FROM aux_sip_transport", "Encrypt Signaling", 3, true, "type", "type", true),
    new Field("combo", "Use SRTP?", "encryption", $record['encryption'], "SELECT * FROM aux_bool", "Encrypt audio", 2, true, "name", "name", true),
    new Field("combo", "Use NAT?", "nat", $record['nat'], "SELECT * FROM aux_bool", "Enable SIP over NAT", 2, true, "name", "name", true),
    new Field("text", "Network Port", "port", $record['port'], "", "Set network port", 5, true),
    new Field("hidden", "", "id", $record['id'], "", "", 0, true)
    );

        $form = new CreateForm(@$_GET['operation'], $back_operation_id, $fields);
    }

    if (isset($_POST['submit']) && $_POST['submit'] != "") {
        $form->submit("sp_pbx_peer_update");
    } else {
        $form->show_form();
    }

?>
