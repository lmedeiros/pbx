<?php

$back_operation_id = 29;

function load_values() {
    if (isset($_GET['id']) && $_GET['id'] != "") {
        $query = "SELECT * FROM pbx_account_description WHERE pbx_account_id = {$_GET['id']}";
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

    $fields = array(
    new Field("textarea", "Description", "doc", $record['doc'], "", "Type in every detail for this account", 80, true),
    new Field("hidden", "", "pbx_account_id", $_GET['id'], "", "", 0, true)
    );

    $form = new CreateForm(@$_GET['operation'], $back_operation_id, $fields);


if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_pbx_account_desc_update");
} else {
    $form->show_form();
}

?>
