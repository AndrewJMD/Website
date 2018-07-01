<?php

  header('X-Frame-Options: DENY');

  require_once("../config.php");
  require_once("../secrets.php");
  require_once("../libs/session.php");

  GeneratePageDefaults();

  $a = GetFromURL('a','dashboard');

  if ($_SESSION['id'] == -1 && ($a != "login" && $a != "register" && $a != "checkin")) {
    header("Location: login");
  }

  if (file_exists("pages/$a.php")) {
    include("pages/$a.php");
    if ($PAGE_TYPE == "custom") {
      OutputPage();
    } else {
      include("template.php");
    }
  } else {
    include("pages/404.php");
    include("template.php");
    exit;
  }

?>
