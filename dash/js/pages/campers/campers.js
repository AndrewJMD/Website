Dash.get("campers",{"f": "campers", "l": Dash.Campers.Filter.SIMPLE},
  function(d) {
    if(d.code === Dash.Result.VALID) {
      var t = new Dash.Template("campers/camper-row.html");
      d.data.forEach(function(i){
        $("#campers-table tr:last").after(t.exec(i));
      });
    } else {
      console.log("Retrieving campers failed with ",d.code);
    }
  }
);
