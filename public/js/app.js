(function() {
  $('[data-toggle="tooltip"]').tooltip();

  $('[data-toggle="popover"]').popover({
    html: true
  });

}).call(this);

(function() {
  var getMedian;

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

  $.fetchPrice = function(id, userCurrency, callback) {
    var EURinGBP, EURinUSD, GBPinUSD;
    EURinUSD = 1.12;
    EURinGBP = 0.79;
    GBPinUSD = 1.42;
    return $.ajax({
      url: "https://api.discogs.com/marketplace/search?release_id=" + id,
      type: 'GET',
      dataType: 'JSON',
      error: function(x, status, error) {
        console.log(status);
        return console.log(error);
      },
      success: function(prices) {
        var median, values;
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
        return callback(median);
      }
    });
  };

  $.mapVinylData = function(vinyl) {
    var $vinylData, i, key, len, ref, tmpTracklist, track;
    $vinylData = {};
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
    if (vinyl.lowest_price) {
      $vinylData.price = vinyl.lowest_price;
    } else {
      $vinylData.price = 0;
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
      tmpTracklist = [];
      ref = vinyl.tracklist;
      for (key = i = 0, len = ref.length; i < len; key = ++i) {
        track = ref[key];
        tmpTracklist.push({
          duration: track.duration,
          position: track.position,
          title: track.title
        });
      }
      $vinylData.tracklist = tmpTracklist;
    } else {
      $vinylData.tracklist = [];
    }
    if (vinyl.videos) {
      $vinylData.videos = vinyl.videos;
    } else {
      $vinylData.videos = [];
    }
    return $vinylData;
  };

}).call(this);

(function() {
  $.getStatus = function(userId) {
    var $vinyls;
    return $vinyls = $.ajax({
      url: '/api/user/' + userId + '/status',
      type: 'GET',
      error: function(x, status, error) {
        console.warn(status);
        console.warn(error);
        $('.js-connectionStatus').removeClass('btn-info').addClass('btn-danger').html('<i class="fa fa-fw fa-exclamation-circle"></i> Not connected');
        $('.js-connectionAction').removeClass('hidden');
        return false;
      },
      success: function(response) {
        $('.js-connectionStatus').removeClass('btn-info').addClass('btn-success').html('<i class="fa fa-fw fa-check"></i> Connected');
        return true;
      }
    });
  };

}).call(this);

//# sourceMappingURL=app.js.map
