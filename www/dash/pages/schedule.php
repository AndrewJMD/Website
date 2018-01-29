<?php
  $PAGE_HEADER = $PAGE_TITLE = "Schedule";

  function OutputPage() { ?>
    <!-- Main content -->
    <section class="content">
      <?php
        include(DROOT."dash/includes/calendar.php");
      ?>
    </section>
  <?php }
?>
