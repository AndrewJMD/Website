<?php
  require("../../../../secrets.php");
?>
var monthNames = ["January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
]
var registrationDateData = [
  <?php
    //TODO maybe move this to a callable php file, so that the js can be minimized
    $dates = array();
    $link = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);
    foreach (range(2016, intval(date("Y"))) as $year) {
      $pq = $link->query("SELECT `camper`,`paid_date` FROM `payments` WHERE `paid_date` LIKE '$year%' GROUP BY `camper`, `paid_date` ORDER BY `paid_date`");
      $total = 0;
      $data = array();
      if ($year != 2016)
        echo ",";
      echo "{data:[";
      while ($p = $pq->fetch_array(MYSQLI_ASSOC)) {
        $date = explode("-", explode(" ",$p['paid_date'])[0]);
        $date[0] = "2000";
        $date = strtotime(implode("-",$date));
        $total += 1;
        if (in_array($date, $data)) {
          $data[$date] += 1;
        } else {
          $data[$date] = $total;
        }
        if (!in_array($date, $dates)) {
          $dt = new DateTime("@$date");
          $dates[$date] = $dt->format("M d");
        }
      }
      foreach ($data as $key => $value) {
        echo "[$key, $value],";
      }
      echo "],label:\"$year\", lines: {show: true}}";
    }

  ?>
];
function parseDate(label, x, y, flotItem) {
  var date = new Date(x * 1000);
  return monthNames[date.getMonth()] + " " + date.getDate() + ": " + y;
}
var barOptions = {
  series: {
    lines: {
      show: true,
      lineWidth: 2,
      fill: false
    }
  },
  xaxis: {
    tickDecimals: 0,
    ticks: [
    <?php
      $previous = 0;
      foreach ($dates as $date => $month) {
        if ($date - $previous > 86400 * 10) {
          echo "[$date,\"$month\"],";
          $previous = $date;
        }
      }
    ?>
    ]
  },
  legend: {position:"nw"},
  grid: {
    color: "#999999",
    hoverable: true,
    clickable: true,
    tickColor: "#D4D4D4",
    borderWidth:0
  },
  tooltip: true,
  tooltipOpts: {
    content: parseDate
  }
};
$.plot($("#camps-payment-line"), registrationDateData, barOptions);
camperData = [
  <?php
    require("../../../libs/campers.php");
    foreach (range(2007, intval(date("Y"))) as $year) {
      $campers = count(Campers::GetCampersFromYear($year));
      echo "[$year, $campers],";
    }
  ?>
];
var barOptions = {
  series: {
    lines: {
      show: true,
      lineWidth: 2,
      fill: true,
      fillColor: {
        colors: [{
          opacity: 0.0
        }, {
          opacity: 0.0
        }]
      }
    }
  },
  xaxis: {
    tickDecimals: 0
  },
  colors: ["#1ab394"],
  grid: {
    color: "#999999",
    hoverable: true,
    clickable: true,
    tickColor: "#D4D4D4",
    borderWidth:0
  },
  legend: {
    show: false
  },
  tooltip: true,
  tooltipOpts: {
    content: "%x: %y"
  }
};
$.plot($("#camper-line"), [camperData], barOptions);
