<?php
  $PAGE_HEADER = $PAGE_TITLE = "Payment";

  function OutputPage() { ?>
    <section class="content">
      <script>
        var transaction_id = "<?php echo GetFromURL("b",""); ?>";
      </script>
      <div class="row">
        <div class="col-md-5">
          <div class="box">
            <div class="box-body">
              <h3 class="text-center">Payment</h3>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Transaction ID</b> <span class="pull-right" id="transaction_id"></span>
                </li>
                <li class="list-group-item">
                  <b>Method</b> <span class="pull-right" id="method"></span>
                </li>
                <li class="list-group-item">
                  <b>Amount</b> <span class="pull-right" id="total"></span>
                </li>
                <li class="list-group-item">
                  <b>Status</b> <span class="pull-right" id="status"></span>
                </li>
                <li class="list-group-item">
                  <b>Date Paid</b> <span class="pull-right" id="paid_date"></span>
                </li>
                <li class="list-group-item">
                  <b>Last Update <i class="fas fa-question-circle" data-toggle="tooltip" data-title="This is the last time the dashboard requsted data from Stripe about this transaction."></i></b> <span class="pull-right" id="checked"></span>
                </li>
                <li class="list-group-item">
                  <b>Live <i class="fas fa-question-circle" data-toggle="tooltip" data-title="Was this transaction performed in the live environment, charging the card."></i></b> <span class="pull-right" id="live"></span>
                </li>
              </ul>
              <a id="btn-update" onclick="updateWithStripe()" style="display:none" class="btn btn-primary btn-block"><b>Update Now</b></a>
            </div>
          </div>
        </div>
        <div class="col-md-7">
          <div class="box">
            <div class="box-body">
              <pre><code class="json" id="raw"></code></pre>
            </div>
          </div>
        </div>
      </div>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/atom-one-light.min.css" rel="stylesheet" />
      <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/languages/json.min.js"></script>
    </section>
  <?php }
?>
