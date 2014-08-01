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
   
    
    /*
    [clid] => 
    [dst] => 
    [calldate_start_year] => 2011
    [calldate_start_month] => 09
    [calldate_start_day] => 6
    [calldate_start_hour] => 20
    [calldate_start_minute] => 46
    [calldate_end_year] => 2011
    [calldate_end_month] => 09
    [calldate_end_day] => 6
    [calldate_end_hour] => 20
    [calldate_end_minute] => 46
    [report_type] => call_details
     */
    # 3 - RECORDSET FUNCTION
    function getCalls() {
        
        $datestart = $_GET['calldate_start_year'] . 
                     "-" . 
                     $_GET['calldate_start_month'] . 
                     "-" . 
                     $_GET['calldate_start_day'] . 
                     " " . 
                     $_GET['calldate_start_hour'] . 
                     ":" . 
                     $_GET['calldate_start_minute'] .
                     ":00";
        
        $dateend = $_GET['calldate_end_year'] . 
                     "-" . 
                     $_GET['calldate_end_month'] . 
                     "-" . 
                     $_GET['calldate_end_day'] . 
                     " " . 
                     $_GET['calldate_end_hour'] . 
                     ":" . 
                     $_GET['calldate_end_minute'] .
                     ":00";
        
        $clid = "%" . $_GET['clid'] ."%";
        $dst = "%" . $_GET['dst'] . "%";
        
        $calls = $GLOBALS['db']->selectAll("SELECT SEC_TO_TIME(max(billsec)) as max, SEC_TO_TIME(min(billsec)) as min, SEC_TO_TIME(((max(billsec) + min(billsec)) / 2)) as med, clid FROM pbx_cdr WHERE calldate BETWEEN '{$datestart}' AND'{$dateend}' AND dcontext='global' AND clid LIKE '{$clid}' AND dst LIKE '{$dst}' GROUP BY clid");
        if($calls) {
            return $calls;
        } else {
            return false;
        }
    }
    # 4 - LIST TABLE CONFIG
    #$headers column names
    $headers = array("Extension", "Min Duration", "Max Duration", "Average");
    #$columns database column names, or parameter for the Filter Function
    $columns = array("clid", "min", "max", "med");


    # 5 - TABLE BUILD

    #populate table 1arg - List Title, 2arg - Function which returns data recordset
    $table = new DisplayTable(getCalls(),'clid', 'ASC');
    #set table header column names
    $table->setHeaders($headers);
    #set table database columns
    $table->setColumns($columns);
    #NO data message
    $table->setEmptyMessage("There is no calls.");
    #add value filter, 1st arg = database column array index, 2arg = filter function name
    //$table->addFilter(2, "filterSys_user_id");
    //$table->addFilter(1, "secToTime");
    //$table->addFilter(2, "secToTime");
    //$table->addFilter(3, "secToTime");
    #show tables

    $table->displayTable();
?>
