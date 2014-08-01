<?php

//new Field($type, $title, $name, $default_value, $query, $helper, $size, $required)
$fields = array(
    new Field("text", "Descrição", "description", "", "", "Descrição da URA", 30, true),
    new Field("combo", "Campanha", "pbx_campaign_id", "", "SELECT * FROM pbx_campaign", "Campanha da URA", 3, true, "pbx_campaign_id", "description", false),
    new Field("text", "Destino Padrão", "exten_t", "", "", "Destino para discar no final da URA", 20, true),
    new Field("text", "Destino Digito 1", "exten_1", "", "", "Destino para discar ao pressionar o digito 1", 20, true),
    new Field("text", "Destino Digito 2", "exten_2", "", "", "Destino para discar ao pressionar o digito 2", 20, false),
    new Field("text", "Destino Digito 3", "exten_3", "", "", "Destino para discar ao pressionar o digito 3", 20, false),
    new Field("text", "Destino Digito 4", "exten_4", "", "", "Destino para discar ao pressionar o digito 4", 20, false),
    new Field("text", "Destino Digito 5", "exten_5", "", "", "Destino para discar ao pressionar o digito 5", 20, false),
    new Field("text", "Destino Digito 6", "exten_6", "", "", "Destino para discar ao pressionar o digito 6", 20, false),
    new Field("text", "Destino Digito 7", "exten_7", "", "", "Destino para discar ao pressionar o digito 7", 20, false),
    new Field("text", "Destino Digito 8", "exten_8", "", "", "Destino para discar ao pressionar o digito 8", 20, false),
    new Field("text", "Destino Digito 9", "exten_9", "", "", "Destino para discar ao pressionar o digito 9", 20, false),
    new Field("text", "Destino Digito 0", "exten_0", "", "", "Destino para discar ao pressionar o digito 0", 20, false)
);

$form = new CreateForm(@$_GET['operation'], 109, $fields);

//debug($_POST);

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_pbx_ivr_insert");
} else {
    $form->show_form();
}

?>
