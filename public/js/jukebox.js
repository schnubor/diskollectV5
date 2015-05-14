(function() {
  $.jukebox = function(vinyls) {
    console.log(vinyls);
    $('.js-cover').attr('src', vinyls[0].artwork);
    $('.js-vinylTitle').text(vinyls[0].artist + ' – ' + vinyls[0].title);
    $('.js-videoTitle').text(vinyls[0].videos[0].title);
    return $('#player').attr('src', vinyls[0].videos[0].uri);
  };

}).call(this);

//# sourceMappingURL=jukebox.js.map