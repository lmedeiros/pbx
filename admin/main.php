<?php
    require("framework/fwk.config.php");
    require("framework/fwk.database.php");
    require("framework/fwk.function.php");
    require("framework/fwk.session.php");
    require("framework/fwk.security.php");
    require("framework/fwk.menu.php");
    require("framework/fwk.breadcrumb.php");
    require("framework/fwk.config_menu.php");
    require("framework/fwk.controller.php");
    require("framework/fwk.create_home.php");
    require("framework/fwk.field.php");
    require("framework/fwk.create_form.php");
    require("framework/fwk.create_delete.php");
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
        <link rel="stylesheet" type="text/css" href="style/anytime.c.css" media="screen" />

        <script src="framework/js/jquery.min.js" type="text/javascript"></script>
        <script src="framework/js/jquery-ui.js" type="text/javascript"></script>
        <script src="framework/js/anytime.js" type="text/javascript"></script>
        <script src="framework/js/calendario.js" type="text/javascript"></script>
	
	<script src="framework/js/tooltip.js" type="text/javascript"></script>
        <script type="text/javascript" language="javascript" src="framework/js/jquery.dropdownPlain.js"></script>
        <link rel="stylesheet" href="style/style.css" type="text/css" media="screen, projection"/>
        <!--[if lte IE 7]>
            <link rel="stylesheet" type="text/css" href="style/ie.css" media="screen" />
        <![endif]-->
        <script language="JavaScript" type="text/javascript">
            window.onload = function(){
                tooltip.init();
            }
        </script>
    </head>
    <body>
        
        <div id="loading" class="loading-invisible">
            <p>Carregando...</p>
        </div>
        <script type="text/javascript">
            document.getElementById("loading").className = "loading-visible";
            var hideDiv = function(){document.getElementById("loading").className = "loading-invisible";};
            var oldLoad = window.onload;
            var newLoad = oldLoad ? function(){hideDiv.call(this);oldLoad.call(this);} : hideDiv;
            window.onload = newLoad;
        </script>        
        <?php $session = new Session(1); ?>
        <div id="all">
            <div id='page'>
                <div id="logo">
			    <a href="?"><img style='margin-top: 15px;' src='media/image/logo.png' alt="Logo" /></a>
                </div>

                <div id="config">
                    <?php new ConfigMenu($_SESSION[SESSION_KEY]); ?>
                </div>

                <div id='menu'>
                    <div style="float: left; height: 45px; width: 100%; background-color: #555;">
                        <?php new Menu(array(1)); ?>
                    </div>
                </div>

                <div id="breadcrumb">
                    <?php new Breadcrumb(); ?>
                </div>

                <div id="content">
                    <?php $controller->show_operation_page(); ?>
                </div>

                <br clear="all"/>
            </div>
            <div style='clear:both; float:left; margin-top: 40px;  margin-bottom: 40px;left:0px; position: relative; width: 100%;'><p style ='text-align:center; float:none;'><a href="http://www.othos.com.br" style='color: #FF6600; font-size: 12px; text-decoration: none;'>Copyright 2012. © Framework</a></p></div>
        </div>
    </body>
</html>
