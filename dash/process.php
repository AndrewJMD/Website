<?php
  require("../config.php");

  $f = GetFromURL('f','null');

  switch ($f) {
    case 'login':
      require_once("../libs/auth.php");
      $username = GetFromURL('username');
      $password = GetFromURL('password');
      echo "{\"result\":".Auth::Login($username, $password)."}";
      break;

    default:
      # code...
      break;
  }
?>
