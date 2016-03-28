discogs_vinyls = []
vinylsToImport = []

# Get vinyls from discogs collection
# ----------------------------------
$.getReleases = (username, user_id) ->
    $('.js-startImport').html('<i class="fa fa-fw fa-spin fa-refresh"></i> Scan Discogs')

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
                    # console.log user_vinyls, discogs_vinyls

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
                    console.log "vinyls to import: ", vinylsToImport

                    # show fetch results
                    $('.js-startImport').fadeOut 400, ->
                        $('.js-vinylsFound').text discogs_vinyls.length
                        $('.js-alreadyInCollection').text alreadyInCollection.length
                        $('.js-vinylsToImport').text vinylsToImport.length
                        $('.js-startMapping').attr('disabled', 'disabled') unless vinylsToImport.length
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
                $.fetchPrice vinyl.id, userCurrency, (price) ->
                    $vinylData = $.mapVinylData vinyl
                    $vinylData.price = price
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
