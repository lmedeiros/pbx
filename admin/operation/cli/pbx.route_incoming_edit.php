<?php

$back_operation_id = 86;

function load_values() {
    if (isset($_GET['id']) && $_GET['id'] != "") {
        $query = "SELECT * FROM pbx_route_incoming WHERE pbx_campaign_id = '" . $_SESSION[session_key]  . "' AND pbx_route_incoming_id = {$_GET['id']}";
        $record = $GLOBALS['db']->selectAll($query);
        if (isset($record[0])) {
            return $record[0];
        } else {
            return false;
        }
    } else {
        return false;
    }
}

$record = load_values();
if (!$record) {
    Header("Location: ?operation={$back_operation_id}");
} else {
//new Field($type, $title, $name, $default_value, $query, $helper, $size, $required)
    $fields = array(
        new Field("text", "Descrição", "description", $record['description'], "", "Descrição da Rota", 30, true),
        new Field("text", "Número Entrada", "trunk_name", $record['trunk_name'], "", "Número de entrada de recepção da rota", 40, true),
        new Field("hidden", "Campanha", "pbx_campaign_id", $record['pbx_campaign_id'], "", "Campanha da Rota de entrada", 3, true),
        new Field("text", "Destino de discagem", "dest_exten", $record['dest_exten'], "", "Destino de discagem para a rota", 40, true),
        new Field("hidden", "", "pbx_route_incoming_id", $_GET['id'], "", "", 0, true)
    );

    $form = new CreateForm(@$_GET['operation'], 128, $fields);
}
//debug($_POST);

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_pbx_route_incoming_update");
} else {
    $form->show_form();
}
?>
