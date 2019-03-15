# **Back-end User API**

  Documentazione per interfacciarsi in modo corretto con l'API

* **URL**

  URL radice: `http://example.com/user_api.php`

* **Metodo:**

  `GET` | `POST`

* **Path**

  il path da aggiungere all'URL radice come fosse un percorso di cartelle
  per identificare delle risorse
  es:`http://example.com/user_api.php`**`/risorsa/`**

  * **Risorse**:
    * dvd
    * img


* **Parametri GET**

  * **img**

    `id=[id_immagine]`

  * **dvd**<br/>
    `limit=[unsigned integer]` numero di righe massime visualizzabili

    `categoria=[integer]`

    `regia=[alphanumeric]`
    

* **Parametri POST**

* **Codici di Risposta**

  * **Codice:** `200`, OK<br/>
    Contenuto: `{ num_rows:[numero_linee], contenuto:[] }`

  * **Codice:** `204`, Nessun Contenuto<br/>
    Contenuto: `{ 'num_rows':0 }`

  * **Codice:** `400`, Richiesta Errata<br/>
    Contenuto: `{ 'errore':'[descrizione dell'errore]' }`

  * **Codice:** `403`, Vietato: non ci sono i permessi necessari<br/>
    Contenuto: `{ 'errore':'Vietato' }`

  * **Codice:** `404`, Risorsa non trovata<br/>
    Contenuto: `{ 'errore':'Risorsa non trovata' }`

* **Esempio:**

  ```javascript
  $.ajax({
    url: "http://example.com/user_api.php/dvd",
    contentType: "application/json",
    dataType: "json",
    type : "GET",
    data: {
      categoria: "Azione",
      lingua_audio: "Italiano"
    },
    statusCode: {
      200: function() {
        console.log("OK");
      },
      204: function() {
        console.warn();("Nessun contenuto");
      },
      400: function() {
        console.error("Richiesta errata");
      },
      403: function() {
        console.error("Risorsa vietata");
      },
      404: function() {
        console.error("Risorsa non trovata");
      },
    }
    success : function(data, status) {
      console.log(r);
    },
    error : function(jqXHR, textStatus, errorThrown) {

    }
  });
  ```

* **Notes:**
