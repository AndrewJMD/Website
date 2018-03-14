<?php

  require_once("../../config.php");
  require_once("../../secrets.php");

  class Payments {

  }

  class Stripe {
    function __construct() {
      \Stripe\Stripe::setApiKey(Secrets::STRIPE_SECRET);
    }

    function charge($token, $description, $amount) {
      try {
        $charge = \Stripe\Charge::create(array(
          "amount" => $amount,
          "currency" => "cad",
          "source" => $token,
          "description" => $description
        ));
        return array(
          "code" => Result::VALID,
          "id" => $charge->id,
          "live" => $charge->livemode
        );
      } catch(\Stripe\Error\Card $e) { // Failed to charge card
        return _error($e);
      } catch (\Stripe\Error\RateLimit $e) { // Too many requests recently
        return _error($e);
      } catch (\Stripe\Error\InvalidRequest $e) { // Invalid parameters
        return _error($e);
      } catch (\Stripe\Error\Authentication $e) { // Authentication failed
        return _error($e);
      } catch (\Stripe\Error\ApiConnection $e) { // Network communication failed
        return _error($e);
      } catch (\Stripe\Error\Base $e) { //Generic Error
        return _error($e);
      } catch (Exception $e) { //Non-stripe error
        return _error($e);
      }
    }

    function _error($e) {
      $err = $e->getJsonBody()['error'];
      return array(
        "code" => Result::INVALID,
        "status" => $error->getHttpStatus(),
        "type" => $err['type'],
        "ecode" => $err['code'],
        "param" => $err['param'],
        "message" => $err['message']
      );
    }
  }

?>
