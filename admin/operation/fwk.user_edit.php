<?php

$back_operation_id = 5;

function load_values() {
    if (isset($_GET['id']) && $_GET['id'] != "") {
        $query = "SELECT * FROM fwk_user WHERE fwk_user_id = {$_GET['id']}";
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
    new Field("text", "Nome Completo", "fullname", $record['fullname'], "", "Nome Completo do usuário", 30, true),
    new Field("text", "E-mail", "email", $record['email'], "", "E-mail do usuário", 30, false),
    new Field("hidden", "", "fwk_user_id", $_GET['id'], "", "", 0, true)
    );

    $form = new CreateForm(@$_GET['operation'], $back_operation_id, $fields);
}

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_fwk_user_update");
} else {
    $form->show_form();
}
?>
