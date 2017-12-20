<?php
  session_start();

  if(!isset($_SESSION['id']))
  {
    $_SESSION['id'] = -1;
  }

  class Session
  {

    /*
      Level::ADMIN is 1 in base 2 (1 in base 10)
      Level::CAMPER is 10 in base 2 (2 in base 10)

      Level::ADMIN + Level::CAMPER = 11 (3 in base 10)

      This function checks to see if a number is present in the provided power of 2
      by checking if the corresponding place in base 2 is 1

      This is scalable to PHP_INT_MAX, usually 2147483647
      This only works with powers of 2 (1, 2, 4, 8, 16, 32) as the role value
    */
    public static function Allowed($user, $required) {
      $v = decbin($required);
      return ($v[strlen($v) - strlen(decbin($user))] == 1);
    }

  }
?>
