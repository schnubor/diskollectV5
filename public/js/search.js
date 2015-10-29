(function() {
  var $results, $search, EURinGBP, EURinUSD, GBPinUSD, getMedian;

  $results = [];

  $search = null;

  EURinUSD = 1.14;

  EURinGBP = 0.73;

  GBPinUSD = 1.53;

  getMedian = function(values) {
    var half;
    values.sort((function(_this) {
      return function(a, b) {
        return a - b;
      };
    })(this));
    half = Math.floor(values.length / 2);
    if (values.length % 2) {
      return values[half];
    } else {
      return (values[half - 1] + values[half]) / 2.0;
    }
  };

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
    $('#modalSubmit').disabled = true;
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
    var $artist, $catno, $color, $count, $country, $cover, $discogs_uri, $format, $genre, $label, $priceRequest, $release_id, $size, $spotify, $title, $tracklist, $type, $videos, $weight, $year, button, modal, vinyl, vinyl_index;
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
        console.log(results);
        if (results.albums.items.length) {
          $('#spotify').html('<iframe src="https://embed.spotify.com/?uri=spotify%3Aalbum%3A' + results.albums.items[0].id + '" width="598" height="380" frameborder="0" allowtransparency="true"></iframe>');
          return modal.find('input[name="spotify_id"]').val(results.albums.items[0].id);
        }
      }
    });
    $priceRequest = $.ajax({
      url: '//api.discogs.com/marketplace/search?release_id=' + vinyl.id,
      type: 'GET',
      dataType: 'JSON',
      error: function(x, status, error) {
        console.log(status);
        return console.log(error);
      },
      success: function(prices) {
        var median, userCurrency, values;
        userCurrency = $('#userCurrency').val();
        values = [];
        median = 0;
        _.each(prices, function(price) {
          var currency;
          currency = price.currency;
          switch (price.currency) {
            case 'EUR':
              return values.push(parseInt(price.price.substr(1)));
            case 'GBP':
              return values.push(parseInt(price.price.substr(1)) / EURinGBP);
            case 'USD':
              return values.push(parseInt(price.price.substr(1)) / EURinUSD);
          }
        });
        median = getMedian(values).toFixed(2);
        switch (userCurrency) {
          case 'EUR':
            median = median;
            break;
          case 'GBP':
            median = median * EURinGBP;
            break;
          case 'USD':
            median = median * EURinUSD;
        }
        if (isNaN(median)) {
          modal.find('input[name="price"]').before('<input type="text" name="price" class="form-control" placeholder="required" required aria-describedby="currencyLabel"/>').remove();
          $('#currencyLabel').text(userCurrency).show();
          $('#price').remove();
          $('#priceLabelText').text('What did you pay?');
        } else {
          $('#price').html(median + ' ' + userCurrency);
          modal.find('input[name="price"]').val(median);
        }
        return $('#modalSubmit').disabled = false;
      }
    });
    if (vinyl.artists) {
      $artist = vinyl.artists[0].name;
    } else {
      $artist = 'unknown artist';
    }
    if (vinyl.title) {
      $title = vinyl.title;
    } else {
      $title = 'unknown title';
    }
    if (vinyl.images) {
      $cover = vinyl.images[0].uri;
    } else {
      $cover = 'images/PH_vinyl.svg';
    }
    if (vinyl.labels) {
      $label = vinyl.labels[0].name;
      if (vinyl.labels[0].catno) {
        $catno = vinyl.labels[0].catno;
      } else {
        $catno = 'unknown catno';
      }
    } else {
      $label = 'unknown label';
    }
    if (vinyl.genres) {
      $genre = vinyl.genres[0];
    } else {
      $genre = 'unknown genre';
    }
    if (vinyl.country) {
      $country = vinyl.country;
    } else {
      $country = 'unknown country';
    }
    if (vinyl.year) {
      $year = vinyl.year;
    } else {
      $year = 'unknown year';
    }
    if (vinyl.format_quantity) {
      $count = vinyl.format_quantity;
    } else {
      $count = 'unknown quantity';
    }
    if (vinyl.estimated_weight) {
      $weight = vinyl.estimated_weight;
    } else {
      $weight = '0';
    }
    if (vinyl.type) {
      $type = vinyl.type;
    } else {
      $type = '-';
    }
    $color = '#000000';
    $size = '12';
    $format = 'LP';
    $release_id = vinyl.id;
    $discogs_uri = vinyl.uri;
    if (vinyl.tracklist) {
      $tracklist = vinyl.tracklist;
    } else {
      $tracklist = [];
    }
    if (vinyl.videos) {
      $videos = vinyl.videos;
    } else {
      $videos = [];
    }
    modal.find('.modal-title').text('Add "' + vinyl.artists[0].name + ' - ' + vinyl.title + '" to collection');
    modal.find('.modal-body .cover').html('<img src="' + $cover + '" class="thumbnail" width="100%">');
    modal.find('input[name="artist"]').val($artist);
    modal.find('input[name="title"]').val($title);
    modal.find('input[name="cover"]').val($cover);
    modal.find('input[name="label"]').val($label);
    modal.find('input[name="catno"]').val($catno);
    modal.find('input[name="genre"]').val($genre);
    modal.find('input[name="country"]').val($country);
    modal.find('input[name="year"]').val($year);
    modal.find('input[name="count"]').val($count);
    modal.find('input[name="color"]').val($color);
    modal.find('input[name="format"]').val($format);
    modal.find('input[name="size"]').val($size);
    modal.find('input[name="weight"]').val($weight);
    modal.find('input[name="type"]').val($type);
    modal.find('input[name="release_id"]').val($release_id);
    modal.find('input[name="discogs_uri"]').val($discogs_uri);
    modal.find('input[name="trackCount"]').val($tracklist.length);
    modal.find('input[name="videoCount"]').val($videos.length);
    _.each($tracklist, function(track, index) {
      modal.find('#addVinylForm').append('<input class="trackInfo" name="track_' + index + '_title" type="hidden" value="' + track.title + '"/>');
      modal.find('#addVinylForm').append('<input class="trackInfo" name="track_' + index + '_position" type="hidden" value="' + track.position + '"/>');
      return modal.find('#addVinylForm').append('<input class="trackInfo" name="track_' + index + '_duration" type="hidden" value="' + track.duration + '"/>');
    });
    return _.each($videos, function(video, index) {
      var uri;
      uri = "//www.youtube.com/embed/" + video.uri.substr(video.uri.length - 11);
      modal.find('#addVinylForm').append('<input class="videoInfo" name="video_' + index + '_title" type="hidden" value="' + video.title + '"/>');
      modal.find('#addVinylForm').append('<input class="videoInfo" name="video_' + index + '_uri" type="hidden" value="' + uri + '"/>');
      return modal.find('#addVinylForm').append('<input class="videoInfo" name="video_' + index + '_duration" type="hidden" value="' + video.duration + '"/>');
    });
  });

}).call(this);
