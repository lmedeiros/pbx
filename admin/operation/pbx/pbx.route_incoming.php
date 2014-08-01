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
        $users = $GLOBALS['db']->selectAll("SELECT * FROM pbx_route_incoming");
        if($users) {
            return $users;
        } else {
            return false;
        }
    }
    
    # 4 - LIST TABLE CONFIG

    #$headers column names
    $headers = array("Descrição", "Tronco/Número", "Destino", "Campanha", "Ações");

    #$columns database column names, or parameter for the Filter Function
    $columns = array("description", "trunk_name","dest_exten", "pbx_campaign_id", "ACTIONS");
    
    #$actions array of operations ID related to the page type LIST
    $actions = array(112, 104);
    $actions_confirm = Array(104=>'Tem certeza que deseja apagar essa rota?');
    #$action_parameters _GET parameters to the functions related, key = GET name, value = @database field
    $action_parameters = array(
        112 => array(
            "id" => "@pbx_route_incoming_id"
        ),
	104 => array(
		"id" => "@pbx_route_incoming_id"
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
    $table->setEmptyMessage("There is no rate groups.");
    #add value filter, 1st arg = database column array index, 2arg = filter function name
    //$table->addFilter(6, "getLevel");
    //$table->addFilter(3, "filterBoolean");
    $table->addConfirmActions($actions_confirm);
    $table->setActionsParameters($action_parameters);
    #set table list actions and parameters
    $table->setActions($actions);
    #show tables
    new CreateHome(@$_GET['operation'], array(87),68);
    $table->displayTable();
?>
