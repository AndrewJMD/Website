<?php
  $PAGE_HEADER = $PAGE_TITLE = "Registrations";

  function OutputPage() { ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-6">
          <div class="ibox float-e-margins">
            <div class="ibox-content">
              <h4>Registration Date</h4>
              <div class="flot-chart">
                <div style="height:200px;" class="flot-chart-content" id="camps-payment-line"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="ibox float-e-margins">
            <div class="ibox-content">
              <h4>Campers / Year</h4>
              <div class="flot-chart">
                <div style="height:200px;" class="flot-chart-content" id="camper-line"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php }
?>
