<?php
session_start();
require_once 'response.php';

$res = new Response();

try {
    if (isset($_SERVER["PATH_INFO"]) && !empty($_SERVER["PATH_INFO"])) {
        $path = str_replace("/", "", $_SERVER["PATH_INFO"]);
    } else throw new Exception("Manca percorso!");

    if ($path === "login") {
        log_in();
    } elseif ($path === "logout") {
        log_out();
    } elseif ($path === "is_logged") {
        is_logged();
        $res->ok("",["logged"=>"false"]);
    } elseif ($path === "prenotazione") {
		    prenota();
    } elseif ($path === "restituzione") {
        restituzione();
    } else {
      throw new Exception("Percorso non valido.");
    }

} catch (Exception $e) {
    $res->error(400, $e);
}

function prenota() {
	global $res;
	require_once 'vars.php';

  if (!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
      $res->errore(400, "Manca username");
  }

	$conn = new mysqli(HOST, USER, PASSWORD, DB);
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
		$conn->rollback();
    $res->error(400,"Dvd non più disponibile");
	}

	$sql = "UPDATE DVD SET Disponibilita='No' WHERE Inventario=$idFilm";
	$result = $conn->query($sql);

	if (!$result) {
		$conn->rollback();
		$res->error(500, "Errore prenotazione(UPDATE)");
	}

	$sql = "INSERT INTO NOLEGGIO VALUES($idFilm,'$email','" . date('Y-m-d') . "','" . date('Y-m-d', strtotime("+30 days")) . "', '$nome', '$cognome')";
	$result = $conn->query($sql);

	if (!$result) {
		$conn->rollback();
    $res->error(500, "Errore prenotazione(INSERT)");
	}

	$conn->commit();
  $res->ok("",["ok"=>"true"]);
}

function restituzione() {
    global $res;
    require_once 'vars.php';

    if (!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
        $res->errore(400, "Manca username");
    }

  	$conn = new mysqli(HOST, USER, PASSWORD, DB);
  	$idFilm = $_POST["idfilm"];

  	$sql = "UPDATE DVD SET Disponibilita='Si' WHERE Inventario=$idFilm";
  	$result = $conn->query($sql);

  	if (!$result) {
  		  $res->error(500, "Errore restituzione (UPDATE)");
  	}

    $res->ok("",["ok"=>"true"]);
}

function is_logged() {
    global $res;
    if (isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
        $res->ok("", ["logged" => "true"]);
    }
}

function log_in() {
    global $res;
    require_once 'vars.php';
    $conn = new mysqli(HOST, USER, PASSWORD, DB);

    if (!isset($_POST["username"]) || empty($_POST["username"])) {
        $res->error(400,"Manca username");
    } else {
        $username = mysqli_real_escape_string($conn, stripslashes($_POST["username"]));
    }

    if (!isset($_POST["password"]) || empty($_POST["password"])) {
        $res->error(400,"Manca password");
    } else {
        $password = mysqli_real_escape_string($conn, stripslashes($_POST["password"]));
        $passmd5 = md5($password);
    }

    $sql = "SELECT * FROM ADMIN WHERE username='$username' AND password='$passmd5'";
    $result = $conn->query($sql);

    if (!$result) {
        $res->error(500,"Errore Login");
    } else {
        if ($result->num_rows === 1) {
            $_SESSION["username"] = $username;
            $res->ok("", ["logged" => "true"]);
        } else {
            $res->error(403);
        }
    }
}

function log_out() {
    global $res;
    session_unset();
    session_destroy();
    $res->ok("", ["logged" => "false"]);
}
