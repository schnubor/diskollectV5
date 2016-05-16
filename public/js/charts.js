(function() {
  $.fetchVinylPage = function(page) {
    var $vinyls, vinyls;
    vinyls = [];
    return $vinyls = $.ajax({
      url: '/api/user/' + userId + '/vinyls',
      type: 'GET',
      dataType: 'JSON',
      error: function(x, status, error) {
        console.log(status);
        return console.log(error);
      },
      success: function(response) {
        return response.data;
      }
    });
  };

  $.getStats = function(userId) {
    var $vinyls;
    return $vinyls = $.ajax({
      url: '/api/user/' + userId + '/vinyls/all',
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
        genreData = _.chain(genreData).countBy().toPairs().value();
        sizeData_temp = _.chain(sizeData_temp).countBy().toPairs().value();
        _.each(sizeData_temp, function(sizeArray) {
          sizeData[0].push(sizeArray[0]);
          return sizeData[1].push(sizeArray[1]);
        });
        timeData_temp = _.chain(timeData_temp).countBy().toPairs().value();
        _.each(timeData_temp, function(timeArray) {
          timeData[0].push(timeArray[0]);
          return timeData[1].push(timeArray[1]);
        });
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

//# sourceMappingURL=charts.js.map