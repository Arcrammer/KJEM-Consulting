(function ($) {
  $(document).ready(function () {
    $('.contact-submit-button').click(function (e) {
      // The 'Send' button has been clicked
      e.preventDefault();

      // Send the message through AJAX
      $.ajax('/contact', {
        method: "POST",
        data: {
          "first_name": $('#contact-form input[type="text"]').val(),
          "email_address": $('#contact-form input[type="email"]').val(),
          "message": $('#contact-form textarea').val()
        },
        beforeSend: function () {
          // Tell the user it's sending
          $('.sending-snackbar').css('bottom', '0');
        },
        success: function (response) {
          // Tell the user it's sent
          $('.sending-snackbar p').text('Sent!');
        }
      });
    });
  });
})(jQuery);
