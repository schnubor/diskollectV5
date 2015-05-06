(function() {
  $('.editVinyl .js-delete-track').click(function() {
    var id;
    id = $(this).data('trackId');
    console.log('click ' + id);
    return $('tr.track' + id);
  });

}).call(this);

//# sourceMappingURL=editVinyl.js.map