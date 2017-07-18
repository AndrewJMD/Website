<?php

  //MYSQL
  define("MYSQL_SERVER","localhost");
  define("MYSQL_DATABASE","compcamps");
  define("MYSQL_USER","mentor");
  define("MYSQL_PASS","admin");

  abstract class Result
  {
    const VALID       = 0;
    const INVALID     = 1;
    const CHANGE      = 2;
    const MYSQLERROR  = 50;
  }

  function GetFromURL($tag,$default = "") {
    if (isset($_REQUEST[$tag])) {
      return $_REQUEST[$tag];
    } else {
      return $default;
    }
  }

  function HumanFilesize($bytes, $decimals = 2) {
    $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
  }

  function GeneratePageDefaults() {
    global $PAGE_TYPE;
    global $PAGE_GUEST_ALLOWED;
    $PAGE_TYPE = "NORMAL";
    $PAGE_GUEST_ALLOWED = False;
  }
?>
