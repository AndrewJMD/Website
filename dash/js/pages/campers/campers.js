Dash.get("campers",{"f": "campers", "l": Dash.campers.filter.SIMPLE},
  function(data) {
    if(data.code == Dash.result.VALID) {
      template = new Dash.Template("campers/camper-row.html");
      data.data.forEach(function(entry){
        $('#campers-table tr:last').after(template.exec(entry));
      });
    } else {
      console.log("Retuning campers failed with ",data.code);
    }
  }
);
