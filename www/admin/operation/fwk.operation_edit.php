<?php

$back_operation_id = 7;

function load_values() {
    if (isset($_GET['id']) && $_GET['id'] != "") {
        $query = "SELECT * FROM fwk_operation WHERE fwk_operation_id = {$_GET['id']}";
        $record = $GLOBALS['db']->selectAll($query);
        if(isset($record[0])) {
            return $record[0];
        } else {
            return false;
        }
    } else {
        return false;
    }
}

$record = load_values();
if(!$record){
    Header("Location: ?operation={$back_operation_id}");
} else {
    $fields = array(
        new Field("text", "Link Name", "name", $record['name'] ,"", "Titulo da Operação", 40, true),
        new Field("textarea", "Tooltip Text", "description", $record['description'], "", "Tooltip text to show on mouse over", 40, true),
        new Field("text", "URL", "url", $record['url'], "", "PHP file path", 70, true),
        new Field("combo", "Icon", "fwk_image_id", $record['fwk_image_id'], "SELECT * FROM fwk_image ORDER BY title", "Operation Icon Image", 1, true, "fwk_image_id", "title"),
        new Field("text", "Breadcrumb Text", "breadcrumb", $record['breadcrumb'], "", "Breadcrumb text to show on top", 70, true),
        new Field("hidden", "", "fwk_operation_id", $_GET['id'], "", "", 0, true)
    );

    $form = new CreateForm(@$_GET['operation'], $back_operation_id, $fields);
}

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_fwk_operation_update");
} else {
    $form->show_form();
}
?>
