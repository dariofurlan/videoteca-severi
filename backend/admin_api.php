<?php
session_start();
require_once 'response.php';

$res = new Response();

//

try {
    if (isset($_SERVER["PATH_INFO"]) && !empty($_SERVER["PATH_INFO"])) {
        $path = str_replace("/", "", $_SERVER["PATH_INFO"]);
    } else throw new Exception("Manca percorso!");

    if ($path === "login") {
        $res->ok("", ["logged" => "true"]);
        log_in();
    } elseif ($path === "logout") {
        log_out();
    } elseif ($path === "is_logged") {
        is_logged();
        $res->ok("",["logged"=>"false"]);
    }

} catch (Exception $e) {
    $res->error(400, $e);
}

function is_logged() {
    global $res;
    if (isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
        $res->ok("", ["logged" => "true"]);
    }
}

function log_in() {
    global $res;
//    require_once 'conn.php';

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
        } else {
            $res->error(403);
        }
    }
}

function log_out() {
    global $res;
    session_start();
    session_unset();
    session_destroy();
    $res->ok("", ["logged" => "false"]);
}