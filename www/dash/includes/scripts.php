<?php
  require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
  if (!isset($a)) {
    $a = GetFromURL('a','dashboard');
  }
  if (file_exists(DROOT."dash/js/pages/$a")) {
    $files = scandir(DROOT."dash/js/pages/$a");
    foreach ($files as &$file) {
      if ($file[0] != ".")
        echo "<script class='pagejs' src=\"".DASH."js/pages/$a/$file\"></script>";
    }
  }
?>
