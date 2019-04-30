<?php
//se il login è ok si attiva la sessione
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
} else {
    echo "Identificazione Riuscita</br>";
    echo "username: " . " " . $_SESSION["username"];
}
?>


<html>
    <head>
        <title>Ricerca</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css" integrity="sha384-PDle/QlgIONtM1aqA2Qemk5gPOE7wFq8+Em+G/hmo5Iq0CCmYZLv3fVRDJ4MMwEA" crossorigin="anonymous">
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <style>
            .centra {
                width: 80%;
            }

            .table {
                border-radius: 5px;
                width: 80%;
                margin: 0px auto;
                float: none;
            }

            .unstyled-button {
                border: none;
                padding: 0;
                background: none;
            }

            .unstyled-button:hover {
                border: none;
                padding: 0;
                background: none;
                color: blue;
            }

            #casella{
                height: 80%;
            }

            #ricercaAvanzata{
                text-decoration: underline;
            }

            #ricercaAvanzata:hover{
                text-decoration: underline;
                color: #E20E0E;
            }

            #BottoneCerca{
                width: 60%;
            }

            th{
                text-align: center;
            }

            td{
                text-align: center;
            }


            #primaRiga{
                margin: auto;
                max-width: 90%;
                text-align:center;
            }

            #secondaRiga{
                margin: auto;
                max-width: 90%;
                text-align:center;
            }

            h1 { color: #343a40; 
                 font-size: 48px; 
                 text-align: center;
                 font-family: 'Segoe Print'; 
                 padding-bottom: 10px; 
            }

            #btnLogin{
                margin: 9px;
            }
            
        </style>
        <script>
            window.onload = function () {
                document.getElementById('secondaRiga').style.display = 'none';
            };
        </script>
    <div class="row">
        <div class="col-lg-11">
            <h1>Videoteca ITI Severi</h1>
        </div>
        <div class="col-lg-1">
            <a href="login.php"><button class="btn btn-md bg-dark text-white" id="btnLogin" name="login">Login</button></a>
            <a href="logout.php"><button class="btn btn-md bg-dark text-white" id="btnLogout" name="logout">Logout</button></a></br>
            <a href="modificapssw.php"><button class="btn btn-md bg-dark text-white" id="btnLogin" name="cambiaPsw">Cambia Password</button></a></br>
            <a href="prenotazione.php"><button class="btn btn-md bg-dark text-white" id="btnLogin" name="prenota">Prenota un dvd</button></a></br>
        </div>
    </div>
</head>
<body>


    <br/>

    <!-- Form -->
    <form method="POST" action="">

        <!-- Prima riga -->
        <div class="row" id="primaRiga">
            <?php
            ?>
            <!-- Titolo -->
            <div class="col-lg-3 offset-lg-1">
                <input list="listatitoli" value="" class="custom-select" placeholder="Titoli">
                <datalist id="listatitoli">
                    <?php
                    $response = file_get_contents('http://10.0.1.252/biblioteca/biblio/backend/user_api.php/list?titolo=1');
                    $response = json_decode($response);
                    foreach ((($response->contenuto)->titolo) as $titolo) {
                        echo "<option value=$titolo>";
                    }
                    ?>

                </datalist>
            </div>

            <!-- Genere -->
            <div class="col-lg-2">
                <input list="listagenere" value="" class="custom-select" placeholder="Genere">
                <datalist id="listagenere">
                    <?php
                    $response = file_get_contents('http://10.0.1.252/biblioteca/biblio/backend/user_api.php/list?genere=1');
                    $response = json_decode($response);
                    foreach ((($response->contenuto)->genere) as $genere) {
                        echo "<option value=$genere>";
                    }
                    ?>
                </datalist>
                </select>
            </div>

            <!-- Disponibilità -->
            <div class="col-lg-2">
                <select class="form-control d-inline-block" id="sel1" placeholder="Disponibilità">
                    <option value="" disabled selected hidden>Disponibilità</option>
                    <option>Disponibile</option>
                    <option>Non disponibile</option>
                </select>
            </div>

            <!-- Cerca -->
            <div class="col-lg-2">
                <input class="btn btn-md bg-dark text-white" type="submit" name="cerca" value="Cerca" id="BottoneCerca">
            </div>

            <!-- Ricerca avanzata -->
            <div class="col-lg-1">
                <input align="center" type="button" id="ricercaAvanzata" name="ricercaAvanzata" value="Ricerca avanzata" class="unstyled-button"/>
            </div>
        </div>
        <br/>

        <!-- Seconda riga -->
        <div class="row" id="secondaRiga" class="hidden">

            <!-- Regista -->
            <div class="col-lg-3 offset-lg-1">
                <input list="listaregista" value="" class="custom-select" placeholder="Regista">
                <datalist id="listaregista">
                    <?php
                    $response = file_get_contents('http://10.0.1.252/biblioteca/biblio/backend/user_api.php/list?regia=1');
                    $response = json_decode($response);
                    foreach ((($response->contenuto)->regia) as $regia) {
                        echo "<option value=$regia>";
                    }
                    ?>
                </datalist>
            </div>

            <!-- Anno -->
            <div class="col-lg-1">
                <input list="listaanni" value="" class=" custom-select" placeholder="Anno">
                <datalist id="listaanni">
                    <?php
                    $response = file_get_contents('http://10.0.1.252/biblioteca/biblio/backend/user_api.php/list?anno=1');
                    $response = json_decode($response);
                    foreach ((($response->contenuto)->anno) as $anno) {
                        echo "<option value=$anno>";
                    }
                    ?>
                </datalist>
            </div>

            <!-- Lingua audio -->
            <div class="col-lg-1">
                <select class="form-control d-inline-block" id="sel1" >
                    <option value="" disabled selected hidden>Audio</option>
                    <?php
                    $response = file_get_contents('http://10.0.1.252/biblioteca/biblio/backend/user_api.php/list?lingua_audio=1');
                    $response = json_decode($response);
                    foreach ((($response->contenuto)->lingua_audio) as $lingua_audio) {
                        echo "<option value=$lingua_audio>$lingua_audio</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Lingua sottotitoli -->
            <div class="col-lg-1">
                <select class="form-control d-inline-block" id="sel1" >
                    <option value="" disabled selected hidden>Sottotitoli</option>
                    <?php
                    $response = file_get_contents('http://10.0.1.252/biblioteca/biblio/backend/user_api.php/list?lingua_sottotitoli=1');
                    $response = json_decode($response);
                    foreach ((($response->contenuto)->lingua_sottotitoli) as $lingua_sottotitoli) {
                        echo "<option value=$lingua_sottotitoli>$lingua_sottotitoli</option>";
                    }
                    ?>
                </select>
            </div>


            <!-- Rating -->
            <div class="col-lg-1">
                <select class="form-control d-inline-block" id="sel1" >
                    <option value="" disabled selected hidden>Rating</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                    <option>7</option>
                    <option>8</option>
                    <option>9</option>
                    <option>10</option>
                </select>
            </div>
            <br/><br/><br>
        </div>
    </form>


    <table class="table table-striped">
        <div class="row">
            <div class="col-11">
                <thead>
                    <tr>
                        <th scope="col">N</th>
                        <th scope="col">Titolo</th>
                        <th scope="col">Regista</th>
                        <th scope="col">Genere</th>
                        <th scope="col">Anno</th>
                        <th scope="col">Lingua audio</th>
                        <th scope="col">Lingua sottotitoli</th>
                        <th scope="col">Disponibilità</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Film</td>
                        <td>Otto</td>
                        <td>@lgo</td>
                        <td>2002</td>
                        <td>Italiano</td>
                        <td>Inglese</td>
                        <td>Sì</td>

                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thuornton</td>
                        <td>@fat</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                    </tr>
                </tbody>
            </div>

        </div>
    </table>



    <script type="text/javascript">
        $("#ricercaAvanzata").click(function () {
            $("#secondaRiga").toggle("slow");
        });






    </script>


</body>

</html>


