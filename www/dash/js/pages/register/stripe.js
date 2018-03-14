var amount = 0;

var handler = StripeCheckout.configure({
  key: STRIPE_PUBLISHABLE,
  image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
  locale: 'auto',
  allowRememberMe: false,
  token: function(token) {
    $.ajax({
      method: 'POST',
      url: 'ajax/payment.php',
      data: { token: token.id, amount: amount }
    })
      .done(function( msg ) {
        console.log("ok",msg);
      })
      .fail(function( jqXHR, textStatus ) {
        console.log("fail",textStatus);
      })
  }
});
$(function(){
  $('#payment-button').on('click', function(e) {
    var weeks = ((week1 ? 1 : 0) + (week2 ? 1 : 0));
    amount = ((week1 ? 350 : 0) + (week2 ? 350 : 0)) * 100;
    handler.open({
      name: 'CompCamps',
      description: weeks + " Week" + (weeks == 2 ? "s" : ""),
      amount: amount
    });
    e.preventDefault();
  });
  // Close Checkout on page navigation:
  $(window).on('popstate', function() {
    handler.close();
  });
});
