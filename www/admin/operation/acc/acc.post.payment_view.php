<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
    # 1 - CLASS INCLUDES
    require("framework/fwk.table.php");

    # 2 - FILTER FUNCTIONS
    function filterBoolean($value) {
        if($value == '0') {
                return 'Em aberto';
        } elseif($value == '1') {
                return 'Confirmada';
        }
        return 'Unknown';
    }

    # 3 - RECORDSET FUNCTION
    function getAccounts() {
        if(isset($_GET['id']) && $_GET['id']!='') {
		$condition = " AND A.pbx_account_id = ".$_GET['id'];
	} else {
		$condition = "";
	}

	$accounts = $GLOBALS['db']->selectAll("SELECT *  FROM pbx_post_payment A INNER JOIN pbx_account ON A.pbx_account_id = pbx_account.pbx_account_id WHERE " . query_filter() . $condition );
        if($accounts) {
            return $accounts;
        } else {
            return false;
        }
    }
    
    # 4 - LIST TABLE CONFIG
    #$headers column names
    $headers = array("Conta", "Valor", "Fechamento" , "Vencimento", "Status","Pagto", "Nome","Ações");
    #$columns database column names, or parameter for the Filter Function
    $columns = array("pbx_account_id", "value_due", "dt_generate","dt_due","status","dt_confirm","description","ACTIONS");
    #$actions array of operations ID related to the page type LIST
    $actions = array(90, 91, 94);
    $actions_confirm = Array(90=>'Deseja confirmar esse pagamento?');
    #$action_parameters _GET parameters to the functions related, key = GET name, value = @database field
    $action_parameters = array(
        90 => array(
            "id" => "@pbx_post_payment_id"
        ),
        91 => array(
            "id" => "@pbx_post_payment_id"
    	),    
	94 => array(
	    "id" => "@pbx_post_payment_id"
        )
    );

    # 5 - TABLE BUILD

    #populate table 1arg - List Title, 2arg - Function which returns data recordset
    $table = new DisplayTable(getAccounts(),'description', 'ASC',1000);

    #set table header column names
    $table->setHeaders($headers);
    #set table database columns
    $table->setColumns($columns);
    #NO data message
    $table->setEmptyMessage("There is no accounts.");
    #add value filter, 1st arg = database column array index, 2arg = filter function name
    //$table->addFilter(1, "get_peer");
    $table->addFilter(4, "filterBoolean");
    $table->setActionsParameters($action_parameters);
    #set table list actions and parameters
    $table->setActions($actions);
    $table->addConfirmActions($actions_confirm);
    #show tables
    new CreateHome(@$_GET['operation'], array(92),83);
    $table->displayTable();
?>
