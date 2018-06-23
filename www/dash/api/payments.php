<?php
  require_once("../../config.php");
  require_once("../../secrets.php");
  require_once(DROOT."libs/session.php");
  require_once(DROOT."dash/libs/payments.php");

  header('Content-Type: application/json');

  $f = GetFromURL("f","ping");

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

  function deny() {
    echo json_encode(array("code" => Result::INSUFFICIENT));
  }

  use function Cekurte\Environment\env;
  use Cekurte\Environment\Environment;

  if (class_exists("Cekurte\Environment\Environment")) {
    if (!Environment::get("CIRCLECI", false) && class_exists("Session")) {
      if (Session::Allowed($_SESSION['level'], Level::ADMIN)) {
        switch ($f) {
          case "ping":
            output("pong", "string");
            break;

          case "username":
            output(Payments::GetFromUsername(GetFromURL('a', ''), GetFromURL('b', NULL)));
            break;

          case "camper":
            output(Payments::GetFromID(GetFromURL('a', ''), GetFromURL('b', NULL)));
            break;

          case "id":
            output(Payments::GetByID(GetFromURL('a', '')), "object");
            break;

          case "year":
            output(Payments::FromYear(GetFromURL('a', date("Y"))));
            break;

          case "update":
            output((new Stripe())->update(GetFromURL('a', NULL)));
            break;

          default:
            echo json_encode(array("code" => Result::INVALID));
        }
      } else {
        deny();
      }
    } else {
      deny();
    }
  } else {
    deny();
  }
?>
