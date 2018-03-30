<?php

  require_once("../config.php");
  require_once("../libs/session.php");
  require_once("../secrets.php");

  use League\OAuth2\Client\Provider\Github;

  $provider = new Github([
      'clientId'          => Secrets::GITHUB_CLIENT,
      'clientSecret'      => Secrets::GITHUB_SECRET,
      'redirectUri'       => DASH."github.php",
  ]);

  $_SESSION['github'] = "js";
  $_SESSION['username'] = "__";

  if (!isset($_GET['code'])) {

      // If we don't have an authorization code then get one
      $authUrl = $provider->getAuthorizationUrl();
      $_SESSION['oauth2state'] = $provider->getState();
      header('Location: '.$authUrl);
      exit;

  // Check given state against previously stored one to mitigate CSRF attack
  } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

      unset($_SESSION['oauth2state']);
      exit('Invalid state');

  }
?>
