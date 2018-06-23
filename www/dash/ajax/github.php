<?php
  require("../../config.php");
  require("../../secrets.php");
  require("../libs/campers.php");

  echo json_encode(Campers::AddGithub($_POST['camper'], $_POST['github']));
?>
