<?php

    if (!isset ($_COOKIE[ini_get('session.name')])) {
        session_start();
    }

    class Session {

        function  __construct($mode) {

            if($mode == 1) {
                if(!$this->check_session()) {
                    echo "</body></html>";
                    Header ("Location: " . login_page);
                    die("Sessão expirou...");
                }
            }

            if($mode == 0) {
                if($this->check_session()) {
                    echo "</body></html>";
                    Header ("Location: " . main_page);
                }
            }
        }

        function check_session() {
            if(isset($_SESSION[session_key]) && $_SESSION[session_key]!="") {
                return true;
            } else {
                return false;
            }
        }

        private function start_session($value) {
            $_SESSION[session_key] = $value;
        }

        public function validate_session($login, $secret) {
            $logon = $GLOBALS['db']->selectAll("SELECT DISTINCT * FROM fwk_user WHERE login='{$login}' AND secret='{$secret}' AND is_active=1");
            if(isset($logon[0])) {
                $this->start_session($logon[0]['fwk_user_id']);
                return true;
            } else {
                return false;
            }
        }

        public function end_session() {
            session_unset();
            session_destroy();
            $_SESSION[session_key] = null;
            unset($_SESSION[session_key]);
        }
    }
    
?>