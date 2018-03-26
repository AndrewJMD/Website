<?php

  require_once("../config.php");
  require_once("../session.php");
  require_once("../secrets.php");

  use League\OAuth2\Client\Provider\Github;

  $provider = new Github([
      'clientId'          => Secrets::GITHUB_CLIENT,
      'clientSecret'      => Secrets::GITHUB_SECRET,
      'redirectUri'       => DASH."github.php",
  ]);

  if (!isset($_GET['code'])) {

      $_SESSION['github'] = "login";

      // If we don't have an authorization code then get one
      $authUrl = $provider->getAuthorizationUrl();
      $_SESSION['oauth2state'] = $provider->getState();
      header('Location: '.$authUrl);
      exit;

  // Check given state against previously stored one to mitigate CSRF attack
  } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

      unset($_SESSION['oauth2state']);
      exit('Invalid state');

  } else {

      // Try to get an access token (using the authorization code grant)
      $token = $provider->getAccessToken('authorization_code', [
          'code' => $_GET['code']
      ]);

      // Optional: Now you have a token you can look up a users profile data
      try {
          if ($_SESSION['github'] == "login") {
            require_once("libs/camps.php");
            // We got an access token, let's now get the user's details
            $user = $provider->getResourceOwner($token);

            $_SESSION['token'] = $token->getToken();

            if (!$link = new PDO("mysql:host=".MYSQL_SERVER.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS)) {
              die("Failed to connect to database");
            }
            if (!$stmt = $link->prepare("SELECT * FROM `users` WHERE `username` = ?")) {
              die("Failed to prepare");
            }
            if (!$stmt->execute(array($user->getNickname()))) {
              die("Failed to execute");
            }
            if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
              //User Found
              $_SESSION['id']         = $user['_id'];
              $_SESSION['level']      = $user['level'];
              $_SESSION['name']       = $user['name'];
              $_SESSION['camp']       = (array) Camps::GetCurrentCamp();
              header("Location: dashboard");
            } else {
              //User Not Found
              die("User not found");
            }
          } else {
            $user = $provider->getResourceOwner($token);

            $_SESSION['token'] = $token->getToken();
            $_SESSION['username'] = $user->getNickname();
            echo "<script>window.close();</script>";
          }
          
      } catch (Exception $e) {

          // Failed to get user details
          header('Location: login.php');
      }
  }
?>
