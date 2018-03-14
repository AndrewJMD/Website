<?php
  $token  = $_POST['token'];
  $amount = $_POST['amount'];

  require("../libs/payment.php");

  $stripe = new Stripe();

  echo json_encode($stripe->charge($token, "CompCamps", $amount));
?>
