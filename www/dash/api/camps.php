<?php
  require_once("../../config.php");
  require_once("../../secrets.php");
  require_once(DROOT."libs/session.php");
  require_once(DROOT."dash/libs/camps.php");

  header('Content-Type: application/json');

  $f = GetFromURL("f","ping");

  function output($raw, $type = "array")
  {
    if (gettype($raw) != $type) {
      $response = array(
        "code" => $raw
      );
    } else {
      $response = array(
        "code" => Result::VALID,
        "data" => $raw
      );
    }
    echo json_encode($response);
  }

  switch($f) {
    case "ping":
      output("pong", "string");
      break;

    case "all":
      output(Camps::GetCamps());
      break;

    case "year":
      output(
        Camps::GetCampsByYear(
          GetFromURL("a", date("Y"))
        )
      );
      break;

    case "current":
      output(Camps::GetCurrentCamp(), "object");
      break;

    default:
      echo json_encode(array("code" => Result::INVALID));
  }
?>
