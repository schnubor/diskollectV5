# Globals
# ----------------------------

$results = []
$search = null

# Submit Search
# ----------------------------

$('#submit-search').click (e) ->
  console.log 'Hello from search.'
  
  # show loading icon, hide and clear result table
  e.preventDefault()
  $('.loading').fadeIn()
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
        $('.loading').html('<p class="h1">Oops!</p><p class="lead">Try refreshing your Discogs Connection</p><a href="/oauth/discogs" class="btn btn-lg btn-primary">Refresh Discogs Token</a>')

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

            $vinyl = '<tr><td class="cover"><img src="'+$cover+'" alt="cover"></td><td>'+$artist+'</td><td>'+$title+'</td><td>'+$catno+'</td><td><a href="'+$link+'" class="btn btn-sm btn-info"><i class="fa fa-fw fa-edit"></i> Edit</a><button class="btn btn-sm btn-success quick-add" data-toggle="modal" data-target="#quickAddVinyl" data-result="'+$index+'"><i class="fa fa-fw fa-plus"></i> Quick add</button></td></tr>';
            $('.search-results-table').find('tbody').append($vinyl);

            # increase index
            $index++
        else
          $('.no-results').fadeIn()

# Cancel search
# ----------------------------

$('#cancel-search').click ->
  $('.loading').fadeOut()
  $search.abort()

# Quick add
# ----------------------------

$('#quickAddVinyl').on 'show.bs.modal', (e) ->
  button = $(e.relatedTarget)
  vinyl_index = button.data 'result'
  vinyl = $results[vinyl_index]
  console.log vinyl

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

  # color
  $color = '#000000'

  # size
  $size = '12'

  # format
  $format = 'LP'

  # visible form data
  modal = $(this)
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

    