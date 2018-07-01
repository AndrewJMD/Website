<?php
  require("../../config.php");
  require("../../secrets.php");
  require("../libs/campers.php");

  if (!$link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS)) {
    return array("code" => Result::MYSQLERROR);
  }
  $link->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  $stmt = $link->prepare("INSERT INTO `addresses` (`id`, `camper`, `street_number`, `street`, `locality`, `province`, `postal_code`, `country`) VALUES (NULL, :camper, :street_number, :street, :locality, :province, :postal_code, :country);");
  $stmt->bindParam(":camper", $_POST['camper']);
  $stmt->bindParam(":street_number", $_POST['street_number']);
  $stmt->bindParam(":street", $_POST['street']);
  $stmt->bindParam(":locality", $_POST['locality']);
  $stmt->bindParam(":province", $_POST['province']);
  $stmt->bindParam(":postal_code", $_POST['postal_code']);
  $stmt->bindParam(":country", $_POST['country']);
  $stmt->execute();

  echo json_encode(Result::VALID);
?>
