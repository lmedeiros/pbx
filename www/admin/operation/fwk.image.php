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
        return "<img style='width: 24px; height: 24px;' src='framework/fwk.imagetb_load.php?id={$value}' alt='icon' />";
    }

    # 3 - RECORDSET FUNCTION
    function getImage() {
        $users = $GLOBALS['db']->selectAll("SELECT * FROM fwk_image");
        if($users) {
            return $users;
        } else {
            return false;
        }
    }
    # 4 - LIST TABLE CONFIG
    #$headers column names
    $headers = array("ID", "Imagem", "Titulo", "Tipo", "Actions");
    #$columns database column names, or parameter for the Filter Function
    $columns = array("fwk_image_id", "fwk_image_id", "title", "file_type", "ACTIONS");
    #$actions array of operations ID related to the page type LIST
    $actions_confirm = Array(46=>'Are you sure to delete this image?');
    $actions = array(46);
    #$action_parameters _GET parameters to the functions related, key = GET name, value = @database field
    $action_parameters = array(
        46 => array(
            "id" => "@fwk_image_id"
        )
    );

    # 5 - TABLE BUILD

    #populate table 1arg - List Title, 2arg - Function which returns data recordset
    $table = new DisplayTable(getImage(),'title', 'ASC',20);
    #set table header column names
    $table->setHeaders($headers);
    #set table database columns
    $table->setColumns($columns);
    #NO data message
    $table->setEmptyMessage("There is no Images.");
    #add value filter, 1st arg = database column array index, 2arg = filter function name
    //$table->addFilter(2, "filterSys_user_id");
    $table->addFilter(1, "load_image");
    #set table list actions and parameters
    $table->setActions($actions);
    $table->setActionsParameters($action_parameters);
    $table->addConfirmActions($actions_confirm);
    #show tables
    new CreateHome(@$_GET['operation'], array(20),1);
    $table->displayTable();
?>
