<?php
  require("../config.php");
  require("../secrets.php");
  require("../libs/session.php");

  $f = GetFromURL('f','ping');

  switch ($f) {
    case 'signout':
      $_SESSION['id'] = -1;
      $_SESSION['username'] = "";
      $_SESSION['level'] = -1;
      $_SESSION['name'] = "";
      echo json_encode(
        array(
          "code" => Result::REDIRECT,
          "location" => DASH
        )
      );
      break;

    case 'setweek':
      require_once("libs/camps.php");
      $camp = Camps::GetCamp(GetFromURL('camp'));
      if (gettype($camp) == "object") {
        $_SESSION['camp'] = (array) $camp;
        echo json_encode(
          array(
            "code" => Result::VALID
          )
        );
      } else {
        echo json_encode(
          array(
            "code" => Result::INVALID
          )
        );
      }
      break;

    default:
      echo json_encode(
        array(
          "code" => Result::VALID,
          "result" => "pong"
        )
      );
      break;
  }
?>
