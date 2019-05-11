<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    //Salvare num inventario film in sessione
}

?>
<html>
<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="style/login.css" rel="stylesheet">
    <title>Prenotazione</title>

</head>
<body>

<div class="mainPrenota">
    <div class="col-md-6 col-sm-12">
        <h2>Inserire i dati relativi all'utente richiedente la prenotazione</h2>
        <div class="prenota-form">
            <form action="controlloprenotazione.php" method="POST">
                <div class="form-group">
                    <label>Nome richiedente:</label>
                    <input type="text" name="nome" class="form-control" placeholder="Nome">
                </div>
                <div class="form-group">
                    <label>Cognome richiedente: </label>
                    <input type="text" name="cognome" class="form-control" placeholder="Cognome">
                </div>
                <div class="form-group">
                    <label>E-mail: </label>
                    <input type="email" name="email" class="form-control" placeholder="Email">
                </div>
                <input type="submit" name="invio" value="invio" class="btn btn-black">
            </form>
        </div>
    </div>
</div>
</body>
</html>                   
