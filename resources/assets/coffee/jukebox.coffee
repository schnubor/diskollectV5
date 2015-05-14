$.jukebox = (vinyls) ->
  #console.log vinyls
  vinyl = vinyls[Math.floor(Math.random()*vinyls.length)]
  video = vinyl.videos[Math.floor(Math.random()*vinyl.videos.length)]

  # fill artwork
  $('.js-cover').attr('src', vinyl.artwork)

  # fill vinyl title
  $('.js-vinylTitle').text(vinyl.artist+' – '+vinyl.title)

  # fill video title
  $('.js-videoTitle').text(video.title)

  # fill player
  $('#player').attr('src', video.uri+"?autoplay=1&controls=0&enablejsapi=1")

  # skip
  $('.js-skip').click ->
    $.jukebox(vinyls)