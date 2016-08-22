(function() {
  var scaleVid;

  scaleVid = function() {
    var height, ratio, widescreen, width;
    width = $(window).width();
    height = 600;
    ratio = width / height;
    widescreen = 16 / 9;
    if (ratio < widescreen) {
      $('#bgvid').css('width', 'auto');
      return $('#bgvid').css('height', '100%');
    } else {
      $('#bgvid').css('width', '100%');
      return $('#bgvid').css('height', 'auto');
    }
  };

  $(document).ready(function() {
    return scaleVid();
  });

  $(window).resize(function() {
    return scaleVid();
  });

}).call(this);

//# sourceMappingURL=welcome.js.map
