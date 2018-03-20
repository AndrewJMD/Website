<?php
  require("../../config.php");
  require("../../secrets.php");
  require("../libs/camps.php");

  echo json_encode(array("code" => Camps::Attend($_POST['camper'], $_POST['camp'])));
?>
