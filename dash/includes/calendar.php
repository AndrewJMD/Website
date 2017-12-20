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
  <?php $DAY = "M"; include('calendar_day.php'); ?>
  <?php $DAY = "T"; include('calendar_day.php'); ?>
  <?php $DAY = "W"; include('calendar_day.php'); ?>
  <?php $DAY = "R"; include('calendar_day.php'); ?>
  <?php $DAY = "F"; include('calendar_day.php'); ?>
</div>
