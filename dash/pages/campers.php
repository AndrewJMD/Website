<?php
  $PAGE_TITLE = "Campers";

  function OutputPage() { ?>
    <section class="content-header">
      <h1>
        Campers
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">404 error</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Search&nbsp;</h3>
          <input type="text">
          <div class="box-tools">
            <ul class="pagination pagination-sm no-margin pull-right">
              <li><a onclick="">1</a></li>
              <li><a onclick="">2</a></li>
              <li><a onclick="">3</a></li>
            </ul>
          </div>
        </div>
        <div class="box-body no-padding">
          <table class="table table-striped" id="campers-table">
            <tr>
              <th style="width: 10px">#</th>
              <th>Name</th>
              <th>Progress</th>
              <th style="width: 40px">Label</th>
            </tr>
          </table>
        </div>
      </div>
    </section>
  <?php }
?>
