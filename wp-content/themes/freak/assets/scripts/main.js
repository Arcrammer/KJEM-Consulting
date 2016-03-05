(function ($) {
  $('.close-banner').click(function (event) {
    // Hide the banner
    $(event.target).closest('.banner').css('display', 'none');

    // Move the header image up
    $('.site-header').css('background-position', '50% 0');
  });
})(jQuery);
