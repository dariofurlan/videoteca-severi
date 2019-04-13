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
        $queries = [];
        $result = [];

        foreach($params as $key=> $value) {
            $params[$key] = stripslashes($params[$key]);
            $params[$key] = mysqli_real_escape_string($this->conn, $params[$key]);
        }

        // TODO all sql injection checks

        switch ($resource) {
            case "img":
                $queries["img"] =  "SELECT "; // TODO
                break;
            case "dvd":
                $campi = "Catalogo, Titolo, Regia, Genere, Anno, Lingua_Originale, Sottotitoli, Disponibilita";
                if (count($params)===0) $queries["dvd"] = "SELECT $campi FROM DVD ORDER BY(Titolo)";
                $joins = "";
                $where = "";

                foreach ($params as $key=>$value) {
                  switch ($key) {
                    case "titolo":
                    case "regia":
                    case "anno":
                    case "tipo":
                        // caso "normale" nessun join
                        $where.= "$key = '$value'";
                        break;
                    case "genere":
                        $joins.= " INNER JOIN GENERE ON DVD.Genere = GENERE.Id_Genere";
                        $where.= "Nome_Genere = '$value'";
                        break;
                    case "lingua_audio":
                        //TODO  correct the query
                        $joins.= "";
                        $where.= " = '$value'";
                        break;
                    case "lingua_sottotitoli":
                        $joins.= " INNER JOIN SOTTOTITOLATO_IN ON DVD.Inventario = SOTTOTITOLATO_IN.Inventario";
                        $where.= "Nome_Lingua = '$value'";
                        break;
                  }
                }
                // titolo, regia, anno, tipo -> DVD
                // genere -> DVD, GENERE
                // lingua_sottotitoli -> dvd sottotitolato_in
                $queries["dvd"] = "SELECT $campi FROM DVD $joins ". (($where!=="")?"WHERE $where":"");
                break;
            case "list":
                if (count($params)===0)
                    break;
                foreach($params as $key=>$value) {
                    switch ($key) {
                        case "tipo":
                        case "regia":
                        case "anno":
                            $queries[$key] = "SELECT DISTINCT ".ucfirst($key)." FROM DVD";
                            break;
                        case 'genere':
                            $queries[$key] = "SELECT DISTINCT Nome_Genere FROM GENERE";
                            break;
                        case 'lingua_audio':
                        case 'lingua_sottotitoli':
                            $queries[$key] = "SELECT DISTINCT Nome_Lingua FROM LINGUE";
                            break;
                    }
                }
                break;
        }

        switch ($resource) {
          case "img":

            break;
          case "dvd":
            $query = $queries["dvd"];
            // print_r($query);
            // echo "<br/>";
            $r = $this->conn->query($query);
            if (!$r)
              die("Errore query ".mysqli_error($this->conn));
            $aaa = $r->fetch_all();
            $result["dvd"] = $aaa;
            break;
          case "list":
            foreach($queries as $key=>$query) {
              $r = $this->conn->query($query);
              if (!$r)
                die("Errore query ".mysqli_error($this->conn));
              $aaa = [];
              while($row = $r->fetch_array()) {
                array_push($aaa,$row[0]);
              }
              $result[$key] = $aaa;
            }
            break;
        }
        return $result;
    }
}
