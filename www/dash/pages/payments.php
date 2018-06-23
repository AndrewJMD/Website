<?php
  $PAGE_HEADER = $PAGE_TITLE = "Payments";

  function OutputPage() { ?>
    <section class="content">
      <div class="row">

      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Search&nbsp;</h3>
              <input type="text" id="payments-search">
            </div>
            <div class="box-body no-padding">
              <table class="table table-striped" id="payments-table">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Camper</th>
                  <th>Transaction ID</th>
                  <th>Amount</th>
                  <th>Status</th>
                  <th>Paid Date</th>
                  <th>Last Update <i class="fas fa-question-circle" data-toggle="tooltip" data-title="This is the last time the dashboard requsted data from Stripe about this transaction."></i></th>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php }
?>
