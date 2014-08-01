<?php

    $back_operation_id = 95;

    function load_values() {
        if (isset($_GET['id']) && $_GET['id'] != "") {
            $query = "SELECT * FROM pbx_campaign WHERE pbx_campaign_id = {$_GET['id']}";
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
    if(!$record) {
        Header("Location: ?operation={$back_operation_id}");
    } else {
    $fields = array(
    	new Field("text", "Descrição", "description", $record['description'], "", "Nome do Campanha", 30, true),
    	new Field("date", "Data Inicio", "01", $record['start_date'], "", "Data de Inicio da Campanha", 18, true),
	new Field("date", "Data Termino", "02", $record['end_date'], "", "Data de Termino da Campanha", 18, true),
	new Field("combo", "Tipo", "type", $record['type'], "SELECT * FROM aux_cpntype", "Tipo da campanha", 3, true, "id", "name", false),
	new Field("hidden", "", "campaign_id", $record['pbx_campaign_id'], "", "", 0, true)
    );

        $form = new CreateForm(@$_GET['operation'], $back_operation_id, $fields);
    }

    if (isset($_POST['submit']) && $_POST['submit'] != "") {
        $form->submit("sp_pbx_campaign_update");
    } else {
        $form->show_form();
    }

?>
