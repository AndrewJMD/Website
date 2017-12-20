function Dash() {}

Dash.error = {
  no_api_provided: "No api was provided.",
  no_callback_provided: "No callback was provided.",
  no_data_provided: "No data for the api was provided."
};

Dash.getCode = function(c){
  for( var prop in dash.result ) {
     if( dash.result[ prop ] === c )
       return prop;
  }
};

Dash.get = function(i, d, s) {
  f = {
    error: function(e) {
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
        throw Dash.error.no_callback_provided;
      }
    }
  } else {
    for(var prop in input) {
      f[prop] = input[prop];
    }
  }
  if ("api" in f && "success" in f && "data" in f) {
    $.ajax({
      url: Dash.dash+"api/"+f.api+".php",
      type: "POST",
      dataType: "json",
      data: f.data,
      success: function(d){
        if(d.code == Dash.result.VALID) {
          f.success(d);
        } else {
          f.error(d);
        }
      },
      error: function(d){
        console.log("Error in Dash.get", d);
      }
    });
  } else if (!("api" in f)) {
    throw Dash.error.no_api_provided;
  } else if (!("success" in f)) {
    throw Dash.error.no_callback_provided;
  } else if (!("data" in f)) {
    throw Dash.error.no_data_provided;
  }
};

Dash.Template = function(f) {
  this.t = "";
  $.ajax({
    url: Dash.dash+'templates/'+f,
    type: 'get',
    async: false,
    context: this,
    success: function(h) {
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
