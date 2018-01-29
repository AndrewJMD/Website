<?php
  $PAGE_HEADER = $PAGE_TITLE = "Campers";

  function OutputPage() { ?>
    <section class="content">
      <div class="row">
        <div class="col-md-4">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Search&nbsp;</h3>
              <input type="text" id="campers-search">
            </div>
            <div class="box-body no-padding">
              <table class="table table-striped" id="campers-table">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Name</th>
                  <th>Username</th>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php }
?>
