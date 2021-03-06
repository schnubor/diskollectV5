(function() {
  var readUrl;

  $('.createVinyl .js-add-track').click(function() {
    var $tracks;
    $tracks = $('.createVinyl input[name="trackCount"]').val();
    $tracks++;
    $('.createVinyl input[name="trackCount"]').val($tracks);
    return $('.js-trackTable').append('<tr class="track' + ($tracks - 1) + '"><td width="80px" style="padding-left: 0;"><input class="form-control" placeholder="A1" name="track_' + ($tracks - 1) + '_position" type="text"></td><td><input class="form-control" placeholder="Title" name="track_' + ($tracks - 1) + '_title" type="text"></td><td width="100px"><input class="form-control" placeholder="1:13" name="track_' + ($tracks - 1) + '_duration" type="text"></td></tr>');
  });

  readUrl = function(input) {
    var reader;
    if (input.files && input.files[0]) {
      reader = new FileReader();
      return reader.onload = function(e) {
        $('#vinylCover').attr('src', e.target.result);
        return reader.readAsDataURL(input.files[0]);
      };
    }
  };

  $("input[name='coverFile']").change(function() {
    return readUrl(this);
  });

  $("input[name='cover']").change(function() {
    return $('#vinylCover').attr('src', $(this).val());
  });

  $('.editVinyl .js-delete-track').click(function() {
    var id;
    id = $(this).data('trackId');
    console.log('click ' + id);
    return $('tr.track' + id);
  });

}).call(this);

//# sourceMappingURL=createVinyl.js.map
