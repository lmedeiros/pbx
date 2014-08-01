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
        $users = $GLOBALS['db']->selectAll("SELECT * FROM fwk_user");
        if($users) {
            return $users;
        } else {
            return false;
        }
    }
    # 4 - LIST TABLE CONFIG
    #$headers column names
    $headers = array("Name", "Login","E-mail", "OPÇÕES");
    #$columns database column names, or parameter for the Filter Function
    $columns = array("fullname","login", "email", "ACTIONS");
    #$actions array of operations ID related to the page type LIST
    $actions = array(15, 16);
    $actions_confirm = Array(16=>'Deseja realmente apagar esse usuário?');
    #$action_parameters _GET parameters to the functions related, key = GET name, value = @database field
    $action_parameters = array(
        15 => array(
            "id" => "@fwk_user_id"
        ),
        16 => array(
            "id" => "@fwk_user_id"
        )
    );

    # 5 - TABLE BUILD

    #populate table 1arg - List Title, 2arg - Function which returns data recordset
    $table = new DisplayTable(getUser(),'fullname', 'ASC');

    
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
    new CreateHome(@$_GET['operation'], array(9),1);
    $table->displayTable();
?>
