<?php

  require_once("../../config.php");
  require_once("../../secrets.php");

  class Payments {

  }

  class Stripe {

    function __construct() {
      \Stripe\Stripe::setApiKey(Secrets::STRIPE_SECRET);
    }

    private static function _getUserIP() {
      if( array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')>0) {
          $addr = explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
          return trim($addr[0]);
        } else {
          return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
      }
      else {
        return $_SERVER['REMOTE_ADDR'];
      }
    }

    function charge($token, $description, $amount, $camper, $email, $phone) {
      try {
        $charge = \Stripe\Charge::create(array(
          "amount"      => $amount,
          "currency"    => "cad",
          "source"      => $token,
          "description" => $description
        ));

        $link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS);
        $stmt = $link->prepare("INSERT INTO `payments` (`_id`, `camper`, `method`, `currency`, `billing_first_name`, `billing_last_name`, `billing_city`, `billing_state`, `billing_postal`, `billing_email`, `billing_phone`, `billing_address`, `transaction_id`, `net_revenue`, `cart_total`, `paid_date`, `ip_address`, `camp`, `live`)
                                VALUES (NULL, :camper, '1', 'CAD', NULL, NULL, NULL, NULL, NULL, :email, :phone, NULL, '".$charge->id."', NULL, :amount, '".date("Y-m-d H:i:s")."', '".Stripe::_getUserIP()."', NULL, :live);");

        $live = $charge->livemode ? '1' : '0';

        $stmt->bindParam(":camper",  $camper);
        $stmt->bindParam(":email",   $email);
        $stmt->bindParam(":phone",   $phone);
        $stmt->bindParam(":amount",  $amount);
        $stmt->bindParam(":live",    $live);

        $stmt->execute();

        return array(
          "code"  => Result::VALID,
          "id"    => $charge->id,
          "live"  => $charge->livemode
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
