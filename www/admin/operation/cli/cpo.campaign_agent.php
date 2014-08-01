<?php
    //new Field($type, $title, $name, $default_value, $query, $helper, $size, $required)
    $fields = array(
	new Field("combo", "Agentes", "pbx_locker_id[]", "", "SELECT CONCAT(pbx_locker_id, ' - ', description) as description, pbx_locker_id FROM pbx_locker WHERE pbx_locker_id NOT IN (SELECT pbx_locker_id FROM pbx_campaign_agent) AND pbx_locker_id NOT IN (SELECT pbx_locker_id FROM pbx_campaign_agent WHERE pbx_campaign_id = " . $_GET['id']  . ") ORDER BY pbx_locker_id", "", 20, true, "pbx_locker_id", "description", true),
        new Field("hidden", "", "pbx_campaign_id", $_GET['id'], "", "campanha", 10, true)
    );

    $form = new CreateForm(@$_GET['operation'], 95, $fields);

    //debug($_POST);

    if(isset($_POST['submit']) && $_POST['submit']!="") {
        foreach($_POST['pbx_locker_id'] as $pbx_locker_id) {
            if($pbx_locker_id!='') {
                $_POST['pbx_locker_id'] = $pbx_locker_id;
                $form->submit("sp_pbx_campaign_agent_insert");
            }
        }
    } else {
        $form->show_form();
    }

?>
