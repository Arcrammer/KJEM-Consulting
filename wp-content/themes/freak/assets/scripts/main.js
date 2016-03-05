(function ($) {
  // Announcement banner stuff
  var banner = $('.banner');
  var headerTitle = $('#masthead.header-medium .site-branding');

  // Move the header text down, consequently
  // pushing the rest of the content down
  headerTitle.css({
    'padding-top': parseInt(headerTitle.css('padding-top')) + banner.height()
  });

  // Hide the banner when the cross is clicked
  banner.click(function (event) {
    $(event.target).closest('.banner').css('display', 'none');

    // Move the content up again
    headerTitle.css({
      'padding-top': parseInt(headerTitle.css('padding-top')) - banner.height()
    });
  });
})(jQuery);
