$('.js-startImport').click ->
    $identity = $.ajax
        url: 'https://api.discogs.com//users/schnubor/collection/folders/0/releases'
        type: 'GET'
        error: (x,status,error) ->
            console.log status
            console.log error
        success: (response) ->
            console.log response