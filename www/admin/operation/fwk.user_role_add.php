<?php
    //new Field($type, $title, $name, $default_value, $query, $helper, $size, $required)
    $fields = array(
        new Field("combo", "Usuários", "fwk_user_id[]", "", "SELECT * FROM fwk_user", "Imagem da Operação", 10, true, "fwk_user_id", "fullname", true),
        new Field("combo", "Grupos", "fwk_role_id", "", "SELECT * FROM fwk_role", "Imagem da Operação", 10, true, "fwk_role_id", "role"),
    );

    $form = new CreateForm(@$_GET['operation'], 1, $fields);

    //debug($_POST);

    if(isset($_POST['submit']) && $_POST['submit']!="") {
        foreach($_POST['fwk_user_id'] as $fwk_user_id) {
            if($fwk_user_id!='') {
                $_POST['fwk_user_id'] = $fwk_user_id;
                $form->submit("sp_fwk_role_user_insert");
            }
        }
    } else {
        $form->show_form();
    }

?>
