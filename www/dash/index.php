<?php

  require_once("../config.php");

  GeneratePageDefaults();

  $a = GetFromURL('a','home');

  if (file_exists("pages/$a.php")) {
    include("pages/$a.php");
    if ($PAGE_TYPE == "custom") {
      OutputPage();
    } else {
      input("template.php");
    }
  } else {
    include("pages/404.php");
    include("template.php");
    exit;
  }
?>
