<?php

class CreateDelete {

    private $back_operation_id;
    private $record_id;
    private $user_id;
    private $param;

    function __construct($back_operation_id, $record_id, $param=false) {
        $this->back_operation_id = $back_operation_id;
        $this->param = $param;
        $this->record_id = $record_id;
        $this->user_id = $_SESSION[session_key];
    }

    public function delete($procedure, $log = true) {
        if($this->param==false) {
            $sql = "CALL {$procedure} ({$this->record_id})";
        } else {
            $sql = "CALL {$procedure} ({$this->record_id}, '{$this->param}')";
        }
        $command = $GLOBALS['db']->command($sql);

        if (@is_numeric($command)) {
            $success = 1;
            if ($log == true) {
                $GLOBALS['db']->command("INSERT INTO fwk_log SET fwk_operation_id='" . $_GET["operation"] . "', fwk_user_id={$this->user_id}, log='" . addslashes($sql) . "', is_success={$success}, type='delete'");
            }
            echo '<script type="text/javascript">';
            echo 'window.location = "?operation=' . $this->back_operation_id . '"';
            echo '</script>';
            return;
        } else {
            $success = 0;
            @message(error, "Erro ao apagar o registro, verifique o log de eventos: " . @$command->getMessage());
            if ($log == true) {
                $GLOBALS['db']->command("INSERT INTO fwk_log SET fwk_operation_id='" . $_GET["operation"] . "', fwk_user_id={$this->user_id}, log='" . addslashes($sql) . "', is_success={$success}, type='delete'");
            }
            return;
        }
    }

}

?>
