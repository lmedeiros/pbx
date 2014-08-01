<?php
ini_set('error_reporting', E_ALL - E_NOTICE);
ini_set('display_errors', 1);
new CreateHome(@$_GET['operation'], array(0),0);
?>


<form method="get" name="report" id="report" action="?<?php echo "operation=" . $_GET['operation']; ?>">
    <input type="hidden" value="<?php echo $_GET['operation']; ?>" name="operation" id="operation" />
    <div style="float:left; margin-bottom: 30px;">
        <h3 style="margin-left: 10px; margin-bottom: 3px;">Filtros de Relatório</h3>
        <table class="filter_cdr" border="0" cellpadding="4" style="padding: 5px;  ">
            <tr>
                <td style="text-align: right"><strong>Número ou Nome do Ramal</strong></td>
                <td colspan="7"> <input style="font-size: 15px;" value="<?php echo (@isset($_GET['clid'])) ? @$_GET['clid'] : "" ?>" type="text" id="clid" name="clid" size="30" /></td>
            </tr>
            <tr>
                <td style="text-align: right"><strong>Número Discado</strong></td>
                <td colspan="7"> <input style="font-size: 15px;" value="<?php echo (@isset($_GET['dst'])) ? @$_GET['dst'] : "" ?>" type="text" id="dst" name="dst" size="30" /></td>
            </tr>
            <tr>
                <td style="text-align: right"><strong>Desde</strong></td>
                <td>
                     <select name="calldate_start_year" id="calldate_start_year">
                        <option <?php echo (!isset($_GET['calldate_start_year']) && date("Y", time()) == '2010') ? "selected='selected'" : ((@$_GET['calldate_start_year'] == "2010") ? "selected='selected'" : "") ?> value="2010">2010</option>
                        <option <?php echo (!isset($_GET['calldate_start_year']) && date("Y", time()) == '2011') ? "selected='selected'" : ((@$_GET['calldate_start_year'] == "2011") ? "selected='selected'" : "") ?> value="2011">2011</option>
                        <option <?php echo (!isset($_GET['calldate_start_year']) && date("Y", time()) == '2012') ? "selected='selected'" : ((@$_GET['calldate_start_year'] == "2012") ? "selected='selected'" : "") ?> value="2012">2012</option>
                        <option <?php echo (!isset($_GET['calldate_start_year']) && date("Y", time()) == '2013') ? "selected='selected'" : ((@$_GET['calldate_start_year'] == "2013") ? "selected='selected'" : "") ?> value="2012">2013</option>
                    </select>
                </td>
                <td>
                     <select name="calldate_start_month" id="calldate_start_month">
                        <option <?php echo (!isset($_GET['calldate_start_month']) && date("m", time()) == '1') ? "selected='selected'" : ((@$_GET['calldate_start_month'] == "01") ? "selected='selected'" : "") ?> value="01">Jan</option>
                        <option <?php echo (!isset($_GET['calldate_start_month']) && date("m", time()) == '2') ? "selected='selected'" : ((@$_GET['calldate_start_month'] == "02") ? "selected='selected'" : "") ?> value="02">Fev</option>
                        <option <?php echo (!isset($_GET['calldate_start_month']) && date("m", time()) == '3') ? "selected='selected'" : ((@$_GET['calldate_start_month'] == "03") ? "selected='selected'" : "") ?> value="03">Mar</option>
                        <option <?php echo (!isset($_GET['calldate_start_month']) && date("m", time()) == '4') ? "selected='selected'" : ((@$_GET['calldate_start_month'] == "04") ? "selected='selected'" : "") ?> value="04">Abr</option>
                        <option <?php echo (!isset($_GET['calldate_start_month']) && date("m", time()) == '5') ? "selected='selected'" : ((@$_GET['calldate_start_month'] == "05") ? "selected='selected'" : "") ?> value="05">Mai</option>
                        <option <?php echo (!isset($_GET['calldate_start_month']) && date("m", time()) == '6') ? "selected='selected'" : ((@$_GET['calldate_start_month'] == "06") ? "selected='selected'" : "") ?> value="06">Jun</option>
                        <option <?php echo (!isset($_GET['calldate_start_month']) && date("m", time()) == '7') ? "selected='selected'" : ((@$_GET['calldate_start_month'] == "07") ? "selected='selected'" : "") ?> value="07">Jul</option>
                        <option <?php echo (!isset($_GET['calldate_start_month']) && date("m", time()) == '8') ? "selected='selected'" : ((@$_GET['calldate_start_month'] == "08") ? "selected='selected'" : "") ?> value="08">Ago</option>
                        <option <?php echo (!isset($_GET['calldate_start_month']) && date("m", time()) == '9') ? "selected='selected'" : ((@$_GET['calldate_start_month'] == "09") ? "selected='selected'" : "") ?> value="09">Set</option>
                        <option <?php echo (!isset($_GET['calldate_start_month']) && date("m", time()) == '10') ? "selected='selected'" : ((@$_GET['calldate_start_month'] == "10") ? "selected='selected'" : "") ?> value="10">Out</option>
                        <option <?php echo (!isset($_GET['calldate_start_month']) && date("m", time()) == '11') ? "selected='selected'" : ((@$_GET['calldate_start_month'] == "11") ? "selected='selected'" : "") ?> value="11">Nov</option>
                        <option <?php echo (!isset($_GET['calldate_start_month']) && date("m", time()) == '12') ? "selected='selected'" : ((@$_GET['calldate_start_month'] == "12") ? "selected='selected'" : "") ?> value="12">Dez</option>
                    </select>
                </td>
                <td>
                     <select name="calldate_start_day" id="calldate_start_day">
                        <?php
                        $days = 31;
                        for ($i = 1; $i <= $days; $i++) {
                            if (strlen($i) < 2) {
                                $day = '0' . $i;
                            } else {
                                $day = $i;
                            }
                            echo "<option " . ((!isset($_GET['calldate_start_day']) && date("d", time()) == $i) ? " selected='selected' " : ((@$_GET['calldate_start_day'] == $day) ? "selected='selected'" : "")) . " value='{$day}'>{$day}</option>\n\r";
                        }
                        ?>
                    </select>
                </td>
                <td></td>

            </tr>
            <tr>
                <td style="text-align: right"><strong>Até</strong></td>
                <td>
                    <select name="calldate_end_year" id="calldate_end_year">
                        <option <?php echo (!isset($_GET['calldate_end_year']) && date("Y", time()) == '2010') ? "selected='selected'" : ((@$_GET['calldate_end_year'] == "2010") ? "selected='selected'" : "") ?> value="2010">2010</option>
                        <option <?php echo (!isset($_GET['calldate_end_year']) && date("Y", time()) == '2011') ? "selected='selected'" : ((@$_GET['calldate_end_year'] == "2011") ? "selected='selected'" : "") ?> value="2011">2011</option>
                        <option <?php echo (!isset($_GET['calldate_end_year']) && date("Y", time()) == '2012') ? "selected='selected'" : ((@$_GET['calldate_end_year'] == "2012") ? "selected='selected'" : "") ?> value="2012">2012</option>
                        <option <?php echo (!isset($_GET['calldate_end_year']) && date("Y", time()) == '2013') ? "selected='selected'" : ((@$_GET['calldate_end_year'] == "2013") ? "selected='selected'" : "") ?> value="2012">2013</option>
                    </select>
                </td>
                <td>
                     <select name="calldate_end_month" id="calldate_end_month">
                        <option <?php echo (!isset($_GET['calldate_end_month']) && date("m", time()) == '1') ? "selected='selected'" : ((@$_GET['calldate_end_month'] == "01") ? "selected='selected'" : "") ?> value="01">Jan</option>
                        <option <?php echo (!isset($_GET['calldate_end_month']) && date("m", time()) == '2') ? "selected='selected'" : ((@$_GET['calldate_end_month'] == "02") ? "selected='selected'" : "") ?> value="02">Fev</option>
                        <option <?php echo (!isset($_GET['calldate_end_month']) && date("m", time()) == '3') ? "selected='selected'" : ((@$_GET['calldate_end_month'] == "03") ? "selected='selected'" : "") ?> value="03">Mar</option>
                        <option <?php echo (!isset($_GET['calldate_end_month']) && date("m", time()) == '4') ? "selected='selected'" : ((@$_GET['calldate_end_month'] == "04") ? "selected='selected'" : "") ?> value="04">Abr</option>
                        <option <?php echo (!isset($_GET['calldate_end_month']) && date("m", time()) == '5') ? "selected='selected'" : ((@$_GET['calldate_end_month'] == "05") ? "selected='selected'" : "") ?> value="05">Mai</option>
                        <option <?php echo (!isset($_GET['calldate_end_month']) && date("m", time()) == '6') ? "selected='selected'" : ((@$_GET['calldate_end_month'] == "06") ? "selected='selected'" : "") ?> value="06">Jun</option>
                        <option <?php echo (!isset($_GET['calldate_end_month']) && date("m", time()) == '7') ? "selected='selected'" : ((@$_GET['calldate_end_month'] == "07") ? "selected='selected'" : "") ?> value="07">Jul</option>
                        <option <?php echo (!isset($_GET['calldate_end_month']) && date("m", time()) == '8') ? "selected='selected'" : ((@$_GET['calldate_end_month'] == "08") ? "selected='selected'" : "") ?> value="08">Ago</option>
                        <option <?php echo (!isset($_GET['calldate_end_month']) && date("m", time()) == '9') ? "selected='selected'" : ((@$_GET['calldate_end_month'] == "09") ? "selected='selected'" : "") ?> value="09">Set</option>
                        <option <?php echo (!isset($_GET['calldate_end_month']) && date("m", time()) == '10') ? "selected='selected'" : ((@$_GET['calldate_end_month'] == "10") ? "selected='selected'" : "") ?> value="10">Out</option>
                        <option <?php echo (!isset($_GET['calldate_end_month']) && date("m", time()) == '11') ? "selected='selected'" : ((@$_GET['calldate_end_month'] == "11") ? "selected='selected'" : "") ?> value="11">Nov</option>
                        <option <?php echo (!isset($_GET['calldate_end_month']) && date("m", time()) == '12') ? "selected='selected'" : ((@$_GET['calldate_end_month'] == "12") ? "selected='selected'" : "") ?> value="12">Dez</option>
                    </select>
                </td>
                <td>
                    <select name="calldate_end_day" id="calldate_end_day">
                        <?php
                        $days = 31;
                        for ($i = 1; $i <= $days; $i++) {
                            if (strlen($i) < 2) {
                                $day = '0' . $i;
                            } else {
                                $day = $i;
                            }
                            echo "<option " . ((!isset($_GET['calldate_end_day']) && date("d", time()) == $i) ? " selected='selected' " : ((@$_GET['calldate_end_day'] == $day) ? "selected='selected'" : "")) . " value='{$day}'>{$day}</option>\n\r";
                        }
                        ?>
                    </select>
                </td>
                <td></td>
            <tr>
                <td style="text-align: right"><strong>Inicio Desde</strong></td>
                <td>
                     <select name="calldate_start_hour" id="calldate_start_hour">
                        <?php
                        $hours = 24;
                        for ($i = 0; $i < $hours; $i++) {
                            if (strlen($i) < 2) {
                                $hour = '0' . $i;
                            } else {
                                $hour = $i;
                            }
                            echo "<option " . ((!isset($_GET['calldate_start_hour']) && $hour == "00") ? " selected='selected' " : ((@$_GET['calldate_start_hour'] == $hour) ? "selected='selected'" : "")) . " value='{$hour}'>{$hour}</option>\n";
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <select name="calldate_start_minute" id="calldate_start_minute">
                        <?php
                        $minute = 60;
                        for ($i = 0; $i < $minute; $i++) {
                            if (strlen($i) < 2) {
                                $min = '0' . $i;
                            } else {
                                $min = $i;
                            }
                            echo "<option " . ((!isset($_GET['calldate_start_minute']) && "00" == $min) ? " selected='selected' " : ((@$_GET['calldate_start_minute'] == $min) ? "selected='selected'" : "")) . " value='{$min}'>{$min}</option>\n\r";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="text-align: right"><strong>Inicio até</strong></td>
                <td>
                     <select name="calldate_end_hour" id="calldate_hour">
                        <?php
                        $hours = 24;
                        for ($i = 0; $i < $hours; $i++) {
                            if (strlen($i) < 2) {
                                $hour = '0' . $i;
                            } else {
                                $hour = $i;
                            }
                            echo "<option " . ((!isset($_GET['calldate_end_hour']) && $hour == "23") ? " selected='selected' " : ((@$_GET['calldate_end_hour'] == $hour) ? "selected='selected'" : "")) . " value='{$hour}'>{$hour}</option>\n";
                        }
                        ?>
                    </select>
                </td>
                <td>
                     <select name="calldate_end_minute" id="calldate_end_minute">
                        <?php
                        $minute = 60;
                        for ($i = 0; $i < $minute; $i++) {
                            if (strlen($i) < 2) {
                                $min = '0' . $i;
                            } else {
                                $min = $i;
                            }
                            echo "<option " . ((!isset($_GET['calldate_end_minute']) && $min == "59") ? " selected='selected' " : ((@$_GET['calldate_end_minute'] == $min) ? "selected='selected'" : "")) . " value='{$min}'>{$min}</option>\n\r";
                        }
                        ?>
                    </select>
                </td>

            </tr>
        </table>
    </div>
    <div class="filter_cdr" style="float:right; margin-top: 0px;">
        <h3 style="margin-left: 10px; margin-bottom: 3px;">Tipo do Relatório</h3>

        <table border="0" cellpadding="4" style="padding: 5px;">
            <tr>
                <td>
                    <select style="font-size: 13px;" name="report_type" id="report_type">
                        <option <?php echo ((isset($_GET['report_type']) && $_GET['report_type'] == "total") ? "selected='selected'" : "") ?> value="total">Total Geral</option>
                        <option <?php echo ((isset($_GET['report_type']) && $_GET['report_type'] == "call_details") ? "selected='selected'" : "") ?> value="call_details">Detalhamento das Chamadas</option>
                        <option <?php echo ((isset($_GET['report_type']) && $_GET['report_type'] == "talk_overview") ? "selected='selected'" : (!isset($_GET['report_type'])) ? "selected='selected'" : "") ?> value="talk_overview">Chamadas por Duração </option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" style="font-size: 18px; " value="Visualizar Relatório"/>
                </td>
            </tr>
        </table>

    </div>
</form>

<?php
if (isset($_GET['report_type'])) {
    switch ($_GET['report_type']) {
        case "total":
            include("total.php");
            break;
        case "average_idle":
            include("average_idle.php");
            break;
        case "talk_overview":
            include("talk_overview.php");
            break;
        case "call_details":
            include("call_details.php");
            break;
        case "talk_duration":
            include("talk_duration.php");
            break;
        case "call_amount":
            include("call_amount.php");
            break;
        case "average_call":
            include("average_call.php");
            break;
    }
} else {
    include("talk_overview.php");
}


?>
    

