<?php

  class Camper {
    public $_id, $name, $safe_name, $username, $dob, $health_card, $phone, $parent_name;
    public $email, $health_notes, $gender, $shirt, $change_pass, $hash_pass;

    function __construct($row)
    {
      $this->_id          = $row['_id'];
      $this->name         = Camper::SafeName($row['name']);
      $this->username     = $row['username'];

      if (Session::Allowed($_SESSION['level'],Level::ADMIN)) {
        foreach(get_class_vars("Camper") as $key=>$value) {
          if (array_key_exists($key, $row))
            $this->$key = $row[$key];
        }
      }
    }

    public static function SafeName($name) {
      $separate = explode(" ", $name);
      $last = array_pop($separate);
      return implode(' ', $separate)." ".$last[0].".";
    }
  }

  class Campers {

    public static function GetAllCampers($filter = "all")
    {
      if (Session::Allowed($_SESSION['level'],Level::ADMIN + Level::CAMPER)) {
        $link = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);
        if (!$link) {
          return Result::MYSQLERROR;
        }
        switch($filter){
          case "all":
            $q = "SELECT * from `users` WHERE `level` = '".Level::CAMPER."'";
            break;
          case "simple":
            $q = "SELECT `_id`,`name`,`username` from `users` WHERE `level` = '".Level::CAMPER."'";
            break;
        }
        if ($result = $link->query($q)) {
          $campers = array();
          $raw = $result->fetch_all(MYSQLI_ASSOC);
          foreach($raw as &$camper)
          {
            array_push($campers, new Camper($camper));
          }
          return $campers;
        } else {
          return Result::INVALID;
        }
      } else {
        return Result::INSUFFICIENT;
      }
    }
  }
?>
