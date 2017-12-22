<?php

  require_once("../config.php");

  $a = GetFromURL('a','campers');

  if (file_exists("pages/$a.php")) {

  } else {
    include("pages/404.php");
    OutputPage();
    exit;
  }
?>
