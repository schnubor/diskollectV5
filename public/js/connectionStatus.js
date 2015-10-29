(function() {
  $.getStatus = function(userId) {
    var $vinyls;
    $vinyls = $.ajax;
    return {
      url: '/api/status/' + userId,
      type: 'GET',
      dataType: 'JSON',
      error: function(x, status, error) {
        console.log(status);
        return console.log(error);
      },
      success: function(status) {
        return console.log(status);
      }
    };
  };

}).call(this);

//# sourceMappingURL=connectionStatus.js.map