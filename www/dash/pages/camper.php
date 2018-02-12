<?php
  $PAGE_HEADER = $PAGE_TITLE = "Camper";

  function OutputPage() { ?>
    <section class="content">
      <script>
        var camper = "<?php echo GetFromURL("b",""); ?>";
      </script>
      <div class="row">
        <div id='userbadge'></div>
        <div id='userprojects'></div>
      </div>
    </section>
  <?php }
?>
