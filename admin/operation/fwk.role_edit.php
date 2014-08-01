<?php

$back_operation_id = 6;

function load_values() {
    if (isset($_GET['id']) && $_GET['id'] != "") {
        $query = "SELECT * FROM fwk_role WHERE fwk_role_id = {$_GET['id']}";
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
    new Field("text", "Nome", "role", $record['role'], "", "Nome Grupo de Usuários", 30, true),
    new Field("text", "Descrição", "description", $record['description'], "", "Descrição do Grupo de Usuários", 30, false),
    new Field("hidden", "", "fwk_role_id", $_GET['id'], "", "", 0, true)
    );

    $form = new CreateForm(@$_GET['operation'], $back_operation_id, $fields);
}

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_fwk_role_update");
} else {
    $form->show_form();
}
?>
