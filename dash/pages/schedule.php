<?php
  $PAGE_TITLE = "Scedule";

  function OutputPage() { ?>
    <section class="content-header">
      <h1>
        Schedule
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">404 error</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php
        include(DROOT."dash/includes/calendar.php");
      ?>
    </section>
  <?php }
?>
