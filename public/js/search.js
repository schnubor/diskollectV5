(function() {
  var $results, $search;

  $results = [];

  $search = null;

  $('#submit-search').click(function(e) {
    console.log('Hello from search.');
    e.preventDefault();
    $('.loading').fadeIn();
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
          return $('.loading').html('<p class="h1">Oops!</p><p class="lead">Try refreshing your Discogs Connection</p><a href="/oauth/discogs" class="btn btn-lg btn-primary">Refresh Discogs Token</a>');
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
              $vinyl = '<tr><td class="cover"><img src="' + $cover + '" alt="cover"></td><td>' + $artist + '</td><td>' + $title + '</td><td>' + $catno + '</td><td><a href="' + $link + '" class="btn btn-sm btn-info"><i class="fa fa-fw fa-edit"></i> Edit</a><button class="btn btn-sm btn-success quick-add" data-toggle="modal" data-target="#quickAddVinyl" data-result="' + $index + '"><i class="fa fa-fw fa-plus"></i> Quick add</button></td></tr>';
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
    $('.loading').fadeOut();
    return $search.abort();
  });

  $('#quickAddVinyl').on('hide.bs.modal', function(e) {
    return $('#addVinylForm .trackInfo').remove();
  });

  $('#quickAddVinyl').on('show.bs.modal', function(e) {
    var $artist, $catno, $color, $count, $country, $cover, $format, $genre, $label, $size, $title, $tracklist, $type, $weight, $year, button, modal, vinyl, vinyl_index;
    button = $(e.relatedTarget);
    vinyl_index = button.data('result');
    vinyl = $results[vinyl_index];
    console.log(vinyl);
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
    if (vinyl.tracklist) {
      $tracklist = vinyl.tracklist;
    } else {
      $tracklist = [];
    }
    modal = $(this);
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
    modal.find('input[name="trackCount"]').val($tracklist.length);
    return _.each($tracklist, function(track, index) {
      modal.find('#addVinylForm').append('<input class="trackInfo" name="track_' + index + '_title" type="hidden" value="' + track.title + '"/>');
      modal.find('#addVinylForm').append('<input class="trackInfo" name="track_' + index + '_position" type="hidden" value="' + track.position + '"/>');
      return modal.find('#addVinylForm').append('<input class="trackInfo" name="track_' + index + '_duration" type="hidden" value="' + track.duration + '"/>');
    });
  });

}).call(this);

//# sourceMappingURL=search.js.map