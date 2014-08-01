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
	    $peer_id = 0;
	    if($_GET['id']) {
		$peer_id = $_GET['id'];	
	    }

        $users = $GLOBALS['db']->selectAll("SELECT * FROM pbx_account_did WHERE pbx_account_id={$peer_id}");
        if($users) {
            return $users;
        } else {
            return false;
        }
    }
    # 4 - LIST TABLE CONFIG

        #$headers column names
        $headers = array("Provider","Number", "Location","Actions");

        #$columns database column names, or parameter for the Filter Function
        $columns = array("provider","number", "location", "ACTIONS");
    #$actions array of operations ID related to the page type LIST
    $actions = array(43, 45);
    $actions_confirm = Array(45=>'Are you sure on deleting this DID?');
    #$action_parameters _GET parameters to the functions related, key = GET name, value = @database field
    $action_parameters = array(
        43 => array(
            "id" => "@id"
        ),
        45 => array(
            "id" => "@id"
        )
    );

    # 5 - TABLE BUILD

    #populate table 1arg - List Title, 2arg - Function which returns data recordset
    $table = new DisplayTable(getUser(),'name', 'ASC');

    
    #set table header column names
    $table->setHeaders($headers);
    #set table database columns
    $table->setColumns($columns);
    #NO data message
    $table->setEmptyMessage("There is no DIDs.");
    #add value filter, 1st arg = database column array index, 2arg = filter function name
    //$table->addFilter(2, "filterSys_user_id");
    //$table->addFilter(3, "filterBoolean");
    $table->setActionsParameters($action_parameters);
    #set table list actions and parameters
    $table->setActions($actions);
    $table->addConfirmActions($actions_confirm);
    #show tables
    new CreateHome(@$_GET['operation'], array(67),26);
    $table->displayTable();
?>
