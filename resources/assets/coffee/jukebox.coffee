###
  Youtube API
###

tag = document.createElement('script')
tag.src = 'https://www.youtube.com/iframe_api'
firstScriptTag = document.getElementsByTagName('script')[0]
firstScriptTag.parentNode.insertBefore tag, firstScriptTag
player = undefined

delay = (ms, func) -> setTimeout func, ms

###
  JukeBox functionality
###

$.jukebox = (vinyls) ->

  # YT stuff
  window.onYouTubeIframeAPIReady = ->
    console.log "ready"
    player = new (YT.Player)('player', events:
      'onReady': onPlayerReady
      'onStateChange': onPlayerStateChange)
    return

  onPlayerStateChange = (state) ->
    # console.log state.data
    

  onPlayerReady = ->
    console.log 'hey Im ready'
    player.playVideo()
    return

  checkPlayer = setInterval ->
      state = player.getPlayerState()
      console.log state
      if(state == -1 || state == 0)
        clearInterval(checkPlayer)
        checkPlayer = 0
        $.jukebox(vinyls)
    , 2000

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
  $('#player').attr('src', video.uri+"?&controls=0&enablejsapi=1&showinfo=0")

  # skip
  $('.js-skip').click ->
    clearInterval(checkPlayer)
    checkPlayer = 0
    $.jukebox(vinyls)