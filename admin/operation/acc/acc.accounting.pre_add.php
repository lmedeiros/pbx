<?php

//new Field($type, $title, $name, $default_value, $query, $helper, $size, $required)
$fields = array(
    new Field("text", "Descrição", "description", "", "", "Nome do Ramal", 30, true),
    new Field("hidden", "Currency", "aux_currency_id", "1", "", "", 1, true),
    new Field("text", "Número 550", "peer_id", "", "", "Número do Ramal até 4 digitos", 4, true),
    new Field("password", "Senha", "secret", "", "", "Senha do Ramal", 25, true),
    new Field("text", "E-mail", "email", "", "", "E-mail do ramal", 50, true),
    new Field("hidden", "Starting Credits (USD)", "credit", "0.000", "", "Set the credit amount, it will be converted to account currency", 6, true),
    new Field("hidden", "Call Limit", "call-limit", "1", "", "Number of simultaneous calls", 3, true)
);

$form = new CreateForm(@$_GET['operation'], 29, $fields);

//debug($_POST);

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_pbx_account_insert");
} else {
    $form->show_form();
}

?>
