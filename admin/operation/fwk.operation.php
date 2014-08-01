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
    function load_image($value) {      
        return "<img style='width: 12px; height: 12px;' src='framework/fwk.image_load.php?id={$value}' alt='icon' />";
    }

    # 3 - RECORDSET FUNCTION
    function getOperation() {
        $users = $GLOBALS['db']->selectAll("SELECT * FROM fwk_operation WHERE " . query_filter());
        if($users) {
            return $users;
        } else {
            return false;
        }
    }
    # 4 - LIST TABLE CONFIG
    #$headers column names
    $headers = array("ID","", "Operação", "Arquivo", "Actions");
    #$columns database column names, or parameter for the Filter Function
    $columns = array("fwk_operation_id", "fwk_operation_id", "name", "url", "ACTIONS");
    #$actions array of operations ID related to the page type LIST
    $actions = array(21,22);
    $actions_confirm = Array(22=>'Deseja realmente apagar essa Operação?');
    #$action_parameters _GET parameters to the functions related, key = GET name, value = @database field
    $action_parameters = array(
        21 => array(
            "id" => "@fwk_operation_id"
        ),
        22 => array(
            "id" => "@fwk_operation_id"
        )
    );

    # 5 - TABLE BUILD

    #populate table 1arg - List Title, 2arg - Function which returns data recordset
    $table = new DisplayTable(getOperation(),'name', 'ASC', 20);
    #set table header column names
    $table->setHeaders($headers);
    #set table database columns
    $table->setColumns($columns);
    #NO data message
    $table->setEmptyMessage("There is no Operations.");
    #add value filter, 1st arg = database column array index, 2arg = filter function name
    //$table->addFilter(2, "filterSys_user_id");
    $table->addFilter(1, "load_image");
    #set table list actions and parameters
    $table->setActions($actions);
    $table->setActionsParameters($action_parameters);
    $table->addConfirmActions($actions_confirm);
    #show tables
    new CreateHome(@$_GET['operation'], array(12),1);
    $table->displayTable();
?>
