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
      "optional" => ["n_catalogo", "titolo", "regia", "genere", "anno", "lingua_audio", "disponibilita", "rating"]
  ];

  static $list = [
      "required" => [],
      "optional" => ["titolo","genere", "regia", "anno", "lingua"]
  ];
}
