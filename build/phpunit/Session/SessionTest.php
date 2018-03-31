<?php

  declare(strict_types=1);

  require_once("www/libs/session.php");
  require_once("www/config.php");

  use PHPUnit\Framework\TestCase;

  /**
  * @covers Session
  */
  final class SessionTest extends TestCase
  {
    public function testAdminAllowedAdmin()
    {
      $this->assertTrue(Session::Allowed(Level::ADMIN, Level::ADMIN));
    }

    public function testAdminAllowedAdminCamper()
    {
      $this->assertTrue(Session::Allowed(Level::ADMIN, Level::ADMIN + Level::CAMPER));
    }

    public function testCamperAllowedAdminCamper()
    {
      $this->assertTrue(Session::Allowed(Level::CAMPER, Level::ADMIN + Level::CAMPER));
    }

    public function testCamperAllowedCamper()
    {
      $this->assertTrue(Session::Allowed(Level::CAMPER, Level::CAMPER));
    }

    public function testCamperNotAllowedAdmin()
    {
      $this->assertFalse(Session::Allowed(Level::CAMPER, Level::ADMIN));
    }

    public function testGuestNotAllowedAdmin()
    {
      $this->assertFalse(Session::Allowed(Level::GUEST, Level::ADMIN));
    }

  }

?>
