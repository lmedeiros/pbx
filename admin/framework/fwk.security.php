<?php
     
    class Security {

        var $fwk_user_id;

        function __construct() {
            $this->fwk_user_id = $_SESSION[session_key];
        }

        public function check_access($fwk_operation_id) {
            $query_role = "
                SELECT DISTINCT
                    A.fwk_role_id as fwk_role_id,
                    C.access_type as access_type
                FROM
                    fwk_role A,
                    fwk_user_role B,
                    fwk_acl C
                WHERE
                    A.fwk_role_id = B.fwk_role_id
                AND
                    B.fwk_user_id = {$this->fwk_user_id}
                AND
                    C.fwk_operation_id = {$fwk_operation_id}
                AND
                    C.fwk_role_id = A.fwk_role_id
            ";
            $roles = $GLOBALS['db']->selectAll($query_role);
            if(isset($roles[0])) {
                foreach($roles as $role) {
                    if($role['access_type']==0) {
                        return false;
                    }
                }
                return true;
            } else {
                return false;
            }
        }
    }

    $security = new Security();
    
?>
