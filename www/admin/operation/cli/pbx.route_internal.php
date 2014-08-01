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
        $users = $GLOBALS['db']->selectAll("SELECT * FROM pbx_route_outgoing WHERE pbx_route_level='1000'");
        if($users) {
            return $users;
        } else {
            return false;
        }
    }
    
    function getLevel($value) {
        $users = $GLOBALS['db']->selectRow("SELECT description FROM pbx_route_outgoing_type WHERE level='{$value}'");
        if($users) {
            return $users['description'];
        } else {
            return false;
        }
    }
    # 4 - LIST TABLE CONFIG

    #$headers column names
#$headers column names
    $headers = array("Descrição","Padrão","Prefixo","Remover Dig.","Ações");

    #$columns database column names, or parameter for the Filter Function
    $columns = array("description", "pattern","prefix","remove_left", "ACTIONS");
    $actions_confirm = Array(105=>'Tem certeza que deseja apagar essa rota?');
    
    #$actions array of operations ID related to the page type LIST
    $actions = array(74, 105);
    
    #$action_parameters _GET parameters to the functions related, key = GET name, value = @database field
    $action_parameters = array(
        74 => array(
            "id" => "@pbx_route_outgoing_id"
        ),
        105 => array(
            "id" => "@pbx_route_outgoing_id"
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
    //$table->addFilter(4, "getLevel");
    //$table->addFilter(3, "filterBoolean");
    $table->addConfirmActions($actions_confirm);
    $table->setActionsParameters($action_parameters);
    #set table list actions and parameters
    $table->setActions($actions);
    #show tables
    new CreateHome(@$_GET['operation'], array(73),53);
    $table->displayTable();
?>
