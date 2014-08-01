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
        $users = $GLOBALS['db']->selectAll("SELECT * FROM pbx_peer_sip S INNER JOIN pbx_campaign_peer CP ON CP.pbx_peer_id = S.name WHERE CP.pbx_campaign_id = " . $_SESSION[session_key]  . "  AND host = 'dynamic' AND " . query_filter());
        if($users) {
            return $users;
        } else {
            return false;
        }
    }
    # 4 - LIST TABLE CONFIG

    #$headers column names
    $headers = array("Account ID","Number", "Secret","Caller ID", "Last IP", "Last Device" ,"Actions");

    #$columns database column names, or parameter for the Filter Function
    $columns = array("accountcode", "name", "secret","callerid", "ipaddr", "useragent", "ACTIONS");
    #$actions array of operations ID related to the page type LIST
    $actions = array(35,44);
    #$action_parameters _GET parameters to the functions related, key = GET name, value = @database field
    $action_parameters = array(
        35 => array(
            "id" => "@name"
        ),
        44 => array(
            "id" => "@name"
        )
    );

    # 5 - TABLE BUILD

    #populate table 1arg - List Title, 2arg - Function which returns data recordset
    $table = new DisplayTable(getUser(),'name', 'ASC', 100);

    
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
    #show tables
    new CreateHome(@$_GET['operation'], array(0),0);
    $table->displayTable();
?>
