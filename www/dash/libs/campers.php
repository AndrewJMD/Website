<?php

  use function Cekurte\Environment\env;
  use Cekurte\Environment\Environment;

  class Camper {
    public $_id, $name, $first, $username, $dob, $health_card, $phone, $parent_name;
    public $email, $health_notes, $gender, $shirt;
    public $camps_attended, $weeks_attended;

    function __construct($row)
    {
      $this->_id            = $row['_id'];
      $this->name           = explode(" ", $row['name'])[0];
      $this->username       = $row['username'];

      if (Session::Allowed($_SESSION['level'],Level::ADMIN)) {
        $this->first        = explode(" ", $row['name'])[0];
        foreach(get_class_vars("Camper") as $key=>$value) {
          if (array_key_exists($key, $row))
            $this->$key = $row[$key];
        }
      }

      if (!Environment::get("CIRCLECI", false)) {
        //Not in a CircleCI Test
        //TODO In the future it would be nice to test data retrieving in CircleCI.
        $link = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);
        $this->weeks_attended = $link->query("SELECT _id FROM `attend` WHERE `camper` = '".$this->_id."'")->num_rows;
        $this->camps_attended = $link->query("SELECT DISTINCT(SELECT `year` FROM `camps` WHERE `camps`.`_id` = `attend`.`camp`) FROM `attend` WHERE `camper` = '".$this->_id."'")->num_rows;
      }

    }
  }

  class Campers {

    const ALL_ALL_STMT      = "SELECT * FROM `users` WHERE `level` = '".Level::CAMPER."' ORDER BY `name` ASC";
    const ALL_SIMPLE_STMT   = "SELECT `_id`,`name`,`username` FROM `users` WHERE `level` = '".Level::CAMPER."' ORDER BY `name` ASC";
    const YEAR_ALL_STMT     = "SELECT * FROM `users` WHERE `users`.`_id` IN (SELECT `attend`.`camper` FROM `attend` WHERE `attend`.`camp` IN (SELECT `camps`.`_id` FROM `camps` WHERE `camps`.`year`= ?)) ORDER BY `name` ASC";
    const YEAR_SIMPLE_STMT  = "SELECT `_id`,`name`,`username` FROM `users` WHERE `users`.`_id` IN (SELECT `attend`.`camper` FROM `attend` WHERE `attend`.`camp` IN (SELECT `camps`.`_id` FROM `camps` WHERE `camps`.`year`= ?)) ORDER BY `name` ASC";
    const CAMP_ALL_STMT     = "SELECT * FROM `users` WHERE `users`.`_id` IN (SELECT `attend`.`camper` FROM `attend` WHERE `attend`.`camp` IN (SELECT `camps`.`_id` FROM `camps` WHERE `camps`.`_id`= ?)) ORDER BY `name` ASC";
    const CAMP_SIMPLE_STMT  = "SELECT `_id`,`name`,`username` FROM `users` WHERE `users`.`_id` IN (SELECT `attend`.`camper` FROM `attend` WHERE `attend`.`camp` IN (SELECT `camps`.`_id` FROM `camps` WHERE `camps`.`_id`= ?)) ORDER BY `name` ASC";

    public static function GetAllCampers($filter = "all")
    {
      if (!$link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS)) {
        return Result::MYSQLERROR;
      }
      if (!$stmt = $link->prepare(($filter == "all") ? Campers::ALL_ALL_STMT : Campers::ALL_SIMPLE_STMT )) {
        return Result::MYSQLPREPARE;
      }
      if (!$stmt->execute()) {
        return Result::MYSQLEXECUTE;
      }
      return Campers::_FetchToCamperArray($stmt);
    }

    public static function GetCampersFromYear($year, $filter = "all")
    {
      if (!$link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS)) {
        return Result::MYSQLERROR;
      }
      if (!$stmt = $link->prepare(($filter == "all") ? Campers::YEAR_ALL_STMT : Campers::YEAR_SIMPLE_STMT )) {
        return Result::MYSQLPREPARE;
      }
      if (!$stmt->execute(array($year))) {
        return Result::MYSQLEXECUTE;
      }
      return Campers::_FetchToCamperArray($stmt);
    }

    public static function GetCampersFromCamp($camp, $filter = "all")
    {
      if (!$link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS)) {
        return Result::MYSQLERROR;
      }
      if (!$stmt = $link->prepare(($filter == "all") ? Campers::CAMP_ALL_STMT : Campers::CAMP_SIMPLE_STMT )) {
        return Result::MYSQLPREPARE;
      }
      if (!$stmt->execute(array($camp))) {
        return Result::MYSQLEXECUTE;
      }
      return Campers::_FetchToCamperArray($stmt);
    }

    public static function GetFromUsername($username, $filter="all")
    {
      $link = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);
      if (!$link) {
        return Result::MYSQLERROR;
      }
      switch($filter){
        case "all":
          $q = "SELECT * from `users` WHERE `username` = '$username'";
          break;
        case "simple":
          $q = "SELECT `_id`,`name`,`username` from `users` WHERE `username` = '$username'";
          break;
      }
      //TODO Prepared Statements
      if ($result = $link->query($q)) {
        if($result->num_rows == 1)
          return new Camper($result->fetch_array(MYSQLI_ASSOC));
        else
          return Result::NOTFOUND;
      } else {
        return Result::INVALID;
      }
    }

    static function _FetchToCamperArray($stmt)
    {
      $campers = array();
      $raw = $stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($raw as &$camper) {
        array_push($campers, new Camper($camper));
      }
      return $campers;
    }
  }
?>
