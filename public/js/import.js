(function() {
  $.getReleases = function(username) {
    var $request;
    return $request = $.ajax({
      url: 'https://api.discogs.com/users/' + username + '/collection/folders/0/releases',
      type: 'GET',
      error: function(x, status, error) {
        console.log(status);
        return console.log(error);
      },
      success: function(response) {
        console.log(response);
        return $('.js-importResults').html('<p class="placeholder">Found ' + response.releases.length + ' records in your Discogs collection.</p>');
      }
    });
  };

}).call(this);

//# sourceMappingURL=import.js.map