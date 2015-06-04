(function() {
  $('.js-startImport').click(function() {
    var $identity;
    return $identity = $.ajax({
      url: 'https://api.discogs.com//users/schnubor/collection/folders/0/releases',
      type: 'GET',
      error: function(x, status, error) {
        console.log(status);
        return console.log(error);
      },
      success: function(response) {
        return console.log(response);
      }
    });
  });

}).call(this);

//# sourceMappingURL=import.js.map