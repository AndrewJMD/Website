<?php

  require("build/phpunit/secrets.php");

  $link = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);

  //Create Users
  $link->query("
    CREATE TABLE `users` (
      `_id` int(4) NOT NULL,
      `name` varchar(32) DEFAULT NULL,
      `username` varchar(32) DEFAULT NULL,
      `dob` varchar(16) DEFAULT NULL,
      `health` varchar(32) DEFAULT NULL,
      `prov` varchar(2) NOT NULL,
      `medical` text NOT NULL,
      `cellphone` varchar(16) NOT NULL,
      `phone` varchar(36) DEFAULT NULL,
      `parents` varchar(64) DEFAULT NULL,
      `email` varchar(64) DEFAULT NULL,
      `gender` varchar(6) DEFAULT NULL,
      `level` int(1) DEFAULT NULL,
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
  ");
  $link->query("ALTER TABLE `users` ADD PRIMARY KEY (`_id`);");
  $link->query("ALTER TABLE `users` MODIFY `_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;");

  //Create Camps
  $link->query("
    CREATE TABLE `camps` (
      `_id` int(2) NOT NULL,
      `year` int(4) DEFAULT NULL,
      `month` int(1) DEFAULT NULL,
      `day` int(2) DEFAULT NULL,
      `week` int(1) DEFAULT NULL,
      `theme` varchar(64) NOT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
  ");
  $link->query("ALTER TABLE `camps` ADD PRIMARY KEY (`_id`);");
  $link->query("ALTER TABLE `camps` MODIFY `_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;");

  //Create Attend
  $link->query("
    CREATE TABLE `attend` (
      `_id` int(3) NOT NULL,
      `camper` int(4) DEFAULT NULL,
      `camp` int(2) DEFAULT NULL
      `drive` tinyint(1) NOT NULL,
      `shirt` varchar(16) DEFAULT NULL,
      `pizza` varchar(32) DEFAULT NULL,
      `hear` text DEFAULT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
  ");
  $link->query("ALTER TABLE `attend` ADD PRIMARY KEY (`_id`);");
  $link->query("ALTER TABLE `attend` MODIFY `_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;");

  $link->query("COMMIT;");

?>
