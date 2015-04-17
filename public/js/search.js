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
        _token: $("input[name='_token']").val(),
        artist: $("input[name='artist']").val(),
        title: $("input[name='title']").val(),
        catno: $("input[name='catno']").val()
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

  $('#quickAddVinyl').on('show.bs.modal', function(e) {
    var $artist, $cover, $label, $title, button, modal, vinyl, vinyl_index;
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
    } else {
      $label = 'unknown label';
    }
    modal = $(this);
    modal.find('.modal-title').text('Add "' + vinyl.artists[0].name + ' - ' + vinyl.title + '" to collection');
    modal.find('.modal-body .cover').html('<img src="' + $cover + '" class="thumbnail" width="100%">');
    return modal.find('input[name="title"]').val($title);
  });

}).call(this);
