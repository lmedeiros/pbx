<?php
    //new Field($type, $title, $name, $default_value, $query, $helper, $size, $required)
    $fields = array(
	new Field("combo", "Ramais", "pbx_peer_id[]", "", "SELECT CONCAT(accountcode, ' - ', callerid) as description, accountcode FROM pbx_peer_sip WHERE host='dynamic' AND accountcode NOT IN (SELECT pbx_peer_id FROM pbx_campaign_peer) ORDER BY callerid", "", 20, true, "accountcode", "description", true),
        new Field("hidden", "", "pbx_campaign_id", $_GET['id'], "", "campanha", 10, true)
    );

    $form = new CreateForm(@$_GET['operation'], 95, $fields);

    //debug($_POST);

    if(isset($_POST['submit']) && $_POST['submit']!="") {
        foreach($_POST['pbx_peer_id'] as $pbx_peer_id) {
            if($pbx_peer_id!='') {
                $_POST['pbx_peer_id'] = $pbx_peer_id;
                $form->submit("sp_pbx_campaign_peer_insert");
            }
        }
    } else {
        $form->show_form();
    }

?>
