<?php
  $token  = $_POST['token'];
  $amount = $_POST['amount'];
  $camper = $_POST['camper'];
  $email  = $_POST['email'];
  $phone  = $_POST['phone'];

  require("../libs/payment.php");

  $stripe = new Stripe();

  echo json_encode($stripe->charge($token, "CompCamps", $amount, $camper, $email, $phone));
?>
