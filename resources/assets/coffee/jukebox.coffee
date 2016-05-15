userId = $('#jukebox').data('userid')

Vue.use(VueYouTubeEmbed)

vm = new Vue
    el: '#jukebox'
    data:
        vinyls: []
        userId: userId
        loading: true
        videoId: 'videoId'
        timeout: null
        vinyl:
            id: null
            cover: "/images/PH_vinyl.svg"
            artist: "-"
            title: "-"
            label: "-"
            year: "-"
            country: "-"

    methods:
        fetchVinylList: (userId) ->
            $.getJSON "/api/user/#{userId}/vinyls/videos/all", (response) =>
                @vinyls = response
                @loading = false
                @newRecord(@vinyls)

        newRecord: (vinyls) ->
            # clear skip timeout
            clearTimeout(@timeout)
            
            # select random vinyl and video
            vinyl = vinyls[Math.floor(Math.random()*vinyls.length)]
            video = vinyl.videos[Math.floor(Math.random()*vinyl.videos.length)]

            # update youtubeId
            @videoId = video.uri.slice(-11)

            # set vinyl data
            @vinyl.id = vinyl.id
            @vinyl.cover = vinyl.artwork
            @vinyl.artist = vinyl.artist
            @vinyl.title = vinyl.title
            @vinyl.label = vinyl.label
            @vinyl.year = vinyl.releasedate
            @vinyl.country = vinyl.country

        playerReady: (player) ->
            @player = player

        playing: ->
            console.log "playing"
            clearTimeout(@timeout)

        paused: ->
            console.log "paused"

        buffering: ->
            @timeout = setTimeout =>
                @newRecord(@vinyls)
            , 5000

        queued: ->
            console.log "queued"

    ready: ->
        @fetchVinylList(@userId)
