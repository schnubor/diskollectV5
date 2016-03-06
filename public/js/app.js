(function() {
  $('[data-toggle="tooltip"]').tooltip();

  $('[data-toggle="popover"]').popover({
    html: true
  });

}).call(this);

(function() {
  $.getStats = function(userId) {
    var $vinyls;
    console.log('user: ' + userId);
    return $vinyls = $.ajax({
      url: '/api/user/' + userId + '/vinyls',
      type: 'GET',
      dataType: 'JSON',
      error: function(x, status, error) {
        console.log(status);
        return console.log(error);
      },
      success: function(vinyls) {
        var genreChart, genreData, sizeChart, sizeData, sizeData_temp, timeChart, timeData, timeData_temp;
        genreData = [];
        sizeData = [['x'], ['sizes']];
        sizeData_temp = [];
        timeData = [['x'], ['vinyls']];
        timeData_temp = [];
        vinyls = vinyls.data;
        _.each(vinyls, function(vinyl) {
          var genre, size, time;
          genre = vinyl.genre.split(';')[0];
          if (genre === "") {
            genre = "unknown";
          }
          genreData.push(genre);
          size = vinyl.size;
          sizeData_temp.push(size);
          time = new Date(vinyl.releasedate);
          if (time.getFullYear()) {
            return timeData_temp.push(time.format('Y'));
          }
        });
        console.log(timeData_temp);
        genreData = _.chain(genreData).countBy().pairs().value();
        sizeData_temp = _.chain(sizeData_temp).countBy().pairs().value();
        _.each(sizeData_temp, function(sizeArray) {
          sizeData[0].push(sizeArray[0]);
          return sizeData[1].push(sizeArray[1]);
        });
        timeData_temp = _.chain(timeData_temp).countBy().pairs().value();
        _.each(timeData_temp, function(timeArray) {
          timeData[0].push(timeArray[0]);
          return timeData[1].push(timeArray[1]);
        });
        console.log(timeData);
        genreChart = c3.generate({
          bindto: '#genreChart',
          data: {
            columns: genreData,
            type: 'donut'
          },
          legend: {
            show: true
          },
          donut: {
            title: vinyls.length + ' Vinyls',
            label: {
              format: function(value) {
                return value;
              }
            }
          }
        });
        sizeChart = c3.generate({
          bindto: '#sizeChart',
          data: {
            x: 'x',
            columns: sizeData,
            types: {
              sizes: 'bar'
            }
          },
          legend: {
            show: false
          },
          axis: {
            x: {
              type: 'categorized'
            }
          }
        });
        return timeChart = c3.generate({
          bindto: '#timeChart',
          data: {
            x: 'x',
            columns: timeData
          },
          legend: {
            show: false
          }
        });
      }
    });
  };

}).call(this);

(function() {
  var readUrl;

  $('.createVinyl .js-add-track').click(function() {
    var $tracks;
    $tracks = $('.createVinyl input[name="trackCount"]').val();
    $tracks++;
    $('.createVinyl input[name="trackCount"]').val($tracks);
    return $('.js-trackTable').append('<tr class="track' + ($tracks - 1) + '"><td width="80px" style="padding-left: 0;"><input class="form-control" placeholder="A1" name="track_' + ($tracks - 1) + '_position" type="text"></td><td><input class="form-control" placeholder="Title" name="track_' + ($tracks - 1) + '_title" type="text"></td><td width="100px"><input class="form-control" placeholder="1:13" name="track_' + ($tracks - 1) + '_duration" type="text"></td></tr>');
  });

  readUrl = function(input) {
    var reader;
    if (input.files && input.files[0]) {
      reader = new FileReader();
      return reader.onload = function(e) {
        $('#vinylCover').attr('src', e.target.result);
        return reader.readAsDataURL(input.files[0]);
      };
    }
  };

  $("input[name='coverFile']").change(function() {
    return readUrl(this);
  });

  $("input[name='cover']").change(function() {
    return $('#vinylCover').attr('src', $(this).val());
  });

  $('.editVinyl .js-delete-track').click(function() {
    var id;
    id = $(this).data('trackId');
    console.log('click ' + id);
    return $('tr.track' + id);
  });

}).call(this);

(function() {
  $.getStatus = function(userId) {
    var $vinyls;
    console.log(userId);
    return $vinyls = $.ajax({
      url: '/api/user/' + userId + '/status',
      type: 'GET',
      error: function(x, status, error) {
        console.log(status);
        console.log(error);
        $('.js-connectionStatus').removeClass('btn-info').addClass('btn-danger').html('<i class="fa fa-fw fa-exclamation-circle"></i> Not connected');
        return $('.js-connectionAction').removeClass('hidden');
      },
      success: function(response) {
        return $('.js-connectionStatus').removeClass('btn-info').addClass('btn-success').html('<i class="fa fa-fw fa-check"></i> Connected');
      }
    });
  };

}).call(this);

(function() {
  $.getReleases = function(username, user_id) {
    var $discogs;
    $('.js-startImport').fadeOut(400, function() {
      return $('.js-importResults').html('<p class="placeholder">Fetching ...</p>');
    });
    return $discogs = $.ajax({
      url: 'https://api.discogs.com/users/' + username + '/collection/folders/0/releases',
      type: 'GET',
      error: function(x, status, error) {
        console.log(status);
        return console.log(error);
      },
      success: function(response) {
        var $api, discogs_vinyls, user_vinyls;
        discogs_vinyls = response.releases;
        user_vinyls = null;
        return $api = $.ajax({
          url: '/api/user/' + user_id + '/vinyls',
          type: 'GET',
          error: function(x, status, error) {
            console.log(status);
            return console.log(error);
          },
          success: function(response) {
            user_vinyls = response;
            $('.js-importResults').html('<p class="placeholder">Found ' + discogs_vinyls.length + ' records in your Discogs collection.</p>');
            $.each(discogs_vinyls, function(index) {
              return $('.js-importTable').find('tbody').append('<tr><td>' + discogs_vinyls[index].id + '</td><td>' + discogs_vinyls[index].basic_information.artists[0].name + '</td><td>' + discogs_vinyls[index].basic_information.title + '</td></tr>');
            });
            return $('.js-importTable').fadeIn();
          }
        });
      }
    });
  };

}).call(this);


/*
  String to time
 */

(function() {
  var checkPlayer, delay, firstScriptTag, player, tag;

  String.prototype.toHHMMSS = function() {
    var hours, minutes, sec_num, seconds, time;
    sec_num = parseInt(this, 10);
    hours = Math.floor(sec_num / 3600);
    minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    seconds = sec_num - (hours * 3600) - (minutes * 60);
    if (hours < 10) {
      hours = '0' + hours;
    }
    if (minutes < 10) {
      minutes = '0' + minutes;
    }
    if (seconds < 10) {
      seconds = '0' + seconds;
    }
    time = hours + ':' + minutes + ':' + seconds;
    return time;
  };


  /*
    Youtube API
   */

  tag = document.createElement('script');

  tag.src = 'https://www.youtube.com/iframe_api';

  firstScriptTag = document.getElementsByTagName('script')[0];

  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  player = void 0;

  checkPlayer = void 0;

  delay = function(ms, func) {
    return setTimeout(func, ms);
  };


  /*
    JukeBox functionality
   */

  $.jukebox = function(vinyls) {
    var duration, onPlayerReady, onPlayerStateChange, video, vinyl;
    window.onYouTubeIframeAPIReady = function() {
      player = new YT.Player('player', {
        events: {
          'onReady': onPlayerReady,
          'onStateChange': onPlayerStateChange
        }
      });
    };
    onPlayerStateChange = function(state) {};
    onPlayerReady = function() {
      player.playVideo();
      checkPlayer = setInterval(function() {
        var state;
        state = player.getPlayerState();
        console.log(state);
        if (state === -1 || state === 0) {
          clearInterval(checkPlayer);
          checkPlayer = 0;
          return $.jukebox(vinyls);
        }
      }, 2000);
    };
    vinyl = vinyls[Math.floor(Math.random() * vinyls.length)];
    video = vinyl.videos[Math.floor(Math.random() * vinyl.videos.length)];
    $('.js-cover').attr('src', vinyl.artwork);
    $('.js-link').attr('href', '/vinyl/' + vinyl.id);
    $('.js-vinylTitle').text(vinyl.artist + ' – ' + vinyl.title);
    duration = video.duration.toHHMMSS();
    $('.js-videoTitle').html(video.title + '<span class="badge pull-right">' + duration + '</span>');
    $('#player').attr('src', video.uri + "?&controls=0&enablejsapi=1&showinfo=0&autohide=1&iv_load_policy=3");
    return $('.js-skip').click(function() {
      clearInterval(checkPlayer);
      checkPlayer = 0;
      return $.jukebox(vinyls);
    });
  };

}).call(this);

(function() {
  var $results, $search, $vinylData, EURinGBP, EURinUSD, GBPinUSD, getMedian;

  $results = [];

  $vinylData = {};

  $search = null;

  EURinUSD = 1.14;

  EURinGBP = 0.73;

  GBPinUSD = 1.53;

  getMedian = function(values) {
    var half;
    values.sort(function(a, b) {
      return a - b;
    });
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
    var $priceRequest, $spotify, button, modal, vinyl, vinyl_index;
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
          return $vinylData.spotify_id = results.albums.items[0].id;
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
        return $('#searchModalSubmit').disabled = false;
      }
    });
    if (vinyl.artists) {
      $vinylData.artist = vinyl.artists[0].name;
    } else {
      $vinylData.artist = 'unknown artist';
    }
    if (vinyl.title) {
      $vinylData.title = vinyl.title;
    } else {
      $vinylData.title = 'unknown title';
    }
    if (vinyl.images) {
      $vinylData.cover = vinyl.images[0].uri;
    } else {
      $vinylData.cover = 'images/PH_vinyl.svg';
    }
    if (vinyl.labels) {
      $vinylData.label = vinyl.labels[0].name;
      if (vinyl.labels[0].catno) {
        $vinylData.catno = vinyl.labels[0].catno;
      } else {
        $vinylData.catno = 'unknown catno';
      }
    } else {
      $vinylData.label = 'unknown label';
    }
    if (vinyl.genres) {
      $vinylData.genre = vinyl.genres[0];
    } else {
      $vinylData.genre = 'unknown genre';
    }
    if (vinyl.country) {
      $vinylData.country = vinyl.country;
    } else {
      $vinylData.country = 'unknown country';
    }
    if (vinyl.year) {
      $vinylData.year = vinyl.year;
    } else {
      $vinylData.year = 'unknown year';
    }
    if (vinyl.format_quantity) {
      $vinylData.count = vinyl.format_quantity;
    } else {
      $vinylData.count = 'unknown quantity';
    }
    if (vinyl.estimated_weight) {
      $vinylData.weight = vinyl.estimated_weight;
    } else {
      $vinylData.weight = '0';
    }
    if (vinyl.type) {
      $vinylData.type = vinyl.type;
    } else {
      $vinylData.type = '-';
    }
    $vinylData.color = '#000000';
    $vinylData.size = '12';
    $vinylData.format = 'LP';
    $vinylData.release_id = vinyl.id;
    $vinylData.discogs_uri = vinyl.uri;
    if (vinyl.tracklist) {
      $vinylData.tracklist = vinyl.tracklist;
    } else {
      $vinylData.tracklist = [];
    }
    if (vinyl.videos) {
      $vinylData.videos = vinyl.videos;
    } else {
      $vinylData.videos = [];
    }
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
      success: function(reponse) {
        console.log('vinyl added!');
        $('#quickAddVinyl').modal('hide');
        return $('body').append('<div class="flash-message"><div class="alert alert-success fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>' + $vinylData.artist + ' - ' + $vinylData.title + '</b> is now in your collection.</div></div>');
      },
      error: function(error) {
        console.warn(error);
        return $('body').append('<div class="flash-message"><div class="alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Oops! Something went wrong, please try again.</div></div>');
      }
    });
  });

}).call(this);

(function() {
  var scaleVid;

  scaleVid = function() {
    var height, ratio, widescreen, width;
    width = $(window).width();
    height = $(window).height();
    ratio = width / height;
    widescreen = 16 / 9;
    if (ratio < widescreen) {
      $('#bgvid').css('width', 'auto');
      return $('#bgvid').css('height', '100%');
    } else {
      $('#bgvid').css('width', '100%');
      return $('#bgvid').css('height', 'auto');
    }
  };

  $(document).ready(function() {
    return scaleVid();
  });

  $(window).resize(function() {
    return scaleVid();
  });

}).call(this);

//# sourceMappingURL=app.js.map