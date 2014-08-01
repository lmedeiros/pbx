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
        $accounts = $GLOBALS['db']->selectAll("SELECT * FROM pbx_campaign WHERE pbx_campaign_id = '" . $_SESSION[session_key]  . "'  AND " . query_filter());
        if($accounts) {
            return $accounts;
        } else {
            return false;
        }
    }

    # 4 - LIST TABLE CONFIG
    #$headers column names
    $headers = array("Nome", "ID", "Inicio", "Termino" , "Tipo", "Ações");
    #$columns database column names, or parameter for the Filter Function
    $columns = array("description", "pbx_campaign_id", "start_date", "end_date", "type" ,"ACTIONS");
    #$actions array of operations ID related to the page type LIST
    $actions = array(117, 118, 119, 120, 128);
//    $actions_confirm = Array(102=>'Tem certeza que deseja excluir esse Ramal?'  );
    #$action_parameters _GET parameters to the functions related, key = GET name, value = @database field
    $action_parameters = array(
        117 => array(
            "id" => "@pbx_campaign_id"
        ),
	118 => array(
            "id" => "@pbx_campaign_id"
        ),
	119 => array(
	    "id" => "@pbx_campaign_id"
	),
	120 => array(
            "id" => "@pbx_campaign_id"
	),
        128 => array(
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
   // $table->addConfirmActions($actions_confirm);
    #show tables
    new CreateHome(@$_GET['operation'], array(0),0);
    $table->displayTable();
?>

