<?php
  require_once("../../config.php");
  require_once("../../secrets.php");
  require_once(DROOT."libs/session.php");
  require_once(DROOT."dash/libs/payments.php");
  require_once(DROOT."dash/libs/email.php");

  $payment = Payments::GetFromID(1209, 2018)[0];

  $receipt = new Receipt("brett@bmandesigns.com", "Brett Mayson", array(array("Week 1", "$350.00")), $payment);

  echo $receipt->message;

  echo Email::sendObject($receipt);
?>
