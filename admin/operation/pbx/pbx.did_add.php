<?php

//new Field($type, $title, $name, $default_value, $query, $helper, $size, $required)
$fields = array(
    new Field("combo", "Account Number", "pbx_account_id", "", "SELECT * FROM pbx_account", "Account to assing the DID", 5, true, "pbx_account_id", "pbx_account_id", false),    
    new Field("text", "Provider", "provider", "", "", "Provider name and Account name", 30, true),
    new Field("text", "Phone Number", "number", "", "", "Phone number of DiD", 40, true),
    new Field("text", "Location", "location", "", "", "Phone Number City/Country", 40, true),
);

$form = new CreateForm(@$_GET['operation'], 66, $fields);

//debug($_POST);

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_pbx_did_insert");
} else {
    $form->show_form();
}

?>
