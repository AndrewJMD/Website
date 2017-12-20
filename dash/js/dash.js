var Dash = {};

Dash.error = {
  no_api_provided: "No api was provided.",
  no_callback_provided: "No callback was provided.",
  no_data_provided: "No data for the api was provided."
};

Dash.Error = class extends Error {
  constructor(message) {
    super(message);
    this.name = "Error";
  }
};

$(document).ready(function(){
  $.getJSON(Dash.dash+"data/nav.json",function(d){
      Dash.nav = d;
  });
});

Dash.getCode = function(c){
  for (var prop in Dash.result) {
    if (Dash.result[ prop ] === c) {
      return prop;
    }
  }
};

Dash.get = function(i, d, s) {
  var f = {
    error(e) {
      console.log("Dash.get unhandled error",e);
    }
  };
  if (typeof(d) != "undefined") {
    f.api = i;
    if (typeof(d) == "object") {
      if ("success" in d){
        f.success = d.success;
        delete d.success;
      }
      if ("data" in d) {
        f.data = d.data;
      } else {
        f.data = d;
      }
    } else {
      f.data = {f: d};
    }
    if (typeof(s) != "undefined") {
      f.success = s;
    } else {
      if (!("success" in f)){
        throw new Dash.Error(Dash.error.no_callback_provided);
      }
    }
  } else {
    if ("data" in i){
      f.data = i.data;
    }
    if ("api" in i){
      f.api = i.api;
    }
    if ("success" in i){
      f.success = i.success;
    }
    if ("error" in i){
      f.error = i.error;
    }
  }
  if ("api" in f && "success" in f && "data" in f) {
    $.ajax({
      url: Dash.DASH+"api/"+f.api+".php",
      type: "POST",
      dataType: "json",
      data: f.data,
      success(d) {
        if(d.code === Dash.Result.VALID) {
          f.success(d);
        } else {
          f.error(d);
        }
      },
      error(d) {
        console.log("Error in Dash.get", d);
      }
    });
  } else if (!("api" in f)) {
    throw new Dash.Error(Dash.error.no_api_provided);
  } else if (!("success" in f)) {
    throw new Dash.Error(Dash.error.no_callback_provided);
  } else if (!("data" in f)) {
    throw new Dash.Error(Dash.error.no_data_provided);
  }
};

Dash.Template = function(f) {
  this.t = "";
  $.ajax({
    url: Dash.DASH+"templates/"+f,
    type: "get",
    async: false,
    context: this,
    success(h) {
      this.t = h;
    }
  });
};

Dash.Template.prototype.exec = function(d) {
  var m;
  var o = this.t;
  var r = /{{\s?(.+?)\s?}}/g;
  while ((m = r.exec(this.t)) !== null) {
      if (m.index === r.lastIndex) {
          r.lastIndex++;
      }
      o = o.replace(m[0],d[(m[1])]);
  }
  return o;
};
