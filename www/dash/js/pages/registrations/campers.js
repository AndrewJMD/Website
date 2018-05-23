var Dash;
Dash.get({
  api: "campers",
  request: "year/"+Dash.Week.year,
  success: function(d) {
    if(d.code === Dash.Result.VALID) {
      var t = new Dash.Template("registrations/camper-row.html");
      d.data.forEach(function(i){
        Dash.get({
          api: "payments",
          request: "camper/"+i._id+"/"+Dash.Week.year,
          success: function(p) {
            if(p.code === Dash.Result.VALID) {
              if (p.data.length !== 0) {
                i.payment = p.data[0];
              } else {
                i.payment = {};
              }
              Dash.get({
                api: "camps",
                request: "camper/"+i._id+"/"+Dash.Week.year,
                success: function(c) {
                  i.camps = c.data;
                  i.weeks = c.data[0].week;
                  if (c.data.length > 1) {
                    c.data.splice(1).forEach(function (w) {
                      i.weeks += ", "+w.week;
                    });
                  }
                  $("#campers-list tr:last").after(t.exec(i));
                }
              });
            }
          }
        });
      });
    }
  }
});
