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
      "phone" => "(306) 555-9876",
      "parent_phone" => "(306) 555-6789",
      "parent_name" => "Jake Doe",
      "parent_email" => "jake@doe.com",
      "parent_drive" => "1",
      "shirt" => "Youth Medium",
    );

    public function testCreateStartData()
    {
      //Create Fake Admin
      $link->query("
        INSERT INTO `users` (`_id`, `name`, `username`, `dob`, `health`, `prov`, `medical`, `cellphone`, `phone`, `parents`, `drive`, `email`, `gender`, `level`, `shirt`)
        VALUES (2, 'John Smith', 'jsmith', '', '', '', '', '', '', '', 0, '', '', 1, 'Adult Large');
      ");

      //Create Fake Camper
      $link->query("
        INSERT INTO `users` (`_id`, `name`, `username`, `dob`, `health`, `prov`, `medical`, `cellphone`, `phone`, `parents`, `drive`, `email`, `gender`, `level`, `shirt`)
        VALUES (2, 'Joe Baker', 'codekid', '12/01/2000', '123456789', 'SK', 'Fake', '(306) 555-1234', '(306) 555-4321', 'Jane Baker', 0, 'jane@baker.ca', '', 1, 'Youth Medium');
      ");

      //Create Fake 2018 Camp
      $link->query("
        INSERT INTO `camps` (`_id`, `year`, `month`, `day`, `week`, `theme`)
        VALUES (1, 2018, 7, 2, 1, 'Camp Theme 1');");
      $link->query("
        INSERT INTO `camps` (`_id`, `year`, `month`, `day`, `week`, `theme`)
        VALUES (2, 2018, 7, 6, 2, 'Camp Theme 2');");
    }

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
