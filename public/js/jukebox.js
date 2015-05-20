
/*
  String to time
 */

(function() {
  var checkPlayer, delay, firstScriptTag, player, tag;

  String.prototype.toHHMMSS = function() {
    var hours, minutes, sec_num, seconds, time;
    sec_num = parseInt(this, 10);
    hours = Math.floor(sec_num / 3600);
    minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    seconds = sec_num - (hours * 3600) - (minutes * 60);
    if (hours < 10) {
      hours = '0' + hours;
    }
    if (minutes < 10) {
      minutes = '0' + minutes;
    }
    if (seconds < 10) {
      seconds = '0' + seconds;
    }
    time = hours + ':' + minutes + ':' + seconds;
    return time;
  };


  /*
    Youtube API
   */

  tag = document.createElement('script');

  tag.src = 'https://www.youtube.com/iframe_api';

  firstScriptTag = document.getElementsByTagName('script')[0];

  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  player = void 0;

  checkPlayer = void 0;

  delay = function(ms, func) {
    return setTimeout(func, ms);
  };


  /*
    JukeBox functionality
   */

  $.jukebox = function(vinyls) {
    var duration, onPlayerReady, onPlayerStateChange, video, vinyl;
    window.onYouTubeIframeAPIReady = function() {
      player = new YT.Player('player', {
        events: {
          'onReady': onPlayerReady,
          'onStateChange': onPlayerStateChange
        }
      });
    };
    onPlayerStateChange = function(state) {};
    onPlayerReady = function() {
      player.playVideo();
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
    };
    vinyl = vinyls[Math.floor(Math.random() * vinyls.length)];
    video = vinyl.videos[Math.floor(Math.random() * vinyl.videos.length)];
    $('.js-cover').attr('src', vinyl.artwork);
    $('.js-link').attr('href', '/vinyl/' + vinyl.id);
    $('.js-vinylTitle').text(vinyl.artist + ' – ' + vinyl.title);
    duration = video.duration.toHHMMSS();
    $('.js-videoTitle').html(video.title + '<span class="badge pull-right">' + duration + '</span>');
    $('#player').attr('src', video.uri + "?&controls=0&enablejsapi=1&showinfo=0&autohide=1&iv_load_policy=3");
    return $('.js-skip').click(function() {
      clearInterval(checkPlayer);
      checkPlayer = 0;
      return $.jukebox(vinyls);
    });
  };

}).call(this);

//# sourceMappingURL=jukebox.js.map