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

var parent_name   = "";
var parent_phone  = "";
var parent_email  = "";
var parent_drive  = false;

var github_username = "";

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
      error = checkInput("#name");
      error     = checkInput("#dob")    || error;
      error     = checkInput("#health") || error;
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
      error = checkInput("#parent_name");
      error     = checkInput("#parent_phone") || error;
      error     = checkInput("#parent_email") || error;
      error     = validateEmail("#parent_email") || error;
      if (!error) {
        $("#parent").slideUp();
        $("#week-select").slideDown();
        $.ajax({
          method: "POST",
          url: "ajax/register.php",
          dataType: "json",
          data: {
            name: name,
            username: github_username,
            dob: dob,
            phone: phone,
            health: health,
            prov: prov,
            medical: medical,
            shirt: shirt,
            hear: hear,
            parent_name: parent_name,
            parent_phone: parent_phone,
            parent_email: parent_email,
            parent_drive: parent_drive
        }}).done(function(data){
          if (data.code === Dash.Result.VALID) {
            camper_id = data.id;
          }
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
      $("#cost").html("CAD $"+((week1 ? 350 : 0) + (week2 ? 350 : 0)).toString());
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
            camp: 17
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
            camp: 18
          }
        });
      }
      $("#payment").slideUp();
      $("#cheque").slideUp()
      $("#next-button").hide();
      $("#prev-button").hide();
      $("#github").slideDown();
      $("#github-button").show();
      state = 5;
      break;
    case 5:
      $("#github").slideUp();
      $("#github-select").slideDown();
      $("#buttons").slideUp();
      state = 6;
      break;
    case 6:
      $("#github-select").slideUp();
      $("#github-create").slideDown();
      $("#buttons").slideDown();
      $("#prev-button").hide();
      $("#github-button").hide();
      $("#next-button").show();
      state = 7;
      break;
    case 7:
      github(8);
      state = 6;
      break;
    case 8:
      $("#complete").slideDown();
      $("#github-done").slideUp();
      $("#buttons").slideUp();
      $.ajax({
        method: "POST",
        url: "ajax/github.php",
        dataType: "json",
        data : {
          camper: camper_id,
          github: github_username
        }
      });
      state = 100;
      break;
  }
}

function cheque() {
  if (state == 4) {
    $("#payment").slideUp();
    $("#cheque").slideDown();
    $("#prev-button").slideUp();
    $("#next-button").slideDown();
    $.ajax({
      method: "POST",
      url: "ajax/cheque.php",
      dataType: "json",
      data: { amount: ((week1 ? 350 : 0) + (week2 ? 350 : 0)) * 100, camper: camper_id, phone: parent_phone, email: parent_email }
    })
  }
}

var interval;
var popup;
var github_finish_state = 7;

function githubDone(username) {
  github_username = username;
  clearInterval(interval);
  $("#prev-button").hide();
  $("#github-button").hide();
  $("#next-button").show();
  $("#buttons").show();
  $("#github-wait").slideUp();
  $("#github-done").slideDown();
  $("#github-username").html(username);
  state = github_finish_state;
}

function githubCheck() {
  if (popup.opener === null) {
    clearInterval(interval);
    setTimeout(function(){
      $.get("includes/registration/github.php",function(data){
        if (data !== "__") {
          githubDone(data);
        } else {
          github(github_finish_state);
        }
      });
    }, 1000);
  }
}

function github(finish_state) {
  popup = window.open("github-js.php","GitHub Registration","width=600,height=800");
  $("#github-select").slideUp();
  $("#github-create").slideUp();
  $("#returning").slideUp();
  $("#buttons").slideUp();
  $("#github-wait").show();
  interval = setInterval(githubCheck, 500);
  github_finish_state = finish_state;
}
