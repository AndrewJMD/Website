<?php
  $PAGE_HEADER = $PAGE_TITLE = "Registrations";

  function OutputPage() { ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <section class="col-lg-6">
          <div class="box">
            <div class="box-body no-padding">
              <table class="table table-striped" id="campers-list">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Name</th>
                  <th>Payment</th>
                  <th>Weeks</th>
                </tr>
              </table>
            </div>
          </div>
        </section>
        <section class="col-lg-6">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Registrations</h3>
            </div>
            <div class="box-body">
              <div class="flot-chart">
                <div style="height:200px;" class="flot-chart-content" id="camps-payment-line"></div>
              </div>
            </div>
          </div>
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Campers / Year</h3>
            </div>
            <div class="box-body">
              <div class="flot-chart">
                <div style="height:200px;" class="flot-chart-content" id="camper-line"></div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </section>
  <?php }
?>
