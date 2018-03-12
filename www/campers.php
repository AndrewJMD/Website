<?php
$page_title = 'Campers';
include('includes/head.php');
include('includes/header.php');
?>

<h1 class="title">Campers</h1>
<div id="camper-app">
  <section class="camper-section">
    <div class="camper" v-for="camper in campers">
      <img width="128" src="img/profileicon.png" /><br />
      <a href="#">{{ camper.first }}</a>
    </div>
  </section>
</div>

<script src="js/campers.js"></script>

<?php include('includes/footer.php'); ?>
