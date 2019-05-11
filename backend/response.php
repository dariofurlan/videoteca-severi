<?php

class Response {

    /**
     *
     * @param string $code : codice errore
     * @param string $desc : descrizione errore (non obbligatoria)
     */
    function error($code, $desc = "") {
        $res = [];
        if (isset($desc) && !empty($desc) && is_string($desc)) {
          $res["errore"] = $desc;
        } else
          switch ($code) {
                case 400:
                    $res["errore"] = "Richiesta Errata";
                    break;
                case 403:
                    $res["errore"] = "Vietato";
                    break;
                case 404:
                    $res["errore"] = "Risorsa non trovata";
                    break;
                case 500:
                    $res["errore"] = "Errore interno";
                    break;
                default:
                    return;
          }
        echo json_encode($res);
        http_response_code($code);
        exit();
    }

    /**
     *
     * @param string $num_rows : numero di righe
     * @param string $contenuto : risultato della query
     */
    function ok($contenuto = "{}") {
        $code = 200;
        $res = array();
        $res["contenuto"] = $contenuto;
        $json =  json_encode($res, JSON_UNESCAPED_UNICODE);
        $jsonError = json_last_error();
        if ($jsonError != JSON_ERROR_NONE) {
          throw new Exception("Errore Json");
          return;
        }
        echo $json;
        http_response_code($code);
        exit();
    }
}
