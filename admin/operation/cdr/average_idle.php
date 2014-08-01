<?php

# 1 - CLASS INCLUDES
require("framework/fwk.table.php");

# 2 - FILTER FUNCTIONS

function filterBoolean($value) {
    if ($value == '0') {
        return 'No';
    } elseif ($value == '1') {
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

    $clid = "%" . $_GET['clid'] . "%";
    $dst = "%" . $_GET['dst'] . "%";

    $extensions = $GLOBALS['db']->selectAll(
            "SELECT DISTINCT
                    clid
                FROM
                    pbx_cdr
                WHERE
                    calldate BETWEEN '{$datestart}' AND '{$dateend}' 
                AND 
                    clid LIKE '${clid}' 
                AND 
                    dst LIKE '{$dst}'
                AND
                    dcontext='global'
                GROUP BY
                    clid
                ");

    if (!$extensions) {

        return null;
    }

    $calls = array();

    foreach ($extensions as $ext) {
        $extension = "%" . $ext['clid'] . "%";
        $calldates = $GLOBALS['db']->selectAll("SELECT calldate, clid FROM pbx_cdr WHERE calldate BETWEEN '{$datestart}' AND'{$dateend}' AND dcontext='global' AND clid LIKE '{$extension}' AND dst LIKE '{$dst}'");

        if (!$calldates) {
            return null;
        }
        foreach ($calldates as $calldate) {
            //
            $average = $GLOBALS['db']->selectAll("
                SELECT DISTINCT
                    clid,
                    calldate,
                    billsec,
                    date_add(calldate, INTERVAL billsec SECOND) AS calldate_end,
                    IFNULL((SELECT calldate FROM pbx_cdr WHERE calldate > '" . $calldate['calldate'] . "' AND clid = '".  $calldate['clid'] ."' AND dcontext='global' order by calldate asc limit 1),NOW()) as calldate_next,
                    TIMESTAMPDIFF(SECOND,date_add(calldate, INTERVAL billsec SECOND), IFNULL((SELECT calldate FROM pbx_cdr WHERE calldate > '" . $calldate['calldate'] . "' AND clid = '".  $calldate['clid'] ."' AND dcontext='global' order by calldate asc limit 1),NOW())) as idle
                FROM
                    pbx_cdr
                WHERE
                    clid = '" . $calldate['clid'] . "'
                AND
                    calldate = '" . $calldate['calldate'] . "'
                AND
                    dcontext='global'
                LIMIT 1
            ");
            
            if ($average) {
                array_push($calls, $average[0]);
            } 
        }
    }


    $idle = array();
    //debug($calls);
    foreach ($extensions as $exten) {
        $array_ext = array();
        foreach ($calls as $call) {
            if ($call['clid'] == $exten['clid']) {
                if($call['idle']<0)
                    $call['idle']=0;
                $array_ext[] = $call['idle'];
            }
        }
        array_push($idle, array('avg' => sec_to_time(((max($array_ext) + min($array_ext)) / 2)), 'max' => sec_to_time(max($array_ext)), 'min' => sec_to_time(min($array_ext)), 'clid' => $exten['clid']));
    }
    
    if ($idle) {
        return $idle;
    } else {
        return false;
    }
}

# 4 - LIST TABLE CONFIG
#$headers column names
$headers = array("Extension", "Min Idle Time", "Max Idle Time", "Average idle Time");
#$columns database column names, or parameter for the Filter Function
$columns = array("clid", "min", "max", "avg");



# 5 - TABLE BUILD
#populate table 1arg - List Title, 2arg - Function which returns data recordset
$table = new DisplayTable(getCalls(), 'clid', 'ASC');
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
