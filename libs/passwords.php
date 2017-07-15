<?php

  class Passwords
  {

    const PASSWORD_CURRENT_VERSION = 1;

    public static function GeneratePassword($text,$version = self::PASSWORD_CURRENT_VERSION,$salt = "GEN"){
      if($version == 1){
        if($salt == "GEN")
          $salt = base64_encode(mcrypt_create_iv(ceil(0.75*16), MCRYPT_DEV_URANDOM));
        $pass = hash('sha512',$salt.$text);
      }
      return $version."$".$salt."$".$pass;
    }

    public static function Verify($hash,$pass){
      $data = explode("$",$hash);
      if($data[0] == '1'){
        $pass = self::GeneratePassword($pass,1,$data[1]);
        return $pass == $hash;
      }
    }

    public static function NeedNew($hash){
      $data = explode("$",$hash);
      return $data[0] != self::PASSWORD_CURRENT_VERSION;
    }

  }

?>
