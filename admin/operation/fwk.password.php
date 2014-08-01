<?php

function load_values() {
        $query = "SELECT * FROM fwk_user WHERE fwk_user_id = '". $_SESSION[session_key] . "'";
        $record = $GLOBALS['db']->selectAll($query);
        if(isset($record[0])) {
            return $record[0];
        } else {
            return false;
        }
}

$record = load_values();
if(!$record){
	
    echo "<script type='text/javascript'> history.go(-1) </script>";
} else {
    $fields = array(
    new Field("text", "Senha", "secret", $record['secret'], "", "Nova Senha", 30, true),
    new Field("hidden", "", "fwk_user_id", $_SESSION[session_key], "", "", 0, true)
    );

    $form = new CreateForm(@$_GET['operation'], 2, $fields);
}

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_fwk_user_password");
} else {
    $form->show_form();
}
?>
