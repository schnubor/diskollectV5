$('#submit-search').click (e) ->
  console.log 'Hello from search.'
  
  # show loading icon, hide and clear result table
  e.preventDefault()
  $('.loading').fadeIn()
  $('.search-results-table').hide()
  $('.search-results-table').find('tbody').html('');

  # request data from discogs.com
  $.ajax
    url: '/search'
    type: 'POST'
    data: 
      _token: $("input[name='_token']").val()
      artist: $("input[name='artist']").val()
      title: $("input[name='title']").val()
      catno: $("input[name='catno']").val()
    dataType: 'JSON'
    success: (results) -> # search results received
      # console.log results
      $('.loading').fadeOut ->
        $('.search-results-table').fadeIn()
        _.each results, (result) ->
          console.log result
          $vinyl = '<tr><td><img src="'+result.images[0].uri150+'" alt="cover"></td><td>'+result.artists[0].name+'</td><td>'+result.title+'</td><td>'+result.labels[0].catno+'</td><td><button class="btn btn-sm btn-success">Add</button></td></tr>';
          $('.search-results-table').find('tbody').append($vinyl);


    