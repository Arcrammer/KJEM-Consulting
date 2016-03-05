(function ($) {
  $(document).ready(function () {
    // Announcement banner stuff
    var banner = $('.banner');
    var headerTitle = $('#masthead.header-medium .site-branding');
    var adminBar = $('#wpadminbar');
    var extraHeight = (adminBar.length) ? + adminBar.height() + banner.height() : banner.height();

    // Move the header text down, consequently
    // pushing the rest of the content down
    headerTitle.css({
      'padding-top': parseInt(headerTitle.css('padding-top')) + extraHeight
    });

    banner.css({
      'top': adminBar.height()
    });

    // Hide the banner when the cross is clicked
    banner.click(function (event) {
      $(event.target).closest('.banner').css('display', 'none');

      // Move the content up again
      headerTitle.css({
        'padding-top': parseInt(headerTitle.css('padding-top')) - extraHeight
      });

      // Tell the server to stop rendering it
      $.ajax({url: '/?action=set_prefers_no_banner'});
    });
  });
})(jQuery);
