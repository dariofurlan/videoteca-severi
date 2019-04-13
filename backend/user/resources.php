<?php
class Resources {
    public static function get_resources_list() {
        $out = [];
        foreach (get_class_vars(get_called_class()) as $key => $val) array_push($out, $key);
        return $out;
    }
    public static function get_required($res) {
        return get_class_vars(get_called_class())[$res]["required"];
    }
    public static function get_all_required() {
        $required = [];
        foreach (get_class_vars(get_called_class()) as $key=>$val) {
            $required[$key] = $val["required"];
        }
        return $required;
    }
    public static function get_optional($res) {
        return get_class_vars(get_called_class())[$res]["optional"];
    }
    public static function get_all_optional() {
        $required = [];
        foreach (get_class_vars(get_called_class()) as $key=>$val) {
            $required[$key] = $val["optional"];
        }
        return $required;
    }
    public static function get_all() {
        return get_class_vars(get_called_class());
    }
}
class GuestResources extends Resources{
  static $img = [
      "required" => ["id"],
      "optional" => []
  ];
  static $dvd = [
      "required" => [],
      "optional" => ["n_catalogo", "titolo", "regia", "tipo", "genere", "anno", "lingua_audio", "lingua_sottotitoli", "disponibilita"]
  ];
  static $list = [
      "required" => [],
      "optional" => ["tipo", "genere", "regia", "anno", "lingua_audio", "lingua_sottotitoli"]
  ];
  
  static $insert_prenotazione =  [
    "required" => ["titolo"],
    "optional" => []
  ];
}
class AdminResources extends Resources {
  static $insert_dvd = [
    "required" => [],
    "optional" => []
  ];
  static $update_dvd = [
    "required" => [],
    "optional" => []
  ];
  static $delete_dvd = [
    "required" => [],
    "optional" => []
  ];
  static $insert_prenotazione =  [
    "required" => ["titolo"],
    "optional" => []
  ];
  static $select_prenotazione =  [
    "required" => [],
    "optional" => []
  ];
}
