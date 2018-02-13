$(function(){
  Dash.get("campers/get/"+camper+"/"+Dash.Campers.Filter.ALL,
  function(d) {
    if(d.code === Dash.Result.VALID) {
      var t = new Dash.Template("camper/badge.html");
      $("#userbadge").html(t.exec(d.data));
    } else {
      console.log("Retrieving camper failed with ", d.code);
    }
  });
});
