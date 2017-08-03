<?php

  require_once("../config.php");

  $a = GetFromURL('a','home');

  if (file_exists("pages/$a.php")) {

  } else {
    include("pages/404.php");
    include("template.php");
    exit;
  }
?>
