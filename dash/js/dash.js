function Dash() {}

Dash.getCode = function(c){
  for( var prop in dash.result ) {
     if( dash.result[ prop ] === c )
       return prop;
  }
};

Dash.get = function(data) {
  $.ajax({
    url: "api/"+data.api+".php",
    type: "POST",
    dataType: "json",
    data: data.data,
    success: function(d){
      if(d.code == Dash.result.VALID) {
        data.success(d);
      } else {
        data.error(d);
      }
    },
    error: function(data){
      console.log("Error", data);
    }
  });
};

Dash.Template = function(f) {
  this.t = "";
  $.ajax({
    url: 'templates/'+f,
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
