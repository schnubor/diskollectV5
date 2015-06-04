(function() {
  $.getStatus = function(userId) {
    var $vinyls;
    console.log(userId);
    return $vinyls = $.ajax({
      url: '/api/user/' + userId + '/status',
      type: 'GET',
      error: function(x, status, error) {
        console.log(status);
        console.log(error);
        $('.js-connectionStatus').removeClass('btn-info').addClass('btn-danger').html('<i class="fa fa-fw fa-exclamation-circle"></i> Not connected');
        return $('.js-connectionAction').removeClass('hidden');
      },
      success: function(response) {
        return $('.js-connectionStatus').removeClass('btn-info').addClass('btn-success').html('<i class="fa fa-fw fa-check"></i> Connected');
      }
    });
  };

}).call(this);

//# sourceMappingURL=getStatus.js.map