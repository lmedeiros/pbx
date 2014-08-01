<?php
    //new Field($type, $title, $name, $default_value, $query, $helper, $size, $required)
    $fields = array(
        new Field("combo", "Operações", "fwk_operation_id[]", "", "SELECT * FROM fwk_operation ORDER BY description", "", 10, true, "fwk_operation_id", "description", true),
        new Field("combo", "Grupos", "fwk_role_id", "", "SELECT * FROM fwk_role ORDER BY role", "Grupos de usuários", 10, true, "fwk_role_id", "role"),
        new Field("radio", "Permitir", "access_type", "1", "", "Permitir acesso a seleção atual", 10, true, "fwk_role_id", "role"),
        new Field("radio", "Negar", "access_type", "0", "", "Negar acesso a seleção atual", 10, true, "fwk_role_id", "role")
    );

    $form = new CreateForm(@$_GET['operation'], 1, $fields);

    //debug($_POST);

    if(isset($_POST['submit']) && $_POST['submit']!="") {
        foreach($_POST['fwk_operation_id'] as $fwk_operation_id) {
            if($fwk_operation_id!='') {
                $_POST['fwk_operation_id'] = $fwk_operation_id;
                $form->submit("sp_fwk_acl_insert");
            }
        }
    } else {
        $form->show_form();
    }

?>
