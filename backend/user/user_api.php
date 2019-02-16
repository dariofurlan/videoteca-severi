<?php
require_once 'request.php';
require_once 'response.php';

$res = new Response();
$req = new Request();



if ($req->check_path()) {
  $resource = $req->get_path();
  if ($req->check_GET($resource)) {

  } else {
    // 400
  }
} else {
  // 404
}
