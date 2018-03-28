<?php
  require("../../config.php");
  require("../../secrets.php");
  require("../libs/campers.php");

  $returning  = isset($_POST['returning']);
  $github     = $_POST['username'];

  if ($returning) {

  } else {

    $info = array(
      "name"          => $_POST['name'],
      "username"      => $github,
      "dob"           => $_POST['dob'],
      "phone"         => $_POST['phone'],
      "health"        => $_POST['health'],
      "prov"          => $_POST['prov'],
      "medical"       => $_POST['medical'],
      "shirt"         => $_POST['shirt'],

      "parent_name"   => $_POST['parent_name'],
      "parent_phone"  => $_POST['parent_phone'],
      "parent_email"  => $_POST['parent_email'],
      "parent_drive"  => $_POST['parent_drive'] ? "1" : "0"
    );

    $ret = Campers::Register($info);

    if (!$link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS)) {
      return array("code" => Result::MYSQLERROR);
    }
    $link->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $stmt = $link->prepare("INSERT INTO `hear` (`id`, `camper`, `text`) VALUES (NULL, :camper, :text);");
    $stmt->bindParam(":camper",   $ret['id']);
    $stmt->bindParam(":text", $_POST['hear']);
    $stmt->execute();

    echo json_encode($ret);

  }
?>
