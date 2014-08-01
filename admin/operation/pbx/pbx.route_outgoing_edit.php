<?php

$back_operation_id = 69;

function load_values() {
    if (isset($_GET['id']) && $_GET['id'] != "") {
        $query = "SELECT * FROM pbx_route_outgoing WHERE pbx_route_outgoing_id = {$_GET['id']}";
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
        new Field("text", "Descrição", "name", $record['description'], "", "Descrição da Rota", 30, true),
        new Field("text", "Padrão Regexp", "user", $record['pattern'], "", "Padrão da Rota em expressão regular", 40, true),
        new Field("combo", "Linha VoIP", "pbx_peer_sip_id", $record['pbx_peer_sip_id'], "SELECT * FROM pbx_peer_sip WHERE host !='dynamic' AND accountcode='0'", "Linha VoIP ", 1, true, "name", "name", false),
        new Field("combo", "Linha VoIP Backup", "pbx_trunk_backup", $record['pbx_trunk_backup'], "SELECT * FROM pbx_peer_sip WHERE host !='dynamic' AND accountcode='0'", "Linha VoIP de Backup", 1, true, "name", "name", false),
        new Field("combo", "Abrangencia", "pbx_route_level",$record['pbx_route_level'], "SELECT * FROM pbx_route_outgoing_type", "Abrangência da Rota de Saída", 6, true, "level", "description", false),
        new Field("text", "Prefixo", "prefix", $record['prefix'], "", "Prefixo adicionado ao número discado", 10, false),
        new Field("text", "Remover da Esquerda", "remove_left", $record['remove_left'], "", "Quantidade de Digitos a remover da esquerda do número discado", 5, false),
        new Field("text", "Prefixo - BACKUP", "prefix_bkp", $record['prefix_bkp'], "", "Prefixo adicionado ao número discado - BACKUP TRUNK", 10, false),
        new Field("text", "Remover da Esquerda - BACKUP", "remove_left_bkp", $record['remove_left_bkp'], "", "Quantidade de Digitos a remover da esquerda do número discado - BACKUP TRUNK", 5, false),
        new Field("hidden", "", "pbx_route_outgoing_id", $_GET['id'], "", "", 0, true)
    );

    $form = new CreateForm(@$_GET['operation'], 69, $fields);
}
//debug($_POST);

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_pbx_route_outgoing_update");
} else {
    $form->show_form();
}
?>
