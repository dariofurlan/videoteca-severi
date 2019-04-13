<?php
session_start();
if(!isset($_SESSION["username"]) || empty($_SESSION["username"])){
	header("Location: index.php");
	exit();
}
if(!isset($_POST["password"]) || empty($_POST["password"]) || !isset($_POST["passwordC"]) || empty($_POST["passwordC"])){
	header("Location: datiP.php");
	exit();
}
if($_POST["password"]!=$_POST["passwordC"]){
	header("Location: datiP.php");
	exit();
}

//da guardare perchè sbagliato
	$p=$_POST["password"];
	$p=stripslashes($p);
	$p=mysqli_real_escape_string($connessione,$p);
	$p=md5($p);
	$sql="SELECT password FROM $tab_name WHERE username='".$_SESSION["username"]."';";
	$con=$connessione->query($sql);
	$res=$con->fetch_assoc();
	if($res["password"]!=md5($_POST["passwordV"])) {
		echo "Password vecchia non esatta, torna alla pagina di <a href=\"datiP.php\">cambio password</a>.";
	} else {
		$sql="UPDATE $tab_name SET password='$p' WHERE username='".$_SESSION["username"]."';";
		if(!$connessione->query($sql)) {
			echo "Errore della query: ".$connessione->error .".<br/>";
			echo "Torna alla pagina di <a href=\"datiP.php\">cambio password</a>.";
		} else {
			echo "Inserimento avvenuto correttamente.";
			echo "Torna alla pagina di <a href=\"loginOk.php\">utente</a>.<br/>";
		}
	}
	$connessione->close();

?>
