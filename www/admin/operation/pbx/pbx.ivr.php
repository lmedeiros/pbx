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

    # 3 - RECORDSET FUNCTION
    function getUser() {
        $users = $GLOBALS['db']->selectAll("SELECT * FROM pbx_ivr WHERE " . query_filter());
        if($users) {
            return $users;
        } else {
            return false;
        }
    }
    # 4 - LIST TABLE CONFIG

        #$headers column names
        $headers = array("ID", "Descrição","Campanha", "Ramal Padrão","Ações");

        #$columns database column names, or parameter for the Filter Function
        $columns = array("pbx_ivr_id", "description","pbx_campaign_id", "exten_t", "ACTIONS");
    #$actions array of operations ID related to the page type LIST
    $actions = array(110, 113, 114);
    $actions_confirm = Array(113=>'Certeza que deseja apagar essa URA?');
    #$action_parameters _GET parameters to the functions related, key = GET name, value = @database field
    $action_parameters = array(
        110 => array(
            "id" => "@pbx_ivr_id"
        ),
	114=> array(
            "id" => "@pbx_ivr_id"
        ),
        113 => array(
            "id" => "@pbx_ivr_id"
        )
    );

    # 5 - TABLE BUILD

    #populate table 1arg - List Title, 2arg - Function which returns data recordset
    $table = new DisplayTable(getUser(),'description', 'ASC');

    
    #set table header column names
    $table->setHeaders($headers);
    #set table database columns
    $table->setColumns($columns);
    #NO data message
    $table->setEmptyMessage("There is no users.");
    #add value filter, 1st arg = database column array index, 2arg = filter function name
    //$table->addFilter(2, "filterSys_user_id");
    //$table->addFilter(3, "filterBoolean");
    $table->setActionsParameters($action_parameters);
    #set table list actions and parameters
    $table->setActions($actions);
    $table->addConfirmActions($actions_confirm);
    #show tables
    new CreateHome(@$_GET['operation'], array(111),0);
    $table->displayTable();
?>
