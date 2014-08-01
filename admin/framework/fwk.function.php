<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

function sip_reload() {

$socket = fsockopen("127.0.0.1","5038", $errno, $errstr, 10);
	
      if (!$socket){
	echo "$errstr ($errno)\n";
	}else{
            fputs($socket, "Action: Login\r\n");
            fputs($socket, "UserName: othos\r\n");
            fputs($socket, "Secret: othos68467\r\n\r\n");
            fputs($socket, "Action: Command\r\n");
            fputs($socket, "Command: sip reload\r\n\r\n");
            fputs($socket, "Action: Logoff\r\n\r\n");
            while (!feof($socket)){
              fgets($socket);
            }
            fclose($socket);
       }

}

function query_filter() {
    $return = '';
    $filters = array();
    if (isset($_POST)) {
        $filters = $_POST;
    }

    $count = 0;

    foreach ($filters as $field => $value) {

        $type = substr($field, -2);
        $field = substr($field, 0, -3);

        if ($type == 'fo') {

            if ($value == '') {
                continue;
            }
            if ($count == 0) {
                $return .= $field . $value;
            } else {
                $return .= " AND " . $field . $value;
            }
        }

        if ($type == 'fv') {
            //debug($_POST[$field . "_fo"]);
            if (@$_POST[$field . "_fo"] == '') {
                continue;
            }
            if ($value != '') {
                if (is_numeric($value)) {
                    $return .= $value;
                } else {
                    $return .= "'" . $value . "'";
                }
            } else {
                $return .= "'%%'";
            }
        }

        $count++;
    }

    if ($return == '') {
        return '1=1';
    }

    return $return;
}

function debug($var) {
    echo "<div style='z-index: 10; background-color: #DDDDDD; font-size: 11px; border: 2px solid green; float: left;'>";
    echo "<pre>";
    echo "<p>Debug Information:</p>";
    print_r($var);
    echo "</pre>";
    echo "</div>";
}

function money($r, $c = 'R$') {
    return $c . ' ' . number_format($r, 2, ',', '.');
}

function div_arred_up($x, $y) {
    if ($x == 0)
        return 0;
    if ($y == 0)
        return 0;
    $result = $x / $y;
    $pos = strpos($result, '.');

    if (!$pos) {
        return $result;
    } else {
        return (int) substr($result, 0, $pos) + 1;
    }
}

function getTimeStamp() {
    date("Y-m-d H:i:s", time());
}

function arrayAsString($vector = array()) {
    $keys = array_keys($vector);
    $count = count($keys);

    if ($count <= 0) {
        return "";
    }

    $param = "?";

    for ($i = 0; $i < $count; $i++) {
        if ($keys[$i] != 'pageNumber') {
            $param .= $keys[$i] . '=' . $_GET[$keys[$i]];
            if ($i < ($count - 2)) {
                $param .= "&";
            }
        }
    }

    return $param;
}

function message($type, $message) {
    echo "<p class='msg_{$type}'><span style='font-size: 20px;'>" . ucfirst($type) . "</span><br /><br />" . $message . "<a style='margin-right: 0px; margin-top: -40px;' title='Fechar mensagem' class='msg_back' href='javascript:history.back();'><img src='media/image/back.png' style='width: 22px; height: 22px; margin-right: 8px; '/></a></p>";
    return;
}

function sec_to_time($time) {
    if ($time < 0) {
        $time = 0;
    }
    return gmdate("H:i:s", $time);
}

function sort_array_by($data, $sort_by, $direction = 'ASC') {
    if (!$data) {
        return;
    }
    foreach ($data as $key => $row) {
        $sort[$key] = $row[$sort_by];
    }

    array_multisort($sort, (($direction == 'ASC') ? SORT_ASC : SORT_DESC), $data);
    return $data;
}
?>
