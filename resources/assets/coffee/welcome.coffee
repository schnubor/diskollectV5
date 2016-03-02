scaleVid = ->
    width = $(window).width()
    height = $(window).height()
    ratio = width / height
    widescreen = 16 / 9

    if(ratio < widescreen) # window ratio is 4:3
        $('#bgvid').css('width', 'auto')
        $('#bgvid').css('height', '100%')
    else
        $('#bgvid').css('width', '100%')
        $('#bgvid').css('height', 'auto')

$(document).ready ->
    scaleVid()

$(window).resize ->
    scaleVid()
