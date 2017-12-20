<?php
  require_once("../../config.php");
  require_once(DROOT."libs/session.php");
  require_once(DROOT."dash/libs/campers.php");

  header('Content-Type: application/json');

  $f = GetFromURL("f","ping");

  switch($f) {
    case "ping":
      echo "pong";
      break;

    case "campers":
      $raw = Campers::GetAllCampers(GetFromURL("l","simple"));
      if (gettype($raw) != "array") {
        $response = array(
          "code" => $raw
        );
      } else {
        $campers = array();
        foreach($raw as $camper)
        {
          $finalcamper = array();
          foreach($camper as $key=>$value)
          {
            if(!(is_null($value) || $value == ''))
            {
              $finalcamper[$key] = $value;
            }
          }
          array_push($campers, $finalcamper);
        }
        $response = array(
          "code" => Result::VALID,
          "data" => $campers
        );
      }
      echo json_encode($response);
      break;
  }
?>
