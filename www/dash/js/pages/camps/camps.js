var Dash;
Dash.get("camps/all",
  function(d) {
    if(d.code === Dash.Result.VALID) {
      var t = new Dash.Template("camps/camp-row.html");
      d.data.forEach(function(i){
        $("#camps-table tr:last").after(t.exec(i));
      });
    } else {
      console.log("Retrieving campers failed with ",d.code);
    }
  }
);

$(function(){
  $("#camps-search").on("input propertychange",function() {
    var query = $(this).val().toLowerCase();
    $("#camps-table tbody").children().each(function(i) {
      if (i === 0) { return; }
      var elements = $(this).children();
      var year      = $(elements[0]).find("a").html();
      var theme     = $(elements[1]).html();

      if (
        year.toLowerCase().includes(query) ||
        theme.toLowerCase().includes(query)) {
          $(this).show();
      } else {
        $(this).hide();
      }
    });
  });
});
