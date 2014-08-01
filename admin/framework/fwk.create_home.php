<?php

class CreateHome {

    private $operation;
    private $back_operation_id;

    function __construct($fwk_operation_id, $operations, $back_operation_id) {
        $this->back_operation_id = $back_operation_id;
        
        echo "<div id='icon_holder'>";
        $this->write_home_title($fwk_operation_id);
        foreach ($operations as $param => $operation_id) {
            $this->operation = $this->load_home_item($operation_id);
            if ($this->operation) {
                $this->write_icon($this->operation, $param);
            } else {
                continue;
            }
        }
        $back_operation = $this->load_home_item($this->back_operation_id);
        if ($back_operation) {
            $this->write_icon($back_operation, $param, true);
        }
        echo "</div>";
    }

    private function write_home_title($fwk_operation_id) {
        $this->operation = $this->load_home_item($fwk_operation_id);
        if ($this->operation) {
            echo "<div id='home_title'>\n";
            echo "<h1>" . "<img style='float: left; width: 38px; height: 38px; margin-right: 15px; margin-top: 5px;' src='framework/fwk.image_load.php?id=" . $this->operation['fwk_operation_id'] . "' alt='' />" . ($this->operation['name']) . "</h1>\n";
            echo "<h2>" . ($this->operation['description']) . "</h2>\n";
            echo "</div>\n\n";
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

    public function write_icon($operation,$param, $back=false) {
        echo "<div class='home_icon'" .
        " onmouseover=" . "'this.style.background=\"#ddd\"' " .
        " onmouseout=" . "'this.style.background=\"#fefefe\"'>";
        echo "<p class='home_icon'>\n";
        echo "<a title='{$operation['description']}' href='?operation={$operation['fwk_operation_id']}&amp;id={$param}'>\n";
        if ($back == false) {
            echo "<img class='home_icon' src='framework/fwk.image_load.php?id=" . $operation['fwk_operation_id'] . "' alt='icon' /></a>\n";
        } else {
            echo "<img class='home_icon' src='framework/fwk.imagetb_load.php?id=9' alt='icon' /></a>\n";
        }
        echo "</p>\n";
        echo "<p class='home_icon'>\n";
        echo "<a  title='{$operation['description']}' href='?operation={$operation['fwk_operation_id']}&amp;id={$param}'>" . ($operation['name']) . "</a>\n";
        echo "</p>\n";
        echo "</div>\n";
    }

}

?>
