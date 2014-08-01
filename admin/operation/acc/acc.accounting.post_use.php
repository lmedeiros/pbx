<?php

    # 1 - CLASS INCLUDES
    require("framework/fwk.table.php");

    # 2 - FILTER FUNCTIONS
    function filterBoolean($value) {
        if($value == '0') {
                return 'Não';
        } elseif($value == '1') {
                return 'Sim';
        }
        return 'Unknown';
    }

    # 3 - RECORDSET FUNCTION
    function getAccounts() {
        $accounts = $GLOBALS['db']->selectAll("SELECT * FROM pbx_account WHERE prepaid='0' AND " . query_filter());
        if($accounts) {
            return $accounts;
        } else {
            return false;
        }
    }
    
   function get_peer($value) {
        $accounts = $GLOBALS['db']->selectRow("SELECT name FROM pbx_peer_sip WHERE accountcode = {$value} LIMIT 1");
        if($accounts) {
            return $accounts['name'];
        } else {
            return false;
        }
    }
  
    function format_number($value) {
        setlocale(LC_MONETARY, 'pt_BR');
	$return = money_format('%!n', $value);

	return $return;
    }
     


    # 4 - LIST TABLE CONFIG
    #$headers column names
    $headers = array("Nome", "Consumo" , "Ações");
    #$columns database column names, or parameter for the Filter Function
    $columns = array("description", "credit", "ACTIONS");
    #$actions array of operations ID related to the page type LIST
    $actions = array(32);
    #$action_parameters _GET parameters to the functions related, key = GET name, value = @database field
    $action_parameters = array(
        32 => array( //date("Y-m-d H:i:s", time());
            "clid" => "@pbx_account_id",
            "calldate_start_year" => date("Y", time()),
            "calldate_start_month" => date("m", time()),
            "calldate_start_day" => date("d", time()),
            "calldate_end_year" => date("Y", time()),
            "calldate_end_month" => date("m", time()),
            "calldate_end_day" => date("d", time()),
            "calldate_start_hour" => "00",
            "calldate_start_minute" => "00",
            "calldate_end_hour" => "23",
            "calldate_end_minute" => "59",
            "report_type" => "call_details"
        )
    );

    # 5 - TABLE BUILD

    #populate table 1arg - List Title, 2arg - Function which returns data recordset
    $table = new DisplayTable(getAccounts(),'description', 'ASC', 100);

    #set table header column names
    $table->setHeaders($headers);
    #set table database columns
    $table->setColumns($columns);
    #NO data message
    $table->setEmptyMessage("There is no accounts.");
    #add value filter, 1st arg = database column array index, 2arg = filter function name
    $table->addFilter(1, "format_number");
    $table->setActionsParameters($action_parameters);
    #set table list actions and parameters
    $table->setActions($actions);
    $table->addConfirmActions($actions_confirm);
    #show tables
    new CreateHome(@$_GET['operation'], array(51),53);
    $table->displayTable();
?>
