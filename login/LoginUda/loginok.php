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
<hr>
<a href="logout.php">Logout</a></br>
<a href="modificapssw.php">Cambia Password</a></br>
<a href="prenotazione.php">Prenota un dvd</a></br>
