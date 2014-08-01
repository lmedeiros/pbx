<?php

//new Field($type, $title, $name, $default_value, $query, $helper, $size, $required)
$fields = array(
    new Field("text", "Descrição", "description", "", "", "Nome do Campanha", 30, true),
    new Field("date", "Data Inicio", "01", "", "", "Data de Inicio da Campanha", 18, true),
    new Field("date", "Data Termino", "02", "", "", "Data de Termino da Campanha", 18, true),
    new Field("combo", "Tipo", "type", "", "SELECT * FROM aux_cpntype", "Tipo da campanha", 2, true, "id", "name", false),
);

$form = new CreateForm(@$_GET['operation'], 95, $fields);

//debug($_POST);

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_pbx_campaign_insert");
} else {
    $form->show_form();
}

?>

