<?php
  $PAGE_HEADER = $PAGE_TITLE = "Camps";

  function OutputPage() { ?>
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Search&nbsp;</h3>
              <input type="text" id="camps-search">
            </div>
            <div class="box-body no-padding">
              <table class="table table-striped" id="camps-table">
                <tr>
                  <th>Year</th>
                  <th>Theme</th>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-6">

        </div>
      </div>
    </section>
  <?php }
?>
