<?php

  declare(strict_types=1);

  require_once("www/config.php");
  require_once("build/phpunit/secrets.php");

  use PHPUnit\Framework\TestCase;

  /**
  * @covers Camper
  */
  final class CampersTest extends TestCase
  {
    const EX_DATA = array(
      "_id" => "100",
      "name" => "John Doe",
      "username" => "johndoe",
      "dob" => "",
      "health_card" => "ABC123",
      "phone" => "5555824714",
      "parent_name" => "Jake Doe",
      "email" => "jake@icloud.com",
      "health_notes" => "",
      "gender" => "Male",
      "level" => "2",
      "shirt" => "Adult XL",
    );

    public function testCamperCanBeCreatedFromValidRow()
    {
      $this->assertInstanceOf(
        Camper::class,
        new Camper(CampersTest::EX_DATA)
      );
    }

    public function testCamperNameCreatedProperly()
    {
      $camper = new Camper(CampersTest::EX_DATA);
      $this->expectOutputString("johndoe");
      print $camper->username;
    }

    public function testGetCamperByUsername()
    {
      $camper = Camper::GetFromUsername("codekid");
      $this->expectOutputString("Joe");
      print $camper->first;
    }
  }
?>
