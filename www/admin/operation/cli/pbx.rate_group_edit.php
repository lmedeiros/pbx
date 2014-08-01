<?php

$back_operation_id = 37;

function load_values() {
    if (isset($_GET['id']) && $_GET['id'] != "") {
        $query = "SELECT * FROM pbx_rate_group WHERE pbx_rate_group_id = {$_GET['id']}";
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
    new Field("text", "Descrição", "description", $record['description'], "", "Call rate group name/description", 30, true),
    new Field("text", "Multiplicador", "multiplier", $record['multiplier'], "", "Rate Multiplier, used to get the call cost", 6, true),
    new Field("hidden", "", "pbx_rate_group_id", $_GET['id'], "", "", 0, true)
    );

    $form = new CreateForm(@$_GET['operation'], $back_operation_id, $fields);
}

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_pbx_rate_group_update");
} else {
    $form->show_form();
}
?>
