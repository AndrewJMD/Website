Dash.get("camps/year/"+Dash.Week.year,
  function(d) {
    if(d.code === Dash.Result.VALID) {
      $("#week-selector").html("");
      var t = new Dash.Template("camps/selector.html");
      d.data.forEach(function(i){
        $("#week-selector").append(t.exec(i));
      });
    }
  }
);
