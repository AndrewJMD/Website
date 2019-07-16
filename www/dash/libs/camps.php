<?php

  class Camps
  {

    const ALL_STMT          = "SELECT * FROM `camps` ORDER BY `year` DESC";
    const ID_STMT           = "SELECT * FROM `camps` WHERE `_id` = ?";
    const YEAR_STMT         = "SELECT * FROM `camps` WHERE `year` = ?";
    const CURRENT_STMT      = "SELECT * FROM `camps` WHERE (`year` = DATE_FORMAT(CURRENT_DATE, \"%Y\")) AND (`month` >= DATE_FORMAT(CURRENT_DATE, \"%m\")) AND (`month` > DATE_FORMAT(CURRENT_DATE, \"%m\") OR `day` + 5 >= DATE_FORMAT(CURRENT_DATE, \"%d\")) ORDER BY `month`, `day` ASC LIMIT 1";
    const CAMPERS_YEAR_STMT = "SELECT * FROM `users` WHERE `users`.`_id` IN (SELECT `attend`.`camper` FROM `attend` WHERE `attend`.`camp` IN (SELECT `camps`.`_id` FROM `camps` WHERE `camps`.`year` = ?))";
    const CAMPER_STMT       = "SELECT `camps`.* FROM `attend` JOIN `camps` ON `camps`.`_id` = `attend`.`camp` WHERE `attend`.`camper` = ? ORDER BY `camps`.`week` ASC";
    const CAMPER_YEAR_STMT  = "SELECT `camps`.* FROM `attend` JOIN `camps` ON `camps`.`_id` = `attend`.`camp` WHERE `attend`.`camper` = ? AND `camps`.`year` = ? ORDER BY `camps`.`week` ASC";

    public static function GetCamps()
    {
      if (!$link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS)) {
        return Result::MYSQLERROR;
      }
      if (!$stmt = $link->prepare(Camps::ALL_STMT)) {
        return Result::MYSQLERROR;
      }
      if (!$stmt->execute()) {
        return Result::MYSQLERROR;
      }
      return Camps::_FetchToCampArray($stmt);
    }

    public static function GetCampsByYear($year)
    {
      if (!$link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS)) {
        return Result::MYSQLERROR;
      }
      if (!$stmt = $link->prepare(Camps::YEAR_STMT)) {
        return Result::MYSQLERROR;
      }
      if (!$stmt->execute(array($year))) {
        return Result::MYSQLERROR;
      }
      return Camps::_FetchToCampArray($stmt);
    }

    public static function GetCamp($camp)
    {
      if (!$link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS)) {
        return Result::MYSQLERROR;
      }
      if (!$stmt = $link->prepare(Camps::ID_STMT)) {
        return Result::MYSQLERROR;
      }
      if (!$stmt->execute(array($camp))) {
        return Result::MYSQLERROR;
      }
      $stmt->setFetchMode(PDO::FETCH_INTO, new Camp);
      return $stmt->fetch();
    }

    public static function GetCurrentCamp()
    {
      if (!$link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS)) {
        return Result::MYSQLERROR;
      }
      if (!$stmt = $link->prepare(Camps::CURRENT_STMT)) {
        return Result::MYSQLERROR;
      }
      if (!$stmt->execute()) {
        return Result::MYSQLERROR;
      }
      $stmt->setFetchMode(PDO::FETCH_INTO, new Camp);
      return $stmt->fetch();
    }

    public static function GetCamperCamps($camper, $year = NULL) {
      if (!$link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS)) {
        return Result::MYSQLERROR;
      }
      if (!$stmt = $link->prepare(($year == NULL) ? Camps::CAMPER_STMT : Camps::CAMPER_YEAR_STMT)) {
        return Result::MYSQLERROR;
      }
      if (!$stmt->execute(($year == NULL) ? array($camper) : array($camper, $year))) {
        return Result::MYSQLERROR;
      }
      return Camps::_FetchToCampArray($stmt);
    }

    static function _FetchToCampArray($stmt)
    {
      $camps = array();
      $raw = $stmt->fetchAll(PDO::FETCH_CLASS, 'Camp');
      foreach ($raw as &$camp) {
        array_push($camps, $camp);
      }
      return $camps;
    }

    static function Attend($info) {
      if (gettype($info['camp']) == "object") {
        $info['camp'] = $info['camp']->_id;
      }
      if (gettype($info['camper']) == "object") {
        $info['camper'] = $info['camper']->_id;
      }
      if (!$link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS)) {
        return Result::MYSQLERROR;
      }
      if (!$stmt = $link->prepare("INSERT INTO `attend` (`camper`, `camp`, `drive`, `shirt`, `pizza`, `hear`) VALUES (:camper, :camp, :drive, :shirt, :pizza, :hear)")) {
        return Result::MYSQLERROR;
      }
      $stmt->bindParam(":camper", $info['camper']);
      $stmt->bindParam(":camp",   $info['camp']);
      $stmt->bindParam(":drive",  $info['drive']);
      $stmt->bindParam(":shirt",  $info['shirt']);
      $stmt->bindParam(":pizza",  $info['pizza']);
      $stmt->bindParam(":hear",   $info['hear']);
      if (!$stmt->execute()) {
        return Result::MYSQLERROR;
      }
      return Result::VALID;
    }

  }

  class Camp
  {

    public $_id, $year, $month, $day, $week, $theme, $campers;

    function __construct()
    {
      $link = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);
      $this->campers = $link->query("SELECT _id FROM `attend` WHERE `camp` = '".$this->_id."'")->num_rows;
    }

  }

?>
