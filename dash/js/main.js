function toUrl(a, b, c) {
  var s = "";
  if(typeof history.state.b !== "undefined" && history.state.b !== "") {s += "../";}
  if(typeof history.state.c !== "undefined" && history.state.c !== "") {s += "../";}
  s += a;
  if(typeof b !== "undefined") {s += "/" + b;}
  if(typeof c !== "undefined") {s += "/" + c;}
  return s;
}

function loadPage(a, b, c, push) {
  if (typeof(push) == "undefined") {
    push = true;
  }
  var state = {"a" : a, "b" : b, "c" : c};
  $.ajax({
    url: Dash.DASH+"libs/getpage.php",
    type: "POST",
    dataType: "json",
    data: state,
    success(data) {
      $("#page_content").html(data.data);
      $("#page_header").html(data.header);
      document.title = data.title + " | CCDash";
      if (push) {
        history.pushState(state, data.title + " | CCDash", toUrl(a,b,c));
      }
      $("script.pagejs").each(function(){
        $(this).remove();
      });
      $.get(Dash.DASH+"includes/scripts.php?a="+a,function(html){
        $("body").append(html);
        Pace.stop();
      });
    },
    error(data) {
      console.log("Error loading page",data);
      Pace.stop();
    }
  });
}

window.onpopstate = function(event) {
  Pace.restart();
  loadPage(event.state.a, event.state.b, event.state.c, false);
};

history.replaceState({
  a: PAGE_A,
  b: PAGE_B,
  c: PAGE_C
}, document.title, document.location.href);

$(document).on("click", "a", function(e) {
  var a = $(this).attr("href");
  if (a !== undefined) {
    if (!a.startsWith("http") && !a.contains("#")) {
      e.preventDefault();
      loadPage(a);
    }
  }
});
