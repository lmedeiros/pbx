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
			calldate, 
			SEC_TO_TIME(billsec) as billsec,
			campaign,
			accountcode,
			locker,
			disposition,
			ivr,
			src,
			location
		FROM 
			pbx_cdr 
		WHERE
			dcontext != 'global'
		AND
			campaign != ''
		AND
			dst REGEXP '[0-9]'
		OR 
			dst = 's'
		AND
			" . query_filter();
	
        $accounts = $GLOBALS['db']->selectAll($query);
        if($accounts) {
            return $accounts;
        } else {
            return false;
        }
    }

    function get_credits($value) {
        $account = $GLOBALS['db']->selectRow("SELECT * FROM pbx_account WHERE pbx_account_id = {$value} LIMIT 1");
        if($account) {
             $accounts = $GLOBALS['db']->selectRow("SELECT * FROM aux_currency WHERE aux_currency_id = {$account['aux_currency_id']} LIMIT 1");
            if($accounts) {
                    if($account['credit']=='0') {
                        return $accounts['symbol'] . ' 0';
                     }
                    return $accounts['symbol'] . " " . round($account['credit']*$accounts['convertion_rate'], 2)*(-1);
            } else {
                return false;
            }
        } else {

            return "0";
        }
    }

    $headers = array("Data", "Campanha", "Ramal", "URA","Número", "Localidade" , "Status","Duração", "");
    $columns = array("calldate", "campaign", "accountcode", "ivr","src", "location", "disposition", "billsec", "ACTIONS");

    $table = new DisplayTable(getCalls(),'calldate', 'DESC', 50);
    $table->setHeaders($headers);
    $table->setColumns($columns);
    $table->setEmptyMessage("There is no accounts.");
    new CreateHome(@$_GET['operation'], array(0),32);
    $table->displayTable();
?>

