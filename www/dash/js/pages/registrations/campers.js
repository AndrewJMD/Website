var Dash;
Dash.get({
  api: "campers",
  request: "year/"+Dash.Week.year,
  success(d) {
    if(d.code === Dash.Result.VALID) {
      var t = new Dash.Template("registrations/camper-row.html");
      d.data.forEach(function(i){
        Dash.get({
          api: "payments",
          request: "camper/"+i._id+"/"+Dash.Week.year,
          success(p) {
            if(p.code === Dash.Result.VALID) {
              if (p.data.length !== 0) {
                i.payment = p.data[0];
              } else {
                i.payment = {};
              }
              $("#campers-list tr:last").after(t.exec(i));
            }
          }
        });
      });
    }
  }
});
