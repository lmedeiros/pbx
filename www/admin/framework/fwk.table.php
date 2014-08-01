<?php
require_once("framework/fwk.paging.php");

class DisplayTable {

    private $paging;
    private $order_by;
    private $titles;
    private $headers;
    private $columns;
    private $value_footer;
    private $emptyMSG;
    public $hasFilter = 1;
    private $actions;
    private $action_parameters;
    private $filters = array();
    private $confirm_actions = array();

    public function __construct($result_set, $order_by, $direction, $records_per_page = 10) {
        if (isset($_GET['ob']) && $_GET['ob'] != '') {
            $order_by = $_GET['ob'];
        }
        $this->order_by = $order_by;
        $this->paging = new Paging($result_set, $this->order_by, $direction, $records_per_page);
    }

    public function setHeaders($headers = array()) {
        $this->headers = $headers;
    }

    public function setValueFooter($value = "") {
        $this->value_footer = $value;
    }

    public function setTitle($value = "") {
        $this->titles = $value;
    }

    public function setColumns($columns = array()) {
        $this->columns = $columns;
    }

    public function setEmptyMessage($msg = "There are no records to be shown") {
        $this->emptyMSG = $msg;
    }

    public function setActions($actions = array("" => "")) {
        $this->actions = $actions;
    }

    public function setActionsParameters($parameters = array("" => "")) {
        $this->action_parameters = $parameters;
    }

    public function addFilter($columnIndex, $func) {
        if (!isset($this->filters[$columnIndex])) {
            $this->filters[$columnIndex] = $func;
        }
    }

    public function addConfirmActions($confirm_actions = array(0 => "")) {
        $this->confirm_actions = $confirm_actions;
    }

    private function showOperationButton($operation, $back = false, $id = 0) {
        echo "<div class='home_icon'" .
        " onmouseover=" . "'this.style.background=\"#E8F4D0\"' " .
        " onmouseout=" . "'this.style.background=\"#FFFFFF\"'>";
        echo "<p class='home_icon'>\n";
        echo "<a title='{$operation['description']}' href='?operation={$operation['fwk_operation_id']}&record_id={$id}'>\n";
        if ($back == false) {
            echo "<img class='home_icon' src='framework/fwk.image_load.php?id=" . $operation['fwk_operation_id'] . "' alt='icon' /></a>\n";
        } else {
            echo "<img class='home_icon' src='framework/fwk.imagetb_load.php?id=9' alt='icon' /></a>\n";
        }
        echo "</p>\n";
        echo "<p class='home_icon'>\n";
        echo "<a  title='{$operation['description']}' href='?operation={$operation['fwk_operation_id']}&record_id={$id}'>" . ($operation['name']) . "</a>\n";
        echo "</p>\n";
        echo "</div>\n";
    }

    public function load_button($fwk_operation_id, $back = false, $id) {
        $operation = $GLOBALS['controller']->load_operation($fwk_operation_id);

        if (isset($operation) && $operation != "FORBIDDEN" && $operation != "NOT_FOUND") {
            $this->showOperationButton($operation, false, $id);
            return true;
        } else {
            return false;
        }
    }

    function load_link_big($code, $param, $confirm = false, $confirm_msg = "") {
        //debug($code);
        //debug($param);
        //debug($confirm);
        //debug($confirm_msg);
        $operation = $this->load_operation($code);
        //debug($operation);
        if ($operation != false) {
            $operation['name'] = explode(" ", $operation['name']);
            if ($confirm) {
                $script = "<a style='margin-right: 30px;' title='" . ($operation['description']) . "' href='javascript: if (confirm(\"{$confirm_msg}\")) { window.location.href=\"?operation=" . $operation['fwk_operation_id'] . '&amp;' . $param . "\" }'>";
                return $script . "<img style='width: 28px; height: 28px; margin-right: 5px; ' src='framework/fwk.image_load.php?id={$code}' alt='' />" . ($operation['name'][0]) . '</a> ';
            } else {
                $link = "<a style='margin-right: 30px;' title='" . ($operation['description']) . "' href='?boxed=1&amp;operation=" . $operation['fwk_operation_id'] . '&amp;' . $param . "'>";
                return $link . "<img style=' width: 28px; height: 28px; margin-right: 5px;' src='framework/fwk.image_load.php?id={$code}' alt='' />" . ($operation['name'][0]) . '</a> ';
            }
        }
    }

    function load_link($code, $param, $confirm = false, $confirm_msg = "") {
        //debug($code);
        //debug($param);
        //debug($confirm);
        //debug($confirm_msg);
        $operation = $this->load_operation($code);
        //debug($operation);
        if ($operation != false) {
            $operation['name'] = explode(" ", $operation['name']);
            if ($confirm) {
                $script = "<a style='margin-right: 10px;' title='" . ($operation['description']) . "' href='javascript: if (confirm(\"{$confirm_msg}\")) { window.location.href=\"?operation=" . $operation['fwk_operation_id'] . '&amp;' . $param . "\" }'>";
                return $script . "<img style=' width: 12px; height: 12px; margin-right: 5px; ' src='framework/fwk.image_load.php?id={$code}' alt='' />" . ($operation['name'][0]) . '</a> ';
            } else {
                $link = "<a style='margin-right: 10px;' title='" . ($operation['description']) . "' href='?boxed=1&amp;operation=" . $operation['fwk_operation_id'] . '&amp;' . $param . "'>";
                return $link . "<img style=' width: 12px; height: 12px; margin-right: 5px;' src='framework/fwk.image_load.php?id={$code}' alt='' />" . ($operation['name'][0]) . '</a> ';
            }
        }
    }

    private function load_operation($fwk_operation_id) {
        $operation = $GLOBALS['controller']->load_operation($fwk_operation_id);

        if (isset($operation) && $operation != "FORBIDDEN" && $operation != "NOT_FOUND") {
            return $operation;
        } else {
            return false;
        }
    }

    public function displayTable() {
        //if ($this->paging->isEmpty()) {
        //    message('warning', "Sem registros");
        //} else {
            ?>
            
            <div class='list' style='margin: 20px 20px 20px 20px;'>
                <h2 style='float: left;'><?php echo $this->titles; ?></h2>
                <table style='float: left; margin-bottom: 0px;'>
                    <thead>
                        <tr style='border-bottom: none !important;'>
                            <?php
                            foreach ($this->headers as $key => $header) {
                                if ($this->columns[$key] == 'ACTIONS') {
                                    echo "\n<th style='border-bottom: none !important;' scope='col'>\n" . ($header) . "\n</th>\n";
                                } else {
                                    if ($this->order_by != $this->columns[$key]) {
                                        echo "\n<th style='border-bottom: none !important;' scope='col'>\n<a style='text-decoration: underline; color: #FFFFFF;' href='#' onclick='document.getElementById(\"filters\").action=\"" . $_SERVER['REQUEST_URI'] . "&amp;ob={$this->columns[$key]}\"; document.getElementById(\"filters\").submit(); return false;'>" . ($header) ."</a>\n</th>\n";
                                    } else {
                                        echo "\n<th style='border-bottom: none !important;' scope='col'>\n" . ($header) . "\n</th>\n";
                                    }
                                }
                            }
                            if ($this->hasFilter == 1) {

                                echo "\n</tr>\n<tr style='border: none !important;'>\n<form name='filters' id='filters' action='?" . $_SERVER['QUERY_STRING'] . "' method='POST'>";

                                foreach ($this->headers as $key => $header) {
                                    if ($this->columns[$key] != 'ACTIONS') {
                                        if ($header != '') {
                                            echo "\n<th scope='col'>\n <select name='{$this->columns[$key]}_fo' id='{$this->columns[$key]}_fo'><option value=''>[Todos]</option><option " . ((@$_POST[$this->columns[$key] . "_fo"] == ' LIKE ') ? "selected='selected'" : "") . " value=' LIKE '>Igual</option><option " . ((@$_POST[$this->columns[$key] . "_fo"] == '>') ? "selected='selected'" : "") . " value='>'>Maior</option><option " . ((@$_POST[$this->columns[$key] . "_fo"] == '<') ? "selected='selected'" : "") . " value='<'>Menor</option><option " . ((@$_POST[$this->columns[$key] . "_fo"] == ' NOT LIKE ') ? "selected='selected'" : "") . " value=' NOT LIKE '>Diferente</option></select><input type='text' name='{$this->columns[$key]}_fv' id='{$this->columns[$key]}_fv' size='10' maxlength='11' value='" . @$_POST[$this->columns[$key] . "_fv"] . "' /> \n</th>\n";
                                        } else {
                                            echo "\n<th scope='col'>\n</th>\n";
                                        }
                                    } else {
                                        echo "\n<th scope='col'>\n<input type='submit' value='Filtrar' /> <input type='reset' onClick='resetForm(\"filters\"); return false;' value='Limpar'/></th>";
                                    }
                                }

                                echo "</form>";
                            }
                            //debug($_SERVER);
                            ?>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr style='background-color: #BBB;'>
                            <th scope='row'>&nbsp;&nbsp;Total:</th>
                            <td><?php echo $this->paging->getTotalRecords(); ?></td>
			    <td align='right' colspan='20' style='font-weight: bold;'><?php echo $this->value_footer; ?></td>
                        </tr>
                    </tfoot>
                    <tbody>

                        <?php
                        $countColor = 0;

                        foreach ($this->paging->getRecords() as $record) {

                            if ($countColor % 2 == 0) {
                                echo "<tr onmouseover='this.className=\"over\";' onmouseout='this.className=\"list\";'>\n";
                            } else {
                                echo "<tr class='odd' onmouseover='this.className=\"over\";' onmouseout='this.className=\"odd\";'>\n";
                            }

                            $c_index = 0; // column index used with filters
                            foreach ($this->columns as $column) {
                                if ($column == "ACTIONS") {
                                    if (($total_actions = count($this->actions)) > 0) {
                                        echo "\n<td style='text-align: center;'>\n";
                                        $index = 0;
                                        foreach ($this->actions as $action) {
                                            $parameters = "";

                                            $params = $this->action_parameters[$action];
                                            $i = 0;
                                            $t = count($params);

                                            /*
                                             *  Make parameter string param=val&param2=&val
                                             *
                                             *  if param starts with a @, then retrieve data from the database,
                                             *  	else retrieve from the especified parameters
                                             */
                                            foreach ($params as $param => $value) {
                                                $val = $value[0] == '@' ? $record[substr($value, 1)] : $value;
                                                $parameters .= "{$param}={$val}";
                                                if ($i++ < ($t - 1)) {
                                                    $parameters .= '&amp;';
                                                }
                                            }

                                            /*
                                             * If an action needs confirm before execute, load link with a javascript confirm
                                             */
                                            $perm = false;

                                            if (array_key_exists($action, $this->confirm_actions)) {
                                                $perm = $this->load_link($action, $parameters, true, $this->confirm_actions[$action]);
                                            } else {
                                                $perm = $this->load_link($action, $parameters, false);
                                            }
                                            echo $perm;
                                            if ($index++ < ($total_actions - 1) && $perm) {
                                                // echo "&nbsp;|&nbsp;";
                                            }
                                        }

                                        echo "\n</td>\n";
                                    }
                                } else {
                                    $data = @isset($record[$column]) ? $record[$column] : "";
                                    $function = null;

                                    if (isset($this->filters[$c_index])) {
                                        $function = $this->filters[$c_index];
                                    } else if (isset($this->filters[$column])) {
                                        $function = $this->filters[$column];
                                    }
                                    /**
                                     * If a filter was specified, then invoke a method using its name, passing data as parameter
                                     *  this is a dynamic method invocation
                                     */
                                    if ($function != null) {
                                        $data = $function($data);
                                    }
                                    echo "\n<td>\n" . $data . "\n</td>\n";
                                }
                                $c_index++;
                            }

                            echo "\n</tr>\n";

                            $countColor++;
                        }
                        ?>

                    </tbody>
                </table>
                <table style='float: left; border:0px;'>
                    <tr style='border:0px; padding:0px;'>
                        <td style="border:0px none; padding-left:0px;">
                            <?php
                            $this->paging->drawPages();
                            ?>
                        </td>
                    </tr>
                </table>
            </div>

            <?php
        }

    public function displayButtons() {
        echo "<br />";
        foreach ($this->paging->getRecords() as $record) {

            $c_index = 0; // column index used with filters
            foreach ($this->columns as $column) {
                if ($column == "ACTIONS") {
                    if (($total_actions = count($this->actions)) > 0) {
                        echo "\n<p style='text-align: center;'>\n";
                        $index = 0;
                        foreach ($this->actions as $action) {
                            $parameters = "";

                            $params = $this->action_parameters[$action];
                            $i = 0;
                            $t = count($params);

                            /*
                             *  Make parameter string param=val&param2=&val
                             *
                             *  if param starts with a @, then retrieve data from the database,
                             *  	else retrieve from the especified parameters
                             */
                            foreach ($params as $param => $value) {
                                $val = $value[0] == '@' ? $record[substr($value, 1)] : $value;
                                $parameters .= "{$param}={$val}";
                                if ($i++ < ($t - 1)) {
                                    $parameters .= '&amp;';
                                }
                            }

                            /*
                             * If an action needs confirm before execute, load link with a javascript confirm
                             */
                            $perm = false;
                            echo "<span style='color:#629632;  font-size: 22px;'>";
                            if (array_key_exists($action, $this->confirm_actions)) {
                                $perm = $this->load_link_big($action, $parameters, true, $this->confirm_actions[$action]);
                            } else {
                                $perm = $this->load_link_big($action, $parameters, false);
                            }
                            echo $perm;
                            echo "</span>";
                        }
                    }
                } else {
                    $data = @isset($record[$column]) ? $record[$column] : "";
                    $function = null;

                    if (isset($this->filters[$c_index])) {
                        $function = $this->filters[$c_index];
                    } else if (isset($this->filters[$column])) {
                        $function = $this->filters[$column];
                    }
                    /**
                     * If a filter was specified, then invoke a method using its name, passing data as parameter
                     *  this is a dynamic method invocation
                     */
                    if ($function != null) {
                        $data = $function($data);
                    }
                }
                $c_index++;
            }
        }
        ?>

        </p>

        <?php
    }

}

//#############################################
?>
