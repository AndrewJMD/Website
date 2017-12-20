<?php

  class Camper {
    public $_id, $name, $first, $username, $dob, $health_card, $phone, $parent_name;
    public $email, $health_notes, $gender, $shirt, $change_pass, $hash_pass, $discriminator;

    function __construct($row)
    {
      $this->_id          = $row['_id'];
      $this->name         = explode(" ", $row['name'])[0];
      $this->discriminator= $row['discriminator'];
      $this->username    = Camper::SafeName($row);

      if (Session::Allowed($_SESSION['level'],Level::ADMIN)) {
        $this->first        = explode(" ", $row['name'])[0];
        foreach(get_class_vars("Camper") as $key=>$value) {
          if (array_key_exists($key, $row))
            $this->$key = $row[$key];
        }
      }
    }

    public static function SafeName($row) {
      $first = strtolower(explode(" ", $row['name'])[0]);
      return $first.".".$row['discriminator'];
    }
  }

  class Campers {

    public static function GetAllCampers($filter = "all")
    {
      $link = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);
      if (!$link) {
        return Result::MYSQLERROR;
      }
      switch($filter){
        case "all":
          $q = "SELECT * from `users` WHERE `level` = '".Level::CAMPER."'";
          break;
        case "simple":
          $q = "SELECT `_id`,`name`,`discriminator` from `users` WHERE `level` = '".Level::CAMPER."'";
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
    }

    public static function GetFromUsername($username, $filter="all")
    {
      $link = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);
      if (!$link) {
        return Result::MYSQLERROR;
      }
      $where = "AND CONCAT(SUBSTRING_INDEX(`name`,' ',1),'.',`discriminator`) = '$username'";
      switch($filter){
        case "all":
          $q = "SELECT * from `users` WHERE `level` = '".Level::CAMPER."' $where";
          break;
        case "simple":
          $q = "SELECT `_id`,`name`,`discriminator` from `users` WHERE `level` = '".Level::CAMPER."' $where";
          break;
      }
      if ($result = $link->query($q)) {
        if($result->num_rows == 1)
          return new Camper($result->fetch_array(MYSQLI_ASSOC));
        else
          return Result::NOTFOUND;
      } else {
        return Result::INVALID;
      }
    }
  }
?>
