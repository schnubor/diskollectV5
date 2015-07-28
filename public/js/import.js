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
        $('.js-importResults').html('<p class="placeholder">Found ' + response.releases.length + ' records in your Discogs collection.</p>');
        $.each(response.releases, function(index) {
          return $('.js-importTable').find('tbody').append('<tr><td>' + response.releases[index].id + '</td><td>' + response.releases[index].basic_information.artists[0].name + '</td><td>' + response.releases[index].basic_information.title + '</td></tr>');
        });
        return $('.js-importTable').fadeIn();
      }
    });
  };

}).call(this);

//# sourceMappingURL=import.js.map