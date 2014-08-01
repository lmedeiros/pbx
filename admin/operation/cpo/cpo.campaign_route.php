<?php

$back_operation_id = 53;

function get_routes() {
    $query = "SELECT pbx_route_outgoing_id, description FROM pbx_route_outgoing";
    $result = $GLOBALS['db']->selectAll($query);
    $routes = array();
    if($result[0]) {
        foreach ($result as $route_id=>$description) {
            $routes[$description['pbx_route_outgoing_id']] = $description['description'];
        }
    } else {
        return false;
    }
    return $routes;
}

function load_values() {
    $record = array();

    if (isset($_GET['id']) && $_GET['id'] != "") {

        foreach (get_routes() as $route => $desc) {
            $query = "SELECT count(is_allow) as is_allow FROM pbx_campaign_route WHERE pbx_campaign_id = '{$_GET['id']}' AND pbx_route_outgoing_id='{$route}' AND is_allow='1'";
            $result = $GLOBALS['db']->selectRow($query);
            $record[$route] = $result['is_allow'];
        }

        return $record;
    } else {
        return false;
    }
}

$record = load_values();

if (!$record) {
    Header("Location: ?operation={$back_operation_id}");
} else {
    
    foreach (get_routes() as $route => $desc) {
        //new Field($type, $title, $name, $default_value, $query, $helper, $size, $required)
        $fields[] = new Field("check", $desc, $route, $record[$route], "", "Allow/Deny route", 10, false);
    }

    $form = new CreateForm(@$_GET['operation'], $back_operation_id, $fields);


    if (isset($_POST['submit']) && $_POST['submit'] != "") {
        $upload = $_POST;
        $_POST = array();
        foreach (get_routes() as $route => $desc) {
            if (!isset($upload[$route])) {
                $_POST[$route] = 0;
            } else {
                $_POST[$route] = 1;
            }
        }
        $_POST['peer_id'] = $_GET['id'];
        
        $GLOBALS['db']->command("DELETE FROM pbx_campaign_route WHERE pbx_campaign_id = '{$_POST['peer_id']}'");
        
        foreach($_POST as $route_id => $permission) {
            if(is_numeric($route_id)) {
                 $GLOBALS['db']->command("INSERT INTO pbx_campaign_route(pbx_campaign_id, pbx_route_outgoing_id, is_allow) VALUES ('{$_POST['peer_id']}', '{$route_id}', '{$permission}')");
            }
        }
        echo "<script language='javascript'>history.go(-1)</script>";
    } else {
        $form->show_form();
    }
}
?>
