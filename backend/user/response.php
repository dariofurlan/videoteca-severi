<?php

class Response {
    /**
     *
     * @param string $code : codice errore
     * @param string $desc : descrizione errore (non obbligatoria)
     */
    function error($code, $desc = "") {
        $res = [];
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
            default:
                return;
        }
        http_response_code($code);
        die(json_encode($res));
    }

    /**
     *
     * @param string $num_rows : numero di righe
     * @param string $contenuto : risultato della query
     */
    function ok($num_rows, $contenuto = "") {
        $res = [];
        if ($num_rows > 0) {
            $code = 200;
            $res["num_rows"] = $num_rows;
            $res["contenuto"] = $contenuto;
        } else {
            $code = 204;
            $res["num_rows"] = 0;
        }
        http_response_code($code);
        die(json_encode($res));
    }
}
