<?php
require_once 'request.php';
require_once 'response.php';
require_once 'resources.php';

$res = new Response();
$req = new Request(new AdminResources());

if ($req->check_path()) {
    $resource = $req->get_path();
    if ($req->check_GET()) {
      $cleaned_GET = $req->get_GET();
      try {
        require_once 'database.php';
        $db = new Database();
        $result = $db->prepare_query($resource, $cleaned_GET);
        $res->ok($result);
      } catch(Exception $e) {
        $res->error(500);
      }
    } else {
        $res->error(400);
    }
} else {
    $res->error(404);
}
