discogs_vinyls = []
vinylsToImport = []

# Fetch a site from discogs
# -----------------------------------
$.fetchDiscogsPage = (username, page, promises = []) ->
    request = $.ajax
        url: "https://api.discogs.com/users/#{username}/collection/folders/0/releases?page=#{page}&per_page=100"
        type: 'GET'
        error: (x,status,error) ->
            console.log status
            console.log error
        success: (response) ->
            console.log response
            return response.releases
    promises.push(request)

# Compare Discogs and User collection
# -----------------------------------
$.getVinylsToImport = (discogs_vinyls, user_vinyls) ->
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
    return {
        "vinylsToImport" : vinylsToImport
        "alreadyInCollection" : alreadyInCollection
    }

$.getReleases = (username, user_id) ->
    $('.js-startImport').html('<i class="fa fa-fw fa-spin fa-refresh"></i> Scan Discogs')

    user_vinyls = []
    discogs_vinyls = []

    $.ajax
        url: "/api/discogs/user/#{username}/releases/1"
        type: 'GET'
        error: (x,status,error) ->
            console.log status
            console.log error
        success: (response) ->
            promises = []
            currentPage = 1

            # Get discogs collection
            # -----------------------------------------------
            while currentPage <= response.pagination.pages
                request = $.ajax
                    url: "/api/discogs/user/#{username}/releases/#{currentPage}"
                    type: 'GET'
                    error: (x,status,error) ->
                        console.log status
                        console.log error
                    success: (response) ->
                        for release in response.releases
                            discogs_vinyls.push release
                promises.push(request)
                currentPage++

            $.when.apply(null, promises).done ->
                # Get vinyls that are already in users collection
                # -----------------------------------------------
                $userVinylsCall = $.ajax
                    url: '/api/user/'+user_id+'/vinyls'
                    type: 'GET'
                    error: (x,status,error) ->
                        console.log status
                        console.log error
                    success: (response) ->
                        user_vinyls = response.data
                        # console.log user_vinyls, discogs_vinyls

                        vinylsObj = $.getVinylsToImport(discogs_vinyls, user_vinyls)
                        console.log "vinyls to import: ", vinylsToImport

                        # show fetch results
                        $('.js-startImport').fadeOut 400, ->
                            $('.js-vinylsFound').text discogs_vinyls.length
                            $('.js-alreadyInCollection').text vinylsObj.alreadyInCollection.length
                            $('.js-vinylsToImport').text vinylsObj.vinylsToImport.length
                            $('.js-startMapping').attr('disabled', 'disabled') unless vinylsObj.vinylsToImport.length
                            $('.js-importFetchResults').fadeIn()

# Click Start Mapping
# ----------------------------
$('.js-startMapping').click ->
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
        $('.js-currentImportVinyl').text("#{vinylsToImport[n].basic_information.artists[0].name} - #{vinylsToImport[n].basic_information.title}")
        $.ajax
            url: "/api/discogs/#{vinylsToImport[n].id}"
            type: "GET"
            error: (x,status,error) ->
                console.log status
                console.log error
            success: (vinyl) -> # fetched vinyl from Discogs
                userCurrency = $('meta[name=user-currency]').attr('content')
                $vinylData = $.mapVinylData vinyl
                $vinylData._token = $('meta[name=csrf-token]').attr('content')  # attach CSRF token

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
    else # import complete
        $('.js-currentImportVinyl').hide()
        $('.js-importProgress .progress-bar').addClass('progress-bar-success')
        $('.js-importComplete').show()
