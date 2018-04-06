Dash.get({
  api: "payments",
  request: "year/"+Dash.Week.year,
  success(d) {
    if(d.code === Dash.Result.VALID) {
      var t = new Dash.Template("payments/payment-row.html");
      d.data.forEach(function(i){
        $("#payments-table tr:last").after(t.exec(i));
      });
    }
  }
});
