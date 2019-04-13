<?php 
	session_start();
	if(!isset($_SESSION["username"])) {
		header("Location: index.php");
}
$timestamp=date("d-m-Y");
?>
<html>
<head>
<title>Pagina di prenotazione</title>
</head>
<body>
<form action="controlloprenotazione.php" method="POST">
Nome film: <input type="text" name="nomefilm"><br><br>
Data di inizio noleggio: <?php echo $timestamp; ?><br><br>
Data di fine noleggio: <input type="date" name="datafine"><br><br>
<input type="submit" value="Invia richiesta di prenotazione">
</form>
</body>
</html>
