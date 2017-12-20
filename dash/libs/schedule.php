<?php

  class Schedule {

    public static function GetDay($day, $camp)
    {
      $link = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);
      if (!$link) {
        return Result::MYSQLERROR;
      }
      if ($result = $link->query(
        "SELECT `sessions`.*,
          (SELECT `color` FROM `session_types`
            WHERE `session_types`.`_id` = `sessions`.`type`) as color
          FROM `sessions`
          WHERE
            (`day` = '$day') AND
            (`camp` = '$camp');"
      )) {
        return $result->fetch_all(MYSQLI_ASSOC);
      } else {
        return Result::INVALID;
      }
    }

    public static function GetLength($start, $end)
    {
      $length = intval(substr($end,0,2)) - intval(substr($start,0,2));
      $length += floatval(intval(substr($end,2,2)) - intval(substr($start,2,2))) / 60.0;
      return $length;
    }

  }

?>
