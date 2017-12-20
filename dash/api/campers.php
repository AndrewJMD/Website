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
    case "all":
      $campers = Campers::GetAllCampers();
      if (gettype($campers) != "array") {
        $response = array(
          "code" => $campers
        );
      } else {
        $response = array(
          "code" => Result::VALID,
          "data" => $campers
        );
      }
      echo json_encode($response);
  }
?>
