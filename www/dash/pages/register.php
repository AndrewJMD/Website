<?php
  $PAGE_TYPE = "custom";

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
      <script src="js/pages/register/register.js"></script>
      <div class="login-box">
        <div class="login-logo">
          <a href="#"><b>CC</b>Dash</a>
        </div>
        <div class="box box-info">
          <form>
            <div class="box-body" id="content">
              <div id="start">
                <?php include("includes/registration/start.php"); ?>
              </div>
              <div id="first" style="display:none">
                <?php include("includes/registration/first.html"); ?>
              </div>
              <div id="parent" style="display:none">
                <?php include("includes/registration/parent.html"); ?>
              </div>
              <div id="github" style="display:none">
                <?php include("includes/registration/github.html"); ?>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer" style="display:none" id="buttons">
              <button type="button" class="btn btn-default" onclick="prev()">Back</button>
              <button type="button" class="btn btn-info pull-right" onclick="next()" id="next-button">Next</button>
              <a class="btn btn-social btn-github pull-right" onclick="github()" id="github-button" style="display:none">
                <i class="fab fa-github" style="color:white;margin-top:5px"></i> Next
              </a>
            </div>
            <!-- /.box-footer -->
          </form>
        </div>

      </div>
    </body>
    </html>
  <?php }
?>
