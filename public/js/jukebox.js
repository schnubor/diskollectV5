(function() {
  $.jukebox = function(userId) {
    var videos, vinyls, vinylsRequest;
    console.log('user: ' + userId);
    vinyls = [];
    videos = [];
    return vinylsRequest = $.ajax({
      url: '/api/user/' + userId + '/vinyls',
      type: 'GET',
      dataType: 'JSON',
      error: function(x, status, error) {
        console.log(status);
        return console.log(error);
      },
      success: function(response) {
        var videoRequest, vinyl;
        vinyls = response;
        console.log(vinyls);
        vinyl = vinyls[Math.floor(Math.random() * vinyls.length)];
        console.log(vinyl.id);
        return videoRequest = $.ajax({
          url: '/api/vinyl/' + vinyl.id + '/videos',
          type: 'GET',
          dataType: 'JSON',
          error: function(x, status, error) {
            console.log(status);
            return console.log(error);
          },
          success: function(response) {
            console.log(response);
            if (response.length) {
              console.log(vinyl);
              return console.log(response[Math.floor(Math.random() * response.length)]);
            } else {
              return $.jukebox(userId);
            }
          }
        });
      }
    });
  };

}).call(this);

//# sourceMappingURL=jukebox.js.map