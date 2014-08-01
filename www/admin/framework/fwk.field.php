<?php

class Field {

    private $type;
    private $default_value;
    private $query;
    private $name;
    private $helper;
    private $required;
    private $size;
    private $title;
    private $combo_text;
    private $combo_value;
    private $combo_multiselect;

    function __construct($type, $title, $name, $default_value='', $query=false, $helper='', $size=20, $required=false, $combo_value='', $combo_text='', $combo_multiselect=false) {
        $this->name = $name;
        $this->type = $type;
        $this->title = ($title);
        $this->default_value = $default_value;
        $this->query = $query;
        $this->helper = ($helper);
        $this->size = $size;
        $this->required = $required;
        $this->combo_text = $combo_text;
        $this->combo_value = $combo_value;
        $this->combo_multiselect = $combo_multiselect;
    }

    public function build_field() {
        switch ($this->type) {
            case "text":
                $this->build_text();
                return;
            case "password":
                $this->build_password();
                return;
            case "textarea":
                $this->build_textarea();
                return;
            case "combo":
                $this->build_combo();
                return;
            case "check":
                $this->build_check();
                return;
            case "radio":
                $this->build_radio();
                return;
            case "hidden":
                $this->build_hidden();
                return;
            case "date":
                $this->build_date();
                return;
            case "file":
                $this->build_file();
                return;
        }
        return false;
    }

    private function build_hidden() {
        echo "<tr style='display:none;'><td><input type='hidden' name='{$this->name}' id='{$this->name}' value='{$this->default_value}' />\n\r";
        echo "<input type='hidden' name='{$this->name}_required' id='{$this->name}_required' value='{$this->required}' />\n\r</td></tr>";
    }

    private function build_text() {
        echo "<tr>\n\r";
        echo "<th>\n\r";
        echo "<label>\n\r" . (($this->required == true) ? "<b style='color: red;'>*</b> " : "") . $this->title . "</label>";
        echo "</th>\n\r";
        echo "<td>\n\r";
        echo "<input type='text' onfocus='getElementById(\"{$this->name}_helper\").style.display=\"block\";' onblur='getElementById(\"{$this->name}_helper\").style.display=\"none\";' name='{$this->name}' id='{$this->name}' value='{$this->default_value}' maxlength='{$this->size}' size='{$this->size}' />\n\r";
        echo "<input type='hidden' name='{$this->name}_required' id='{$this->name}_required' value='{$this->required}' />\n\r";
        echo "<span id='{$this->name}_helper' class='helper'>(?) {$this->helper}</span>\n\r";
        echo "</td>\n\r";
        echo "</tr>\n\r";
    }

    private function build_date() {
	$this->name = "cal".$this->name;
	echo "<tr>\n\r";
        echo "<th>\n\r";
        echo "<label>\n\r" . (($this->required == true) ? "<b style='color: red;'>*</b> " : "") . $this->title . "</label>";
        echo "</th>\n\r";
        echo "<td>\n\r";
        echo "<input type='text' onfocus='getElementById(\"{$this->name}_helper\").style.display=\"block\";' onblur='getElementById(\"{$this->name}_helper\").style.display=\"none\";' name='{$this->name}' id='{$this->name}' value='{$this->default_value}' maxlength='{$this->size}' size='{$this->size}' />\n\r";
        echo "<input type='hidden' name='{$this->name}_required' id='{$this->name}_required' value='{$this->required}' />\n\r";
        echo "<span id='{$this->name}_helper' class='helper'>(?) {$this->helper}</span>\n\r";
        echo "</td>\n\r";
        echo "</tr>\n\r";
    }

    private function build_textarea() {
        echo "<tr>\n\r";
        echo "<th>\n\r";
        echo "<label>" . (($this->required == true) ? "<b style='color: red;'>*</b> " : "") . $this->title . "</label>";
        echo "</th>\n\r";
        echo "<td>\n\r";
        echo "<textarea onfocus='getElementById(\"{$this->name}_helper\").style.display=\"block\";' onblur='getElementById(\"{$this->name}_helper\").style.display=\"none\";' name='{$this->name}' id='{$this->name}' rows='10' cols='{$this->size}' >{$this->default_value}</textarea>\n\r";
        echo "<input type='hidden' name='{$this->name}_required' id='{$this->name}_required' value='{$this->required}' />\n\r";
        echo "<span id='{$this->name}_helper' class='helper'>(?) {$this->helper}</span>\n\r";
        echo "</td>\n\r";
        echo "</tr>\n\r";
    }

    private function build_password() {
        echo "<tr>\n\r";
        echo "<th>\n\r";
        echo "<label>" . (($this->required == true) ? "<b style='color: red;'>*</b> " : "") . $this->title . "</label>";
        echo "</th>\n\r";
        echo "<td>\n\r";
        echo "<input type='password' onfocus='getElementById(\"{$this->name}_helper\").style.display=\"block\";' onblur='getElementById(\"{$this->name}_helper\").style.display=\"none\";' name='{$this->name}' id='{$this->name}' value='{$this->default_value}' maxlength='{$this->size}' size='{$this->size}' />\n\r";
        echo "<input type='hidden' name='{$this->name}_required' id='{$this->name}_required' value='{$this->required}' />\n\r";

        echo "<span id='{$this->name}_helper' class='helper'>(?) {$this->helper}</span>\n\r";
        echo "</td>\n\r";
        echo "</tr>\n\r";
        echo "<tr>\n\r";
        echo "<th>\n\r";
        echo "<label>" . (($this->required == true) ? "<b style='color: red;'>*</b> " : "") . "Confirmar " . $this->title . "</label>\n\r";
        echo "</th>\n\r";
        echo "<td>\n\r";
        echo "<input onfocus='getElementById(\"{$this->name}_c_helper\").style.display=\"block\";' onblur='getElementById(\"{$this->name}_c_helper\").style.display=\"none\";' type='password' name='{$this->name}_confirm' id='{$this->name}_confirm' value='{$this->default_value}' size='{$this->size}' maxlength='{$this->size}'/>\n\r";
        echo "<input type='hidden' name='{$this->name}_confirm_required' id='{$this->name}_confirm_required' value='{$this->required}' />\n\r";

        echo "<span id='{$this->name}_c_helper' class='helper'>(?) {$this->helper} - Confirmar</span>";
        echo "</td>";
        echo "</tr>";
    }

    private function build_combo() {
        if (strpos($this->name, "[]")) {
            $comboname = substr($this->name, 0, -2);
        } else {
            $comboname = $this->name;
        }


        echo "<tr>\n\r";
        echo "<th>\n\r";
        echo "<label>" . (($this->required == true) ? "<b style='color: red;'>*</b> " : "") . $this->title . "</label>\n\r";
        echo "</th>\n\r";
        echo "<td>\n\r";
        echo "<select " . (($this->combo_multiselect == true) ? "multiple='multiple'" : "") . "onfocus='getElementById(\"{$comboname}_helper\").style.display=\"block\";' onblur='getElementById(\"{$comboname}_helper\").style.display=\"none\";' name='{$this->name}' id='{$comboname}' size='{$this->size}'>";
        $combo_items = $GLOBALS['db']->selectAll($this->query);

        if (isset($combo_items[0])) {
            echo (($this->size == 1) ? "<option value=''>[Selecione um Item]</option>\n\r" : "");
            foreach ($combo_items as $combo_item) {
                 if($this->default_value == $combo_item[$this->combo_value]) {
                    $selected = "selected='selected'";
                 } else {
                     $selected = "";
                 }
                echo "<option {$selected} value='{$combo_item[$this->combo_value]}'>{$combo_item[$this->combo_text]}</option>\n\r";
            }
        } else {
            echo "<option value=''>[No items to select]</option>\n\r";
        }

        echo "</select>\n\r";

        echo "<input type='hidden' name='{$comboname}_required' id='{$comboname}_required' value='{$this->required}' />\n\r";
        echo "<span id='{$comboname}_helper' class='helper'>(?) {$this->helper}</span>\n\r";
        echo "</td>\n\r";
        echo "</tr>\n\r";
    }

    private function build_radio() {
        echo "<tr>\n\r";
        echo "<th>\n\r";
        echo "<label>\n\r" . (($this->required == true) ? "<b style='color: red;'>*</b> " : "") . $this->title . "</label>";
        echo "</th>\n\r";
        echo "<td>\n\r";
        $id = $this->name . rand(0, 33);
        echo "<input type='radio' onfocus='getElementById(\"{$id}_helper\").style.display=\"block\";' onblur='getElementById(\"{$id}_helper\").style.display=\"none\";' name='{$this->name}' id='{$id}' value='{$this->default_value}'  />\n\r";
        echo "<input type='hidden' name='{$this->name}_required' id='{$id}_required' value='{$this->required}' />\n\r";
        echo "<span id='{$id}_helper' class='helper'>(?) {$this->helper}</span>\n\r";
        echo "</td>\n\r";
        echo "</tr>\n\r";
    }
    
    private function build_check() {
        echo "<tr>\n\r";
        echo "<th>\n\r";
        echo "<label>\n\r" . (($this->required == true) ? "<b style='color: red;'>*</b> " : "") . $this->title . "</label>";
        echo "</th>\n\r";
        echo "<td>\n\r";
        $id = $this->name;
        echo "<input type='checkbox' onfocus='getElementById(\"{$id}_helper\").style.display=\"block\";' onblur='getElementById(\"{$id}_helper\").style.display=\"none\";' name='{$this->name}' id='{$id}' value='{$this->default_value}' " . (($this->default_value=='1') ? "checked='checked'" : "") . "  />\n\r";
        echo "<input type='hidden' name='{$this->name}_required' id='{$id}_required' value='{$this->required}' />\n\r";
        //echo "<span id='{$id}_helper' class='helper'>(?) {$this->helper}</span>\n\r";
        echo "</td>\n\r";
        echo "</tr>\n\r";
    }

    private function build_file() {
        echo "<tr>\n\r";
        echo "<th>\n\r";
        echo "<label>\n\r" . (($this->required == true) ? "<b style='color: red;'>*</b> " : "") . $this->title . "</label>";
        echo "</th>\n\r";
        echo "<td>\n\r";
        echo "<input type='file' onfocus='getElementById(\"{$this->name}_helper\").style.display=\"block\";' onblur='getElementById(\"{$this->name}_helper\").style.display=\"none\";' name='{$this->name}' id='{$this->name}' size='{$this->size}' />\n\r";
        echo "<input type='hidden' name='{$this->name}_required' id='{$this->name}_required' value='{$this->required}' />\n\r";
        echo "<span id='{$this->name}_helper' class='helper'>(?) {$this->helper}</span>\n\r";
        echo "</td>\n\r";
        echo "</tr>\n\r";
    }

}

?>
