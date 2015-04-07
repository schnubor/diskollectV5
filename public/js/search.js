(function() {
  var $results;

  $results = [];

  $('#submit-search').click(function(e) {
    var search;
    console.log('Hello from search.');
    e.preventDefault();
    $('.loading').fadeIn();
    $('.search-results-table').hide();
    $('.no-results').hide();
    $('.search-results-table').find('tbody').html('');
    return search = $.ajax({
      url: '/search',
      type: 'POST',
      data: {
        _token: $("input[name='_token']").val(),
        artist: $("input[name='artist']").val(),
        title: $("input[name='title']").val(),
        catno: $("input[name='catno']").val()
      },
      dataType: 'JSON',
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

  $('#quickAddVinyl').on('show.bs.modal', function(e) {
    var $artist, $cover, $title, button, modal, vinyl, vinyl_index;
    button = $(e.relatedTarget);
    vinyl_index = button.data('result');
    vinyl = $results[vinyl_index];
    console.log(vinyl);
    $artist = vinyl.artists[0].name;
    $title = vinyl.title;
    $cover = vinyl.images[0].uri;
    modal = $(this);
    modal.find('.modal-title').text('Add "' + vinyl.artists[0].name + ' - ' + vinyl.title + '" to collection');
    return modal.find('.modal-body .cover').html('<img src="' + $cover + '" class="thumbnail" width="100%">');
  });

}).call(this);
