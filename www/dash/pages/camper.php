<?php
  $PAGE_HEADER = $PAGE_TITLE = "Camper";

  function OutputPage() { ?>
    <section class="content">
      <script>
        var camper = "<?php echo GetFromURL("b",""); ?>";
      </script>
      <div class="row" id='userbadge'></div>
    </section>
  <?php }
?>
