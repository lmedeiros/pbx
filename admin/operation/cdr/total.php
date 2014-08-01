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
    
    function secToTime($value) {
        return sec_to_time($value);
    }
    
    function set_kb($value) {
        if($value==0) {
            return "0 MB.";
        }
        return round($value/1024,1) . " MB"; 
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
        
        $calls = $GLOBALS['db']->selectAll("SELECT 
						sum(cost) as cost,
						count(calldate) as amount, 
                                                (SEC_TO_TIME(sum(billsec))) as duration,
                                                (SELECT count(calldate) FROM pbx_cdr WHERE billsec = 0 AND dcontext='global' AND calldate BETWEEN '{$datestart}' AND '{$dateend}' AND accountcode LIKE '{$clid}' and dst LIKE '{$dst}') as '0min',
                                                (SELECT count(calldate) FROM pbx_cdr WHERE billsec > 0 AND dcontext='global' AND billsec < 60 AND calldate BETWEEN '{$datestart}' AND '{$dateend}' AND accountcode LIKE '{$clid}' and dst LIKE '{$dst}') as 'less1m',
                                                (SELECT count(calldate) FROM pbx_cdr WHERE billsec >= 60 AND dcontext='global' AND billsec < 300 AND calldate BETWEEN '{$datestart}' AND '{$dateend}' AND accountcode LIKE '{$clid}' and dst LIKE '{$dst}') as '1to5min',
                                                (SELECT count(calldate) FROM pbx_cdr WHERE billsec >= 300 AND dcontext='global' AND billsec < 900 AND calldate BETWEEN '{$datestart}' AND '{$dateend}' AND accountcode LIKE '{$clid}' and dst LIKE '{$dst}') as '5to15min',
                                                (SELECT count(calldate) FROM pbx_cdr WHERE billsec >= 900 AND dcontext='global' AND billsec < 1800 AND calldate BETWEEN '{$datestart}' AND '{$dateend}' AND accountcode LIKE '{$clid}' and dst LIKE '{$dst}') as '15to30min',
                                                (SELECT count(calldate) FROM pbx_cdr WHERE billsec >= 1800 AND dcontext='global' AND calldate BETWEEN '{$datestart}' AND '{$dateend}' AND accountcode LIKE '{$clid}' and dst LIKE '{$dst}') as 'more30min'
                                            FROM 
                                                pbx_cdr 
                                            WHERE 
                                                calldate BETWEEN '{$datestart}' AND '{$dateend}' 
                                            AND 
                                                accountcode LIKE '{$clid}' 
                                            AND 
                                                dst LIKE '{$dst}' 
                                            AND 
                                                dcontext='global' 
                                            AND 
                                                dst NOT LIKE '%BUSY%' 
                                            AND 
                                                dst NOT LIKE '%NOANSWER%' 
                                            AND 
                                                dst NOT LIKE '%CONGESTION%'
                                           ");
        if($calls) {
            return $calls;
        } else {
            return false;
        }
    }
    # 4 - LIST TABLE CONFIG
    #$headers column names
    $headers = array("Qtd.", "Duração", "Custo", "0 sec.", "< 1 min.", "1 − 5 min.", "5 − 15 min.", "15 − 30 min.", "> 30 min.");
    #$columns database column names, or parameter for the Filter Function
    $columns = array("amount", "duration", "cost", "0min", "less1m", "1to5min", "5to15min", "15to30min", "more30min");

    # 5 - TABLE BUILD

    #populate table 1arg - List Title, 2arg - Function which returns data recordset
    $table = new DisplayTable(getCalls(),'accountcode', 'ASC');
    #set table header column names
    $table->setHeaders($headers);
    #set table database columns
    $table->setColumns($columns);
    #NO data message
    $table->setEmptyMessage("There is no calls.");
    #add value filter, 1st arg = database column array index, 2arg = filter function name
    //$table->addFilter(2, "filterSys_user_id");
    //$table->addFilter(3, "set_kb");
    //$table->addFilter(4, "set_kb");
    #show tables
   

    $table->displayTable();
?>
