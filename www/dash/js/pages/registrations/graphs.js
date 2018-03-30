var monthNames = [
  "January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

function parseDate(label, x, y, flotItem) {
  var date = new Date(x * 1000);
  return monthNames[date.getMonth()] + " " + date.getDate() + ": " + y;
}

$(document).ready(function(){
  //Registrations
  $.ajax({
    url: Dash.DASH+"data/registrations.php",
    type: "POST",
    dataType: "json",
    success(d) {
      if (d.code === Dash.Result.VALID) {
        $.plot($("#camps-payment-line"), d.points, {
          series: {
            lines: {
              show: true,
              lineWidth: 2,
              fill: false
            }
          },
          xaxis: {
            tickDecimals: 0,
            ticks: d.ticks
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
        });
      }
    }
  });

  //Campers per Year
  $.ajax({
    url: Dash.DASH+"data/campersperyear.php",
    type: "POST",
    dataType: "json",
    success(d) {
      if (d.code === Dash.Result.VALID) {
        $.plot($("#camper-line"), [d.data], {
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
        });
      }
    }
  });
});
