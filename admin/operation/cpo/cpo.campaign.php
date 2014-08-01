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
    function getCampaigns() {
        $accounts = $GLOBALS['db']->selectAll("SELECT * FROM pbx_campaign WHERE " . query_filter());
        if($accounts) {
            return $accounts;
        } else {
            return false;
        }
    }

    function get_credits($value) {
        $account = $GLOBALS['db']->selectRow("SELECT * FROM pbx_account WHERE pbx_account_id = {$value} LIMIT 1");
        if($account) {
             $accounts = $GLOBALS['db']->selectRow("SELECT * FROM aux_currency WHERE aux_currency_id = {$account['aux_currency_id']} LIMIT 1");
            if($accounts) {
                    if($account['credit']=='0') {
                        return $accounts['symbol'] . ' 0';
                     }
                    return $accounts['symbol'] . " " . round($account['credit']*$accounts['convertion_rate'], 2)*(-1);
            } else {
                return false;
            }
        } else {

            return "0";
        }
    }

    # 4 - LIST TABLE CONFIG
    #$headers column names
    $headers = array("Nome", "ID", "Inicio", "Termino" , "Tipo", "Ações");
    #$columns database column names, or parameter for the Filter Function
    $columns = array("description", "pbx_campaign_id", "start_date", "end_date", "type" ,"ACTIONS");
    #$actions array of operations ID related to the page type LIST
    $actions = array(98, 99, 102, 85, 115, 133);
    $actions_confirm = Array(102=>'Tem certeza que deseja excluir esse Ramal?'  );
    #$action_parameters _GET parameters to the functions related, key = GET name, value = @database field
    $action_parameters = array(
        98 => array(
            "id" => "@pbx_campaign_id"
        ),
	99 => array(
            "id" => "@pbx_campaign_id"
        ),
	102 => array(
	    "id" => "@pbx_campaign_id"
	),
	85 => array(
            "id" => "@pbx_campaign_id"
        ),
        115 => array(
            "id" => "@pbx_campaign_id"
        ),
        133 => array(
            "id" => "@pbx_campaign_id"
        )
    );

    # 5 - TABLE BUILD

    #populate table 1arg - List Title, 2arg - Function which returns data recordset
    $table = new DisplayTable(getCampaigns(),'description', 'ASC', 50);

    #set table header column names
    $table->setHeaders($headers);
    #set table database columns
    $table->setColumns($columns);
    #NO data message
    $table->setEmptyMessage("There is no accounts.");
    #add value filter, 1st arg = database column array index, 2arg = filter function name
    //$table->addFilter(1, "get_peer");
    //$table->addFilter(2, "get_credits");
    $table->setActionsParameters($action_parameters);
    #set table list actions and parameters
    $table->setActions($actions);
    $table->addConfirmActions($actions_confirm);
    #show tables
    new CreateHome(@$_GET['operation'], array(96),0);
    $table->displayTable();
?>

