<?php
  $amount = $_POST['amount'];
  $camper = $_POST['camper'];
  $email  = $_POST['email'];
  $phone  = $_POST['phone'];

  require("../libs/payments.php");

  echo json_encode(Payments::AddCheque($amount, $camper, $email, $phone));
?>
