<?php
  class Camper {
    public $_id, $name, $username, $dob, $health_card, $phone, $parent_name;
    public $email, $health_notes, $gender, $shirt, $change_pass, $hash_pass;

    function __construct($row)
    {
      $this->_id          = $row['_id'];
      $this->name         = $row['name'];
      $this->username     = $row['username'];
      $this->dob          = $row['dob'];
      $this->health_card  = $row['health_card'];
      $this->phone        = $row['phone'];
      $this->parent_name  = $row['parent_name'];
      $this->email        = $row['email'];
      $this->health_notes = $row['health_notes'];
      $this->gender       = $row['gender'];
      $this->shirt        = $row['shirt'];
      $this->change_pass  = $row['change_pass'];
      $this->hash_pass    = $row['hash_pass'];
    }
  }

  class Campers {
    public static function GetAllCampers()
    {
      if ($_SESSION['level'] == Level::ADMIN) {
        $link = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);
        if (!$link) {
          return Result::MYSQLERROR;
        }
        if ($result = $link->query(
          "SELECT * from `users` WHERE `level` = '".Level::CAMPER."'"
        )) {
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
