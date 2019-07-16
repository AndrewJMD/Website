<?php
  require("../../config.php");
  require("../../secrets.php");
  require("../libs/camps.php");

  $info = array(
    "camper"    => $_POST["camper"],
    "camp"      => $_POST["camp"],
    "drive"     => $_POST['drive'],
    "shirt"     => $_POST['shirt'],
    "pizza"     => $_POST['pizza'],
    "hear"      => $_POST['hear']
  );
  echo json_encode(array("code" => Camps::Attend($info)));
?>
