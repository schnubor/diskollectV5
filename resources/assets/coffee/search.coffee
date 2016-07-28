# Globals
# ----------------------------

$results = []
$vinylData = {}
$search = null

# Submit Search
# ----------------------------

$('#submit-search').click (e) ->
    console.log 'Hello from search.'

    # show loading icon, hide and clear result table
    e.preventDefault()
    $('.loading').fadeIn()
    $('.search-help').hide()
    $('.search-results-table').hide()
    $('.no-results').hide()
    $('.search-results-table').find('tbody').html('')

    # request data from discogs.com
    $search = $.ajax
        url: '/search'
        type: 'POST'
        data:
            _token: $("#search-vinyl-form input[name='_token']").val()
            artist: $("#search-vinyl-form input[name='artist']").val()
            title: $("#search-vinyl-form input[name='title']").val()
            catno: $("#search-vinyl-form input[name='catno']").val()
        dataType: 'JSON'
        error: (x,status,error) ->
            console.log status
            console.log error
            if error == 'abort'
                $('.loading').fadeOut()
            else
                $('.loading').html('<p class="placeholder">Oops! <br> Try refreshing your Discogs Connection</p><a href="/oauth/discogs" class="btn btn-lg btn-primary"><i class="fa fa-fw fa-exchange"></i> Refresh Discogs Token</a>')

        success: (results) -> # search results received
            console.log results
            $results = results
            $index = 0
            $('.loading').fadeOut ->
                if results.length
                    $('.search-results-table').fadeIn()
                    _.each results, (result) ->
                        #console.log result

                        # artist
                        if result.artists
                            $artist = result.artists[0].name
                        else
                            $artist = '<em>unknown artist</em>'

                        # cover
                        if result.images
                            $cover = result.images[0].uri150
                        else
                            $cover = '/images/PH_vinyl.svg'

                        # title
                        if result.title
                            $title = result.title
                        else
                            $title = '<em>unknown title</em>'

                        # catno
                        if result.type == 'release'
                            $catno = result.labels[0].catno
                        else
                            $catno = '<em>no catalog number</em>'

                        # link
                        $link = '/vinyl/add?id='+result.id+'?type='+result.type

                        $vinyl = '<tr><td class="cover"><img src="'+$cover+'" alt="cover"></td><td>'+$artist+'</td><td>'+$title+'</td><td>'+$catno+'</td><td><!--<a href="'+$link+'" class="btn btn-sm btn-info"><i class="fa fa-fw fa-edit"></i> Edit</a>--><button class="btn btn-sm btn-success quick-add" data-toggle="modal" data-target="#quickAddVinyl" data-result="'+$index+'"><i class="fa fa-fw fa-plus"></i> Add</button></td></tr>'
                        $('.search-results-table').find('tbody').append($vinyl)

                        # increase index
                        $index++
                else
                    $('.no-results').fadeIn()

# Cancel search
# ----------------------------

$('#cancel-search').click ->
    $('.search-help').fadeIn()
    $('.loading').fadeOut()
    $search.abort()

# Close Modal
# ----------------------------

$('#quickAddVinyl').on 'hidden.bs.modal', (e) ->
    modal = $(this)
    $('#searchModalSubmit').disabled = true # disable submit
    $('#addVinylForm .trackInfo').remove() # remove track infos
    $('#currencyLabel').hide() # remove price
    modal.find('input[name="price"]').before('<input type="hidden" name="price"/>').remove()
    unless($('#price').length) # as long as not already present
        modal.find('input[name="price"]').before('<p class="h1" id="price">Fetching...</p>') # show price text
    else
        $('#price').text('Fetching...')
    $('#priceLabelText').text('Discogs median price:')

# Quick add
# ----------------------------

$('#quickAddVinyl').on 'show.bs.modal', (e) ->
    button = $(e.relatedTarget)
    vinyl_index = button.data 'result'
    vinyl = $results[vinyl_index]
    modal = $(this)
    console.log vinyl

    # fetch Spotify tracklist
    $spotify = $.ajax
        url: 'https://api.spotify.com/v1/search?q=album%3A'+vinyl.title+'+artist%3A'+vinyl.artists[0].name+'&type=album'
        type: 'GET'
        dataType: 'JSON'
        error: (x,status,error) ->
            console.log status
            console.log error
        success: (results) -> # search results received
            # console.log results
            if(results.albums.items.length)
                $('#spotify').html('<iframe src="https://embed.spotify.com/?uri=spotify%3Aalbum%3A'+results.albums.items[0].id+'" width="100%" height="380" frameborder="0" allowtransparency="true"></iframe>')
                $vinylData.spotify_id = results.albums.items[0].id

    # fetch price
    userCurrency = $('#userCurrency').val()
    ### Disabled until Discogs allows to fetch a price again
    $.fetchPrice vinyl.id, userCurrency, (price) ->
        # show the price & add to form
        if(isNaN(price))
            # no prices on Discogs -> show text input for price
            modal.find('input[name="price"]').before('<input type="text" name="price" class="form-control" placeholder="required" required aria-describedby="currencyLabel"/>').remove()
            $('#currencyLabel').text(userCurrency).show()
            $('#price').remove()
            $('#priceLabelText').text('What did you pay?')
        else
            $('#price').html(price+' '+userCurrency)
            modal.find('input[name="price"]').val(price)
    ###

    # no prices on Discogs -> show text input for price
    modal.find('input[name="price"]').before('<input type="text" name="price" class="form-control" placeholder="required" required aria-describedby="currencyLabel"/>').remove()
    $('#currencyLabel').text(userCurrency).show()
    $('#price').remove()
    $('#priceLabelText').text('What did you pay?')

    # enable submit button
    $('#searchModalSubmit').disabled = false

    # map fetched vinyl data to object required to create vinyl
    $vinylData = $.mapVinylData vinyl

    # visible form data
    modal.find('.modal-title').text('Add "' + vinyl.artists[0].name + ' - '+ vinyl.title + '" to collection')
    modal.find('.modal-body .cover').html('<img src="'+$vinylData.cover+'" class="thumbnail" width="100%">')

# Submit Add Modal
# ----------------------------

$('#searchModalSubmit').on 'click', (e) ->
    e.preventDefault()
    e.stopPropagation()

    button = e.target
    $vinylData._token = $(button).data 'token' # attach CSRF token
    $vinylData.price = $('#quickAddVinyl').find('input[name=price]').val()
    console.log $vinylData
    # fetch Spotify tracklist
    $createVinyl = $.ajax
        url: '/vinyl/create'
        type: 'POST'
        data: $vinylData
        success: (response) ->
            console.log 'vinyl added!'
            $('#quickAddVinyl').modal('hide')
            $('body').append('<div class="flash-message"><div class="alert alert-success fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><a href="/vinyl/'+response.id+'"><b>'+ $vinylData.artist + ' - ' + $vinylData.title + '</b></a> is now in your collection.</div></div>')
        error: (error) ->
            console.warn error
            $('body').append '<div class="flash-message"><div class="alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Oops! Something went wrong, please try again.</div></div>'
