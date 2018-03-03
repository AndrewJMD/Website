state = 0;

var name = "";
var dob = "";
var phone = "";
var health = "";
var prov = "";
var medical = "";
var shirt = "";

var parent_name = "";
var parent_phone = "";
var parent_email = "";

function first() {
  $("#start").slideUp();
  $("#first").slideDown();
  $("#buttons").slideDown();
  state = 1;
}

function prev() {
  switch(state) {
    case 1:
      $("#start").slideDown();
      $("#first").slideUp();
      $("#buttons").slideUp();
      state = 0;
      break;
    case 2:
      $("#parent").slideUp();
      $("#first").slideDown();
      state = 1;
      break;
    case 3:
      $("#parent").slideDown();
      $("#github").slideUp();
      $("#github-button").hide();
      $("#next-button").show();
      break;
  }
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function checkInput(id) {
  if ($(id).val() == "") {
    $(id).parent().addClass("has-error");
    return true;
  }
  $(id).parent().removeClass("has-error");
  return false;
}

function next() {
  switch(state) {
    case 1:
      name = $("#name").val();
      dob = $("#dob").val();
      phone = $("#cellphone").val();
      health = $("#health").val();
      prov = $("#prov").val();
      medical = $("#medical").html();
      shirt = $("#shirt").val();
      var error = checkInput("#name");
      error     = checkInput("#dob")    || error;
      error     = checkInput("#health") || error;
      if (!error) {
        $("#first").slideUp();
        $("#parent").slideDown();
        state = 2;
      }
      break;
    case 2:
      parent_name = $("#parent_name").val();
      parent_phone = $("#parent_phone").val();
      parent_email = $("#parent_email").val();
      var error = checkInput("#parent_name");
      error     = checkInput("#parent_phone") || error;
      error     = checkInput("#parent_email") || error;
      if (!error) {
        $("#parent").slideUp();
        $("#github").slideDown();
        $("#github-button").show();
        $("#next-button").hide();
        state = 3;
      }
      break;
  }
}

function github() {
  javascript:window.open('github-js.php','GitHub Registration','width=600,height=400');
}
