<?php
    require("framework/fwk.config.php");
    require("framework/fwk.database.php");
    require("framework/fwk.function.php");
    require("framework/fwk.session.php");
    require("framework/fwk.menu.php"); 
    require("framework/fwk.breadcrumb.php");
    require("framework/fwk.controller.php");
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>
<head>
	<title>Framework</title>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	 <link rel="stylesheet" type="text/css" href="style/layout.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="style/tags.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="style/operation_home.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="style/list.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="style/form.css" media="screen" />

</head>
<body>
    <?php
        $session = new Session(0);
        if($session->check_session() == "") {
            validate_logon();
        }    
    ?>
    <div id='main' style="width: 421px; text-align: left; position: relative; margin: auto; height: auto; margin-top: 30px;">    
    
            <form style="border: none !important; background-color: none !important;" name='form_logon' id='form_logon' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                <input type='hidden' name='perform_logon' id='perform_logon' />
                <table style='margin-top: 30px; font-size: 18px;' class='form'>
                    <tr>
                        <td style="text-align: right; font-size: 16px; font-weight: bold;">Usuário:</td>
                        <td><input type='text' name='login_username' id='login_username' value="<?php echo isset($_POST['login_username']) ? $_POST['login_username'] : "";?>"/></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; font-size: 16px; font-weight: bold;">Senha:</td>
                        <td><input type='password' name='login_password' id='login_password' /></td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <td></td><td><input style='cursor:pointer' type='submit' value=' OK ' /></td>
                    </tr>
                </table>
            </form>

    </div>
</body>
</html>

<?php

    function validate_logon() {
        if(isset($_POST['perform_logon'])) {
            if(isset($_POST['login_username']) && isset($_POST['login_password'])) {
                $result = $GLOBALS['session']->validate_session($_POST['login_username'], $_POST['login_password']);
                if($result) {
                    Header ("Location: " . main_page);
                }
            }
        }
    }
    
?>
