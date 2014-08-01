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
            $query = "SELECT count(is_allowed) as is_allowed FROM pbx_route_permission WHERE pbx_peer_sip_id = '{$_GET['id']}' AND code='{$route}' AND is_allowed='1'";
            $result = $GLOBALS['db']->selectRow($query);
            $record[$route] = $result['is_allowed'];
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
        
        $GLOBALS['db']->command("DELETE FROM pbx_route_permission WHERE pbx_peer_sip_id = '{$_POST['peer_id']}'");
        
        foreach($_POST as $route_id => $permission) {
            if(is_numeric($route_id)) {
                 $GLOBALS['db']->command("INSERT INTO pbx_route_permission(pbx_peer_sip_id, code, is_allowed) VALUES ('{$_POST['peer_id']}', '{$route_id}', '{$permission}')");
            }
        }
        echo "<script language='javascript'>history.go(-1)</script>";
    } else {
        $form->show_form();
    }
}
?>
