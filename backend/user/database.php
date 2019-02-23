<?php
define ("USER", "5id31");
define ("PASSWORD", "5id31");
define ("HOST", "10.0.1.252");
define ("DB", "5id31");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

class Database {

    function __construct() {
        $conn = new mysqli(HOST, USER, PASSWORD, DB);
    }

    /**
     * @param array $cleaned_GET
     * @param array $cleaned_GET
     *
     * @return string query completa
     */
    function prepare_query($resource, $cleaned_GET) {
        $query;

        return $query;
    }

    /**
     * @param $query
     *
     * @return array contenuto
     */
    function exec($query) {
        $result = [];

        return $result;
    }


}
