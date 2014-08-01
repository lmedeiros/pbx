<?php

//new Field($type, $title, $name, $default_value, $query, $helper, $size, $required)
$fields = array(
    new Field("text", "Descrição", "description", "", "", "Descrição da Rota", 30, true),
    new Field("text", "Padrão Regexp", "pattern", "", "", "Padrão da Rota em expressão regular", 40, true),
    new Field("combo", "Linha VoIP", "pbx_peer_sip_id", "", "SELECT * FROM pbx_peer_sip WHERE host !='dynamic' AND accountcode='0'", "Linha VoIP ", 1, true, "name", "name", false),
    new Field("combo", "Linha VoIP Backup", "pbx_trunk_backup", "", "SELECT * FROM pbx_peer_sip WHERE host !='dynamic' AND accountcode='0'", "Linha VoIP de Backup", 1, true, "name", "name", false),
    new Field("combo", "Abrangencia", "pbx_route_level", "", "SELECT * FROM pbx_route_outgoing_type WHERE level !='1000'", "Abrangência da Rota de Saída", 6, true, "level", "description", false),
    new Field("text", "Prefixo", "prefix", "", "", "Prefixo adicionado ao número discado", 10, false),
    new Field("text", "Remover da Esquerda", "remove_left", "", "", "Quantidade de Digitos a remover da esquerda do número discado", 5, false),
    new Field("text", "Prefixo - BACKUP", "prefix_bkp", "", "", "Prefixo adicionado ao número discado - BACKUP TRUNK", 10, false),
    new Field("text", "Remover da Esquerda - BACKUP", "remove_left_bkp", "", "", "Quantidade de Digitos a remover da esquerda do número discado - BACKUP TRUNK", 5, false)
);

$form = new CreateForm(@$_GET['operation'], 69, $fields);

//debug($_POST);

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_pbx_route_outgoing_insert");
} else {
    $form->show_form();
}

?>
