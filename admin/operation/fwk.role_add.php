<?php
    //new Field($type, $title, $name, $default_value, $query, $helper, $size, $required)
    $fields = array(
        new Field("text", "Grupo", "role", "", "", "Nome Completo do grupo para acesso as operações", 20, true),
        new Field("textarea", "Descrição", "description", "", "", "Descrição dos acessos do grupo", 20, false)
    );

    $form = new CreateForm(@$_GET['operation'], 6, $fields);

    if(isset($_POST['submit']) && $_POST['submit']!="") {
        $form->submit("sp_fwk_role_insert");
    } else {
        $form->show_form();
    }

?>
