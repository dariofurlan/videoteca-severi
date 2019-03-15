<?php
require_once 'resources.php';
require_once 'vars.php';


class Database {

    private $conn;

    function __construct() {
        $this->conn = new mysqli(HOST, USER, PASSWORD, DB);
        if ($this->conn->connect_error)
            throw new Error("Errore connesione al database");
    }

    /**
     * @param string $resource
     * @param array $params
     *
     * @return array query completa
     */
    function prepare_query($resource, $params) {
        $query = [];

        foreach($params as $key=> $value) {
            $params[$key] = stripslashes($params[$key]);
            $params[$key] = mysqli_real_escape_string($this->conn, $params[$key]);
        }

        // TODO all sql injection checks

        switch ($resource) {
            case "img":
                array_push($query, "SELECT "); // TODO
                break;
            case "dvd":
                $campi = "Catalogo, Titolo, Regia, Tipo, Genere, Anno, Lingua_Originale, Sottotitoli, Disponibilita";
                if (count($params)===0) array_push($query, "SELECT $campi FROM DVD ORDER BY(Titolo)");
                $joins = "";
                $where = [];

                foreach ($params as $key=>$value) {
                    switch ($key) {
                        case "titolo":
                        case "regia":
                        case "anno":
                        case "tipo":
                            // caso "normale" nessun join
                            array_push($where,"$key = '$value'");
                            break;
                        case "genere":
                            $joins.= " INNER JOIN GENERE ON DVD.Genere = GENERE.Id_Genere";
                            array_push($where,"Nome_Genere = '$value'");
                            break;
                        case "lingua_audio":
                            //TODO  correct the query
                            $joins.= "";
                            array_push($where, " = '$value'");
                            break;
                        case "lingua_sottotitoli":
                            $joins.= " INNER JOIN SOTTOTITOLATO_IN ON DVD.Inventario = SOTTOTITOLATO_IN.Inventario";
                            array_push($where, "Nome_Lingua = $value");
                            break;
                    }
                }
                // titolo, regia, anno, tipo -> DVD

                // genere -> DVD, GENERE

                // lingua_sottotitoli -> dvd sottotitolato_in

                array_push($query, "SELECT $campi FROM DVD $joins WHERE ");
                break;
            case "list":
                if (count($params)===0)
                    break;
                foreach($params as $key=>$value) {
                    switch ($key) {
                        case "tipo":
                        case "regia":
                        case "anno":
                            array_push($query, "SELECT DISTINCT $key FROM DVD");
                            break;
                        case 'genere':
                            array_push($query, "SELECT DISTINCT Nome_Genere FROM Genere");
                            break;
                        case 'lingua_audio':
                        case 'lingua_sottotitoli':
                            array_push($query, "SELECT DISTINCT Nome_Lingua FROM LINGUE");
                            break;
                    }
                }
                break;
        }
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
