<?php

  header('Content-Type: application/json');

  require("../../config.php");
  require("../../libs/session.php");
  require("../../secrets.php");

  $ret = array();

  if (Session::Allowed($_SESSION['level'], Level::ADMIN)) {
    $ret['code'] = Result::VALID;
    $data = array();
    require("../libs/campers.php");
    foreach (range(2007, intval(date("Y"))) as $year) {
      $campers = count(Campers::GetCampersFromYear($year));
      array_push($data, array($year, $campers));
    }
    $ret['data'] = $data;
  } else {
    $ret['code'] = Result::INSUFFICIENT;
  }

  echo json_encode($ret);

?>
