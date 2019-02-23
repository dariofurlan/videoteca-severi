<?php

class Request {

    static $required = ["img" => ["id"], "dvd" => []];
    static $optionals = ["img" => [], "dvd" => ["categoria", "regia"]];

    private $path = "";
    private $cleaned = [];
    private $checked = ["path" => false, "get" => false, "filtred" => false];

    /**
     * @return boolean true or false (404)
     */
    function check_path() {
        if (isset($_SERVER["PATH_INFO"]) && !empty($_SERVER["PATH_INFO"])) {
            $path = str_replace("/", "", $_SERVER["PATH_INFO"]);
            if ($path === "dvd" || $path === "img") {
                $this->path = $path;
                $this->checked["path"] = true;
                return true;
            }
        }
        return false;
    }

    /**
     * @return string risorsa richiesta
     */
    function get_path() {
        return $this->path;
    }

    /**
     * @return boolean true or false (400)
     */
    function check_GET() {
        if ($this->checked["path"]) {
            // controllo generico sui campi richiesti
            foreach (Request::$required[$this->path] as $item) {
                if (!isset($_GET[$item]) || empty($_GET[$item])) return false; else
                    $this->cleaned[$item] = $_GET[$item];
            }
            // controllo generico sui campi opzionali
            foreach (Request::$optionals[$this->path] as $item) {
                if (isset($_GET[$item]) && !empty($_GET[$item])) $this->cleaned[$item] = $_GET[$item];
            }

            // controlli specifici
            if ($this->path === "img") {
                if (!filter_var($_GET["id"], FILTER_VALIDATE_INT)) return false;
            } elseif ($this->path === "dvd") {
            }

            $this->checked["get"] = true;
            return true;
        }
        return false;
    }

    /**
     * @return array tutti i parametri get filtrati
     */
    function get_GET() {
        return $this->cleaned;
    }
}
