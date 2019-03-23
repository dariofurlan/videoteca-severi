<?php
session_start();
if (!isset($_SESSION["email"]) || empty($_SESSION["email"])) {
	header("Location: index.php");
  	exit();
}
require_once 'request.php';
require_once 'response.php';

$res = new Response();
$req = new Request();
if ($req->check_path()) {
    $resource = $req->get_path();
    if ($req->check_GET()) {
      $cleaned_GET = $req->get_GET();
      try {
        require_once 'database.php';
        $db = new Database();
        $db->prepare_query($resource, $cleaned_GET);
      } catch(Exception $e) {
        $res->error(500);
      }
    } else {
        $res->error(400);
    }
} else {
    $res->error(404);
}
