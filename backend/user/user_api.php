<?php
echo phpversion();
die();
require_once 'request.php';
require_once 'response.php';
require_once 'resources.php';

var_dump(GuestResources::get_all());
$res = new Response("GuestResources");
$req = new Request();

if ($req->check_path()) {
    $resource = $req->get_path();
    if ($req->check_GET()) {
      $cleaned_GET = $req->get_GET();

      $res->ok(1, "ciao");
      exit();
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
