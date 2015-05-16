###
  String to time
###
String::toHHMMSS = ->
  sec_num = parseInt(this, 10)
  # don't forget the second param
  hours = Math.floor(sec_num / 3600)
  minutes = Math.floor((sec_num - (hours * 3600)) / 60)
  seconds = sec_num - (hours * 3600) - (minutes * 60)
  if hours < 10
    hours = '0' + hours
  if minutes < 10
    minutes = '0' + minutes
  if seconds < 10
    seconds = '0' + seconds
  time = hours + ':' + minutes + ':' + seconds
  time

###
  Youtube API
###

tag = document.createElement('script')
tag.src = 'https://www.youtube.com/iframe_api'
firstScriptTag = document.getElementsByTagName('script')[0]
firstScriptTag.parentNode.insertBefore tag, firstScriptTag
player = undefined
checkPlayer = undefined

delay = (ms, func) -> setTimeout func, ms

###
  JukeBox functionality
###

$.jukebox = (vinyls) ->

  # YT stuff
  window.onYouTubeIframeAPIReady = ->
    # console.log "ready"
    player = new (YT.Player)('player', events:
      'onReady': onPlayerReady
      'onStateChange': onPlayerStateChange)
    return

  onPlayerStateChange = (state) ->
    # console.log state.data
    

  onPlayerReady = ->
    # console.log 'hey Im ready'
    player.playVideo()
    
    checkPlayer = setInterval ->
        state = player.getPlayerState()
        console.log state
        if(state == -1 || state == 0)
          clearInterval(checkPlayer)
          checkPlayer = 0
          $.jukebox(vinyls)
      , 2000
    return

  #console.log vinyls
  vinyl = vinyls[Math.floor(Math.random()*vinyls.length)]
  video = vinyl.videos[Math.floor(Math.random()*vinyl.videos.length)]

  # fill artwork & link
  $('.js-cover').attr('src', vinyl.artwork)
  $('.js-link').attr('href', '/vinyl/'+vinyl.id)

  # fill vinyl title
  $('.js-vinylTitle').text(vinyl.artist+' – '+vinyl.title)

  # fill video title + duration
  duration = video.duration.toHHMMSS()
  $('.js-videoTitle').html(video.title+'<span class="badge pull-right">' + duration + '</span>')

  # fill player
  $('#player').attr('src', video.uri+"?&controls=0&enablejsapi=1&showinfo=0&autohide=1&iv_load_policy=3")

  # skip
  $('.js-skip').click ->
    clearInterval(checkPlayer)
    checkPlayer = 0
    $.jukebox(vinyls)