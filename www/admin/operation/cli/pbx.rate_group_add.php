<?php

//new Field($type, $title, $name, $default_value, $query, $helper, $size, $required)
$fields = array(
    new Field("text", "Descrição", "description", "", "", "Call Rate group name", 30, true),
    new Field("text", "Multiplicador", "multiplier", "", "", "Amount to multiply the rate cost to get call cost", 6, true)
);

$form = new CreateForm(@$_GET['operation'], 37, $fields);

//debug($_POST);

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_pbx_rate_group_insert");
} else {
    $form->show_form();
}

?>
