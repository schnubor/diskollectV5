# Globals
# ----------------------------

$results = []
$search = null

EURinUSD = 1.14 # USD
EURinGBP = 0.73 # GBP
GBPinUSD = 1.53 # USD

# Calc Median
# ----------------------------

getMedian = (values) ->
  values.sort  (a,b)=> return a - b
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
  $('.search-results-table').find('tbody').html('');

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
      # console.log results
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

            $vinyl = '<tr><td class="cover"><img src="'+$cover+'" alt="cover"></td><td>'+$artist+'</td><td>'+$title+'</td><td>'+$catno+'</td><td><!--<a href="'+$link+'" class="btn btn-sm btn-info"><i class="fa fa-fw fa-edit"></i> Edit</a>--><button class="btn btn-sm btn-success quick-add" data-toggle="modal" data-target="#quickAddVinyl" data-result="'+$index+'"><i class="fa fa-fw fa-plus"></i> Add</button></td></tr>';
            $('.search-results-table').find('tbody').append($vinyl);

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
  $('#modalSubmit').disabled = true         # disable submit
  $('#addVinylForm .trackInfo').remove()    # remove track infos
  $('#currencyLabel').hide()                # remove price
  modal.find('input[name="price"]').before('<input type="hidden" name="price"/>').remove()
  unless($('#price').length)                # as long as not already present
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
        modal.find('input[name="spotify_id"]').val(results.albums.items[0].id)

  # fetch price
  $priceRequest = $.ajax
    url: '//api.discogs.com/marketplace/search?release_id='+vinyl.id
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
      $('#modalSubmit').disabled = false

  # artist
  if vinyl.artists
    $artist = vinyl.artists[0].name
  else
    $artist = 'unknown artist'

  # title
  if vinyl.title
    $title = vinyl.title
  else
    $title = 'unknown title'

  # cover
  if vinyl.images
    $cover = vinyl.images[0].uri
  else
    $cover = 'images/PH_vinyl.svg'

  # label & catno
  if vinyl.labels
    $label = vinyl.labels[0].name
    if vinyl.labels[0].catno
      $catno = vinyl.labels[0].catno
    else
      $catno = 'unknown catno'
  else
    $label = 'unknown label'

  # genre
  if vinyl.genres
    $genre = vinyl.genres[0]
  else
    $genre = 'unknown genre'

  # country
  if vinyl.country
    $country = vinyl.country
  else
    $country = 'unknown country'

  # year
  if vinyl.year
    $year = vinyl.year
  else
    $year = 'unknown year'

  # count
  if vinyl.format_quantity
    $count = vinyl.format_quantity
  else
    $count = 'unknown quantity'

  # weight
  if vinyl.estimated_weight
    $weight = vinyl.estimated_weight
  else
    $weight = '0'

  # type
  if vinyl.type
    $type = vinyl.type
  else
    $type = '-'

  # color
  $color = '#000000'

  # size
  $size = '12'

  # format
  $format = 'LP'

  # release ID
  $release_id = vinyl.id

  # Discogs URI
  $discogs_uri = vinyl.uri

  # tracklist
  if vinyl.tracklist
    $tracklist = vinyl.tracklist
  else
    $tracklist = []

  # videos
  if vinyl.videos
    $videos = vinyl.videos
  else
    $videos = []

  # visible form data
  modal.find('.modal-title').text('Add "' + vinyl.artists[0].name + ' - '+ vinyl.title + '" to collection')
  modal.find('.modal-body .cover').html('<img src="'+$cover+'" class="thumbnail" width="100%">')
  
  # invisible form data
  modal.find('input[name="artist"]').val($artist)
  modal.find('input[name="title"]').val($title)
  modal.find('input[name="cover"]').val($cover)
  modal.find('input[name="label"]').val($label)
  modal.find('input[name="catno"]').val($catno)
  modal.find('input[name="genre"]').val($genre)
  modal.find('input[name="country"]').val($country)
  modal.find('input[name="year"]').val($year)
  modal.find('input[name="count"]').val($count)
  modal.find('input[name="color"]').val($color)
  modal.find('input[name="format"]').val($format)
  modal.find('input[name="size"]').val($size)
  modal.find('input[name="weight"]').val($weight)
  modal.find('input[name="type"]').val($type)
  modal.find('input[name="release_id"]').val($release_id)
  modal.find('input[name="discogs_uri"]').val($discogs_uri)
  modal.find('input[name="trackCount"]').val($tracklist.length)
  modal.find('input[name="videoCount"]').val($videos.length)
  _.each $tracklist, (track, index) ->
    #console.log track
    modal.find('#addVinylForm').append('<input class="trackInfo" name="track_'+index+'_title" type="hidden" value="'+track.title+'"/>');
    modal.find('#addVinylForm').append('<input class="trackInfo" name="track_'+index+'_position" type="hidden" value="'+track.position+'"/>');
    modal.find('#addVinylForm').append('<input class="trackInfo" name="track_'+index+'_duration" type="hidden" value="'+track.duration+'"/>');
  _.each $videos, (video, index) ->
    #console.log video
    # rewrite uri to embed uri
    uri = "//www.youtube.com/embed/"+video.uri.substr(video.uri.length-11)
    modal.find('#addVinylForm').append('<input class="videoInfo" name="video_'+index+'_title" type="hidden" value="'+video.title+'"/>');
    modal.find('#addVinylForm').append('<input class="videoInfo" name="video_'+index+'_uri" type="hidden" value="'+uri+'"/>');
    modal.find('#addVinylForm').append('<input class="videoInfo" name="video_'+index+'_duration" type="hidden" value="'+video.duration+'"/>');
