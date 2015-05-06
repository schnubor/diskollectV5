# Edit Vinyl Site
# ----------------------------

$('.editVinyl .js-delete-track').click ->
  id = $(this).data('trackId')
  console.log 'click '+id
  $('tr.track'+id)