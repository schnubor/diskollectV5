(function() {
  var $results, $search, $vinylData;

  $results = [];

  $vinylData = {};

  $search = null;

  $('#submit-search').click(function(e) {
    console.log('Hello from search.');
    e.preventDefault();
    $('.loading').fadeIn();
    $('.search-help').hide();
    $('.search-results-table').hide();
    $('.no-results').hide();
    $('.search-results-table').find('tbody').html('');
    return $search = $.ajax({
      url: '/search',
      type: 'POST',
      data: {
        _token: $("#search-vinyl-form input[name='_token']").val(),
        artist: $("#search-vinyl-form input[name='artist']").val(),
        title: $("#search-vinyl-form input[name='title']").val(),
        catno: $("#search-vinyl-form input[name='catno']").val()
      },
      dataType: 'JSON',
      error: function(x, status, error) {
        console.log(status);
        console.log(error);
        if (error === 'abort') {
          return $('.loading').fadeOut();
        } else {
          return $('.loading').html('<p class="placeholder">Oops! <br> Try refreshing your Discogs Connection</p><a href="/oauth/discogs" class="btn btn-lg btn-primary"><i class="fa fa-fw fa-exchange"></i> Refresh Discogs Token</a>');
        }
      },
      success: function(results) {
        var $index;
        console.log(results);
        $results = results;
        $index = 0;
        return $('.loading').fadeOut(function() {
          if (results.length) {
            $('.search-results-table').fadeIn();
            return _.each(results, function(result) {
              var $artist, $catno, $cover, $link, $title, $vinyl;
              if (result.artists) {
                $artist = result.artists[0].name;
              } else {
                $artist = '<em>unknown artist</em>';
              }
              if (result.images) {
                $cover = result.images[0].uri150;
              } else {
                $cover = '/images/PH_vinyl.svg';
              }
              if (result.title) {
                $title = result.title;
              } else {
                $title = '<em>unknown title</em>';
              }
              if (result.type === 'release') {
                $catno = result.labels[0].catno;
              } else {
                $catno = '<em>no catalog number</em>';
              }
              $link = '/vinyl/add?id=' + result.id + '?type=' + result.type;
              $vinyl = '<tr><td class="cover"><img src="' + $cover + '" alt="cover"></td><td>' + $artist + '</td><td>' + $title + '</td><td>' + $catno + '</td><td><!--<a href="' + $link + '" class="btn btn-sm btn-info"><i class="fa fa-fw fa-edit"></i> Edit</a>--><button class="btn btn-sm btn-success quick-add" data-toggle="modal" data-target="#quickAddVinyl" data-result="' + $index + '"><i class="fa fa-fw fa-plus"></i> Add</button></td></tr>';
              $('.search-results-table').find('tbody').append($vinyl);
              return $index++;
            });
          } else {
            return $('.no-results').fadeIn();
          }
        });
      }
    });
  });

  $('#cancel-search').click(function() {
    $('.search-help').fadeIn();
    $('.loading').fadeOut();
    return $search.abort();
  });

  $('#quickAddVinyl').on('hidden.bs.modal', function(e) {
    var modal;
    modal = $(this);
    $('#searchModalSubmit').disabled = true;
    $('#addVinylForm .trackInfo').remove();
    $('#currencyLabel').hide();
    modal.find('input[name="price"]').before('<input type="hidden" name="price"/>').remove();
    if (!($('#price').length)) {
      modal.find('input[name="price"]').before('<p class="h1" id="price">Fetching...</p>');
    } else {
      $('#price').text('Fetching...');
    }
    return $('#priceLabelText').text('Discogs median price:');
  });

  $('#quickAddVinyl').on('show.bs.modal', function(e) {
    var $spotify, button, modal, userCurrency, vinyl, vinyl_index;
    button = $(e.relatedTarget);
    vinyl_index = button.data('result');
    vinyl = $results[vinyl_index];
    modal = $(this);
    console.log(vinyl);
    $spotify = $.ajax({
      url: 'https://api.spotify.com/v1/search?q=album%3A' + vinyl.title + '+artist%3A' + vinyl.artists[0].name + '&type=album',
      type: 'GET',
      dataType: 'JSON',
      error: function(x, status, error) {
        console.log(status);
        return console.log(error);
      },
      success: function(results) {
        if (results.albums.items.length) {
          $('#spotify').html('<iframe src="https://embed.spotify.com/?uri=spotify%3Aalbum%3A' + results.albums.items[0].id + '" width="100%" height="380" frameborder="0" allowtransparency="true"></iframe>');
          return $vinylData.spotify_id = results.albums.items[0].id;
        }
      }
    });
    userCurrency = $('#userCurrency').val();

    /* Disabled until Discogs allows to fetch a price again
    $.fetchPrice vinyl.id, userCurrency, (price) ->
         * show the price & add to form
        if(isNaN(price))
             * no prices on Discogs -> show text input for price
            modal.find('input[name="price"]').before('<input type="text" name="price" class="form-control" placeholder="required" required aria-describedby="currencyLabel"/>').remove()
            $('#currencyLabel').text(userCurrency).show()
            $('#price').remove()
            $('#priceLabelText').text('What did you pay?')
        else
            $('#price').html(price+' '+userCurrency)
            modal.find('input[name="price"]').val(price)
     */
    modal.find('input[name="price"]').before('<input type="text" name="price" class="form-control" placeholder="required" required aria-describedby="currencyLabel"/>').remove();
    $('#currencyLabel').text(userCurrency).show();
    $('#price').remove();
    $('#priceLabelText').text('What did you pay?');
    $('#searchModalSubmit').disabled = false;
    $vinylData = $.mapVinylData(vinyl);
    modal.find('.modal-title').text('Add "' + vinyl.artists[0].name + ' - ' + vinyl.title + '" to collection');
    return modal.find('.modal-body .cover').html('<img src="' + $vinylData.cover + '" class="thumbnail" width="100%">');
  });

  $('#searchModalSubmit').on('click', function(e) {
    var $createVinyl, button;
    e.preventDefault();
    e.stopPropagation();
    button = e.target;
    $vinylData._token = $(button).data('token');
    $vinylData.price = $('#quickAddVinyl').find('input[name=price]').val();
    console.log($vinylData);
    return $createVinyl = $.ajax({
      url: '/vinyl/create',
      type: 'POST',
      data: $vinylData,
      success: function(response) {
        console.log('vinyl added!');
        $('#quickAddVinyl').modal('hide');
        return $('body').append('<div class="flash-message"><div class="alert alert-success fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><a href="/vinyl/' + response.id + '"><b>' + $vinylData.artist + ' - ' + $vinylData.title + '</b></a> is now in your collection.</div></div>');
      },
      error: function(error) {
        console.warn(error);
        return $('body').append('<div class="flash-message"><div class="alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Oops! Something went wrong, please try again.</div></div>');
      }
    });
  });

}).call(this);

//# sourceMappingURL=search.js.map