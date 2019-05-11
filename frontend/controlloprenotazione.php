<?php
session_start();
require "conn.php";

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
}

print_r($_POST);

$idFilm = $_POST["idfilm"];
$dataInizio = time();
$nome = $_POST["nome"];
$cognome = $_POST["cognome"];
$email = $_POST["email"];

$conn->autocommit(FALSE);

$sql = "SELECT * FROM DVD WHERE Inventario=$idFilm AND Disponibilita='Si'";
$result = $conn->query($sql);
$num_rows = $result->num_rows;
if ($num_rows == 0) {

    echo "Il dvd non è più disponibile";
    $conn->rollback();
    exit();
}

$sql = "UPDATE DVD SET Disponibilita='No' WHERE Inventario=$idFilm";
$result = $conn->query($sql);

if (!$result) {
    echo "Errore nella prenotazione UPDATE";
    $conn->rollback();
    exit();
}

$sql = "INSERT INTO NOLEGGIO VALUES($idFilm,'$email','" . date('Y-m-d') . "','" . date('Y-m-d', strtotime("+30 days")) . "', '$nome', '$cognome')";

$result = $conn->query($sql);


if (!$result) {
    echo "Errore nella prenotazione INSERT";
    $conn->rollback();
    exit();
}

$conn->commit();

//$conn->rollback();


?>
