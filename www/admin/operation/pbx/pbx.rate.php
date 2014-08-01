<?php 
require("framework/fwk.table.php");
new CreateHome(@$_GET['operation'], array(0), 0);
?>
<form method="get" name="report" id="report" action="?<?php echo "operation=" . $_GET['operation']; ?>">
    <input type="hidden" value="<?php echo $_GET['operation']; ?>" name="operation" id="operation" />
    <div style="float:left; margin-bottom: 30px;">
        <table class="filter_cdr" border="0" cellpadding="4" style="padding: 5px;  ">
            <tr>
                <td><h3 style="float: right;">Digite o nome da Localidade: </h3></td>
                <td><input style="font-size: 15px;" value="<?php echo (@isset($_GET['description'])) ? @$_GET['description'] : "" ?>" type="text" id="description" name="description" size="30" /></td>
                <td>
                    <input type="hidden" name="filter" id="filter" value="1"/>
                    <input type="submit" style="font-size: 14px; " value="Pesquisar Tarifas"/>
                </td>
            </tr>
        </table>
    </div>
</form>

<?php
if (isset($_GET['filter']) && $_GET['filter'] == '1') {
    # 1 - CLASS INCLUDES
    

    # 2 - FILTER FUNCTIONS

    function filterBoolean($value) {
        if ($value == '0') {
            return 'No';
        } elseif ($value == '1') {
            return 'Yes';
        }
        return 'Unknown';
    }

    # 3 - RECORDSET FUNCTION

    function getUser() {
        if(!isset($_GET['description'])) {
            $description='';
        } else {
            $description=$_GET['description'];
        }
        $users = $GLOBALS['db']->selectAll("SELECT * FROM pbx_rate WHERE description LIKE '%{$description}%' AND " . query_filter());
        if ($users) {
            return $users;
        } else {
            return false;
        }
    }

    # 4 - LIST TABLE CONFIG
    #$headers column names
    $headers = array("Localidade", "Número", "Valor/Min (R$)", "Opções");

    #$columns database column names, or parameter for the Filter Function
    $columns = array("description", "pattern", "rate", "ACTIONS");
    #$actions array of operations ID related to the page type LIST
    $actions = array(36);
    #$action_parameters _GET parameters to the functions related, key = GET name, value = @database field
    $action_parameters = array(
        36 => array(
            "id" => "@pbx_rate_id"
        )
    );

    # 5 - TABLE BUILD
    #populate table 1arg - List Title, 2arg - Function which returns data recordset
    $table = new DisplayTable(getUser(), 'description', 'ASC', 200);


    #set table header column names
    $table->setHeaders($headers);
    #set table database columns
    $table->setColumns($columns);
    #NO data message
    $table->setEmptyMessage("There is no rates.");
    #add value filter, 1st arg = database column array index, 2arg = filter function name
    //$table->addFilter(2, "filterSys_user_id");
    //$table->addFilter(3, "filterBoolean");
    $table->setActionsParameters($action_parameters);
    #set table list actions and parameters
    $table->setActions($actions);
    //$table->addConfirmActions($actions_confirm);
    #show tables
    
    $table->displayTable();
}
?>
