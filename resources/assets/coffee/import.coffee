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
            #console.log response
            discogs_vinyls = response.releases
            user_vinyls = null

            $api = $.ajax
                url: '/api/user/'+user_id+'/vinyls'
                type: 'GET'
                error: (x,status,error) ->
                    console.log status
                    console.log error
                success: (response) ->
                    user_vinyls = response
                    # imports = $.grep()
                    $('.js-importResults').html('<p class="placeholder">Found '+discogs_vinyls.length+' records in your Discogs collection.</p>')

                    $.each discogs_vinyls, (index) ->
                        $('.js-importTable').find('tbody').append('<tr><td>'+discogs_vinyls[index].id+'</td><td>'+discogs_vinyls[index].basic_information.artists[0].name+'</td><td>'+discogs_vinyls[index].basic_information.title+'</td></tr>')
                    $('.js-importTable').fadeIn()
