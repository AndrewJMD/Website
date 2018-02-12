<?php

  declare(strict_types=1);

  require_once("www/config.php");
  require_once("www/libs/session.php");

  use PHPUnit\Framework\TestCase;

  /**
  * @covers Passwords
  */
  final class PasswordsTest extends TestCase
  {
    public function testCanPasswordBeGeneratedV1()
    {
      $this->expectOutputString("1\$test\$e9e633097ab9ceb3e48ec3f70ee2beba41d05d5420efee5da85f97d97005727587fda33ef4ff2322088f4c79e8133cc9cd9f3512f4d3a303cbdb5bc585415a00");
      print(Passwords::GeneratePassword("password",1,"test"));
    }

    public function testCanVerifyPassword()
    {
      $this->assertTrue(
        Passwords::Verify(
          "1\$test\$e9e633097ab9ceb3e48ec3f70ee2beba41d05d5420efee5da85f97d97005727587fda33ef4ff2322088f4c79e8133cc9cd9f3512f4d3a303cbdb5bc585415a00",
          "password"
        )
      );
    }

    public function testNotNeedNew()
    {
      $this->assertFalse(
        Passwords::NeedNew(Passwords::PASSWORD_CURRENT_VERSION."\$test\$test")
      );
    }
  }
?>
