<?php
  require_once("../libs/passwords.php");

  class Auth
  {

    const LOGIN_STMT  = "SELECT * FROM `users` WHERE (CASE WHEN `level` = '1' THEN LCASE(`name`) ELSE CONCAT(SUBSTRING_INDEX(`name`,' ',1),'.',`discriminator`) END) = ? LIMIT 1;";
    const HASH_STMT   = "UPDATE `users` SET `password` = :password, `hash_pass` = '1' WHERE (CASE WHEN `level` = '1' THEN LCASE(`name`) ELSE CONCAT(SUBSTRING_INDEX(`name`,' ',1),'.',`discriminator`) END) = :username";
    const UPDATE_STMT = "UPDATE `users` SET `password` = :password WHERE (CASE WHEN `level` = '1' THEN LCASE(`name`) ELSE CONCAT(SUBSTRING_INDEX(`name`,' ',1),'.',`discriminator`) END) = :username";
    const CHANGE_STMT = "UPDATE `users` SET `password` = :password, `hash_pass` = '1', `change_pass` = '0' WHERE (CASE WHEN `level` = '1' THEN LCASE(`name`) ELSE CONCAT(SUBSTRING_INDEX(`name`,' ',1),'.',`discriminator`) END) = :username";

    public static function Login($username, $password)
    {
      $result = Auth::Check($username, $password);
      if (
        $result['result'] == Result::VALID ||
        $result['result'] == Result::CHANGE
      ) {
        $_SESSION['id']         = $result['id'];
        $_SESSION['level']      = $result['level'];
        $_SESSION['name']       = $result['name'];
        $_SESSION['camp']       = -1;
      }
      return $result;
    }

    public static function Check($username, $password)
    {
      $ret = array("result" => Result::MYSQLERROR, "text" => "");
      if (!$link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS)) {
        $ret['result'] = Result::MYSQLERROR;
        $ret['text'] = "Failed to connect";
        return $ret;
      }
      if (!$stmt = $link->prepare(Auth::LOGIN_STMT)) {
        $ret['result'] = Result::MYSQLERROR;
        $ret['text'] = "Failed to prepare LOGIN";
        return $ret;
      }
      if (!$stmt->execute(array($username))) {
        $ret['result'] = Result::MYSQLERROR;
        $ret['text'] = "Failed to execute LOGIN";
        return $ret;
      }
      if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //User Found
        $login = Result::INVALID;
        if ($user['hash_pass'] == 0) {
          //The user's password is currently stored in plain text
          if ($password == $user['password']) {
            $login = Result::VALID;
            $newpass = Passwords::GeneratePassword($password);
            if (!$h_stmt = $link->prepare(Auth::HASH_STMT)) {
              $ret['result'] = Result::MYSQLERROR;
              $ret['text'] = "Failed to prepare HASH";
              return $ret;
            }
            if (
              !$h_stmt->bindParam(":password", $newpass) ||
              !$h_stmt->bindParam(":username", $username)
            ) {
              $ret['result'] = Result::MYSQLERROR;
              $ret['text'] = "Failed to bind HASH";
              return $ret;
            }
            if (!$h_stmt->execute()) {
              $ret['result'] = Result::MYSQLERROR;
              $ret['text'] = "Failed to execute HASH";
              return $ret;
            }
          }
        } else {
          //The user's password is hashed
          if (Passwords::Verify($user['password'], $password)) {
            $login = Result::VALID;
            if (Passwords::NeedNew($user['password'])) {
              //The user's password was hashed using an older method and needs to be updated
              $newpass = Passwords::GeneratePassword($password);
              if (!$u_stmt = $link->prepare(Auth::UPDATE_STMT)) {
                $ret['result'] = Result::MYSQLERROR;
                $ret['text'] = "Failed to prepare UPDATE";
                return $ret;
              }
              if (
                !$u_stmt->bindParam(":password", $newpass) ||
                !$u_stmt->bindParam(":username", $username)
              ) {
                $ret['result'] = Result::MYSQLERROR;
                $ret['text'] = "Failed to bind UPDATE";
                return $ret;
              }
              if (!$u_stmt->execute()) {
                $ret['result'] = Result::MYSQLERROR;
                $ret['text'] = "Failed to execute UPDATE";
                return $ret;
              }
            }
          }
        }
        if ($user['change_pass'] == 1) {
          $login = Result::CHANGE;
        }
        $ret['result']  = $login;
        $ret['id']      = $user['_id'];
        $ret['level']   = $user['level'];
        $ret['name']    = $user['name'];
        return $ret;
      } else {
        //User not found
        $ret['result'] = Result::INVALID;
        return $ret;
      }
    }

    public static function ChangePassword($username, $password)
    {
      if ($_SESSION['id'] != -1) {
        $ret = array("result" => Result::MYSQLERROR, "text" => "");
        if (!$link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS)) {
          $ret['result'] = Result::MYSQLERROR;
          $ret['text'] = "Failed to connect";
          return $ret;
        }
        $newpass = Passwords::GeneratePassword($password);
        if (!$stmt = $link->prepare(Auth::CHANGE_STMT)) {
          $ret['result'] = Result::MYSQLERROR;
          $ret['text'] = "Failed to prepare CHANGE";
          return $ret;
        }
        if (
          !$stmt->bindParam(":password", $newpass) ||
          !$stmt->bindParam(":username", $username)
        ) {
          $ret['result'] = Result::MYSQLERROR;
          $ret['text'] = "Failed to bind CHANGE";
          return $ret;
        }
        if (!$stmt->execute()) {
          $ret['result'] = Result::MYSQLERROR;
          $ret['text'] = "Failed to execute CHANGE";
          return $ret;
        }
        $ret['result'] = Result::VALID;
        return $ret;
      } else {
        $ret['result'] = Result::INSUFFICIENT;
      }
    }
  }
?>
