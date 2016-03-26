# Globals
# ----------------------------

$results = []
$vinylData = {}
$search = null

EURinUSD = 1.14 # USD
EURinGBP = 0.73 # GBP
GBPinUSD = 1.53 # USD

# Calc Median
# ----------------------------

getMedian = (values) ->
    values.sort (a,b) -> return a - b
    half = Math.floor values.length/2
    if values.length % 2
        return values[half]
    else
        return (values[half-1] + values[half]) / 2.0

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
            console.log results
            if(results.albums.items.length)
                $('#spotify').html('<iframe src="https://embed.spotify.com/?uri=spotify%3Aalbum%3A'+results.albums.items[0].id+'" width="598" height="380" frameborder="0" allowtransparency="true"></iframe>')
                $vinylData.spotify_id = results.albums.items[0].id

    # fetch price
    $priceRequest = $.ajax
        url: 'https://api.discogs.com/marketplace/search?release_id='+vinyl.id
        type: 'GET'
        dataType: 'JSON'
        error: (x,status,error) ->
            console.log status
            console.log error
        success: (prices) -> # prices
            # console.log prices
            userCurrency = $('#userCurrency').val()
            values = []
            median = 0

            # convert all prices to EUR and add up
            _.each prices, (price) ->
                currency = price.currency

                switch(price.currency)
                    when 'EUR'
                        values.push(parseInt(price.price.substr(1)))
                    when 'GBP'
                        values.push(parseInt(price.price.substr(1)) / EURinGBP)
                    when 'USD'
                        values.push(parseInt(price.price.substr(1)) / EURinUSD)

            # calc median
            median = getMedian(values).toFixed(2)

            # convert to users currency
            switch(userCurrency)
                when 'EUR'
                    median = median
                when 'GBP'
                    median = median * EURinGBP
                when 'USD'
                    median = median * EURinUSD

            # show the price & add to form
            if(isNaN(median))
                # no prices on Discogs -> show text input for price
                modal.find('input[name="price"]').before('<input type="text" name="price" class="form-control" placeholder="required" required aria-describedby="currencyLabel"/>').remove()
                $('#currencyLabel').text(userCurrency).show()
                $('#price').remove()
                $('#priceLabelText').text('What did you pay?')
            else
                $('#price').html(median+' '+userCurrency)
                modal.find('input[name="price"]').val(median)

            # enable submit button
            $('#searchModalSubmit').disabled = false

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
            console.log key, track
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
        success: (reponse) ->
            console.log 'vinyl added!'
            $('#quickAddVinyl').modal('hide')
            $('body').append '<div class="flash-message"><div class="alert alert-success fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>'+ $vinylData.artist + ' - ' + $vinylData.title + '</b> is now in your collection.</div></div>'
        error: (error) ->
            console.warn error
            $('body').append '<div class="flash-message"><div class="alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Oops! Something went wrong, please try again.</div></div>'
