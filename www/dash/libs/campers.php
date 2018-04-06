<?php

  use function Cekurte\Environment\env;
  use Cekurte\Environment\Environment;

  class Camper {

    public $_id, $name, $first, $username, $dob, $health, $prov, $cellphone, $phone, $parents;
    public $drive, $email, $medical, $gender, $shirt;
    public $camps_attended, $weeks_attended;

    function __construct($row)
    {
      $this->_id            = $row['_id'];
      $this->name           = explode(" ", $row['name'])[0];
      $this->first          = $this->name;
      $this->username       = $row['username'];

      if (class_exists("Cekurte\Environment\Environment")) {
        if (!Environment::get("CIRCLECI", false) && class_exists("Session")) {
          if (Session::Allowed($_SESSION['level'], Level::ADMIN)) {
            $this->name         = $row['name'];
            $this->first        = explode(" ", $row['name'])[0];
            foreach (get_class_vars("Camper") as $key) {
              if (array_key_exists($key, $row))
                $this->$key = $row[$key];
            }
          }
        }
      }

      $link = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);
      $this->weeks_attended = $link->query("SELECT _id FROM `attend` WHERE `camper` = '".$this->_id."'")->num_rows;
      $this->camps_attended = $link->query("SELECT DISTINCT(SELECT `year` FROM `camps` WHERE `camps`.`_id` = `attend`.`camp`) FROM `attend` WHERE `camper` = '".$this->_id."'")->num_rows;

    }

  }

  class Campers {

    const ALL_ALL_STMT      = "SELECT * FROM `users` WHERE `level` = '".Level::CAMPER."' ORDER BY `name` ASC";
    const ALL_SIMPLE_STMT   = "SELECT `_id`,`name`,`username` FROM `users` WHERE `level` = '".Level::CAMPER."' ORDER BY `name` ASC";
    const YEAR_ALL_STMT     = "SELECT * FROM `users` WHERE `users`.`_id` IN (SELECT `attend`.`camper` FROM `attend` WHERE `attend`.`camp` IN (SELECT `camps`.`_id` FROM `camps` WHERE `camps`.`year`= ?)) ORDER BY `name` ASC";
    const YEAR_SIMPLE_STMT  = "SELECT `_id`,`name`,`username` FROM `users` WHERE `users`.`_id` IN (SELECT `attend`.`camper` FROM `attend` WHERE `attend`.`camp` IN (SELECT `camps`.`_id` FROM `camps` WHERE `camps`.`year`= ?)) ORDER BY `name` ASC";
    const CAMP_ALL_STMT     = "SELECT * FROM `users` WHERE `users`.`_id` IN (SELECT `attend`.`camper` FROM `attend` WHERE `attend`.`camp` IN (SELECT `camps`.`_id` FROM `camps` WHERE `camps`.`_id`= ?)) ORDER BY `name` ASC";
    const CAMP_SIMPLE_STMT  = "SELECT `_id`,`name`,`username` FROM `users` WHERE `users`.`_id` IN (SELECT `attend`.`camper` FROM `attend` WHERE `attend`.`camp` IN (SELECT `camps`.`_id` FROM `camps` WHERE `camps`.`_id`= ?)) ORDER BY `name` ASC";
    const USER_ALL_STMT     = "SELECT * from `users` WHERE `username` = ?";
    const USER_SIMPLE_STMT  = "SELECT `_id`,`name`,`username` from `users` WHERE `username` = ?";
    const ID_ALL_STMT     = "SELECT * from `users` WHERE `_id` = ?";
    const ID_SIMPLE_STMT  = "SELECT `_id`,`name`,`username` from `users` WHERE `_id` = ?";

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

    public static function GetFromUsername($username, $filter = "all")
    {
      if (!$link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS)) {
        return array("code" => Result::MYSQLERROR);
      }
      if (!$stmt = $link->prepare(($filter == "all") ? Campers::USER_ALL_STMT : Campers::USER_SIMPLE_STMT )) {
        return Result::MYSQLPREPARE;
      }
      if ($stmt->execute(array($username))) {
        if ($stmt->rowCount() == 1)
          return new Camper($stmt->fetch(PDO::FETCH_ASSOC));
        return Result::NOTFOUND;
      }
      return Result::INVALID;
    }

    public static function GetFromID($cid, $filter = "all")
    {
      if (!$link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS)) {
        return array("code" => Result::MYSQLERROR);
      }
      if (!$stmt = $link->prepare(($filter == "all") ? Campers::ID_ALL_STMT : Campers::ID_SIMPLE_STMT )) {
        return Result::MYSQLPREPARE;
      }
      if ($stmt->execute(array($cid))) {
        if ($stmt->rowCount() == 1)
          return new Camper($stmt->fetch(PDO::FETCH_ASSOC));
        return Result::NOTFOUND;
      }
      return Result::INVALID;
    }

    public static function Register($info) {
      if (!$link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS)) {
        return array("code" => Result::MYSQLERROR);
      }
      $link->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
      if (!$stmt = $link->prepare("
      INSERT INTO `users`
          (`_id`, `name`, `username`, `dob`, `health`, `prov`, `medical`, `cellphone`, `phone`, `parents`, `drive`, `email`, `level`, `shirt`)
          VALUES (NULL, :name, :username, :dob, :health, :prov, :medical, :cellphone, :phone, :parents, :drive, :email, '".Level::CAMPER."', :shirt);")) {
        return array("code" => Result::MYSQLPREPARE);
      }
      $stmt->bindParam(":name",       $info['name']);
      $stmt->bindParam(":username",   $info['username']);
      $stmt->bindParam(":dob",        $info['dob']);
      $stmt->bindParam(":health",     $info['health']);
      $stmt->bindParam(":prov",       $info['prov']);
      $stmt->bindParam(":medical",    $info['medical']);
      $stmt->bindParam(":cellphone",  $info['phone']);
      $stmt->bindParam(":phone",      $info['parent_phone']);
      $stmt->bindParam(":parents",    $info['parent_name']);
      $stmt->bindParam(":email",      $info['parent_email']);
      $stmt->bindParam(":drive",      $info['parent_drive']);
      $stmt->bindParam(":shirt",      $info['shirt']);
      if (!$stmt->execute()) {
        return array("code" => Result::MYSQLEXECUTE);
      }

      if (defined("DISCORD_WEBHOOK")) {
        $postData = array(
          "content" => "New Registration: ".$info['name']
        );
        $ch = curl_init(DISCORD_WEBHOOK);
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
              "Content-Type: application/json"
            ),
            CURLOPT_POSTFIELDS => json_encode($postData)
        ));
        curl_exec($ch);
      }

      return array("code" => Result::VALID, "id" => $link->lastInsertId());
    }

    public static function AddGithub($id, $username) {
      if (!$link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS)) {
        return array("code" => Result::MYSQLERROR);
      }
      if (!$stmt = $link->prepare("UPDATE `users` SET `username` = :username WHERE `_id` = :id")){
        return array("code" => Result::MYSQLPREPARE);
      }
      $stmt->bindParam(":id",       $id);
      $stmt->bindParam(":username", $username);
      if (!$stmt->execute()) {
        return array("code" => Result::MYSQLEXECUTE);
      }
      return array("code" => Result::VALID);
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
