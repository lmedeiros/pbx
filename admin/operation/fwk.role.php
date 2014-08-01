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
    function getGroup() {
        $users = $GLOBALS['db']->selectAll("SELECT * FROM fwk_role");
        if($users) {
            return $users;
        } else {
            return false;
        }
    }
    # 4 - LIST TABLE CONFIG
    #$headers column names
    $headers = array("Grupo", "Descrição", "Actions");
    #$columns database column names, or parameter for the Filter Function
    $columns = array("role", "description", "ACTIONS");
    #$actions array of operations ID related to the page type LIST
    $actions = array(17,18);
    $actions_confirm = Array(18=>'Deseja realmente apagar esse grupo?');
    #$action_parameters _GET parameters to the functions related, key = GET name, value = @database field
    $action_parameters = array(
        17 => array(
            "id" => "@fwk_role_id"
        ),
        18 => array(
            "id" => "@fwk_role_id"
        )
    );

    # 5 - TABLE BUILD

    #populate table 1arg - List Title, 2arg - Function which returns data recordset
    $table = new DisplayTable(getGroup(),'role', 'ASC');
    #set table header column names
    $table->setHeaders($headers);
    #set table database columns
    $table->setColumns($columns);
    #NO data message
    $table->setEmptyMessage("There is no Roles.");
    #add value filter, 1st arg = database column array index, 2arg = filter function name
    //$table->addFilter(2, "filterSys_user_id");
    $table->addFilter(3, "filterBoolean");
    #set table list actions and parameters
    $table->addConfirmActions($actions_confirm);
    $table->setActions($actions);
    $table->setActionsParameters($action_parameters);
    #show tables
    new CreateHome(@$_GET['operation'], array(11),1);
    $table->displayTable();
?>
