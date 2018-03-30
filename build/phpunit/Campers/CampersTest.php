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
      "name" => "Jeremy Doe",
      "username" => "jcoder",
      "dob" => "12/10/2003",
      "health" => "987654321",
      "prov" => "SK",
      "medical" => "Not Real",
      "cellphone" => "(306) 555-9876",
      "parent_phone" => "(306) 555-6789",
      "parent_name" => "Jake Doe",
      "parent_email" => "jake@doe.com",
      "parent_drive" => "1",
      "shirt" => "Youth Medium",
    );

    public function testGetCamperByUsername()
    {
      $camper = Campers::GetFromUsername("codekid");
      $this->expectOutputString("Joe");
      print $camper->first;
    }

    public function testRegisterCamper()
    {
      $camper = Campers::Register(CampersTest::EX_DATA);
      $this->assertEquals(1, $camper['code']);
    }

    public function testAllCampers()
    {
      $campers = count(Campers::GetAllCampers());
      $this->assertEquals(2, $campers);
    }
  }
?>
