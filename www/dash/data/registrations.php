<?php

  header('Content-Type: application/json');

  require("../../config.php");
  require("../../libs/session.php");
  require("../../secrets.php");

  $ret = array();

  if (Session::Allowed($_SESSION['level'], Level::ADMIN)) {
    $ret['code'] = Result::VALID;

    $dates  = array();
    $ticks  = array();
    $points = array();

    $link = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);
    $minyear = intval(date("Y")) - 5;
    $minyear = ($minyear >= 2016) ? $minyear : 2016;
    foreach (range($minyear, intval(date("Y"))) as $year) {
      $qpayment = $link->query("SELECT `camper`,`paid_date` FROM `payments` WHERE `paid_date` LIKE '$year%' GROUP BY `camper`, `paid_date` ORDER BY `paid_date`");
      $total = 0;
      $data = array();
      while ($payment = $qpayment->fetch_array(MYSQLI_ASSOC)) {
        $date = explode("-", explode(" ", $payment['paid_date'])[0]);
        $date[0] = "2000";
        $date = strtotime(implode("-", $date));
        $total += 1;
        if (in_array($date, $data)) {
          $data[$date] += 1;
        } else {
          $data[$date] = $total;
        }
        if (!in_array($date, $dates)) {
          $dates[$date] = (new DateTime("@$date"))->format("M d");
        }
      }
      $data_array = array();
      foreach ($data as $key => $value) {
        array_push($data_array, array($key, $value));
      }
      array_push($points,
        array("data" => $data_array, "label" => $year, "lines" => array("show" => True))
      );
    }
    $ret['points'] = $points;
    $previous = 0;
    foreach ($dates as $date => $day) {
      if ($date - $previous > 86400 * 10) {
        array_push($ticks, array($date, $day));
        $previous = $date;
      }
    }
    $ret['ticks'] = $ticks;
  } else {
    $ret['code'] = Result::INSUFFICIENT;
  }

  echo json_encode($ret);

?>
