<?php

  class Camps
  {

    const ALL_STMT      = "SELECT * FROM `camps` ORDER BY `year` DESC";
    const ID_STMT       = "SELECT * FROM `camps` WHERE `_id` = ?";
    const YEAR_STMT     = "SELECT * FROM `camps` WHERE `year` = ?";
    const CURRENT_STMT  = "SELECT * FROM `camps` WHERE (`year` = DATE_FORMAT(CURRENT_DATE, \"%Y\")) AND (`month` >= DATE_FORMAT(CURRENT_DATE, \"%m\")) AND (`month` > DATE_FORMAT(CURRENT_DATE, \"%m\") OR `day` + 5 >= DATE_FORMAT(CURRENT_DATE, \"%d\")) ORDER BY `month`, `day` ASC LIMIT 1";

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

    public static function GetCamp($id)
    {
      if (!$link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS)) {
        return Result::MYSQLERROR;
      }
      if (!$stmt = $link->prepare(Camps::ID_STMT)) {
        return Result::MYSQLERROR;
      }
      if (!$stmt->execute(array($id))) {
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

    static function _FetchToCampArray($stmt)
    {
      $camps = array();
      $raw = $stmt->fetchAll(PDO::FETCH_CLASS, 'Camp');
      foreach ($raw as &$camp) {
        array_push($camps, $camp);
      }
      return $camps;
    }
  }

  class Camp
  {
    public $_id, $year, $month, $day, $week, $theme;
  }

?>
