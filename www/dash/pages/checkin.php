<?php
  $PAGE_TYPE = "custom";

  require_once("../secrets.php");

  function OutputPage() { ?>
    <!DOCTYPE html>
    <html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Check in | CCDash</title>
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link rel="stylesheet" href="css/admin.min.css">
      <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition login-page">
      <div class="login-box">
        <div class="login-logo">
          <a href="#">CompCamps 2018</a>
        </div>
        <div class="box box-info">
          <form>
            <div class="box-body" id="content">
              <div class="form-group">
                <label for="name">Camper Name</label>
                <input class="form-control" id="name" placeholder="Enter Full Name" autocomplete="new-password" type="nothing">
              </div>
              <div class="form-group">
                <label for="address">Address</label>
                <input class="form-control" id="address" onFocus="geolocate()" id="address"/>
              </div>
            </div>
            <div class="box-body" id="done" style="display:none">
              <center><h2>Checked In</h2></center>
            </div>
            <table id="addressdata" style="display:none">
              <tr>
                <td class="label">Street address</td>
                <td class="slimField"><input class="field" id="street_number"
                      disabled="true"></input></td>
                <td class="wideField" colspan="2"><input class="field" id="route"
                      disabled="true"></input></td>
              </tr>
              <tr>
                <td class="label">City</td>
                <td class="wideField" colspan="3"><input class="field" id="locality"
                      disabled="true"></input></td>
              </tr>
              <tr>
                <td class="label">State</td>
                <td class="slimField"><input class="field"
                      id="administrative_area_level_1" disabled="true"></input></td>
                <td class="label">Zip code</td>
                <td class="wideField"><input class="field" id="postal_code"
                      disabled="true"></input></td>
              </tr>
              <tr>
                <td class="label">Country</td>
                <td class="wideField" colspan="3"><input class="field"
                      id="country" disabled="true"></input></td>
              </tr>
            </table>
            <div class="box-footer" id="buttons">
              <button type="button" class="btn btn-info pull-right" onclick="next()" id="next-button">Check In</button>
            </div>
          </form>
        </div>
      </div>

      <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

      <script>
        var placeSearch, autocomplete;
        var componentForm = {
          street_number: 'short_name',
          route: 'long_name',
          locality: 'long_name',
          administrative_area_level_1: 'short_name',
          country: 'short_name',
          postal_code: 'short_name'
        };

        function initAutocomplete() {
          autocomplete = new google.maps.places.Autocomplete(
            (document.getElementById('address')),
            {types: ['geocode']}
          );
          autocomplete.setComponentRestrictions({"country":["ca"]});
          autocomplete.addListener('place_changed', fillInAddress);
        }

        function fillInAddress() {
          // Get the place details from the autocomplete object.
          var place = autocomplete.getPlace();

          for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
          }

          // Get each component of the address from the place details
          // and fill the corresponding field on the form.
          for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
              var val = place.address_components[i][componentForm[addressType]];
              document.getElementById(addressType).value = val;
            }
          }
        }

        function geolocate() {
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
              var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
              };
              var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
              });
              autocomplete.setBounds(circle.getBounds());
            });
          }
        }

        var campers = {};
        var tags = [];

        $(function(){
          Dash.get({
            api: "campers",
            request: "year/2018/all",
            success(d) {
              if(d.code === Dash.Result.VALID) {
                d.data.forEach(function(item){
                  campers[item.name.toLowerCase()] = item._id;
                  tags.push(item.name);
                });
              }
              $("#name").autocomplete({source: tags});
            }
          });
        });

        function next() {
          var name = $("#name").val().toLowerCase();
          var street_number = $("#street_number").val();
          if (street_number === "") {
            console.log("error");
            $("#address").parent().addClass("has-error");
            return false;
          }
          if (name in campers) {
            console.log("Ajax");
            $.ajax({
              method: "POST",
              url: "ajax/checkin.php",
              dataType: "json",
              data: {
                camper: campers[name],
                street_number: street_number,
                street: $("#route").val(),
                locality: $("#locality").val(),
                province: $("#administrative_area_level_1").val(),
                postal_code: $("#postal_code").val(),
                country: $("#country").val()
            }}).done(function(data){
              console.log(data);
              if (data === Dash.Result.VALID) {
                $("#content").slideUp();
                $("#buttons").slideUp();
                $("#done").slideDown();
                setTimeout(function(){
                  location.reload();
                }, 2000);
              }
            }).fail(function( jqXHR, textStatus ) { console.log(jqXHR, textStatus); });
          }
        }
      </script>
      <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo Secrets::GOOGLE_MAPS_PLATFORM; ?>&libraries=places&callback=initAutocomplete" async defer></script>
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
