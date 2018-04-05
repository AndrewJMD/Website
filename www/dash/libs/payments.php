<?php

  require_once("../../config.php");
  require_once("../../secrets.php");

  class Payment {
    public $_id, $camper, $method, $method_name, $transaction_id, $cart_total, $paid_date, $ip_address, $status, $total;

    function __construct($row) {
      $this->_id = $row['_id'];
      $this->camper = $row['camper'];
      $this->method = $row['method'];
      $this->transaction_id = $row['transaction_id'];
      if (strpos($row['cart_total'], ".") !== false) {
        $this->cart_total = explode(".", $row['cart_total'])[0]."00";
      } else {
        $this->cart_total = $row['cart_total'];
      }
      setlocale(LC_MONETARY, 'en_US.UTF-8');
      $this->total = money_format('%.2n', $this->cart_total / 100);
      $this->paid_date = $row['paid_date'];
      $this->ip_address = $row['ip_address'];
      $this->status = $row['status'];

      $link = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);
      $this->method_name = $link->query("SELECT `name` FROM `payment_methods` WHERE `_id` = '".$this->method."'")->fetch_array(MYSQLI_ASSOC)['name'];
    }
  }

  class Payments {
    public static function GetFromUsername($username, $year = NULL) {
      if (!$link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS)) {
        return array("code" => Result::MYSQLERROR);
      }
      if (!$stmt = $link->prepare("SELECT `_id` FROM `users` WHERE `username` = ?")) {
        return Result::MYSQLPREPARE;
      }
      if ($stmt->execute(array($username))) {
        if ($stmt->rowCount() == 1)
          return Payments::GetFromID($stmt->fetch(PDO::FETCH_ASSOC)['_id'], $year);
        return Result::NOTFOUND;
      }
      return Result::INVALID;
    }

    public static function GetFromID($cid, $year = NULL) {
      if (!$link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS)) {
        return array("code" => Result::MYSQLERROR);
      }
      if (!$stmt = $link->prepare(($year === NULL) ? "SELECT * FROM `payments` WHERE `camper` = ?" : "SELECT * FROM `payments` WHERE `camper` = ? AND `paid_date` LIKE ?")) {
        return Result::MYSQLPREPARE;
      }
      if ($year === NULL) {
        if (!$stmt->execute(array($cid))) {
          return Result::MYSQLEXECUTE;
        }
      } else {
        $year = $year."%";
        if (!$stmt->execute(array($cid, $year))) {
          return Result::MYSQLEXECUTE;
        }
      }

      return Payments::_FetchToPaymentArray($stmt);
    }

    private static function _update($transaction_id) {
      if (!$link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS)) {
        return array("code" => Result::MYSQLERROR);
      }
      if (!$stmt = $link->prepare("SELECT * FROM `payments` WHERE `transaction_id` = ?")) {
        return Result::MYSQLPREPARE;
      }
      if ($stmt->execute(array($transaction_id))) {
        if ($stmt->rowCount() == 1) {
          $results = $stmt->fetch(PDO::FETCH_ASSOC);
          if (explode("-", $results['paid_date'])[0] == date("Y")) {
            //Only update payments a max of once per day per transaction, to avoid abusing stripe API
            if (strtotime($results['checked']) < strtotime('-1 days')) {
              $stripe = new Stripe();
              $stripe->update();
            }
          }
          return Result::VALID;
        }
        return Result::NOTFOUND;
      }
      return Result::INVALID;
    }

    private static function _FetchToPaymentArray($stmt)
    {
      $payments = array();
      $raw = $stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($raw as &$payment) {
        array_push($payments, new Payment($payment));
      }
      return $payments;
    }
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
        $stmt = $link->prepare(
          "INSERT INTO `payments` (`_id`, `camper`, `method`, `currency`, `billing_first_name`, `billing_last_name`, `billing_city`, `billing_state`, `billing_postal`, `billing_email`, `billing_phone`, `billing_address`, `transaction_id`, `net_revenue`, `cart_total`, `paid_date`, `ip_address`, `camp`, `live`, `status`, `checked`)
          VALUES (NULL, :camper, '1', 'CAD', NULL, NULL, NULL, NULL, NULL, :email, :phone, NULL, '".$charge->id."', NULL, :amount, '".date("Y-m-d H:i:s")."', '".Stripe::_getUserIP()."', NULL, :live, 'submitted', NULL);"
        );

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

    function update($transaction_id) {
      try{
        $charge = \Stripe\Charge::retrieve($transaction_id);
        if (!$link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS)) {
          return array("code" => Result::MYSQLERROR);
        }
        if (!$stmt = $link->prepare("UPDATE `payments` SET `status` = ?, `checked` = '".date("Y-m-d H:i:s")."' WHERE `transaction_id` = ?")) {
          return Result::MYSQLPREPARE;
        }
        if (!$stmt->execute(array($charge->status, $transaction_id))) {
          return Result::MYSQLEXECUTE;
        }
        return Result::Valid;
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
