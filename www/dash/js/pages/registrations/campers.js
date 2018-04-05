var Dash;
Dash.get({
  api: "campers",
  request: "year/"+(new Date()).getFullYear(),
  success(d) {
    if(d.code === Dash.Result.VALID) {
      var t = new Dash.Template("registrations/camper-row.html");
      d.data.forEach(function(i){
        Dash.get({
          api: "payments",
          request: "id/"+i._id+"/"+(new Date()).getFullYear(),
          success(p) {
            if(p.code === Dash.Result.VALID) {
              if (p.data.length !== 0) {
                i.payment = p.data[0].total;
                i.method = p.data[0].method_name;
                i.status = p.data[0].status;
              } else {
                i.payment = "NA";
                i.method = "NA";
                i.status = "NA";
              }

              $("#campers-list tr:last").after(t.exec(i));
            }
          }
        });

      });
    }
  }
});
