(function() {
  var userId, vm;

  userId = $('#jukebox').data('userid');

  Vue.use(VueYouTubeEmbed);

  vm = new Vue({
    el: '#jukebox',
    data: {
      vinyls: [],
      userId: userId,
      loading: true,
      videoId: 'videoId',
      timeout: null,
      vinyl: {
        id: null,
        cover: "/images/PH_vinyl.svg",
        artist: "-",
        title: "-",
        label: "-",
        year: "-",
        country: "-"
      }
    },
    methods: {
      fetchVinylList: function(userId) {
        return $.getJSON("/api/user/" + userId + "/vinyls/videos/all", (function(_this) {
          return function(response) {
            _this.vinyls = response;
            _this.loading = false;
            return _this.newRecord(_this.vinyls);
          };
        })(this));
      },
      newRecord: function(vinyls) {
        var video, vinyl;
        clearTimeout(this.timeout);
        vinyl = vinyls[Math.floor(Math.random() * vinyls.length)];
        video = vinyl.videos[Math.floor(Math.random() * vinyl.videos.length)];
        this.videoId = video.uri.slice(-11);
        this.vinyl.id = vinyl.id;
        this.vinyl.cover = vinyl.artwork;
        this.vinyl.artist = vinyl.artist;
        this.vinyl.title = vinyl.title;
        this.vinyl.label = vinyl.label;
        this.vinyl.year = vinyl.releasedate;
        return this.vinyl.country = vinyl.country;
      },
      playerReady: function(player) {
        return this.player = player;
      },
      playing: function() {
        console.log("playing");
        return clearTimeout(this.timeout);
      },
      paused: function() {
        return console.log("paused");
      },
      buffering: function() {
        return this.timeout = setTimeout((function(_this) {
          return function() {
            return _this.newRecord(_this.vinyls);
          };
        })(this), 5000);
      },
      queued: function() {
        return console.log("queued");
      }
    },
    ready: function() {
      return this.fetchVinylList(this.userId);
    }
  });

}).call(this);

//# sourceMappingURL=jukebox.js.map
