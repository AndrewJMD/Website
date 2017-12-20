<?php
  require("../config.php");
  require("../libs/session.php");

  $f = GetFromURL('f','null');

  switch ($f) {
    case 'login':
      require_once("../libs/auth.php");
      $username = GetFromURL('username');
      $password = GetFromURL('password');
      echo "{\"result\":".Auth::Login($username, $password)."}";
      break;

    case 'change':
      require_once("../libs/auth.php");
      $password = GetFromURL('password');
      echo "{\"result\":".Auth::ChangePassword($_SESSION['username'], $password)."}";
      break;

    case 'signout':
      $_SESSION['id'] = -1;
      $_SESSION['username'] = "";
      $_SESSION['level'] = 0;
      $_SESSION['name'] = "";

    default:
      # code...
      break;
  }
?>
