<?php
class Request {

  private $path="";
  private $cleaned=array();
  private $checked=array("path"=>false,"filter"=>false);
  /**
  * @return boolean true or false (404)
  */
  function check_path() {
	  if(isset($_SERVER["PATH_INFO"])){
		$path=str_replace("/","",$_SERVER["PATH_INFO"]);
		if($path==="dvd"||$path==="img"){
			$this->path=$path;
			$this->checked->path=true;
			return true;
		}
	  }
	  return false;

  }
  /**
  * @return string risorsa richiesta
  */
  function get_path() {
	  return $this->path;
  }
  /**
  * @return boolean true or false (400)
  */
  function filter_GET() {
    $obbligatori = [];
    $filters = ["categoria","regia"];
    if($this->checked->path) {
      if($this->path==="img") {
        if(isset($_GET["id"])&&!empty($_GET["id"])&&filter_var($_GET["id"],FILTER_VALIDATE_INT))
        return true;
		  }
		  elseif($this->path==="dvd") {
        foeach ($filters as $filter)
		  }
	  }
		return false;
  }
  /**
  * @return array tutti i parametri get filtrati
  */
  function get_GET() {
  }
}

$r=new Request();
if($r->check_path())
	echo"ok";
else
	echo"404";
