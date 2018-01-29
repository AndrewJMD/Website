<?php
  if (!isset($CALENDAR_STYLE_PRESENT)){
    $CALENDAR_STYLE_PRESENT = 1;
  ?>
  <style>
    .calendar-day {
      width: 200px;
    }
    .event {
      padding:2px;
      border-bottom: 2px solid grey;
    }
    .event h4 {
      margin-top: 0px;
      margin-bottom: -5px;
    }
    .time {
      font-size: 0.8em;
    }
  </style>
<?php
  }
  require_once(DROOT."dash/libs/schedule.php");
  $sessions = Schedule::GetDay($DAY,$CAMP);
?>
<div class='calendar-day'>
  <h3><?php echo NameFromDayCode($DAY); ?></h3>
  <h4>0800 - 2100</h4>
  <div class='column'>
    <?php
      foreach ($sessions as $session) {
        $height = 80.0 * Schedule::GetLength($session['start'],$session['end']);
        ?>
        <div class='event' style=
          "
            height:<?php echo $height; ?>px;
            background-color:<?php echo $session['color'];?>;
          "
        >
          <h4><?php echo $session['name']?></h4>
          <span class='time'><?php echo $session['start']." - ".$session['end']?></span>
        </div>
      <?php }
    ?>
  </div>
</div>
