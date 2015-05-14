(function() {
  var firstScriptTag, onPlayerReady, onPlayerStateChange, player, tag;

  tag = document.createElement('script');

  tag.src = 'https://www.youtube.com/iframe_api';

  firstScriptTag = document.getElementsByTagName('script')[0];

  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  player = void 0;

  window.onYouTubeIframeAPIReady = function() {
    console.log("ready");
    player = new YT.Player('player', {
      events: {
        'onReady': onPlayerReady,
        'onStateChange': onPlayerStateChange
      }
    });
  };

  onPlayerReady = function() {
    console.log('hey Im ready');
  };

  onPlayerStateChange = function() {
    console.log('my state changed');
  };

}).call(this);

//# sourceMappingURL=yt.js.map