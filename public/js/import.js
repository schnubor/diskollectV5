(function() {
  var discogs_vinyls, processNext, vinylsToImport;

  discogs_vinyls = [];

  vinylsToImport = [];

  $.fetchDiscogsPage = function(username, page, promises) {
    var request;
    if (promises == null) {
      promises = [];
    }
    request = $.ajax({
      url: "https://api.discogs.com/users/" + username + "/collection/folders/0/releases?page=" + page + "&per_page=100",
      type: 'GET',
      error: function(x, status, error) {
        console.log(status);
        return console.log(error);
      },
      success: function(response) {
        console.log(response);
        return response.releases;
      }
    });
    return promises.push(request);
  };

  $.getVinylsToImport = function(discogs_vinyls, user_vinyls) {
    var alreadyInCollection, discogs_vinyl, i, j, len, len1, onlyInA, onlyInB, user_vinyl;
    alreadyInCollection = [];
    for (i = 0, len = discogs_vinyls.length; i < len; i++) {
      discogs_vinyl = discogs_vinyls[i];
      for (j = 0, len1 = user_vinyls.length; j < len1; j++) {
        user_vinyl = user_vinyls[j];
        if (discogs_vinyl.id === parseInt(user_vinyl.release_id)) {
          alreadyInCollection.push(discogs_vinyl);
        }
      }
    }
    onlyInA = alreadyInCollection.filter(function(current) {
      return discogs_vinyls.filter(function(current_b) {
        return current_b.id === current.id;
      }).length === 0;
    });
    onlyInB = discogs_vinyls.filter(function(current) {
      return alreadyInCollection.filter(function(current_a) {
        return current_a.id === current.id;
      }).length === 0;
    });
    vinylsToImport = onlyInA.concat(onlyInB);
    return {
      "vinylsToImport": vinylsToImport,
      "alreadyInCollection": alreadyInCollection
    };
  };

  $.getReleases = function(username, user_id) {
    var user_vinyls;
    $('.js-startImport').html('<i class="fa fa-fw fa-spin fa-refresh"></i> Scan Discogs');
    user_vinyls = [];
    discogs_vinyls = [];
    return $.ajax({
      url: "/api/discogs/user/" + username + "/releases/1",
      type: 'GET',
      error: function(x, status, error) {
        console.log(status);
        return console.log(error);
      },
      success: function(response) {
        var currentPage, promises, request;
        promises = [];
        currentPage = 1;
        while (currentPage <= response.pagination.pages) {
          request = $.ajax({
            url: "/api/discogs/user/" + username + "/releases/" + currentPage,
            type: 'GET',
            error: function(x, status, error) {
              console.log(status);
              return console.log(error);
            },
            success: function(response) {
              var i, len, ref, release, results;
              ref = response.releases;
              results = [];
              for (i = 0, len = ref.length; i < len; i++) {
                release = ref[i];
                results.push(discogs_vinyls.push(release));
              }
              return results;
            }
          });
          promises.push(request);
          currentPage++;
        }
        return $.when.apply(null, promises).done(function() {
          var $userVinylsCall;
          return $userVinylsCall = $.ajax({
            url: '/api/user/' + user_id + '/vinyls',
            type: 'GET',
            error: function(x, status, error) {
              console.log(status);
              return console.log(error);
            },
            success: function(response) {
              var vinylsObj;
              user_vinyls = response.data;
              vinylsObj = $.getVinylsToImport(discogs_vinyls, user_vinyls);
              console.log("vinyls to import: ", vinylsToImport);
              return $('.js-startImport').fadeOut(400, function() {
                $('.js-vinylsFound').text(discogs_vinyls.length);
                $('.js-alreadyInCollection').text(vinylsObj.alreadyInCollection.length);
                $('.js-vinylsToImport').text(vinylsObj.vinylsToImport.length);
                if (!vinylsObj.vinylsToImport.length) {
                  $('.js-startMapping').attr('disabled', 'disabled');
                }
                return $('.js-importFetchResults').fadeIn();
              });
            }
          });
        });
      }
    });
  };

  $('.js-startMapping').click(function() {
    console.log("Starting Mapping ...");
    $('.js-startMapping').hide();
    $('.js-importProgress').show();
    return processNext(0);
  });

  processNext = function(n) {
    console.log("Processing vinyl index " + n);
    $('.js-importProgress .progress-bar').css('width', ((100 * n) / vinylsToImport.length) + "%");
    $('.js-importProgress .progress-bar').text((Math.round(((100 * n) / vinylsToImport.length) * 100) / 100) + "%");
    if (n < vinylsToImport.length) {
      $('.js-currentImportVinyl').text(vinylsToImport[n].basic_information.artists[0].name + " - " + vinylsToImport[n].basic_information.title);
      return $.ajax({
        url: "/api/discogs/" + vinylsToImport[n].id,
        type: "GET",
        error: function(x, status, error) {
          console.log(status);
          return console.log(error);
        },
        success: function(vinyl) {
          var $vinylData, userCurrency;
          userCurrency = $('meta[name=user-currency]').attr('content');
          $vinylData = $.mapVinylData(vinyl);
          $vinylData.price = 0;
          $vinylData._token = $('meta[name=csrf-token]').attr('content');
          return $.ajax({
            url: '/vinyl/create',
            type: 'POST',
            data: $vinylData,
            success: function(reponse) {
              console.log("vinyl " + n + " added!");
              n++;
              return processNext(n);
            },
            error: function(error) {
              return console.warn(error);
            }
          });
        }
      });
    } else {
      $('.js-currentImportVinyl').hide();
      $('.js-importProgress .progress-bar').addClass('progress-bar-success');
      return $('.js-importComplete').show();
    }
  };

}).call(this);

//# sourceMappingURL=import.js.map