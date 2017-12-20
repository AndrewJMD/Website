<?php
  $PAGE_TITLE = "Schedule";
  $PAGE_HEADER = "Schedule";

  function OutputPage() { ?>
    <!-- Main content -->
    <section class="content">
      <?php
        include(DROOT."dash/includes/calendar.php");
      ?>
    </section>
  <?php }
?>
