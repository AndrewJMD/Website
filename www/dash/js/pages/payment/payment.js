var stripe_transaction = -1;

Dash.get({
  api: "payments",
  request: "id/"+transaction_id,
  success: function(d) {
    if(d.code === Dash.Result.VALID) {
      d = d.data;
      stripe_transaction = d.transaction_id;
      $("#transaction_id").html(d.transaction_id);
      $("#method").html(d.method_name);
      $("#total").html(d.total);
      $("#status").html(d.status);
      $("#paid_date").html(d.paid_date);
      $("#created_date").html(d.created_date);
      $("#checked").html(d.checked);
      $("#live").html((d.live === "0") ? "No" : "Yes");

      $("#raw").html(JSON.stringify(JSON.parse(d.raw), null, 2));
      
      if (d.method === 1) {
        $("#btn-update").show();
      }
      
      hljs.initHighlightingOnLoad();
    }
  }
});

function updateWithStripe() {
  Dash.get({
    api: "payments",
    request: "update/"+stripe_transaction,
    success: function(d) {
      if (d.code === Dash.Result.VALID) {
        loadPage("payment", transaction_id);
      }
    }
  });
}
