<?php

$back_operation_id = 95;

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

        foreach (get_routes() as $route => $desc) {;
            $query = "SELECT * FROM pbx_rate_group_account WHERE pbx_account_id = '{$_GET['id']}' AND pbx_route_outgoing_id='{$route}'";
            $result = $GLOBALS['db']->selectRow($query);
            $record[$route] = $result['pbx_rate_group_id'];
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
        $fields[] = new Field("combo", $desc, $route, $record[$route], "SELECT * FROM pbx_rate_group ORDER BY description", "Select a Rate Group for the account", 1, false, "pbx_rate_group_id", "description", false); 
    }

    $form = new CreateForm(@$_GET['operation'], $back_operation_id, $fields);


    if (isset($_POST['submit']) && $_POST['submit'] != "") {
        $upload = $_POST;
        $_POST = array();
        foreach (get_routes() as $route => $desc) {
            if (!isset($upload[$route])) {
                $_POST[$route] = 0;
            } else {
                $_POST[$route] = $upload[$route];
            }
        }
        $_POST['peer_id'] = $_GET['id'];
        $GLOBALS['db']->command("DELETE FROM pbx_rate_group_account WHERE pbx_account_id = '{$_POST['peer_id']}'");
        
        foreach($_POST as $route_id => $permission) {
            if(is_numeric($route_id) && $permission>0) {
                 $GLOBALS['db']->command("INSERT INTO pbx_rate_group_account(pbx_account_id, pbx_route_outgoing_id, pbx_rate_group_id) VALUES ('{$_POST['peer_id']}', '{$route_id}', '{$permission}')");
            }
        }
        echo "<script language='javascript'>history.go(-1)</script>";
    } else {
        $form->show_form();
    }
}
?>
