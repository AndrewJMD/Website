<?php

  require_once("../libs/passwords.php");

  class Auth
  {

    public static function Login($username, $password)
    {
      $link = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);
      if (!$link) {
        return Result::MYSQLERROR;
      }
      else {
        if ($result = $link->query("SELECT * FROM `users` WHERE `username` = '$username' LIMIT 1;")) {
          $row = $result->fetch_array(MYSQLI_ASSOC);
          $login = Result::INVALID;
          if ($row['hash_pass'] == 0) {
            if ($password == $row['password']) {
              $login = Result::VALID;
              $link->query("UPDATE `users` SET `password` = '".Passwords::GeneratePassword($password)."', `hash_pass` = '1' WHERE `username` = '$username'");
            }
          } else {
            if (Passwords::Verify($row['password'],$password)) {
              $login = Result::VALID;
              if (Passwords::NeedNew($row['password'])) {
                $link->query("UPDATE `users` SET `password` = '".Passwords::GeneratePassword($password)."' WHERE `username` = '$username'");
              }
            }
          }
          if ($login == Result::VALID) {

            $_SESSION['id']         = $row['id'];
            $_SESSION['level']      = $row['level'];
            $_SESSION['name']       = $row['name'];
            $_SESSION['username']   = $row['username'];

            if ($row['change_pass'] == 1) {
              $login = Result::CHANGE;
            }
          }
          return $login;
        }
      }
    }

    public static function Check($username, $password)
    {
      $link = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);
      if (!$link) {
        return Result::MYSQLERROR;
      }
      else {
        if ($result = $link->query("SELECT * FROM `users` WHERE `username` = '$username' LIMIT 1;")) {
          $row = $result->fetch_array(MYSQLI_ASSOC);
          $login = Result::INVALID;
          if ($row['hash_pass'] == 0) {
            if ($password == $row['password']) {
              $login = Result::VALID;
            }
          } else {
            if (Passwords::Verify($row['password'],$password)) {
              $login = Result::VALID;
            }
          }
          if ($login == Result::VALID) {
            return $row['level'];
          }else{
            return -1;
          }
        }
      }
    }

    public static function ChangePassword($username, $password)
    {
      if ($_SESSION['id'] != -1) {
        $link = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);
        if(!$link)
        {
          return Result::MYSQLERROR;
        }
        $passwordn = Passwords::GeneratePassword($password);
        $link->query("UPDATE `users` SET `password` = '$passwordn', `hash_pass` = '1', `change_pass` = '0' WHERE `username` = '$username'");

        return Result::VALID;
      } else {
        return Result::INVALID;
      }
    }

  }
?>
