# Create Vinyl Site
# ----------------------------

$('.createVinyl .js-add-track').click ->
  console.log 'click'
  $tracks = $('.createVinyl input[name="trackCount"]').val()
  $tracks++
  $('.createVinyl input[name="trackCount"]').val($tracks)
  
  $('.js-trackTable').append('<tr><td width="80px" style="padding-left: 0;"><input class="form-control" placeholder="A1" name="track_'+($tracks-1)+'_position" type="text"></td><td><input class="form-control" placeholder="Title" name="track_'+($tracks-1)+'_title" type="text"></td><td width="100px"><input class="form-control" placeholder="1:13" name="track_'+($tracks-1)+'_duration" type="text"></td></tr>')