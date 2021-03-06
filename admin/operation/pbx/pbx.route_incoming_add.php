<?php

//new Field($type, $title, $name, $default_value, $query, $helper, $size, $required)
$fields = array(
    new Field("text", "Descrição", "name", "", "", "Descrição da rota de entrada", 30, true),
    new Field("text", "Número/Tronco", "trunk_name", "", "", "Número de entrada ou nome do tronco de entrada", 40, true),
    new Field("text", "Destino", "dest_exten", "", "SELECT * FROM pbx_account", "Número de ramal/fila/ura para direcionar a chamada entrante", 20, true),
    new Field("combo", "Campanha", "pbx_campaign_id", "", "SELECT * FROM pbx_campaign", "Campanha associada a rota de entrada", 10, true, "pbx_campaign_id", "description", true)
);

$form = new CreateForm(@$_GET['operation'], 86, $fields);

//debug($_POST);

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_pbx_route_incoming_insert");
} else {
    $form->show_form();
}

?>
