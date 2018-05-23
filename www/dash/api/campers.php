<?php
  require_once("../../config.php");
  require_once("../../secrets.php");
  require_once(DROOT."libs/session.php");
  require_once(DROOT."dash/libs/campers.php");

  header('Content-Type: application/json');

  $f = GetFromURL("f","ping");

  function removeEmpty($raw) {
    $campers = array();
    foreach ($raw as $camper)
    {
      $finalcamper = array();
      foreach ($camper as $key=>$value)
      {
        if (!(is_null($value) || $value == ''))
        {
          $finalcamper[$key] = $value;
        }
      }
      array_push($campers, $finalcamper);
    }
    return $campers;
  }

  function output($raw, $type = "array")
  {
    echo json_encode((gettype($raw) != $type) ?
      array(
        "code" => $raw
      ) :
      array(
        "code" => Result::VALID,
        "data" => $raw
      )
    );
  }

  switch ($f) {
    case "ping":
      output("pong", "string");
      break;

    case "all":
      $raw = Campers::GetAllCampers(GetFromURL("a","simple"));
      if (gettype($raw) != "array") {
        $response = array(
          "code" => $raw
        );
      } else {
        $campers = removeEmpty($raw);
        $response = array(
          "code" => Result::VALID,
          "data" => $campers
        );
      }
      echo json_encode($response);
      break;

    case "year":
      $raw = Campers::GetCampersFromYear(GetFromURL("a",date("Y")), GetFromURL("b","simple"));
      if (gettype($raw) != "array") {
        $response = array(
          "code" => $raw
        );
      } else {
        $campers = removeEmpty($raw);
        $response = array(
          "code" => Result::VALID,
          "data" => $campers
        );
      }
      echo json_encode($response);
      break;

    case "camp":
      $raw = Campers::GetCampersFromCamp(GetFromURL("a",$_SESSION['camp']['_id']), GetFromURL("b","simple"));
      if (gettype($raw) != "array") {
        $response = array(
          "code" => $raw
        );
      } else {
        $campers = removeEmpty($raw);
        $response = array(
          "code" => Result::VALID,
          "data" => $campers
        );
      }
      echo json_encode($response);
      break;

    case "get":
      $raw = Campers::GetFromUsername(GetFromURL("a",""), GetFromURL("b","simple"));
      output($raw, "object");
      break;

    case "fetch":
      $raw = Campers::GetFromID(GetFromURL("a",""), GetFromURL("b","simple"));
      output($raw, "object");
      break;

    default:
      echo json_encode(array("code" => Result::INVALID));
  }
?>
