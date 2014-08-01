<?php

class CreateForm {

    private $fields;
    private $back_operation_id;
    private $fwk_operation_id;
    private $operation;

    function __construct($fwk_operation_id, $back_operation_id, $fields) {
        $this->back_operation_id = $back_operation_id;
        $this->fields = $fields;
        $this->fwk_operation_id = $fwk_operation_id;
        $this->user_id = $_SESSION[session_key];
        $this->write_home_title();
    }

    public function submit($procedure, $log = true) {
        if (!$this->load_fields()) {
            message("warning", "Preencha todos os campos marcados com um * vermelho");
            return;
        }

        $sql = "CALL " . $procedure . "(" . $this->load_fields() . ")";
        $command = $GLOBALS['db']->command($sql);
        
        if (@is_numeric($command)) {
            $success = 1;
            if ($log == true) {
                $GLOBALS['db']->command("INSERT INTO fwk_log SET fwk_operation_id='" . $_GET["operation"] . "', fwk_user_id={$this->user_id}, log='" . addslashes($sql) . "', is_success={$success}, type='edit/add'");
            }
            echo '<script type="text/javascript">';
            echo 'window.location = "?operation=' . $this->back_operation_id . '"';
            echo '</script>';
            return;
        } else {
            $sql = "CALL " . $procedure . "(" . $this->load_fields() . ")";
            $success = 0;
            @message(error, "Erro ao executar o registro, verifique o log de eventos: " . @$command->getMessage());
            if ($log == true) {
                $GLOBALS['db']->command("INSERT INTO fwk_log SET fwk_operation_id='" . $_GET["operation"] . "', fwk_user_id={$this->user_id}, log='" . addslashes($sql) . "', is_success={$success}, type='edit/add'");
            }
            return;
        }
    }

    private function load_fields() {
        $fields = "";
        $fields_validate = array();
        foreach ($_POST as $field => $value) {
            if (!strpos($field, "_required") && !strpos($field, "_confirm") && $field != "submit") {
                $fields = $fields . ("'" . $value . "', ");
            }
        }

        foreach ($_POST as $field => $value) {
            if (strpos($field, "_required") && $value == '1') {
                array_push($fields_validate, substr($field, 0, -9));
            }
        }

        foreach ($fields_validate as $field_validate) {
            if (@$_POST[$field_validate] == "") {
                return false;
            }
        }

        return substr($fields, 0, -2);
    }

    public function show_form() {
        echo "<div id='icon_holder'>\n";
        echo "\t\t<form name='frame_form' enctype='multipart/form-data' method='post' action='{$_SERVER['REQUEST_URI']}'>\n";
        echo "\t\t\t\t<table class='form'>\n";
        foreach ($this->fields as $field) {
            $field->build_field();
        }
        echo "\t\t\t<tr>\n";
        echo "\t\t\t\t<td></td>\n";
        echo "\t\t\t\t<td class='submit'>\n";
        echo "\t\t\t\t\t<input type='hidden' id='submit' name='submit' value='1' />\n";
        echo "\t\t\t\t\t<input class='submit' type='submit' value='" . ($this->operation['name']) . "'/>\n";
        echo "\t\t\t\t\t<input class='cancel' type='button' onclick='history.go(-1)' value='Cancelar'/>\n";
        echo "\t\t\t\t</td>\n";
        echo "\t\t\t</tr>\n";
        echo "\t\t</table>\n";
        echo "\t</form>\n";
        echo "</div>\n";
    }

    private function write_home_title() {
        $this->operation = $this->load_home_item($this->fwk_operation_id);
        $back_operation = $this->load_home_item($this->back_operation_id);
        if ($this->operation) {
            echo "<div id='home_title'>\n";
            echo "<h1>" . "<img style='float: left; width: 38px; height: 38px;  margin-right: 10px; margin-top: 5px;' src='framework/fwk.image_load.php?id=" . $this->operation['fwk_operation_id'] . "' alt='' />" . ($this->operation['name']) . "</h1>\n";
            echo "<h2>" . ($this->operation['description']) . "</h2>\n";
            echo "</div>\n\n";
            if ($back_operation) {
                echo "<div id='home_voltar'>";
                echo "<p>\n";
                echo "<a title='{$back_operation['description']}' href='?operation={$this->back_operation_id}'>\n";
                echo "<img src='framework/fwk.image_load.php?id={$this->back_operation_id}' alt='icon' /> <img src='framework/fwk.imagetb_load.php?id=9' alt='icon' /></a>\n";
                echo "</p>\n";
                echo "</div>\n\n";
            }
        } else {
            return false;
        }
    }

    private function load_home_item($fwk_operation_id) {
        $operation = $GLOBALS['controller']->load_operation($fwk_operation_id);

        if (isset($operation) && $operation != "FORBIDDEN" && $operation != "NOT_FOUND") {
            return $operation;
        } else {
            return false;
        }
    }

}

?>
