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
    );

    public function testCreateStartData()
    {
      $link = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);

      //Create Fake Admin
      $link->query("
        INSERT INTO `users` (`_id`, `name`, `username`, `dob`, `health`, `prov`, `medical`, `cellphone`, `phone`, `parents`, `email`, `gender`, `level`)
        VALUES (NULL, 'John Smith', 'jsmith', '', '', '', '', '', '', '', '', '', 1);
      ");

      //Create Fake Camper
      $link->query("
        INSERT INTO `users` (`_id`, `name`, `username`, `dob`, `health`, `prov`, `medical`, `cellphone`, `phone`, `parents`, `email`, `gender`, `level`)
        VALUES (NULL, 'Joe Baker', 'codekid', '12/01/2000', '123456789', 'SK', 'Fake', '(306) 555-1234', '(306) 555-4321', 'Jane Baker', 'jane@baker.ca', '', 2);
      ");

      $this->assertEquals(2, $link->insert_id);

      //Create Fake Camper without username
      $link->query("
        INSERT INTO `users` (`_id`, `name`, `username`, `dob`, `health`, `prov`, `medical`, `cellphone`, `phone`, `parents`, `email`, `gender`, `level`)
        VALUES (NULL, 'John Doe', '', '12/01/2000', '123456789', 'SK', 'Fake', '(306) 555-1234', '(306) 555-4321', 'Jane Doe', 'jane@doe.ca', '', 2);
      ");

      $this->assertEquals(3, $link->insert_id);

      //Create Fake 2018 Camp
      $link->query("
        INSERT INTO `camps` (`_id`, `year`, `month`, `day`, `week`, `theme`)
        VALUES (NULL, 2018, 7, 2, 1, 'Camp Theme 1');");
      $link->query("
        INSERT INTO `camps` (`_id`, `year`, `month`, `day`, `week`, `theme`)
        VALUES (NULL, 2018, 7, 6, 2, 'Camp Theme 2');");

      $this->assertEquals(2, $link->insert_id);
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

    public function testAddGitHub()
    {
      $result = Campers::AddGithub(3, "procode");
      $this->assertEquals(1, $result['code']);
    }

    public function testGetCamperByUsernameAfterGitHub()
    {
      $camper = Campers::GetFromUsername("procode");
      $this->expectOutputString("John");
      print $camper->first;
    }

    public function testAllCampers()
    {
      $campers = count(Campers::GetAllCampers());
      $this->assertEquals(3, $campers);
    }
  }
?>
