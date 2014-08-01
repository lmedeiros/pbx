<?php

    $back_operation_id = 53;

    function load_values() {
        if (isset($_GET['id']) && $_GET['id'] != "") {
            $query = "SELECT * FROM pbx_account WHERE pbx_account_id = {$_GET['id']}";
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
        new Field("text", "Descrição", "description", $record['description'], "", "Account name/owner", 30, true),
        new Field("hidden", "Câmbio", "aux_currency_id", $record['aux_currency_id'], "SELECT * FROM aux_currency ORDER BY name", "Select an Account currency", 1, true, "aux_currency_id", "name", false),
        new Field("text", "E-mail", "email", $record['email'], "", "Account E-mail", 50, false),
        new Field("hidden", "Limite (USD)", "credit", $record['credit'], "", "Set the credit amount, it will be converted to account currency", 6, true),
        new Field("combo", "Conta Ativa?", "is_active", $record['is_active'], "SELECT * FROM aux_bool", "Select an Account currency", 2, true, "value", "name", true),
        new Field("combo", "Cadeado?", "has_locker", $record['has_locker'], "SELECT * FROM aux_bool", "Ativar/Desativar Cadeado do Ramal", 2, true, "value", "name", true),
        new Field("text", "Limite de Bloqueio", "block", $record['block-limit'], "", "Amount expend to block the account, set to 0 to disable", 10, true),
        new Field("hidden", "", "pbx_account_id", $record['pbx_account_id'], "", "", 0, true)
    );

        $form = new CreateForm(@$_GET['operation'], $back_operation_id, $fields);
    }

    if (isset($_POST['submit']) && $_POST['submit'] != "") {
        $form->submit("sp_pbx_account_update");
    } else {
        $form->show_form();
    }

?>
