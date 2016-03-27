discogs_vinyls = []
vinylsToImport = []

# Get vinyls from discogs collection
# ----------------------------------
$.getReleases = (username, user_id) ->
    $('.js-startImport').fadeOut 400, ->
        $('.js-importResults').html('<p class="placeholder">Fetching ...</p>')

    $discogs = $.ajax
        url: 'https://api.discogs.com/users/'+username+'/collection/folders/0/releases'
        type: 'GET'
        error: (x,status,error) ->
            console.log status
            console.log error
        success: (response) ->
            discogs_vinyls = response.releases
            user_vinyls = null

            # get vinyls that are already in users collection
            $api = $.ajax
                url: '/api/user/'+user_id+'/vinyls'
                type: 'GET'
                error: (x,status,error) ->
                    console.log status
                    console.log error
                success: (response) ->
                    user_vinyls = response.data
                    console.log user_vinyls, discogs_vinyls

                    alreadyInCollection = []
                    for discogs_vinyl in discogs_vinyls
                        for user_vinyl in user_vinyls
                            alreadyInCollection.push discogs_vinyl if discogs_vinyl.id is parseInt user_vinyl.release_id

                    # remove vinyls that are already in collection
                    onlyInA = alreadyInCollection.filter((current) ->
                        return discogs_vinyls.filter((current_b) ->
                            return current_b.id == current.id
                        ).length == 0
                    )

                    onlyInB = discogs_vinyls.filter((current) ->
                        return alreadyInCollection.filter((current_a) ->
                            return current_a.id == current.id
                        ).length == 0
                    )

                    vinylsToImport = onlyInA.concat(onlyInB)

                    $('.js-importResults').html('<p class="placeholder">Found ' + discogs_vinyls.length + ' records in your Discogs collection. ' + alreadyInCollection.length + ' of them are already in your collection.</p><button class="btn btn-primary btn-lg js-startMapping">Start mapping</button>')

                    # create results table
                    $.each discogs_vinyls, (index) ->
                        $('.js-importTable').find('tbody').append('<tr><td>'+discogs_vinyls[index].id+'</td><td>'+discogs_vinyls[index].basic_information.artists[0].name+'</td><td>'+discogs_vinyls[index].basic_information.title+'</td></tr>')
                    $('.js-importTable').fadeIn()

# Click Start Mapping
# ----------------------------
$('.js-importResults').on 'click', '.js-startMapping', ->
    console.log "Starting Mapping ..."
    $('.js-startMapping').hide()
    $('.js-importProgress').show()
    processNext(0)

# Add vinyl n from discogs collection
# -----------------------------------
processNext = (n) ->
    console.log "Processing vinyl index #{n}"
    # update progress bar
    $('.js-importProgress .progress-bar').css('width', "#{(100 * n) / vinylsToImport.length}%" )
    $('.js-importProgress .progress-bar').text("#{Math.round(((100 * n) / vinylsToImport.length) * 100) / 100}%")

    if n < vinylsToImport.length
        $.ajax
            url: "/api/discogs/#{vinylsToImport[n].id}"
            type: "GET"
            error: (x,status,error) ->
                console.log status
                console.log error
            success: (vinyl) -> # fetched vinyl from Discogs
                $vinylData = {}
                $vinylData._token = $('meta[name=csrf-token]').attr('content')  # attach CSRF token
                $vinylData.price = 10

                # artist
                if vinyl.artists
                    $vinylData.artist = vinyl.artists[0].name
                else
                    $vinylData.artist = 'unknown artist'

                # title
                if vinyl.title
                    $vinylData.title = vinyl.title
                else
                    $vinylData.title = 'unknown title'

                # cover
                if vinyl.images
                    $vinylData.cover = vinyl.images[0].uri
                else
                    $vinylData.cover = 'images/PH_vinyl.svg'

                # label & catno
                if vinyl.labels
                    $vinylData.label = vinyl.labels[0].name
                    if vinyl.labels[0].catno
                        $vinylData.catno = vinyl.labels[0].catno
                    else
                        $vinylData.catno = 'unknown catno'
                else
                    $vinylData.label = 'unknown label'

                # genre
                if vinyl.genres
                    $vinylData.genre = vinyl.genres[0]
                else
                    $vinylData.genre = 'unknown genre'

                # country
                if vinyl.country
                    $vinylData.country = vinyl.country
                else
                    $vinylData.country = 'unknown country'

                # year
                if vinyl.year
                    $vinylData.year = vinyl.year
                else
                    $vinylData.year = 'unknown year'

                # count
                if vinyl.format_quantity
                    $vinylData.count = vinyl.format_quantity
                else
                    $vinylData.count = 'unknown quantity'

                # weight
                if vinyl.estimated_weight
                    $vinylData.weight = vinyl.estimated_weight
                else
                    $vinylData.weight = '0'

                # type
                if vinyl.type
                    $vinylData.type = vinyl.type
                else
                    $vinylData.type = '-'

                # color
                $vinylData.color = '#000000'

                # size
                $vinylData.size = '12'

                # format
                $vinylData.format = 'LP'

                # release ID
                $vinylData.release_id = vinyl.id

                # Discogs URI
                $vinylData.discogs_uri = vinyl.uri

                # tracklist
                if vinyl.tracklist
                    tmpTracklist = []
                    for track, key in vinyl.tracklist
                        tmpTracklist.push
                            duration: track.duration
                            position: track.position
                            title: track.title
                    $vinylData.tracklist = tmpTracklist
                else
                    $vinylData.tracklist = []

                # videos
                if vinyl.videos
                    $vinylData.videos = vinyl.videos
                else
                    $vinylData.videos = []

                $.ajaxSetup
                    headers:
                        'X-XSRF-TOKEN': $('meta[name="_token"]').attr('content')

                $.ajax
                    url: '/vinyl/create'
                    type: 'POST'
                    data: $vinylData
                    success: (reponse) ->
                        console.log "vinyl #{n} added!"
                        n++
                        processNext(n)
                    error: (error) ->
                        console.warn error
