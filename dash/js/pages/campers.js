$.ajax({
  url: "api/campers.php",
  type: "POST",
  dataType: "json",
  data: {"f" : "all"},
  success: function(data){
    if(data.code == dash.result.VALID) {
      template = new Template("campers/camper_row.html");
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
