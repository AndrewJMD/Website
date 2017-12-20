<style>
  .calendar {
    display:flex;
    width: 1000px;
    margin-left:auto;
    margin-right: auto;
  }
</style>
<?php
  require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
  $CAMP = GetFromURL("camp","17");
?>
<div class='calendar'>
  <?php $DAY = "M"; include('calendar-day.php'); ?>
  <?php $DAY = "T"; include('calendar-day.php'); ?>
  <?php $DAY = "W"; include('calendar-day.php'); ?>
  <?php $DAY = "R"; include('calendar-day.php'); ?>
  <?php $DAY = "F"; include('calendar-day.php'); ?>
</div>
