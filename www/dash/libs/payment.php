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
        }
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
      }
      return $_SERVER['REMOTE_ADDR'];
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
      } catch (\Stripe\Error\Card $err) { // Failed to charge card
        return _error($err);
      } catch (\Stripe\Error\RateLimit $err) { // Too many requests recently
        return _error($err);
      } catch (\Stripe\Error\InvalidRequest $err) { // Invalid parameters
        return _error($err);
      } catch (\Stripe\Error\Authentication $err) { // Authentication failed
        return _error($err);
      } catch (\Stripe\Error\ApiConnection $err) { // Network communication failed
        return _error($err);
      } catch (\Stripe\Error\Base $err) { //Generic Error
        return _error($err);
      } catch (Exception $err) { //Non-stripe error
        return _error($err);
      }
    }

    function _error($err) {
      $error = $err->getJsonBody()['error'];
      return array(
        "code"    => Result::INVALID,
        "status"  => $err->getHttpStatus(),
        "type"    => $error['type'],
        "ecode"   => $error['code'],
        "param"   => $error['param'],
        "message" => $error['message']
      );
    }

  }

?>
