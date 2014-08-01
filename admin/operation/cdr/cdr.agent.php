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
    function getCalls() {

	$query = "SELECT
			*
		FROM 
			pbx_agent_log 
			WHERE
				pbx_campaign_id != '0' 
			AND
				" . query_filter();
	
        $accounts = $GLOBALS['db']->selectAll($query);
        if($accounts) {
            return $accounts;
        } else {
            return false;
        }
    }

    function get_event($value) {
	if($value==0) {
		return "Logout (0)";
	}
	if($value==1) {
                return "Login (1)";
        }
        if($value==3) {
                return "Pausa (3)";
        }
        if($value==4) {
                return "Retorno (4)";
        }
    }

    $headers = array("Data/Hora", "Campanha", "Ramal", "Agente ", "Evento","");
    $columns = array("moment", "pbx_campaign_id", "pbx_peer_id", "pbx_locker_id", "event", "ACTIONS");

    $table = new DisplayTable(getCalls(),'moment', 'DESC', 50);
    $table->setHeaders($headers);
    $table->setColumns($columns);
    $table->addFilter(4,'get_event');
    $table->setEmptyMessage("There is no accounts.");
    new CreateHome(@$_GET['operation'], array(0),32);
    $table->displayTable();
?>

