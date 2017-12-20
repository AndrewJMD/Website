$(document).on('click', 'a', function(e) {
  e.preventDefault();
  var a = $(this).attr("href");
  if (a !== undefined) {
    loadPage(a);
  }
});

function toUrl(a, b, c) {
  var s = "";
  if(typeof history.state.b !== "undefined" && history.state.b != "") {s += "../";}
  if(typeof history.state.c !== "undefined" && history.state.c != "") {s += "../";}
  s += a;
  if(typeof b !== "undefined") {s += "/" + b;}
  if(typeof c !== "undefined") {s += "/" + c;}
  return s;
}

function loadPage(a, b, c) {
  var state = {"a" : a, "b" : b, "c" : c};
  $.ajax({
    url: Dash.dash+"libs/getpage.php",
    type: "POST",
    dataType: "json",
    data: state,
    success: function(data){
      $("#page_content").html(data.data);
      $("#page_header").html(data.header);
      history.pushState(state, data.title + " | CCDash", toUrl(a,b,c));
      $("script.pagejs").each(function(){
        $(this).remove();
      });
      $.get(Dash.dash+"includes/scripts.php?a="+a,function(html){
        $("body").append(html);
        Pace.stop();
      });
    },
    error: function(data){
      console.log("Error loading page",data);
      Pace.stop();
    }
  });
}

window.onpopstate = function(event) {
  Pace.restart();
  loadPage(event.state.a, event.state.b, event.state.c);
};

history.replaceState({
  a: PAGE_A,
  b: PAGE_B,
  c: PAGE_C
}, document.title, document.location.href);
