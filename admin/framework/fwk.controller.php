<?php
    class Controller {
        var $page_forbbiden = "framework/fwk.forbidden.php";
        var $page_not_found = "framework/fwk.not_found.php";
        var $page_home = "framework/fwk.home.php";
        
        function show_operation_page() {
            if(isset($_GET['operation']) && $_GET['operation'] != "") {
                $this->load_operation_page($_GET['operation']);
            } else {
                $this->include_page($this->page_home);
            }
        }

        function include_page($page) {
             if(file_exists($page)) {
                include($page);
                return true;
             } else {
                return false;
             }
        }

        function load_operation_page($fwk_operation_id) {
            $operation = $this->load_operation($fwk_operation_id);
            $operation_path = "operation/";

            if($operation=="FORBIDDEN") {
                $this->include_page($this->page_forbbiden);
                return;
            }
            if($operation=="NOT_FOUND") {
                $this->include_page($this->page_not_found);
                return;
            }
            $operation_url = $operation_path . $operation['url'];
            $this->include_page($operation_url);
            return;
        }

        public function load_operation($fwk_operation_id) {
            $query_operation = "
                SELECT DISTINCT
                    *
                FROM
                    fwk_operation
                WHERE
                    fwk_operation_id={$fwk_operation_id}
            ";
            $operation = $GLOBALS['db']->selectAll($query_operation);
            if(!isset($operation[0])) {
                return "NOT_FOUND";
            }

            if(isset($operation[0]) && $GLOBALS['security']->check_access($fwk_operation_id)==false) {
                return "FORBIDDEN";
            }
            $operation_path = "operation/";
            $operation_url = $operation_path . $operation[0]['url'];

            if(isset($operation[0]) && $GLOBALS['security']->check_access($fwk_operation_id)==true && file_exists($operation_url)) {
                return $operation[0];
            }
        }
    }

    $controller = new Controller();
?>
