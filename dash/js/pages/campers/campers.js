Dash.get({
  api: "campers",
  data: {"f" : "campers", "l": Dash.campers.filter.SIMPLE},
  success: function(data) {
    if(data.code == Dash.result.VALID) {
      console.log(data);
      template = new Dash.Template("campers/camper-row.html");
      data.data.forEach(function(entry){
        $('#campers-table tr:last').after(template.exec(entry));
      });
    } else {
      console.log(data.code);
    }
  },
  error: function(data){
    console.log("Error");
    console.log(data);
  }
});
