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
      reader.onload = function(e) {
        return $('#vinylCover').attr('src', e.target.result);
      };
      return reader.readAsDataURL(input.files[0]);
    }
  };

  $("input[name='coverFile']").change(function() {
    return readUrl(this);
  });

  $("input[name='cover']").change(function() {
    return $('#vinylCover').attr('src', $(this).val());
  });

}).call(this);

//# sourceMappingURL=createVinyl.js.map