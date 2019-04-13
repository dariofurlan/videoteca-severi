<?php
//se uso xampp
$host="10.0.1.252";
$username="biblio01";
$password="10588861";
$db_name="biblio01";
$tab_name="ADMIN";

$conn=new mysqli($host, $username, $password, $db_name);
if ($conn->connect_errno) {
	die("Connessione Fallita: " . $conn->connect_error);
	//die sostituisce echo e exit()
}
?>
