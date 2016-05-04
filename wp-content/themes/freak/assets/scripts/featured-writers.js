(function ($) {
  $('video').mediaelementplayer({
    videoWidth: '100%',
    videoHeight: '75%',
    features: [],
    success: function (me) {
      me.play();
    }
  });

  $('audio').mediaelementplayer({
    audioWidth: '100%',
    audioHeight: '75%',
    features: [
      'playpause',
      'progress',
      'current',
      'duration',
      'tracks',
      'volume',
      'fullscreen'
    ],
    success: function (me) {
      // Show the controls >_>
      $('.mejs-container .mejs-controls').css('display', 'block');
      me.play();
    }
  });
})(jQuery);
