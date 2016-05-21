(function() {
  var userId;

  userId = $('#statistics').data('userid');

  new Vue({
    el: '#statistics',
    data: {
      loading: true,
      vinyls: [],
      userId: userId,
      genreData: {
        labels: [],
        datasets: [
          {
            label: "Genre Distrbution",
            backgroundColor: ["#56c9b8", "#2f9fc2", "#4466b3", "#7d4193", "#975aaa", "#a44b8b", "#be5f5f", "#b98657", "#e8c56a", "#bee488", "#60b04c", "#5fda9b"],
            hoverBorderColor: "#FFF",
            data: []
          }
        ]
      },
      sizeData: {
        labels: [],
        datasets: [
          {
            label: "Record Sizes",
            backgroundColor: ["#202020", "#404040", "#606060"],
            hoverBorderColor: "#FFF",
            data: []
          }
        ]
      },
      timeData: {
        labels: [],
        datasets: [
          {
            label: "Record Release Dates",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,192,192,0.4)",
            borderColor: "rgba(75,192,192,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: []
          }
        ]
      }
    },
    methods: {
      fetchVinylList: function(userId) {
        return $.getJSON("/api/user/" + userId + "/vinyls/all", (function(_this) {
          return function(response) {
            _this.vinyls = response;
            _this.loading = false;
            return _this.generateCharts(_this.vinyls);
          };
        })(this));
      },
      generateCharts: function(vinyls) {
        var allGenres, allSizes, allTimes, genreChart, genreChartCanvas, genreCount, sizeChart, sizeChartCanvas, sizeCount, timeChart, timeChartCanvas, timeCount;
        allGenres = [];
        allSizes = [];
        allTimes = [];
        genreCount = [];
        sizeCount = [];
        timeCount = [];
        _.each(vinyls, function(vinyl) {
          var genre, size, time;
          genre = vinyl.genre.split(';')[0];
          if (genre === "") {
            genre = "unknown";
          }
          allGenres.push(genre);
          genreCount = _.chain(allGenres).countBy().toPairs().value();
          size = vinyl.size;
          allSizes.push(size);
          sizeCount = _.chain(allSizes).countBy().toPairs().value();
          time = vinyl.releasedate;
          allTimes.push(time);
          return timeCount = _.chain(allTimes).countBy().toPairs().value();
        });
        _.each(genreCount, (function(_this) {
          return function(genre) {
            _this.genreData.labels.push(genre[0]);
            return _this.genreData.datasets[0].data.push(genre[1]);
          };
        })(this));
        _.each(sizeCount, (function(_this) {
          return function(size) {
            _this.sizeData.labels.push(size[0] + "inch");
            return _this.sizeData.datasets[0].data.push(size[1]);
          };
        })(this));
        _.each(timeCount, (function(_this) {
          return function(time) {
            _this.timeData.labels.push("" + time[0]);
            return _this.timeData.datasets[0].data.push(time[1]);
          };
        })(this));
        genreChartCanvas = $("#genreChart");
        genreChart = new Chart(genreChartCanvas, {
          type: 'pie',
          data: this.genreData
        });
        sizeChartCanvas = $("#sizeChart");
        sizeChart = new Chart(sizeChartCanvas, {
          type: 'pie',
          data: this.sizeData
        });
        timeChartCanvas = $("#timeChart");
        return timeChart = new Chart(timeChartCanvas, {
          type: 'line',
          data: this.timeData
        });
      }
    },
    ready: function() {
      return this.fetchVinylList(this.userId);
    }
  });

}).call(this);

//# sourceMappingURL=charts.js.map