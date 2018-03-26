<?php
  $PAGE_TYPE = "custom";

  require_once("../secrets.php");

  function OutputPage() {?>
    <!DOCTYPE html>
    <html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Register | CCDash</title>
      <!-- Tell the browser to be responsive to screen width -->
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="css/admin.min.css">
      <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->

      <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>

      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition login-page">
      <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <script src="https://checkout.stripe.com/checkout.js"></script>
      <script src="js/pages/register/register.js"></script>
      <script>
        var STRIPE_PUBLISHABLE = "<?php echo Secrets::STRIPE_CLIENT; ?>";
      </script>
      <script src="js/pages/register/stripe.js"></script>
      <div class="login-box">
        <div class="login-logo">
          <a href="#"><b>CC</b>Dash</a>
        </div>
        <div class="box box-info">
          <form>
            <div class="box-body" id="content">
              <!--<div id="start">
                <?php /*include("includes/registration/start.html");*/ ?>
              </div>-->
              <div id="first">
                <?php include("includes/registration/first.html"); ?>
              </div>
              <div id="returning" style="display:none">
                <?php include("includes/registration/returning.html"); ?>
              </div>
              <div id="parent" style="display:none">
                <?php include("includes/registration/parent.html"); ?>
              </div>
              <div id="github" style="display:none">
                <?php include("includes/registration/github.html"); ?>
              </div>
              <div id="github-select" style="display:none">
                <?php include("includes/registration/github-select.html"); ?>
              </div>
              <div id="github-create" style="display:none">
                <?php include("includes/registration/github-create.html"); ?>
              </div>
              <div id="github-wait" style="display:none">
                <?php include("includes/registration/github-wait.html"); ?>
              </div>
              <div id="github-done" style="display:none">
                <?php include("includes/registration/github-done.html"); ?>
              </div>
              <div id="github-forgot" style="display:none">
                <?php include("includes/registration/github-forgot.html"); ?>
              </div>
              <div id="github-invalid" style="display:none">
                <?php include("includes/registration/github-invalid.html"); ?>
              </div>
              <div id="confirm-info" style="display:none">
                <?php include("includes/registration/confirm-info.html"); ?>
              </div>
              <div id="week-select" style="display:none">
                <?php include("includes/registration/week-select.html"); ?>
              </div>
              <div id="payment" style="display:none">
                <?php include("includes/registration/payment.html"); ?>
              </div>
              <div id="complete" style="display:none">
                <?php include("includes/registration/complete.html"); ?>
              </div>
            </div>
            <div class="box-footer" id="buttons">
              <button type="button" class="btn btn-default" style="display:none" onclick="prev()" id="prev-button">Back</button>
              <button type="button" class="btn btn-info pull-right" onclick="next()" id="next-button">Next</button>
              <a class="btn btn-social btn-github pull-right" onclick="next()" id="github-button" style="display:none">
                <i class="fab fa-github" style="color:white;margin-top:5px"></i> Next
              </a>
            </div>
          </form>
        </div>
      </div>
      <script src="<?php echo DASH; ?>js/dash.js"></script>
      <script>
        Dash.Result = <?php echo json_encode((new ReflectionClass("Result"))->getConstants()); ?>;
        Dash.Level =  <?php echo json_encode((new ReflectionClass("Level"))->getConstants()); ?>;
        Dash.DASH = "<?php echo DASH; ?>";
        Dash.ROOT = "<?php echo ROOT; ?>";
        Dash.Campers =  {
          Filter: <?php echo json_encode((new ReflectionClass("CampersFilter"))->getConstants()); ?>
        }
      </script>
    </body>
    </html>
  <?php }
?>
