<?php
    # 1 - CLASS INCLUDES
    require("framework/fwk.table.php");

    # 2 - FILTER FUNCTIONS
    function filterBoolean($value) {
        if($value == '0') {
                return 'No';
        } elseif($value == '1') {
                return 'Yes';
        }
        return 'Unknown';
    }
    
    function get_method($value) {
        switch($value) {
            case "manual":
                return "Manual";
            case "credit":
                return "Credit Card";
            case "wire":
                return "Wire Transfer";
            default:
                return "Unknown";
            
        }
    }
    
    function get_credits($value) {
        $topup = $GLOBALS['db']->selectRow("SELECT * FROM pbx_acc_pre_history WHERE pbx_account_id = '{$value}' LIMIT 1");
        if($account) {
             $accounts = $GLOBALS['db']->selectRow("SELECT * FROM aux_currency WHERE aux_currency_id = {$account['aux_currency_id']} LIMIT 1");
            if($accounts) {
                return $accounts['symbol'] . " " . round($topup['value']*$accounts['convertion_rate'], 2);
            } else {
                return false;
            }
        } else {
            
            return "0";
        }   
    }

    # 3 - RECORDSET FUNCTION
    function getUser() {
	if(isset($_GET['id']) && $_GET['id']!='') {
		$condition = " WHERE pbx_account_id = ".$_GET['id'];
	} else {
		$condition = "";
	}

        $users = $GLOBALS['db']->selectAll("SELECT * FROM pbx_acc_pre_history".$condition);
        if($users) {
            return $users;
        } else {
            return false;
        }
    }
    # 4 - LIST TABLE CONFIG

        #$headers column names
        $headers = array("Conta","Valor (R$)","Metodo", "Data");

        #$columns database column names, or parameter for the Filter Function
        $columns = array("pbx_account_id","value","method", "date_insert");
    #$actions array of operations ID related to the page type LIST


    # 5 - TABLE BUILD

    #populate table 1arg - List Title, 2arg - Function which returns data recordset
    $table = new DisplayTable(getUser(),'date_insert', 'DESC',30);

    
    #set table header column names
    $table->setHeaders($headers);
    #set table database columns
    $table->setColumns($columns);
    #NO data message
    $table->setEmptyMessage("There is no topup.");
    #add value filter, 1st arg = database column array index, 2arg = filter function name
    //$table->addFilter(1, "get_credits");
    $table->addFilter(2, "get_method");
    #show tables
    new CreateHome(@$_GET['operation'], array(0),29);
    $table->displayTable();
?>
