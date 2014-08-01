<?php
    //new Field($type, $title, $name, $default_value, $query, $helper, $size, $required)
    $fields = array(
        new Field("text", "Nome Completo", "fullname", "", "", "Nome Completo do usuário", 30, true),
        new Field("text", "Login", "login", "", "", "Login de acesso do usuário", 10, true),
        new Field("password", "Senha", "secret", "", "", "Senha de Acesso do usuário", 10, true),
        new Field("text", "E-mail", "email", "", "", "E-mail do usuário", 30, false)
    );

    $form = new CreateForm(@$_GET['operation'], 5, $fields);

    if(isset($_POST['submit']) && $_POST['submit']!="") {
        $form->submit("sp_fwk_user_insert");
    } else {
        $form->show_form();
    }

?>
