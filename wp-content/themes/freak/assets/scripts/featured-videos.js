(function ($) {
  $('video').mediaelementplayer({
    videoWidth: '100%',
    videoHeight: '75%',
    featured: [],
    success: function (me) {
      me.play();
    }
  });
})(jQuery);
