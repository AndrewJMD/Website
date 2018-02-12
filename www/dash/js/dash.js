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

Dash.get = function(i, s) {
  //TODO rewrite to take json object instead of multiple params
  var f = {
    error(e) {
      console.log("Dash.get unhandled error",e);
    }
  };
  f.api = i;
  if (typeof(s) != "undefined") {
    f.success = s;
  } else {
    if (!("success" in f)){
      throw new Dash.Error(Dash.error.no_callback_provided);
    }
  }
  if ("api" in f && "success" in f) {
    $.ajax({
      url: Dash.DASH+"api/"+f.api,
      type: "POST",
      dataType: "json",
      data: f.data,
      success(d) {
        if (d.code === Dash.Result.VALID) {
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
  }
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
      console.log(d);
      if (d.code === Dash.Result.VALID) {
        if (typeof(f.success) != "undefined") {
          f.success(d);
        }
      } else if (d.code === Dash.Result.REDIRECT) {
        window.location.href = d.location;
      }  else {
        if (typeof(f.error) != "undefined") {
          f.error(d);
        }
      }
    }, error(d){
      console.log(d);
    }
  });
}

Dash.setweek = function(id) {
  Dash.do({
    action: 'setweek',
    data: {
      camp: id
    },
    success(d) {
      location.reload();
    }
  });
}

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
