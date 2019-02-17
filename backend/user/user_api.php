<?php
require_once 'request.php';
require_once 'response.php';
require_once 'database.php';

$res = new Response();
$req = new Request();

if ($req->check_path()) {
    $resource = $req->get_path();
    if ($req->check_GET()) {
        $res->ok(0,"moma");
    } else {
        $res->error(400);
    }
} else {
    $res->error(404);
}
