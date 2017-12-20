<?php

  require_once("../libs/passwords.php");

  class Auth
  {

    const USERNAME_STR = "(CASE WHEN `level` = '1' THEN LCASE(`name`) ELSE CONCAT(SUBSTRING_INDEX(`name`,' ',1),'.',`discriminator`) END)";

    public static function Login($username, $password)
    {
      $USERNAME_STR = Auth::USERNAME_STR;
      $link = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);
      if (!$link) {
        return Result::MYSQLERROR;
      }
      else {
        if ($result = $link->query("SELECT *FROM `users` WHERE $USERNAME_STR = '$username' LIMIT 1;")) {
          $row = $result->fetch_array(MYSQLI_ASSOC);
          $login = Result::INVALID;
          if ($row['hash_pass'] == 0) {
            if ($password == $row['password']) {
              $login = Result::VALID;
              $link->query("UPDATE `users` SET `password` = '".Passwords::GeneratePassword($password)."', `hash_pass` = '1' WHERE $USERNAME_STR = '$username'");
            }
          } else {
            if (Passwords::Verify($row['password'],$password)) {
              $login = Result::VALID;
              if (Passwords::NeedNew($row['password'])) {
                $link->query("UPDATE `users` SET `password` = '".Passwords::GeneratePassword($password)."' WHERE $USERNAME_STR = '$username'");
              }
            }
          }
          if ($login == Result::VALID) {

            $_SESSION['id']         = $row['_id'];
            $_SESSION['level']      = $row['level'];
            $_SESSION['name']       = $row['name'];
            //$_SESSION['username']   = $row['username'];
            $_SESSION['camp']       = -1;

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
      $USERNAME_STR = Auth::USERNAME_STR;
      $link = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);
      if (!$link) {
        return Result::MYSQLERROR;
      }
      else {
        if ($result = $link->query("SELECT * FROM `users` WHERE $USERNAME_STR = '$username' LIMIT 1;")) {
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
      $USERNAME_STR = Auth::USERNAME_STR;
      if ($_SESSION['id'] != -1) {
        $link = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);
        if(!$link)
        {
          return Result::MYSQLERROR;
        }
        $passwordn = Passwords::GeneratePassword($password);
        $link->query("UPDATE `users` SET `password` = '$passwordn', `hash_pass` = '1', `change_pass` = '0' WHERE $USERNAME_STR = '$username'");

        return Result::VALID;
      } else {
        return Result::INVALID;
      }
    }

  }
?>
