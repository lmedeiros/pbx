<?php

define('DEFAULT_RECORDS_PAGE', 20);

class Paging {

    private $records = null;
    private $totalRecords = 0;
    private $totalPages;
    private $data = array();

    public function __construct($result, $sort_by, $direction='ASC', $recordsPerPage=DEFAULT_RECORDS_PAGE) {
        (!isset($_GET['pageNumber'])) ? $_GET['pageNumber'] = 1 : "";

        $this->records = $result;
        $this->records = sort_array_by($this->records, $sort_by, $direction);
        $this->totalRecords = ($result !== false) ? count($result) : 0;
        $this->totalPages = div_arred_up($this->totalRecords, $recordsPerPage);
        $actualPage = $_GET['pageNumber'];
        $firstRecord = (int) ($recordsPerPage * ($actualPage - 1));
        $this->totalRecords = $this->totalRecords - $firstRecord;
        $this->data = $this->totalRecords > 0 ? array_slice($this->records, $firstRecord, $recordsPerPage) : array();
    }

    public function getRecords() {
        return $this->data;
    }

    public function getTotalRecords() {
        return $this->totalRecords;
    }

    public function isEmpty() {
        return ($this->records == null || count($this->records) <= 0);
    }

    public function drawPages() {
        for ($i = 1; $i <= $this->totalPages; $i++) {
            ($i < 10) ? $a = "0" . (string) $i : $a = (string) $i;
            if ($i == $_GET['pageNumber']) {
                echo "<a style='float: left; width:42px; color: #AAAAAA; text-decoration: none;display:block; font-size: 13px; text-align:center'>&nbsp;&nbsp; " . $a . " &nbsp;&nbsp;</a> ";
            } else {
                $params = arrayAsString($_GET) . "&amp;pageNumber={$i}";
                echo "<a onclick='document.getElementById(\"filters\").action=\"" . $_SERVER['PHP_SELF'] . $params ."\"; document.getElementById(\"filters\").submit(); return false;' onmouseout='this.style.backgroundColor=\"#AAAAAA\"' onmouseover='this.style.backgroundColor=\"#ff7e00\"' style='text-decoration: none; float: left; background-color: #AAAAAA; width:42px; color: #FFFFFF; text-align:center; border: 1px solid #CCCCCC; font-size: 13px;' href='" . $_SERVER['PHP_SELF'] . "{$params}'>&nbsp;&nbsp; " . $a . " &nbsp;&nbsp;</a> ";
            }
        }
    }

}

?>