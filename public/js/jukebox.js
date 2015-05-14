(function() {
  $.jukebox = function(vinyls) {
    var video, vinyl;
    vinyl = vinyls[Math.floor(Math.random() * vinyls.length)];
    video = vinyl.videos[Math.floor(Math.random() * vinyl.videos.length)];
    $('.js-cover').attr('src', vinyl.artwork);
    $('.js-vinylTitle').text(vinyl.artist + ' – ' + vinyl.title);
    $('.js-videoTitle').text(video.title);
    $('#player').attr('src', video.uri + "?autoplay=1&controls=0&enablejsapi=1");
    return $('.js-skip').click(function() {
      return $.jukebox(vinyls);
    });
  };

}).call(this);

//# sourceMappingURL=jukebox.js.map