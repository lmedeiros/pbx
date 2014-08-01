<?php

$back_operation_id = 120;

function load_values() {
    if (isset($_GET['id']) && $_GET['id'] != "") {
        $query = "SELECT * FROM pbx_ivr WHERE pbx_ivr_id = {$_GET['id']}";
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
	new Field("text", "Descrição", "description", $record['description'], "", "Descrição da URA", 30, true),
	new Field("hidden", "Campanha", "pbx_campaign_id", $record['pbx_campaign_id'], "", 3, true),
	new Field("text", "Destino Padrão", "exten_t", $record['exten_t'], "", "Destino para discar no final da URA", 20, true),
	new Field("text", "Destino Digito 1", "exten_1", $record['exten_1'], "", "Destino para discar ao pressionar o digito 1", 20, true),
	new Field("text", "Destino Digito 2", "exten_2", $record['exten_2'], "", "Destino para discar ao pressionar o digito 2", 20, false),
	new Field("text", "Destino Digito 3", "exten_3", $record['exten_3'], "", "Destino para discar ao pressionar o digito 3", 20, false),
	new Field("text", "Destino Digito 4", "exten_4", $record['exten_4'], "", "Destino para discar ao pressionar o digito 4", 20, false),
	new Field("text", "Destino Digito 5", "exten_5", $record['exten_5'], "", "Destino para discar ao pressionar o digito 5", 20, false),
	new Field("text", "Destino Digito 6", "exten_6", $record['exten_6'], "", "Destino para discar ao pressionar o digito 6", 20, false),
	new Field("text", "Destino Digito 7", "exten_7", $record['exten_7'], "", "Destino para discar ao pressionar o digito 7", 20, false),
	new Field("text", "Destino Digito 8", "exten_8", $record['exten_8'], "", "Destino para discar ao pressionar o digito 8", 20, false),
	new Field("text", "Destino Digito 9", "exten_9", $record['exten_9'], "", "Destino para discar ao pressionar o digito 9", 20, false),
	new Field("text", "Destino Digito 0", "exten_0", $record['exten_0'], "", "Destino para discar ao pressionar o digito 0", 20, false),
   	new Field("hidden", "ivr_id", "pbx_ivr_id",  $record['pbx_ivr_id'], "","",2,true)
    );

    $form = new CreateForm(@$_GET['operation'], $back_operation_id, $fields);
}

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_pbx_ivr_update");
} else {
    $form->show_form();
}
?>
