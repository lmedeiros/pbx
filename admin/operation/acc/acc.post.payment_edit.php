<?php

    $back_operation_id = 89;

    function load_values() {
        if (isset($_GET['id']) && $_GET['id'] != "") {
            $query = "SELECT * FROM pbx_post_payment WHERE pbx_post_payment_id = {$_GET['id']}";
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
        new Field("text", "Valor", "value_due", $record['value_due'], "", "Valor da Cobrança", 10, true),
        new Field("text", "Vencimento", "dt_due", $record['dt_due'], "", "Data de Vencimento do Pagamento", 10, true),
        new Field("hidden", "", "pbx_post_payment_id", $record['pbx_post_payment_id'], "", "", 0, true)
    );

        $form = new CreateForm(@$_GET['operation'], $back_operation_id, $fields);
    }

    if (isset($_POST['submit']) && $_POST['submit'] != "") {
        $form->submit("sp_pbx_post_payment_update");
    } else {
        $form->show_form();
    }

?>
