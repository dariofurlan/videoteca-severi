<?php

class Database {

    function __construct() {
        echo "A";
    }

    /**
     * @param array $cleaned_GET
     *
     * @return string query completa
     */
    function prepare_query($cleaned_GET) {
        $query = "";

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
