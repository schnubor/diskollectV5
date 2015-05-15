
/*
  Youtube API
 */

(function() {
  var delay, firstScriptTag, player, tag;

  tag = document.createElement('script');

  tag.src = 'https://www.youtube.com/iframe_api';

  firstScriptTag = document.getElementsByTagName('script')[0];

  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  player = void 0;

  delay = function(ms, func) {
    return setTimeout(func, ms);
  };


  /*
    JukeBox functionality
   */

  $.jukebox = function(vinyls) {
    var checkPlayer, onPlayerReady, onPlayerStateChange, video, vinyl;
    window.onYouTubeIframeAPIReady = function() {
      console.log("ready");
      player = new YT.Player('player', {
        events: {
          'onReady': onPlayerReady,
          'onStateChange': onPlayerStateChange
        }
      });
    };
    onPlayerStateChange = function(state) {};
    onPlayerReady = function() {
      console.log('hey Im ready');
      player.playVideo();
    };
    checkPlayer = setInterval(function() {
      var state;
      state = player.getPlayerState();
      console.log(state);
      if (state === -1 || state === 0) {
        clearInterval(checkPlayer);
        checkPlayer = 0;
        return $.jukebox(vinyls);
      }
    }, 2000);
    vinyl = vinyls[Math.floor(Math.random() * vinyls.length)];
    video = vinyl.videos[Math.floor(Math.random() * vinyl.videos.length)];
    $('.js-cover').attr('src', vinyl.artwork);
    $('.js-vinylTitle').text(vinyl.artist + ' – ' + vinyl.title);
    $('.js-videoTitle').text(video.title);
    $('#player').attr('src', video.uri + "?&controls=0&enablejsapi=1&showinfo=0&autohide=1");
    return $('.js-skip').click(function() {
      clearInterval(checkPlayer);
      checkPlayer = 0;
      return $.jukebox(vinyls);
    });
  };

}).call(this);

//# sourceMappingURL=jukebox.js.map