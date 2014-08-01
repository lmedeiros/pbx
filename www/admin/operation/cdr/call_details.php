<?php

# 1 - CLASS INCLUDES
require("framework/fwk.table.php");

# 2 - FILTER FUNCTIONS
function set_kb($value) {
    return round($value) . " KB";
}

function cutNumber($value) {
    if(strlen($value)>10) {
        return $value;
    } else {
        return $value;
    }
}

# 3 - RECORDSET FUNCTION

function getCDR() {
    
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
      /*
      //debug("SELECT * FROM asterisk.cdr WHERE calldate BETWEEN '{$datestart}' AND '{$dateend}' AND clid LIKE '{$clid}' AND dst LIKE '{$dst}'");
      $calls = $GLOBALS['db']->selectAll("SELECT calldate, clid, dst,  SEC_TO_TIME(billsec) as billsec FROM asterisk.cdr WHERE calldate BETWEEN '{$datestart}' AND'{$dateend}'  AND dcontext='otgoing' AND  clid LIKE '{$clid}' AND dst LIKE '{$dst}' AND dst NOT LIKE '%BUSY%' AND dst NOT LIKE '%NOANSWER%' AND dst NOT LIKE '%CONGESTION%'");
     */

    $extensions = $GLOBALS['db']->selectAll(
            "SELECT DISTINCT
                    accountcode
                FROM
                    pbx_cdr
                WHERE
                    calldate BETWEEN '{$datestart}' AND '{$dateend}' 
                AND 
                    accountcode LIKE '${clid}' 
                AND 
                    dst LIKE '{$dst}'
                AND 
                    NOT accountcode = ''
                AND
                    dcontext='global'
                GROUP BY
                    accountcode
                ");

    if (!$extensions) {

        return null;
    }

    $calls = array();

    foreach ($extensions as $ext) {
        $extension = "%" . $ext['accountcode'] . "%";
        $calldates = $GLOBALS['db']->selectAll("SELECT DISTINCT calldate, accountcode FROM pbx_cdr WHERE calldate BETWEEN '{$datestart}' AND'{$dateend}' AND dcontext='global' AND NOT accountcode = '' AND accountcode LIKE '{$extension}' AND dst LIKE '{$dst}' AND dst REGEXP '[0-9]'");
        
        if (!$calldates) {
            return null;
        }
        
        /*
          ROUND(llp) as llp,
                    ROUND(rlp) as rlp,
                    (txcount/8)/8 as tx,
                    (rxcount/8)/8 as rx,
         */
        foreach ($calldates as $calldate) {
            $average = $GLOBALS['db']->selectAll("
                SELECT
                    ROUND(llp) as llp,
                    ROUND(rlp) as rlp,
                    (txcount/8)/8 as tx,
                    (rxcount/8)/8 as rx,
                    accountcode,
                    calldate,
                    SEC_TO_TIME(billsec) as billsec,
		    dst,
		    location,
		    rate,
                    trunkname,
		    cost,
                    locker,
                    date_add(calldate, INTERVAL billsec SECOND) AS calldate_end,
                    IFNULL((SELECT calldate FROM pbx_cdr WHERE calldate > '" . $calldate['calldate'] . "' AND accountcode = '" . $calldate['accountcode'] . "' AND dcontext='global' AND NOT accountcode = '' AND dst LIKE '{$dst}' AND dst REGEXP '[0-9]' order by calldate asc limit 1),NOW()) as calldate_next,
                    TIMESTAMPDIFF(SECOND,date_add(calldate, INTERVAL billsec SECOND), IFNULL((SELECT calldate FROM pbx_cdr WHERE calldate > '" . $calldate['calldate'] . "' AND NOT accountcode = '' AND  accountcode = '" . $calldate['accountcode'] . "' AND dcontext='global'  AND dst LIKE '{$dst}' AND dst REGEXP '[0-9]' order by calldate asc limit 1),NOW())) as idle
                FROM
                    pbx_cdr
                WHERE
                    accountcode = '" . $calldate['accountcode'] . "'
                AND
                    calldate = '" . $calldate['calldate'] . "'
                AND
                    dcontext='global'
                AND 
                    dst LIKE '{$dst}' 
                AND 
                    NOT accountcode = ''
                AND 
                    dst REGEXP '[0-9]'
                LIMIT 1
            ");

            
                    
            if ($average) {
                array_push($calls, $average[0]);
            }
        }
    }
    

    if ($calls) {
        return $calls;
    } else {
        return false;
    }
    
}


# 4 - LIST TABLE CONFIG
#$headers column names
$headers = array("Data/Hora", "Ramal", "Destino", "Duração", "Localidade", "Custo", "Dados Env.", "Dados Rec.", "Linha", "Senha");
#$columns database column names, or parameter for the Filter Function
$columns = array("calldate", "accountcode", "dst", "billsec", "location", "cost", "tx", "rx", "trunkname","locker");
$calls = getCDR();
# 5 - TABLE BUILD
#populate table 1arg - List Title, 2arg - Function which returns data recordset
$table = new DisplayTable($calls, 'calldate', 'DESC', 100);
#set table header column names
$table->setHeaders($headers);
#set table database columns
$table->setColumns($columns);
#NO data message
$table->setEmptyMessage("Não há chamadas.");
#add value filter, 1st arg = database column array index, 2arg = filter function name
$table->addFilter(2, "cutNumber");
$table->addFilter(6, "set_kb");
$table->addFilter(7, "set_kb");

$table->displayTable();
?>
