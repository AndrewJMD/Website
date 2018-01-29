$(function(){
  Dash.get("campers",{"f": "get", "u": camper, "l": Dash.Campers.Filter.ALL},
  function(d) {
    if(d.code === Dash.Result.VALID) {
      console.log("Camper",d.data);
      var t = new Dash.Template("camper/badge.html");
      $("#userbadge").html(t.exec(d.data));
    } else {
      console.log("Retrieving camper failed with ", d.code);
    }
  });
});
