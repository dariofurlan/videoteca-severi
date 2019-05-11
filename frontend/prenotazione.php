<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
}
$timestamp = date("d-m-Y");
?>
<html>
<head>
    <title>Pagina di prenotazione</title>
</head>
<body>
<form action="controlloprenotazione.php" method="POST">
    Nome film: <input type="text" name="idfilm"><br>
    Nome richiedente: <input type="text" name="nome"><br>
    Cognome richiedente <input type="text" name="cognome"><br>
    Email richiedente: <input type="text" name="email"><br>
    <input type="submit" value="Invia richiesta di prenotazione">
</form>
</body>
</html>
