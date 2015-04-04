(function() {
  $('#submit-search').click(function(e) {
    console.log('Hello from search.');
    e.preventDefault();
    $('.loading').fadeIn();
    $('.search-results-table').hide();
    $('.search-results-table').find('tbody').html('');
    return $.ajax({
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
        return $('.loading').fadeOut(function() {
          $('.search-results-table').fadeIn();
          return _.each(results, function(result) {
            var $vinyl;
            console.log(result);
            $vinyl = '<tr><td><img src="' + result.images[0].uri150 + '" alt="cover"></td><td>' + result.artists[0].name + '</td><td>' + result.title + '</td><td>' + result.labels[0].catno + '</td><td><button class="btn btn-sm btn-success">Add</button></td></tr>';
            return $('.search-results-table').find('tbody').append($vinyl);
          });
        });
      }
    });
  });

}).call(this);
