# Calc Median
# ----------------------------
getMedian = (values) ->
    values.sort (a,b) -> return a - b
    half = Math.floor values.length/2
    if values.length % 2
        return values[half]
    else
        return (values[half-1] + values[half]) / 2.0

# Fetch price of vinyl ID
# ----------------------------------
$.fetchPrice = (id, userCurrency, callback) ->

    EURinUSD = 1.12 # USD
    EURinGBP = 0.79 # GBP
    GBPinUSD = 1.42 # USD

    $.ajax
        url: "https://api.discogs.com/marketplace/search?release_id=#{id}"
        type: 'GET'
        dataType: 'JSON'
        error: (x,status,error) ->
            console.log status
            console.log error
        success: (prices) -> # prices
            # console.log prices
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

            callback(median)

# Map fetched vinyl data to object required to create vinyl
# ---------------------------------------------------------
$.mapVinylData = (vinyl) ->
    $vinylData = {}

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

    # price
    if vinyl.lowest_price
        $vinylData.price = vinyl.lowest_price
    else
        $vinylData.price = 0

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
            # console.log key, track
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

    return $vinylData
