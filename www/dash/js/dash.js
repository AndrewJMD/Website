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
  for (var prop in Dash.Result) {
    if (Dash.Result[ prop ] === c) {
      return prop;
    }
  }
};

Dash.get = function(f) {
  if (typeof(f) == "string") {
    f = {data: {}, api: f, request: ""};
  }
  $.ajax({
    url: Dash.DASH+"api/"+f.api+"/"+f.request,
    type: "POST",
    dataType: "json",
    data: f.data,
    success(d) {
      if (d.code === Dash.Result.VALID) {
        if (typeof(f.success) != "undefined") {
          f.success(d);
        }
      } else if ("error" in f) {
        f.error(d);
      }
    }
  });
};

Dash.do = function(f) {
  if (typeof(f) == "string") {
    f = {data: {}, action: f};
  }
  f.data.f = f.action;
  $.ajax({
    url: Dash.DASH+"process.php",
    type: "POST",
    dataType: "json",
    data: f.data,
    success(d) {
      if (d.code === Dash.Result.VALID) {
        if (typeof(f.success) != "undefined") {
          f.success(d);
        }
      } else if (d.code === Dash.Result.REDIRECT) {
        window.location.href = d.location;
      } else if (typeof(f.error) != "undefined") {
        f.error(d);
      }
    }
  });
};

Dash.setweek = function(id) {
  Dash.do({
    action: "setweek",
    data: {
      camp: id
    },
    success(d) {
      location.reload();
    }
  });
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
