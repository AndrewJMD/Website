<?php
  $PAGE_TYPE = "custom";

  function OutputPage() {?>
    <!DOCTYPE html>
    <html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Sign in | CCDash</title>
      <!-- Tell the browser to be responsive to screen width -->
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="css/admin.min.css">

      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->

      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="#"><b>CC</b>Dash</a>
      </div>
      <div class="login-box-body">
        <p class="login-box-msg">Sign in</p>
        <div class="form-group has-feedback">
          <input type="text" id='username' class="form-control" placeholder="Username">
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" id='password' class="form-control" placeholder="Password">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-4">
            <button type="submit" onclick="javascript:submit()" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-4">
            <span id='response'></span>
          </div>
        </div>
        <br/>
        <a href="#">Reset Password</a><br>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
      function submit() {
        $.ajax({
          url: "process.php",
          type: "POST",
          dataType: "json",
          data: {"f" : "login", "username" : $("#username").val(), "password" : $("#password").val()},
          success: function(data){
            switch (data.result) {
              case 2:
                window.location.replace("change");
                break;
              case 1:
                window.location.replace("home");
                break;
              case 0:
                $("#response").html("<span style='color:red'>Incorrect</span>");
                $("#password").val("");
                break;
              default:
            }
          },
          error: function(data){
            $("#response").html("<span style='color:red'>Error</span>");
            console.log("Error",data);
          }
        });
      }
      $("input").keyup(function(e){
        if (e.keyCode ==13){
          submit();
        }
      });
    </script>
    </body>
    </html>
  <?php }
?>
