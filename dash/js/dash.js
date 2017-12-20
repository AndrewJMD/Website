$(document).on('click', 'a', function(e) {
  e.preventDefault();
  var a = $(this).attr("href");
  if (a !== undefined) {
    var state = {"a" : a};
    $.ajax({
      url: "libs/getpage.php",
      type: "POST",
      dataType: "json",
      data: state,
      success: function(data){
        $(".content-wrapper").html(data.data);
        history.pushState(state, data.title + " | CCDash", a);
        $("script.pagejs").each(function(){
          $(this).remove();
        });
        $.get(dash.dash+"includes/scripts.php?a="+a,function(html){
          $("body").append(html);
          Pace.stop();
        });
      },
      error: function(data){
        console.log("Error");
        console.log(data);
        Pace.stop();
      }
    });
  }
});

window.onpopstate = function(event) {
  console.log(event);
  $.ajax({
    url: "libs/getpage.php",
    type: "POST",
    dataType: "json",
    data: event.state,
    success: function(data){
      $(".content-wrapper").html(data.data);
      Pace.stop();
    },
    error: function(data){
      console.log("Error");
      console.log(data);
    }
  });
};

history.replaceState({
  a: PAGE_A,
  b: PAGE_B,
  c: PAGE_C
}, document.title, document.location.href);
