<?php
    //new Field($type, $title, $name, $default_value, $query, $helper, $size, $required)
    $fields = array(
        new Field("text", "Link Name", "name", "", "", "Text to the <a> link", 40, true),
        new Field("textarea", "Tooltip Text", "description", "", "", "Tooltip text to show on mouse over", 40, true),
        new Field("text", "URL", "url", ".php", "", "PHP file path", 70, true),
        new Field("combo", "Icon", "fwk_image_id", "", "SELECT * FROM fwk_image ORDER BY title", "Operation Icon", 1, true, "fwk_image_id", "title"),
        new Field("text", "Breadcrumb Text", "breadcrumb", "", "", "Breadcrumb text to show on top", 70, true)
    );

    $form = new CreateForm(@$_GET['operation'], 7, $fields);

    if(isset($_POST['submit']) && $_POST['submit']!="") {
        $form->submit("sp_fwk_operation_insert");
    } else {
        $form->show_form();
    }

?>
