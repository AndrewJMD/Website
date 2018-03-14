<?php
  require("../../config.php");
  require("../libs/campers.php");

  $returning  = isset($_POST['returning']);
  $github     = $_POST['github'];

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

      "parent_name"   => $_POST['parent_name'],
      "parent_phone"  => $_POST['parent_phone'],
      "parent_email"  => $_POST['parent_email']
    );

    echo json_encode(array("code" => Campers::Register($info)));

  }
?>
