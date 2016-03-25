discogs_vinyls = 0

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
                    user_vinyls = response

                    $('.js-importResults').html('<p class="placeholder">Found '+discogs_vinyls.length+' records in your Discogs collection.</p><button class="btn btn-primary btn-lg js-startMapping">Start mapping</button>')

                    # create results table
                    $.each discogs_vinyls, (index) ->
                        $('.js-importTable').find('tbody').append('<tr><td>'+discogs_vinyls[index].id+'</td><td>'+discogs_vinyls[index].basic_information.artists[0].name+'</td><td>'+discogs_vinyls[index].basic_information.title+'</td></tr>')
                    $('.js-importTable').fadeIn()

$('js-startMapping').on 'click', ->
    counter = 0
    processNext(counter)

processNext: (n) ->
    # if n < discogs_vinyls.length
        # TODO:
