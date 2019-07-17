var state = 1;

var camper_id = -1;

var name    = "";
var dob     = "";
var phone   = "";
var health  = "";
var prov    = "";
var medical = "";
var shirt   = "";
var hear    = "";
var pizza   = "";

var parent_name   = "";
var parent_phone  = "";
var parent_email  = "";
var parent_drive  = false;

var week1 = false;
var week2 = false;

var error = null;

function first() {
  $("#start").slideUp();
  $("#first").slideDown();
  $("#buttons").slideDown();
  state = 1;
}

function returning() {
  $("#start").slideUp();
  $("#returning").slideDown();
  $("#buttons").slideDown();
  state = 100;
}

function prev() {
  switch(state) {
    case 1:
    case 100:
      $("#start").slideDown();
      $("#first").slideUp();
      $("#returning").slideUp();
      $("#buttons").slideUp();
      state = 0;
      break;
    case 2:
      $("#parent").slideUp();
      $("#first").slideDown();
      $("#prev-button").slideUp();
      state = 1;
      break;
    case 3:
      $("#parent").slideDown();
      $("#week-select").slideUp();
      $("#next-button").show();
      state = 2;
      break;
    case 4:
      $("#week-select").slideDown();
      $("#payment").slideUp();
      $("#next-button").slideDown();
      state = 3;
      break;
  }
}

function validateEmail(id) {
    var email = $(id).val();
    var re = /^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
    if (!re.test(String(email).toLowerCase())) {
      $(id).parent().addClass("has-error");
      return true;
    }
    $(id).parent().removeClass("has-error");
    return false;
}

function checkInput(id) {
  if ($(id).val() === "") {
    $(id).parent().addClass("has-error");
    return true;
  }
  $(id).parent().removeClass("has-error");
  return false;
}

function next() {
  switch(state) {
    case 1:
      name    = $("#name").val();
      dob     = $("#dob").val();
      phone   = $("#cellphone").val();
      health  = $("#health").val();
      prov    = $("#prov").val();
      medical = $("#medical").val();
      shirt   = $("#shirt").val();
      hear    = $("#hear").val();
      pizza   = $("#pizza").val();
      error   = checkInput("#name");
      error   = checkInput("#dob")    || error;
      error   = checkInput("#health") || error;
      if (!error) {
        $("#first").slideUp();
        $("#parent").slideDown();
        $("#prev-button").slideDown();
        state = 2;
      }
      break;
    case 2:
      parent_name   = $("#parent_name").val();
      parent_phone  = $("#parent_phone").val();
      parent_email  = $("#parent_email").val();
      parent_drive  = ($("#parent_drive").is(":checked")) ? 1 : 0;
      error     = checkInput("#parent_name");
      error     = checkInput("#parent_phone") || error;
      error     = checkInput("#parent_email") || error;
      error     = validateEmail("#parent_email") || error;
      error     = checkInput("#address") || error;
      console.log("Ajax");
      if (!error) {
        $("#complete-email").html(parent_email);
        $("#parent").slideUp();
        $("#week-select").slideDown();
        $.ajax({
          method: "POST",
          url: "ajax/register.php",
          dataType: "json",
          data: {
            name: name,
            username: "",
            dob: dob,
            phone: phone,
            health: health,
            prov: prov,
            medical: medical,
            shirt: shirt,
            hear: hear,
            pizza: pizza,
            parent_name: parent_name,
            parent_phone: parent_phone,
            parent_email: parent_email,
            drive: parent_drive
        }}).done(function(data){
          if (data.code === Dash.Result.VALID) {
            camper_id = data.id;
          }
          
          $.ajax({
            method: "POST",
            url: "ajax/checkin.php",
            dataType: "json",
            data: {
              camper: data.id,
              street_number: $("#street_number").val(),
              street: $("#route").val(),
              locality: $("#locality").val(),
              province: $("#administrative_area_level_1").val(),
              postal_code: $("#postal_code").val(),
              country: $("#country").val()
          }});
        }).fail(function( jqXHR, textStatus ) { return; });
        state = 3;
      }
      break;
    case 3:
      week1 = $("#week-1").is(":checked");
      week2 = $("#week-2").is(":checked");
      if (!week1 && !week2) {
        break;
      }
      $("#week-select").slideUp();
      $("#cost").html("CAD $"+((week1 && week2) ? 500 : 300).toString());
      $("#payment").slideDown();
      $("#next-button").slideUp();
      state = 4;
      break;
    case 4:
      if (week1) {
        $.ajax({
          method: "POST",
          url: "ajax/attend.php",
          dataType: "json",
          data : {
            camper: camper_id,
            camp: 19,
            drive: parent_drive,
            shirt: shirt,
            pizza: pizza,
            hear: hear,
          }
        });
      }
      if (week2) {
        $.ajax({
          method: "POST",
          url: "ajax/attend.php",
          dataType: "json",
          data : {
            camper: camper_id,
            camp: 20,
            drive: parent_drive,
            shirt: shirt,
            pizza: pizza,
            hear: hear,         
          }
        });
      }
      $("#payment").slideUp();
      $("#cheque").slideUp();
      $("#next-button").hide();
      $("#prev-button").hide();
      $("#complete").slideDown();
      state = 100;
      break;
  }
}

function cheque() {
  if (state === 4) {
    $("#payment").slideUp();
    $("#cheque").slideDown();
    $("#prev-button").slideUp();
    $("#next-button").slideDown();
    $.ajax({
      method: "POST",
      url: "ajax/cheque.php",
      dataType: "json",
      data: { amount: ((week1 && week2) ? 500 : 300) * 100, camper: camper_id, phone: parent_phone, email: parent_email }
    });
  }
}

function home() {
  if (state === 5) {
    window.location.href = "../";
  }
}

var interval;
var popup;
