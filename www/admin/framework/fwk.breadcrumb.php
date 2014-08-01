<?php
    class Breadcrumb {
        function __construct(){
            if(isset($_GET['operation']) && $_GET['operation'] != "") {
                $operation = $this->load_operation_breadcrumb($_GET['operation']);
                if($operation) {
                    $this->write_breadcrumb($operation['breadcrumb']);
                } else {
                    return false;
                }
            }
        }

        private function write_breadcrumb($breadcrumb) {
   
           echo ("<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Você está em: <span style='color: #AAAAAA;'>" . $breadcrumb . "</span></p>");
        }


        private function load_operation_breadcrumb($fwk_operation_id) {
            $operation_page = $GLOBALS['db']->selectAll("SELECT DISTINCT * FROM fwk_operation WHERE is_visible=1 AND fwk_operation_id={$fwk_operation_id}");
            $operation_path = "operation/";

            if(isset($operation_page[0])) {
                $operation_url = $operation_path . $operation_page[0]['url'];
                if(file_exists($operation_url)) {
                    return $operation_page[0];
                }
            }
            return false;
        }
    }

?>
