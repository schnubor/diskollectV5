tag = document.createElement('script')
tag.src = 'https://www.youtube.com/iframe_api'
firstScriptTag = document.getElementsByTagName('script')[0]
firstScriptTag.parentNode.insertBefore tag, firstScriptTag
player = undefined

window.onYouTubeIframeAPIReady = ->
  console.log "ready"
  player = new (YT.Player)('player', events:
    'onReady': onPlayerReady
    'onStateChange': onPlayerStateChange)
  return

onPlayerReady = ->
  console.log 'hey Im ready'
  return

onPlayerStateChange = ->
  console.log 'my state changed'
  return

