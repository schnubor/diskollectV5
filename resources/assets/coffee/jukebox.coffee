$.jukebox = (vinyls) ->
    console.log vinyls

    # fill artwork
    $('.js-cover').attr('src', vinyls[0].artwork)

    # fill vinyl title
    $('.js-vinylTitle').text(vinyls[0].artist+' – '+vinyls[0].title)

    # fill video title
    $('.js-videoTitle').text(vinyls[0].videos[0].title)

    # fill player
    $('#player').attr('src', vinyls[0].videos[0].uri)
