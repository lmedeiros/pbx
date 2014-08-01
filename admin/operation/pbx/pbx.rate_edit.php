<?php

$back_operation_id = 31;

function load_values() {
    if (isset($_GET['id']) && $_GET['id'] != "") {
        $query = "SELECT * FROM pbx_rate WHERE pbx_rate_id = {$_GET['id']}";
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
    new Field("text", "Valor/Min (R$)", "rate", $record['rate'], "", "Call cost for that location", 6, true),
    new Field("hidden", "", "pbx_rate_id", $_GET['id'], "", "", 0, true)
    );

    $form = new CreateForm(@$_GET['operation'], $back_operation_id, $fields);
}

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_pbx_call_rate_update");
} else {
    $form->show_form();
}
?>
