(function() {
  $.getReleases = function(username, user_id) {
    var $discogs;
    $('.js-startImport').fadeOut(400, function() {
      return $('.js-importResults').html('<p class="placeholder">Fetching ...</p>');
    });
    return $discogs = $.ajax({
      url: 'https://api.discogs.com/users/' + username + '/collection/folders/0/releases',
      type: 'GET',
      error: function(x, status, error) {
        console.log(status);
        return console.log(error);
      },
      success: function(response) {
        var $api, discogs_vinyls, user_vinyls;
        discogs_vinyls = response.releases;
        user_vinyls = null;
        return $api = $.ajax({
          url: '/api/user/' + user_id + '/vinyls',
          type: 'GET',
          error: function(x, status, error) {
            console.log(status);
            return console.log(error);
          },
          success: function(response) {
            user_vinyls = response;
            $('.js-importResults').html('<p class="placeholder">Found ' + discogs_vinyls.length + ' records in your Discogs collection.</p>');
            $.each(discogs_vinyls, function(index) {
              return $('.js-importTable').find('tbody').append('<tr><td>' + discogs_vinyls[index].id + '</td><td>' + discogs_vinyls[index].basic_information.artists[0].name + '</td><td>' + discogs_vinyls[index].basic_information.title + '</td></tr>');
            });
            return $('.js-importTable').fadeIn();
          }
        });
      }
    });
  };

}).call(this);
